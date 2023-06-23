<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Andijan'],
            ['name'=>'Bukhara'],
            ['name'=>'Jizzakh'],
            ['name'=>'Kashkadarya'],
            ['name'=>'Navoi'],
            ['name'=>'Namangan'],
            ['name'=>'Samarkand'],
            ['name'=>'Sirdarya'],
            ['name'=>'Surkhandarya'],
            ['name'=>'Tashkent'],
            ['name'=>'Fergana'],
            ['name'=>'Khorezm'],
            ['name'=>'Karakalpakstan'],
        ];

        foreach ($data as $item){
            City::query()->create($item);
        }
    }
}
