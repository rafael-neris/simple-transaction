<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\External\ExternalException;
use App\Exceptions\Transaction\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreRequest;
use App\Notifications\TransactionReceivedNotification;
use App\Services\AuthorizationService;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    private $transactionService;
    private $authorizationService;

    public function __construct(
        AuthorizationService $authorizationService,
        TransactionService $transactionService
    ) {
        $this->authorizationService = $authorizationService;
        $this->transactionService = $transactionService;
    }

    /**
     * store
     * Salva transações entre usuários
     *
     * @param  \App\Http\Requests\Transaction\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $transactions = $this->transactionService->createUsersTransactions($request->all());
            $this->authorizationService->send();

            DB::commit();
            Log::info('Transação efetuada com sucesso', $request->all());

            $transactions['payeeTransaction']->notify(new TransactionReceivedNotification());

            Log::info('Notificação adicionada a fila de envio', [
                'transaction' => [
                    'id' => $transactions['payeeTransaction']->id,
                    'wallet_id' => $transactions['payeeTransaction']->wallet_id,
                    'type' => $transactions['payeeTransaction']->type,
                    'value' => $transactions['payeeTransaction']->value
                ]
            ]);

            return response()->json(['message' => 'success']);
        } catch (TransactionException $exception) {
            return $this->returnException($exception);
        } catch (ExternalException $exception) {
            return $this->returnException($exception);
        } catch (Exception $exception) {
            return $this->returnException($exception);
        }
    }

    private function returnException(Exception $exception, $customMessage = null): JsonResponse
    {
        DB::rollBack();

        $exceptionMessage = $exception->getMessage();
        $exceptionCode = $exception->getCode();

        Log::error($exceptionMessage, [
            'code' => $exceptionCode,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        return response()->json(['message' => $customMessage ?? $exceptionMessage], $exceptionCode);
    }
}
