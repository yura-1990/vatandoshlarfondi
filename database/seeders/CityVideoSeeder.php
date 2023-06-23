<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\CityVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityVideoSeeder extends Seeder
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
            CityVideo::query()->create([
                'city_id' => $city->id,
                'title' => fake()->text(50),
                'content' => fake()->imageUrl,
                'video' => fake()->imageUrl,
            ]);
        }
    }
}
