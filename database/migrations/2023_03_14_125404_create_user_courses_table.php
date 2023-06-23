<?php

use App\Models\Messenger\ChatRoom;
use App\Models\OnlineCourse\Course;
use App\Models\OnlineCourse\CourseCertificate;
use App\Models\User;
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
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(Course::class)->constrained('courses')->onDelete('restrict');
            $table->string('course_rate', 5)->nullable();
            $table->foreignIdFor(CourseCertificate::class, 'certificate_id')->nullable()
                ->constrained('course_certificates')->onDelete('restrict');
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_courses');
    }
};
