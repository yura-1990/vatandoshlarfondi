<?php

use App\Models\OnlineCourse\Exam;
use App\Models\OnlineCourse\Question;
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
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(Exam::class)->constrained('exams')->onDelete('restrict');
            $table->foreignIdFor(Question::class)->constrained('questions')->onDelete('restrict');
            $table->text('user_answer');
            $table->text('correct_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_answers');
    }
};
