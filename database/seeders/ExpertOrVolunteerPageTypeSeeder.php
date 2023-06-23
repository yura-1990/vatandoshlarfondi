<?php

namespace Database\Seeders;

use App\Enums\ExpertOrVolunteerPageTypeEnum;
use App\Models\Userdata\ExpertOrVolunteerPageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpertOrVolunteerPageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ExpertOrVolunteerPageTypeEnum::cases() as $typeEnum){
            ExpertOrVolunteerPageType::query()->create([
                'type' => $typeEnum->name
            ]);
        }
    }
}
