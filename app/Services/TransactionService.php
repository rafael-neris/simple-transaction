<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TransactionTypesEnum;
use App\Enums\UserTypeEnum;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Exception;

class TransactionService
{
    private $transactionRepository;
    private $userRepository;
    private $walletService;

    public function __construct(
        TransactionRepository $transactionRepository,
        UserRepository $userRepository,
        WalletService $walletService
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletService = $walletService;
        $this->userRepository = $userRepository;
    }

    /**
     * Realiza a criação de uma transação
     *
     * @param  Wallet $wallet
     * @param  int    $value
     * @param  string $type
     * @return bool
     */
    public function create(Wallet $wallet, int $value, string $type = TransactionTypesEnum::IN): bool
    {
        $this->validateTransaction($wallet, $value, $type);

        return $this->transactionRepository->create([
            'wallet_id' => $wallet->id,
            'value' => $value,
            'type' => $type,
        ]);
    }

    /**
     * Realiza a criação das transações entre usuários
     *
     * @param  array $data
     * @return bool
     */
    public function createUsersTransactions(array $data): bool
    {
        $payer = $this->userRepository->getById((int) $data['payer']);
        $payee = $this->userRepository->getById((int) $data['payee']);
        $transactionValue = (int) $data['value'];

        $payerTransaction = $this->create($payer->wallet, $transactionValue, TransactionTypesEnum::OUT);
        $payeeTransaction = $this->create($payee->wallet, $transactionValue, TransactionTypesEnum::IN);

        return $payerTransaction && $payeeTransaction;
    }

    /**
     * Valida a criação da transação
     *
     * @param  Wallet $wallet
     * @param  int    $value
     * @param  string $type
     * @return void
     */
    private function validateTransaction(Wallet $wallet, int $value, string $type): void
    {
        if ($type === TransactionTypesEnum::OUT) {
            if (!$this->walletService->hasBalance($wallet, $value)) {
                throw new Exception('usuário sem saldo');
            }

            if ($wallet->user->user_type_id !== UserTypeEnum::INDIVIDUAL) {
                throw new Exception("tipo de usuario sem permissão para efetuar transação");
            }
        }
    }
}
