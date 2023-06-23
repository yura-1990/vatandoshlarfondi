<?php

namespace Database\Seeders;

use App\Enums\CompatriotTypeEnum;
use App\Enums\ExpertOrVolunteerPageTypeEnum;
use App\Models\Public\Location;
use App\Models\Public\LocationCity;
use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserEducation;
use App\Models\Userdata\UserEmploymentInfo;
use App\Models\Userdata\UserProfile;
use App\Models\Userdata\UserVolunteerOrExpertActivity;
use Illuminate\Database\Seeder;

class CompatriotExpertSeeder extends Seeder
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
            $userProfile = UserProfile::query()->inRandomOrder()->first();
            $data = [
                'user_id' => $user->id,
                'user_profile_id' => $userProfile->id,
                'academic_degree' => fake()->realTextBetween(50),
                'scientific_title' => fake()->title,
                'main_science_directions' => [fake()->jobTitle()],
                'topic_of_scientific_article' => fake()->realTextBetween(50),
                'scientific_article_created_at' => fake()->dateTimeInInterval('-5 years', '+3 years', null),
                'article_published_journal_name' => fake()->title,
                'type' => CompatriotTypeEnum::VOLUNTEER->value,
                'suggestions' => fake()->realText,
                'additional_information' => fake()->realText,
            ];
            CompatriotExpert::query()->create($data);
        }
    }
}
