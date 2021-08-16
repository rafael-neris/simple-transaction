<?php

namespace Tests\Feature;

use App\Enums\TransactionTypesEnum;
use App\Models\User;
use App\Services\TransactionService;
use Exception;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
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

    public function testUsersTransactionUserCantDoTransactionException()
    {
        $transactionValue = 1000;

        $payer = User::find(3); // CORPORATE USER
        $payee = User::find(2);

        $transactionData = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $transactionValue,
        ];

        $response = $this->postJson('/api/transaction', $transactionData);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Usuário não possui permissão para realizar transação',
        ]);
    }

    public function testUsersTransactionUserHasNoBalanceException()
    {
        $transactionValue = 1000000000000;

        $payer = User::find(1);
        $payee = User::find(2);

        $transactionData = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $transactionValue,
        ];

        $response = $this->postJson('/api/transaction', $transactionData);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Usuário não possui saldo suficiente para realizar transação',
        ]);
    }

    public function testUsersTransactionException()
    {
        $this->partialMock(TransactionService::class, function ($mock) {
            $mock->shouldReceive('createUsersTransactions')->once()->andThrow(new Exception('Error', 500));
        });

        $transactionValue = 100;

        $payer = User::find(1);
        $payee = User::find(2);

        $transactionData = [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $transactionValue,
        ];

        $response = $this->postJson('/api/transaction', $transactionData);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Error',
        ]);
    }
}
