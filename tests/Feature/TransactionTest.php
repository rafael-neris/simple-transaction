<?php

namespace Tests\Feature;

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Models\User;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function testUsersTransactionSuccess()
    {
        $transactionValue = 1000;

        $payer = User::find(1);
        $payee = User::find(2);

        $transactionData = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $transactionValue,
        ];

        $response = $this->postJson('/api/transaction', $transactionData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'wallet_id' => $payer->wallet->id,
            'type' => TransactionTypesEnum::OUT,
            'value' => $transactionValue,
        ]);

        $this->assertDatabaseHas('transactions', [
            'wallet_id' => $payee->wallet->id,
            'type' => TransactionTypesEnum::IN,
            'value' => $transactionValue,
        ]);
    }
}
