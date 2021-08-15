<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    protected $modelClass = Transaction::class;
}
