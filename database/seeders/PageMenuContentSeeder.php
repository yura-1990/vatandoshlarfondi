<?php

namespace Database\Seeders;

use App\Models\AboutUzbekistan\AboutUzbekistanPageMenu;
use App\Models\AboutUzbekistan\PageMenuContent;
use Illuminate\Database\Seeder;

class PageMenuContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abouts = AboutUzbekistanPageMenu::query()->get();
        foreach ($abouts as $item){
            $data = [
                'title' => fake()->text(50),
                'text' => fake()->text(150),
                'about_uzbekistan_page_menu_id' => $item->id
            ];

            PageMenuContent::query()->create($data);
        }
    }
}
