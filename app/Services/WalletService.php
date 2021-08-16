<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TransactionTypesEnum;
use App\Models\Wallet;
use App\Repositories\WalletRepository;

class WalletService
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function update(Wallet $wallet, array $data): ?bool
    {
        return $this->walletRepository->update($wallet, $data);
    }

    /**
     * updateBalance
     * Atualiza saldo em carteira de acordo com o tipo de transação cadastrada
     *
     * @param  mixed $wallet
     * @param  mixed $value
     * @param  mixed $transactionType
     * @return bool
     */
    public function updateBalance(Wallet $wallet, int $value, string $transactionType): ?bool
    {
        $oldValue = (int) $wallet->balance;
        $newValue = $oldValue;

        if ($transactionType === TransactionTypesEnum::IN) {
            $newValue = $oldValue + $value;
        }

        if ($transactionType === TransactionTypesEnum::OUT) {
            $newValue = $oldValue - $value;
        }

        return $this->update($wallet, [
            'balance' => $newValue,
        ]);
    }

    /**
     * hasBalance
     * Verifica se carteira tem saldo para efetuar transação
     *
     * @param  mixed $wallet
     * @param  mixed $value
     * @return bool
     */
    public function hasBalance(Wallet $wallet, int $value): bool
    {
        if ((int) $wallet->balance < $value) {
            return false;
        }

        return true;
    }
}
