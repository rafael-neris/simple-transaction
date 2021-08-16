<?php

namespace Tests\Unit\Repositories;

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    private $transactionRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->transactionRepository = new TransactionRepository();
    }

    public function testGetById()
    {
        $transaction = $this->transactionRepository->getById(1);

        $this->assertEquals(100000, $transaction->value);
        $this->assertEquals(TransactionTypesEnum::IN, $transaction->type);
    }

    public function testCreate()
    {
        $newTransactionData = factory(Transaction::class)->make()->toArray();
        $this->transactionRepository->create($newTransactionData);

        $this->assertDatabaseHas('transactions', $newTransactionData);
    }

    public function testeUpdate()
    {
        $transaction = $this->transactionRepository->getById(1);
        $updateTransactionData = ['value' => 10000];

        $this->assertDatabaseHas('transactions', $transaction->toArray());

        $this->transactionRepository->update($transaction, $updateTransactionData);

        $this->assertDatabaseHas('transactions', $updateTransactionData);
    }
}
