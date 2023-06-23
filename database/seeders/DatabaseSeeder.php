<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LocalesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(NationalTableSeeder::class);
        $this->call(SpecializationSeeder::class);
        $this->call(LocationCitySeeder::class);
        $this->call(UsersProfileTableSeeder::class);
        $this->call(DictionariesTableSeeder::class);
        $this->call(CompatriotExpertSeeder::class);
        $this->call(UsersEducationTableSeeder::class);
        $this->call(UsersEmploymentInfoTableSeeder::class);
        $this->call(UserVolunteerActivitySeeder::class);
        $this->call(CompatriotMenuSeeder::class);
        $this->call(ELibrarySeeder::class);
        $this->call(AboutUzbekistanPageMenuSeeder::class);
        $this->call(PageMenuContentSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SightseeingPlaceSeeder::class);
        $this->call(CityContentInfoSeeder::class);
        $this->call(CityGallerySeeeder::class);
        $this->call(CityVideoSeeder::class);
        $this->call(City3DSeeder::class);
        $this->call(ExpertOrVolunteerPageTypeSeeder::class);
    }
}
