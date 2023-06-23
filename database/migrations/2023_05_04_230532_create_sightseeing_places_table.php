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
        Schema::create('sightseeing_places', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained('cities')->onDelete('restrict');
            $table->text('image');
            $table->text('thumbnail');
            $table->text('title');
            $table->text('content_title');
            $table->text('text');
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
        Schema::dropIfExists('sightseeing_places');
    }
};
