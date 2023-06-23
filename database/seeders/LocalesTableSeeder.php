<?php

namespace Database\Seeders;

use App\Models\Public\Locale;
use App\Models\Public\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = [
            [
                'name' => 'O`zbek tili',
                'code' => 'uz'
            ],
            [
                'name' => 'Русский язык',
                'code' => 'ru'
            ],
            [
                'name' => 'Узбек тили',
                'code' => 'oz'
            ],
            [
                'name' => 'English',
                'code' => 'en'
            ]
        ];
            Locale::query()->insert($locales);

        DB::statement('alter sequence locales_id_seq restart with 5');
    }
}
