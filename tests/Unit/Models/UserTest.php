<?php

namespace Tests\Unit\Models;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Models\UserType;
use App\Models\Wallet;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testGetAllUsers()
    {
        $users = User::all();

        $this->assertEquals(3, $users->count());
    }

    public function testGetAUser()
    {
        $user = User::find(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('pf1@email.com', $user->email);
        $this->assertEquals(UserTypeEnum::INDIVIDUAL, $user->user_type_id);
    }

    public function testBelongsToUserType()
    {
        $user = User::all()->random();

        $this->assertInstanceOf(UserType::class, $user->type);
    }

    public function testHasOneWallet()
    {
        $user = User::all()->random();

        $this->assertInstanceOf(Wallet::class, $user->wallet);
    }
}
