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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->string('avatar_image', 255)->nullable();
            $table->string('type', 255)->default('private')->index();
            $table->json('avatar_colors')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
