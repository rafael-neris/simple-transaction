<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\External\ExternalException;
use App\Exceptions\Transaction\TransactionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreRequest;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
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

            $this->transactionService->createUsersTransactions($request->all());

            DB::commit();
            return response()->json(['message' => 'success']);
        } catch (TransactionException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        } catch (ExternalException $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
