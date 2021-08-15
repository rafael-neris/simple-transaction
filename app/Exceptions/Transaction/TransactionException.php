<?php

declare(strict_types=1);

namespace App\Exceptions\Transaction;

use Exception;

class TransactionException extends Exception
{
    protected $code = 400;
}
