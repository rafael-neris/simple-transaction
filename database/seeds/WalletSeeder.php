<?php

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Wallet::class)->create([
            'id' => 1,
            'balance' => 50000,
            'user_id' => 1,
        ]);

        factory(Wallet::class)->create([
            'id' => 2,
            'balance' => 25000,
            'user_id' => 2,
        ]);

        factory(Wallet::class)->create([
            'id' => 3,
            'balance' => 25000,
            'user_id' => 3,
        ]);
    }
}
