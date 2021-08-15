<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumTrait;

class UserTypeEnum
{
    use EnumTrait;

    public const INDIVIDUAL = 1;
    public const CORPORATE = 2;

    public static $title = [
        self::INDIVIDUAL => 'PF',
        self::CORPORATE => 'PJ',
    ];
}
