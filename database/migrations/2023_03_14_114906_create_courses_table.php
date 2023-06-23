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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->text('content')->nullable();
            $table->string('locale', 5);
            $table->string('image', 255);
            $table->smallInteger('order');
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
