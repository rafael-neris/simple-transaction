<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\User;

class UserService
{
    private $userTypesDoTransaction = [
        UserTypeEnum::INDIVIDUAL,
    ];

    public function canDoTransaction(User $user): bool
    {
        return in_array($user->user_type_id, $this->userTypesDoTransaction);
    }
}
