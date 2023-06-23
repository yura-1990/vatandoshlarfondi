<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\CityContentInfo;
use App\Models\AboutUzbekistan\CityGallery;
use App\Models\AboutUzbekistan\SightseeingPlace;
use Illuminate\Database\Seeder;

class CityGallerySeeeder extends Seeder
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
            CityGallery::query()->create([
                'city_id' => $city->id,
                'image' => fake()->imageUrl,
                'title' => fake()->text(50),
            ]);
        }
    }
}
