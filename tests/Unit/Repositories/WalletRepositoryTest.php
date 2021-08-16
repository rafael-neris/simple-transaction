<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    private $walletRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = new WalletRepository();
    }

    public function testGetById()
    {
        $wallet = $this->walletRepository->getById(1);

        $this->assertEquals(50000, $wallet->balance);
    }

    public function testCreate()
    {
        $newWalletData = factory(Wallet::class)->make([
            'user_id' => factory(User::class)->create()
        ])->toArray();

        $this->walletRepository->create($newWalletData);

        $this->assertDatabaseHas('wallets', $newWalletData);
    }

    public function testeUpdate()
    {
        $wallet = $this->walletRepository->getById(1);
        $updateWalletData = ['balance' => 99999];

        $this->assertDatabaseHas('wallets', $wallet->toArray());

        $this->walletRepository->update($wallet, $updateWalletData);

        $this->assertDatabaseHas('wallets', $updateWalletData);
    }
}
