<?php

use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\SightseeingPlace;
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
    public function up(): void
    {
        Schema::create('city_content_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained('cities')->onDelete('restrict');
            $table->foreignIdFor(SightseeingPlace::class)->constrained('sightseeing_places')->onDelete('restrict');
            $table->text('title');
            $table->longText('content');
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
        Schema::dropIfExists('city_content_infos');
    }
};
