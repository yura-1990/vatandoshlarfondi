<?php

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
        Schema::create('e_libraries', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->integer('stars')->nullable();
            $table->bigInteger('viewers')->nullable();
            $table->string('author')->nullable();
            $table->string('language')->nullable();
            $table->longText('text')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->dateTime('publication')->nullable();
            $table->integer('ages')->nullable();
            $table->bigInteger('stir')->nullable();
            $table->bigInteger('pages')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('image')->nullable();
            $table->text('book_file')->nullable();
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
        Schema::dropIfExists('e_libraries');
    }
};
