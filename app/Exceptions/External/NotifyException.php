<?php

declare(strict_types=1);

namespace App\Exceptions\External;

class NotifyException extends ExternalException
{
    protected $message = 'Ocorreu um erro ao tentar enviar notificação';
}
