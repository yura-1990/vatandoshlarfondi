<?php

namespace Database\Seeders;

use App\Models\Public\Dictionary;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictionariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $dictionaries = [
                [
                    'title' => 'speciality',
                    'key' => 'speciality',
                    'locale' => 'en',
                ],
                [
                    'title' => 'education_level',
                    'key' => 'education_level',
                    'locale' => 'en',
                ],
                [
                    'title' => 'job_skills',
                    'key' => 'job_skills',
                    'locale' => 'en',
                ],
                [
                    'title' => 'languages',
                    'key' => 'languages',
                    'locale' => 'en',
                ],
                [
                    'title' => 'languages_level',
                    'key' => 'languages_level',
                    'locale' => 'en',
                ],
                [
                    'title' => 'employment_type',
                    'key' => 'employment_type',
                    'locale' => 'en',
                ],
                [
                    'title' => 'schedule_type',
                    'key' => 'schedule_type',
                    'locale' => 'en',
                ],
                [
                    'title' => 'family_status',
                    'key' => 'family_status',
                    'locale' => 'en',
                ],
                [
                    'title' => 'course_level',
                    'key' => 'course_level',
                    'locale' => 'en',
                ]
            ];
            Dictionary::query()->insert($dictionaries);

        DB::statement('alter sequence dictionaries_id_seq restart with 10');
    }
}
