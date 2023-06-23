<?php

namespace App\Models\Messenger;

use App\Models\User;
use Carbon\Carbon;
use DateTimeInterface;
use TCG\Voyager\Traits\Translatable;

class ChatRoom extends \Illuminate\Database\Eloquent\Model
{
    use Translatable;

    protected $table = 'chat_rooms';

    protected $translatable = ['name', 'description'];

//    protected $casts = [
//        'created_at' => 'date',
//    ];
    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->toW3cString();
    }
    protected $fillable = ['id', 'name', 'type'];
    public function messages()
    {
        return $this->hasMany(ChatRoomMessage::class)
            ->leftJoin('users', 'users.id', '=', 'chat_room_messages.user_id')
            ->select('chat_room_messages.*', 'users.name', 'users.avatar')
            ->orderBy('chat_room_messages.created_at', 'DESC');
    }

    public function users()
    {
        return $this->hasMany(UserChatRoom::class);
    }
    public function user()
    {
        return $this->belongsTo(UserChatRoom::class)->where('user_id','!=', $this->id);
    }
    public function online()
    {
        $now = now(); // hozirgi vaqt
        $three_minutes_ago = $now->subMinutes(5);
        return $this->hasMany(UserChatRoom::class, );
//            ->leftJoin('users', 'users.id', '=', 'user_chat_rooms.user_id')
//            ->where('users.last_online_at', '>', $three_minutes_ago);
    }
}
