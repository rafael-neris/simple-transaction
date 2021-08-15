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

    public function hasBalance(Wallet $wallet, int $value): bool
    {
        if ((int) $wallet->balance < $value) {
            return false;
        }

        return true;
    }
}
