<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'id' => 1,
            'name' => 'Pessoa Física 01',
            'email' => 'pf1@email.com',
            'user_type_id' => UserTypeEnum::INDIVIDUAL,
        ]);

        factory(User::class)->create([
            'id' => 2,
            'name' => 'Pessoa Física 02',
            'email' => 'pf2@email.com',
            'user_type_id' => UserTypeEnum::INDIVIDUAL,
        ]);

        factory(User::class)->create([
            'id' => 3,
            'name' => 'Pessoa Jurídica 01',
            'email' => 'pj1@email.com',
            'user_type_id' => UserTypeEnum::CORPORATE,
        ]);
    }
}
