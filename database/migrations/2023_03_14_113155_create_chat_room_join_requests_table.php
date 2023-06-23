<?php

use App\Enums\ChatRoomJoinRequestStatusEnum;
use App\Enums\ChatRoomJoinRequestTypeEnum;
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
        Schema::create('chat_room_join_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(ChatRoom::class)->constrained('chat_rooms')->onDelete('restrict');
            $table->smallInteger('type')->default(ChatRoomJoinRequestTypeEnum::PRIVATE->value)->index();
            $table->smallInteger('status')->default(ChatRoomJoinRequestStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room_join_requests');
    }
};
