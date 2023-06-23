<?php

use App\Enums\MessageTypeEnum;
use App\Enums\StatusEnum;
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
        Schema::create('chat_room_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('restrict');
            $table->foreignIdFor(ChatRoom::class)->constrained('chat_rooms')->onDelete('restrict');
            $table->text('message');
            $table->string('file')->nullable();
            $table->smallInteger('type')->default(MessageTypeEnum::TEXT->value)->index();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE->value);
            $table->foreignIdFor(\App\Models\Messenger\ChatRoomMessage::class, 'reply_to')->nullable()->constrained('chat_room_messages')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room_messages');
    }
};
