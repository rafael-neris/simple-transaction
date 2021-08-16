<?php

namespace Tests\Unit\Models;

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function testGetAllTransactions()
    {
        $transactions = Transaction::all();

        $this->assertEquals(5, $transactions->count());
    }

    public function testGetATransaction()
    {
        $transaction = Transaction::find(1);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals(100000, $transaction->value);
        $this->assertEquals(TransactionTypesEnum::IN, $transaction->type);
    }

    public function testBelongsToWallet()
    {
        $transaction = Transaction::all()->random();

        $this->assertInstanceOf(Wallet::class, $transaction->wallet);
    }
}
