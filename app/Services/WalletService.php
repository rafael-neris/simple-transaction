<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function hasBalance(Wallet $wallet, int $value): bool
    {
        if ((int) $wallet->balance < $value) {
            return false;
        }

        return true;
    }
}
