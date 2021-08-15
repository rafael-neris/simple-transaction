<?php

use App\Enums\UserTypeEnum;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserType::class)->create([
            'id' => UserTypeEnum::INDIVIDUAL,
            'name' => UserTypeEnum::title(UserTypeEnum::INDIVIDUAL),
        ]);

        factory(UserType::class)->create([
            'id' => UserTypeEnum::CORPORATE,
            'name' => UserTypeEnum::title(UserTypeEnum::CORPORATE),
        ]);
    }
}
