<?php

use App\Models\OnlineCourse\Question;
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
        Schema::create('question_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Question::class)->constrained('questions')->onDelete('restrict');
            $table->text('answer');
            $table->string('file_path', 255)->nullable();
            $table->boolean('is_true')->default(false);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_variants');
    }
};
