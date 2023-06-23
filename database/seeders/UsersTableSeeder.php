<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data=[
            [
                'name'=>'Mirahmad',
                'email' => 'mirahmad.info@gmail.com',
                'password' => Hash::make('a2929199')
            ],
            [
                'name'=>'Murod',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password')
            ]
        ];

        foreach ($data as $item){
            $user = User::query()->where('email', $item['email'])->first();
            if (!$user){
                User::query()->create($item);
            }
        }

        User::factory()
            ->count(20)
            ->create();

    }
}
