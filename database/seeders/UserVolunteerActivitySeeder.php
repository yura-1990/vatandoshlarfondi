<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserVolunteerOrExpertActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserVolunteerActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::query()->get();
        foreach ($users as $user){
            $compatriotExpert = CompatriotExpert::query()->inRandomOrder()->first();
            $data = [
                'user_id' => $user->id,
                'title' => fake()->text(10),
                'description' => fake()->text(50),
                'compatriot_expert_id' => $compatriotExpert->id,
                'images'=>[fake()->imageUrl],
            ];
            UserVolunteerOrExpertActivity::query()->create($data);
        }
    }
}
