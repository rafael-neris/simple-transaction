<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    protected $modelClass = Wallet::class;
    protected $cacheKey = 'wallets';
}
