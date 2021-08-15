<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumTrait;

class TransactionTypesEnum
{
    use EnumTrait;

    public const IN = 'IN';
    public const OUT = 'OUT';

    public static $title = [
        self::IN => 'entrada',
        self::OUT => 'saída',
    ];
}
