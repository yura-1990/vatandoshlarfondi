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
        Schema::create('community_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('type', 10);
            $table->foreignId('community_news_id')->nullable()->constrained('community_news')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('community_event_id')->nullable()->constrained('community_events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('community_id')->nullable()->constrained('communities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('path', 255);
            $table->smallInteger('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_attachments');
    }
};
