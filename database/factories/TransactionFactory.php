<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\TransactionTypesEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $types = TransactionTypesEnum::toArray();
    shuffle($types);

    return [
        'wallet_id' => Wallet::all()->random(),
        'type' => current($types),
        'value' => $faker->randomNumber(),
    ];
});
