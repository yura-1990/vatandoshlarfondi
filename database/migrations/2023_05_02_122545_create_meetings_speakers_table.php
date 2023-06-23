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
        Schema::create('meetings_speakers', function (Blueprint $table) {
            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('meeting_speaker_id')->constrained('meeting_speakers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings_speakers');
    }
};
