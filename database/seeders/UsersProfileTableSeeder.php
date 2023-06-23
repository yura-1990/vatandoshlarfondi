<?php

namespace Database\Seeders;

use App\Enums\FamilyStatusEnum;
use App\Enums\GenderEnum;
use App\Models\Public\Location;
use App\Models\Public\LocationCity;
use App\Models\Public\National;
use App\Models\User;
use App\Models\Userdata\UserProfile;
use Illuminate\Database\Seeder;

class UsersProfileTableSeeder extends Seeder
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
            $location = Location::query()->inRandomOrder()->first();
            $uzb = National::query()->inRandomOrder()->first();
            $data = [
                'user_id' => $user->id,
                'first_name' => fake()->firstName(),
                'second_name' => fake()->lastName(),
                'last_name' => fake()->lastName(),
                'international_location_id' => $location->id,
                'international_address_id' => $location->id,
                'national_id' => $uzb->id,
                'birth_date' => fake()->date(),
                'gender' => GenderEnum::MALE,
                'academic_degree' => 'academic_degree',
                'phone_number' => fake()->phoneNumber,
                'scientific_title' => 'scientific_title',
                'job_position' => 'job_position',
                'work_experience' => rand(1, 10),
                'additional_info' => fake()->text(),
                'achievements' => fake()->text(),
                'family_status' => FamilyStatusEnum::SINGLE,
                'hobbies' => fake()->text(),
                'interests' => fake()->text(),
                'opinions_about_uzbekistan' => fake()->text(),
                'suggestions_and_recommendations' => fake()->text(),
                'timezone' => 'GMT+05:00',
                'language' => 'uz',
                'avatar_url' => '/user-profile/avatar.png',
                'passport_file' => '/user-profile/passport.png'
            ];

            UserProfile::query()->create($data);
        }
    }
}
