<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\CityContentInfo;
use App\Models\AboutUzbekistan\SightseeingPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityContentInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<50; $i++){
            $city = City::query()->inRandomOrder()->first();
            $sightseeingPlace = SightseeingPlace::query()->inRandomOrder()->first();
            CityContentInfo::query()->create([
                'city_id' => $city->id,
                'sightseeing_place_id' => $sightseeingPlace->id,
                'title' => fake()->text(50),
                'content' => fake()->text(150),
            ]);
        }
    }
}
