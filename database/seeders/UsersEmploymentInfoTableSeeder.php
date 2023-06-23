<?php

namespace Database\Seeders;

use App\Models\Public\Location;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserEmploymentInfo;
use Illuminate\Database\Seeder;

class UsersEmploymentInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::query()->get();
        foreach ($users as $user) {
            $location = Location::query()->inRandomOrder()->first();
            $compatriotExpert = CompatriotExpert::query()->inRandomOrder()->first();
            $data = [
                'user_id' => $user->id,
                'company' => fake()->company(),
                'position' => 'position',
                'location_id' => $location->id,
                'city' => fake()->city,
                'start_date' => fake()->dateTimeInInterval('-10 years', '+5 years', null),
                'finish_date' => fake()->dateTimeInInterval('-5 years', '+3 years', null),
                'compatriot_expert_id' => $compatriotExpert->id,
                'specialization' => 'specialization',
            ];
            UserEmploymentInfo::query()->create($data);
        }
    }
}
