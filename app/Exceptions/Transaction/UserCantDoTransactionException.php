<?php

declare(strict_types=1);

namespace App\Exceptions\Transaction;

class UserCantDoTransactionException extends TransactionException
{
    protected $message = 'Usuário não possui permissão para realizar transação';
}
