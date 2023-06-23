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
        Schema::create('forum_post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_post_id')->constrained('forum_posts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('content');
            $table->text('replay_to');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_post_comments');
    }
};
