<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\User;

class UserService
{
    private $typesDoTransaction = [
        UserTypeEnum::INDIVIDUAL,
    ];

    /**
     * canDoTransaction
     * Valida se usuário tem permissão para realizar transação
     *
     * @param  mixed $user
     * @return bool
     */
    public function canDoTransaction(User $user): bool
    {
        return in_array($user->user_type_id, $this->typesDoTransaction);
    }
}
