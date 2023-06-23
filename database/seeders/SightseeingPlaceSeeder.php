<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\SightseeingPlace;
use Illuminate\Database\Seeder;

class SightseeingPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::query()->get();

        foreach ($cities as $city ){
            $data = [
                'city_id' => $city->id,
                'image' => fake()->imageUrl,
                'thumbnail' => fake()->imageUrl,
                'title' => fake()->text(25),
                'content_title' => fake()->text(50),
                'text' => fake()->text(100),
            ];

            SightseeingPlace::query()->create($data);
        }
    }
}
