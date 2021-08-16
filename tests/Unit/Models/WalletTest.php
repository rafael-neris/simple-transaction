<?php

namespace Tests\Unit\Models;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function testGetAllWallets()
    {
        $wallets = Wallet::all();

        $this->assertEquals(3, $wallets->count());
    }

    public function testGetAWallet()
    {
        $wallet = Wallet::find(1);

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals(50000, $wallet->balance);
    }

    public function testBelongsToUser()
    {
        $wallet = Wallet::all()->random();

        $this->assertInstanceOf(User::class, $wallet->user);
    }

    public function testHasManyTransactions()
    {
        $wallet = Wallet::all()->random();

        $this->assertInstanceOf(Transaction::class, $wallet->transactions->first());
    }
}
