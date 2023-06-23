<?php

namespace Database\Seeders;

use App\Models\Userdata\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['title'=>'Lawyer'],
            ['title'=>'Doctor'],
            ['title'=>'Developer'],
        ];
        foreach ($data as $it){
            Specialization::query()->create($it);
        }
    }
}
