<?php

namespace Database\Seeders;

use App\Enums\EducationLocationTypeEnum;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\Specialization;
use App\Models\Userdata\UserEducation;
use Illuminate\Database\Seeder;

class UsersEducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->get();
        foreach ($users as $user) {
            $specialization = Specialization::query()->inRandomOrder()->first();
            $compatriotExpert = CompatriotExpert::query()->inRandomOrder()->first();
            $data = [
                'user_id' => $user->id,
                'compatriot_expert_id' => $compatriotExpert->id,
                'institution' => 'institution',
                'level' => 'level',
                'faculty' => 'faculty',
                'specialization_id' => $specialization->id,
                'type' => fake()->randomElement(EducationLocationTypeEnum::cases())
            ];
            UserEducation::query()->create($data);
        }
    }
}
