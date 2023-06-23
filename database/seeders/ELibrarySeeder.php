<?php

namespace Database\Seeders;

use App\Models\EBooks\ELibrary;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ELibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->get();
        foreach ($users as $user){
            $data=[
                'title' =>fake()->text,
                'stars' => fake()->randomDigit() <= 5 ? fake()->randomDigit() : 5,
                'viewers' => fake()->randomDigit(),
                'author' => fake()->name,
                'language' => fake()->languageCode,
                'text' => fake()->realText,
                'type' => fake()->randomElement(['bestseller', 'box']),
                'format' => fake()->randomElement(['handbook', 'criminals', 'Abstract']),
                'publication' => fake()->date('d/m/Y'),
                'ages' => fake()->randomDigit(),
                'stir' => fake()->randomDigit(),
                'pages' => fake()->randomDigit(),
                'thumbnail'=> fake()->imageUrl,
                'image'=> fake()->imageUrl,
            ];
            ELibrary::query()->create($data);
        }


    }
}
