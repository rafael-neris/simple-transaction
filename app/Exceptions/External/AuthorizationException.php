<?php

declare(strict_types=1);

namespace App\Exceptions\External;

class AuthorizationException extends ExternalException
{
    protected $message = 'A transação não foi autorizada pelo serviço externo';
    protected $code = '400';
}
