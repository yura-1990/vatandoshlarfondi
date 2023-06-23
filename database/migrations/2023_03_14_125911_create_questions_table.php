<?php

use App\Enums\QuestionTypeEnum;
use App\Models\OnlineCourse\Exam;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class)->constrained('exams')->onDelete('restrict');
            $table->smallInteger('TYPE')->default(QuestionTypeEnum::QUESTION->value);
            $table->string('file_path', 255);
            $table->text('question');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
