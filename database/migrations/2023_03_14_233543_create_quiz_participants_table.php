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
        Schema::create('quiz_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_win')->default(false);
            $table->integer('position')->nullable();
            $table->text('description')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('doc', 255)->nullable();
            $table->integer('question')->nullable();
            $table->timestamps();
            $table->unique(['quiz_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_participants');
    }
};
