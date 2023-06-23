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
        Schema::create('university_appliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained('universities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->default(null)->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('education_type', 20);
            $table->string('last_education_type', 20);
            $table->string('last_education_number', 255);
            $table->string('last_education_address', 255);
            $table->smallInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_appliers');
    }
};
