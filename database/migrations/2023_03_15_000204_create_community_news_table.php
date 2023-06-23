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
        Schema::create('community_news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('description', 255)->nullable();
            $table->text('content');
            $table->foreignId('community_id')->constrained('communities')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_news');
    }
};
