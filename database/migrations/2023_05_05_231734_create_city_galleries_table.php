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
        Schema::create('city_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image');
            $table->text('title');
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
        Schema::dropIfExists('city_galleries');
    }
};
