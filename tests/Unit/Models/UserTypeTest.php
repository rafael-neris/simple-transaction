<?php

namespace Tests\Unit\Models;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Models\UserType;
use Tests\TestCase;

class UserTypeTest extends TestCase
{
    public function testGetAllUserTypes()
    {
        $userTypes = UserType::all();

        $this->assertEquals(2, $userTypes->count());
    }

    public function testGetAUserType()
    {
        $userType = UserType::find(1);

        $this->assertInstanceOf(UserType::class, $userType);
        $this->assertEquals(UserTypeEnum::title(UserTypeEnum::INDIVIDUAL), $userType->name);
    }

    public function testHasManyUsers()
    {
        $userType = UserType::all()->random();

        $this->assertInstanceOf(User::class, $userType->users->first());
    }
}
