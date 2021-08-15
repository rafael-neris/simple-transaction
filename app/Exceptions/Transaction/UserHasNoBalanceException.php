<?php

declare(strict_types=1);

namespace App\Exceptions\Transaction;

class UserHasNoBalanceException extends TransactionException
{
    protected $message = 'Usuário não possui saldo suficiente para realizar transação';
}
