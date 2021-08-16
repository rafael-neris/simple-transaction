<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TransactionTypesEnum;
use App\Exceptions\Transaction\UserCantDoTransactionException;
use App\Exceptions\Transaction\UserHasNoBalanceException;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;

class TransactionService
{
    private $transactionRepo;
    private $userRepo;
    private $userService;
    private $walletService;

    public function __construct(
        TransactionRepository $transactionRepo,
        UserRepository $userRepo,
        UserService $userService,
        WalletService $walletService
    ) {
        $this->transactionRepo = $transactionRepo;
        $this->userRepo = $userRepo;
        $this->userService = $userService;
        $this->walletService = $walletService;
    }

    /**
     * create
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

        return $this->transactionRepo->create([
            'wallet_id' => $wallet->id,
            'value' => $value,
            'type' => $type,
        ]);
    }

    /**
     * createUsersTransactions
     * Realiza a criação das transações entre usuários
     *
     * @param  array $data
     * @return bool
     */
    public function createUsersTransactions(array $data): bool
    {
        $payer = $this->userRepo->getById((int) $data['payer']);
        $payee = $this->userRepo->getById((int) $data['payee']);
        $transactionValue = (int) $data['value'];

        $payerTransaction = $this->create($payer->wallet, $transactionValue, TransactionTypesEnum::OUT);
        $payeeTransaction = $this->create($payee->wallet, $transactionValue, TransactionTypesEnum::IN);

        return $payerTransaction && $payeeTransaction;
    }

    /**
     * validateTransaction
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
                throw new UserHasNoBalanceException();
            }

            if (!$this->userService->canDoTransaction($wallet->user)) {
                throw new UserCantDoTransactionException();
            }
        }
    }
}
