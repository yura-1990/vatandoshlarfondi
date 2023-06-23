<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Userdata\CompatriotMenu;
use Illuminate\Database\Seeder;

class CompatriotMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->inRandomOrder()->first();

        $menus = [
            [
                'user_id' => $user->id,
                'name_uz' => 'Shaxsiy ma’lumotingiz',
                'name_oz' => 'Шахсий маълумотингиз',
                'name_ru' => 'Ваша личная информация',
                'name_en' => 'Your personal information',
                'type' => null
            ],
            [
                'user_id' => $user->id,
                'name_uz' => 'Oliy ma’lumotingiz',
                'name_oz' => 'Олий маълумотингиз',
                'name_ru' => 'Ваше высшее образование',
                'name_en' => 'Your higher education',
                'type' => null
            ],
            [
                'user_id' => $user->id,
                'name_uz' => 'Mehnat faoliyatingiz',
                'name_oz' => 'Меҳнат фаолиятингиз',
                'name_ru' => 'Ваша занятость',
                'name_en' => 'Your employment',
                'type' => null
            ],
            [
                'user_id' => $user->id,
                'name_uz' => 'Ilmiy faoliyatingiz',
                'name_oz' => 'Илмий фаолиятингиз',
                'name_ru' => 'Ваша научная деятельность',
                'name_en' => 'Your scientific activity',
                'type' => null
            ],
            [
                'user_id' => $user->id,
                'name_uz' => 'Taklifingiz',
                'name_oz' => 'Таклифингиз',
                'name_ru' => 'Ваше предложение',
                'name_en' => 'Your offer',
                'type' => null
            ],

        ];

        CompatriotMenu::query()->insert($menus);
    }
}
