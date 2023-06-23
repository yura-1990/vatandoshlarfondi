<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\City3D;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class City3DSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::query()->get();
        foreach ($cities as $city){
            City3D::query()->create([
                'city_id' => $city->id,
                'image' => fake()->image('public'),
                'title' => fake()->text(50),
            ]);
        }
    }
}
