<?php

use App\Models\Messenger\ChatRoom;
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
        Schema::create('user_chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(ChatRoom::class)->constrained('chat_rooms')->onDelete('restrict');
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chat_rooms');
    }
};
