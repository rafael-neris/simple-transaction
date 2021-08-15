<?php

declare(strict_types=1);

namespace App\Exceptions\External;

use Exception;

class ExternalException extends Exception
{
    protected $code = 500;
}
