<?php

use App\Models\AboutUzbekistan\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained('cities')->onDelete('restrict');
            $table->text('title');
            $table->longText('content');
            $table->text('video');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_videos');
    }
};
