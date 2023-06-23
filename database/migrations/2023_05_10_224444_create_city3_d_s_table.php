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
        Schema::create('city3_d_s', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class)->constrained('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->text('image');
            $table->text('title');
            $table->text('share')->nullable();
            $table->text('download')->nullable();
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
        Schema::dropIfExists('city3_d_s');
    }
};
