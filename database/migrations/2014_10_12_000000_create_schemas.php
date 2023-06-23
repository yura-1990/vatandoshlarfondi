<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS userdata CASCADE');
//        DB::statement('DROP SCHEMA IF EXISTS cv CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS media CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS messenger CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS forum CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS online_courses CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS online_applications CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS quizzes CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS public_associations CASCADE');
        DB::statement('DROP SCHEMA IF EXISTS events CASCADE');

//        DB::statement('CREATE SCHEMA userdata');
//        DB::statement('CREATE SCHEMA cv');
//        DB::statement('CREATE SCHEMA media');
//        DB::statement('CREATE SCHEMA messenger');
//        DB::statement('CREATE SCHEMA forum');
//        DB::statement('CREATE SCHEMA online_courses');
//        DB::statement('CREATE SCHEMA online_applications');
//        DB::statement('CREATE SCHEMA quizzes');
//        DB::statement('CREATE SCHEMA public_associations');
//        DB::statement('CREATE SCHEMA events');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
