<?php

namespace App\Models\Messenger;

use App\Models\User;
use DateTimeInterface;

class ChatRoomMessage extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'chat_room_messages';

    protected $fillable = ['id', 'user_id', 'chat_room_id', 'message', 'reply_to', 'file', 'type', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->toW3cString();
    }

}
