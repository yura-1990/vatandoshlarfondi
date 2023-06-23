<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('type');
            $table->dateTime('start_date');
            $table->string('url', 255)->nullable();
            $table->string('image', 255);
            $table->string('video', 255)->nullable();
            $table->smallInteger('status')->default(1);
            $table->smallInteger('attendees')->default(0);
            $table->string('uuid', 255)->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
