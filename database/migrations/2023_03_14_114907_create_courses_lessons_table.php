<?php

use App\Enums\CourseTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Public\Dictionary;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable();
            $table->foreignId('course_id');
            $table->string('title', 255);
            $table->string('type', 255);
            $table->text('description');
            $table->text('content')->nullable();
            $table->string('locale', 5);
            $table->smallInteger('order')->default(0);
            $table->integer('duration')->nullable();
            $table->string('path', 255)->nullable();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
