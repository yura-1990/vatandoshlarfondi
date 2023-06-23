<?php

use App\Enums\CourseTypeEnum;
use App\Models\OnlineCourse\Course;
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
        Schema::create('course_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class)->constrained('courses')->onDelete('restrict');
            $table->string('title', 255);
            $table->string('path', 255);
            $table->smallInteger('type')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_attachments');
    }
};
