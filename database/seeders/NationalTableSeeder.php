<?php

namespace Database\Seeders;

use App\Models\Public\Location;
use App\Models\Public\National;
use App\OpenApi\Schemas\NationalSchema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nationals = [
            [
                "name" => 'O\'zbek',
            ],
            [
                "name" => 'Qirg\'iz',
            ],
            [
                "name" => 'Qozoq',
            ],
            [
                "name" => 'Rus',
            ],
        ];
        National::query()->insert($nationals);

    }
}
