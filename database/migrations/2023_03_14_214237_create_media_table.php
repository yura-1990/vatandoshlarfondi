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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_category_id')->constrained('media_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
            $table->string('name');
            $table->text('description');
            $table->text('tags');
            $table->integer('read_count');
            $table->string('is_top');
            $table->string('is_recommended');
            $table->integer('views_count')->default(0);
            $table->string('locale', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
