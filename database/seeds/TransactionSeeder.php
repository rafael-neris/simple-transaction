<?php

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Transaction::class)->create([
            'value' => 100000,
            'type' => TransactionTypesEnum::IN,
            'wallet_id' => 1,
        ]);

        factory(Transaction::class)->create([
            'value' => 50000,
            'type' => TransactionTypesEnum::OUT,
            'wallet_id' => 1,
        ]);

        factory(Transaction::class)->create([
            'value' => 50000,
            'type' => TransactionTypesEnum::IN,
            'wallet_id' => 2,
        ]);

        factory(Transaction::class)->create([
            'value' => 25000,
            'type' => TransactionTypesEnum::OUT,
            'wallet_id' => 2,
        ]);

        factory(Transaction::class)->create([
            'value' => 25000,
            'type' => TransactionTypesEnum::IN,
            'wallet_id' => 3,
        ]);
    }
}
