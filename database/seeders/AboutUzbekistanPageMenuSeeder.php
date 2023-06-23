<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\AboutUzbekistanPageMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutUzbekistanPageMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            ['name'=>'Bosh sahifa', 'image'=>fake()->imageUrl],
            ['name'=>'Vizual malumot', 'image'=> 'aboutUZBPageMenu/visual.png'],
            ['name'=>'3D TOUR', 'image'=>fake()->imageUrl],
            ['name'=>'Turustik obyektlar', 'image'=> 'aboutUZBPageMenu/object.png'],
            ['name'=>'Bog’lanish', 'image'=>fake()->imageUrl],
        ];

        foreach ($data as $item){
            AboutUzbekistanPageMenu::query()->create($item);
        }
    }
}
