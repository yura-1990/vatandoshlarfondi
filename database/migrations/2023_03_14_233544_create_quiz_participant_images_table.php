<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_participant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_participant_id')->constrained('quiz_participants')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_participant_images');
    }
};
