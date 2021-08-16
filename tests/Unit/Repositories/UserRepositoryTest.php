<?php

namespace Tests\Unit\Repositories;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    public function testGetById()
    {
        $user = $this->userRepository->getById(1);

        $this->assertEquals('pf1@email.com', $user->email);
        $this->assertEquals(UserTypeEnum::INDIVIDUAL, $user->user_type_id);
    }

    public function testCreate()
    {
        $newUserData = factory(User::class)->make()->toArray();
        $this->userRepository->create($newUserData);

        $this->assertDatabaseHas('users', $newUserData);
    }

    public function testeUpdate()
    {
        $user = $this->userRepository->getById(1);
        $updateUserData = ['email' => 'pf10@email.com'];

        $this->assertDatabaseHas('users', $user->toArray());

        $this->userRepository->update($user, $updateUserData);

        $this->assertDatabaseHas('users', $updateUserData);
    }
}
