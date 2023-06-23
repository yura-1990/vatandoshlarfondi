<?php

namespace App\Http\Controllers\Api;

use App\Events\ChatMessage;
use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Messenger\ChatRoom;
use App\Models\Messenger\ChatRoomMessage;
use App\Models\Messenger\UserChatRoom;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizParticipant;
use App\Models\Quiz\QuizParticipantImage;
use App\Models\Quiz\QuizQuestion;
use App\Models\User;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Page;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;
use Illuminate\Support\Facades\App;

#[Prefix('chat')]
#[PathItem]
class ChatController extends Controller
{
    /**
     * Get all chats
     */
    #[Get('/chats')]
    #[Operation(tags: ['Chats'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAllChats(Request $request): JsonResponse
    {
        $now = now(); // hozirgi vaqt
        $type = $request->type ?? '';
        $three_minutes_ago = $now->subMinutes(5);
        $user_id = auth()->guard('api')->id();
        $chats = ChatRoom::leftJoin('user_chat_rooms', 'user_chat_rooms.chat_room_id', '=', 'chat_rooms.id')
            ->where('user_chat_rooms.user_id', $user_id)
//            ->select([])
            ->withCount(['users', 'online' => function ($query) use ($three_minutes_ago) {
                $query->leftJoin('users', 'users.id', '=', 'user_chat_rooms.user_id')
                    ->where('users.last_online_at', '>', $three_minutes_ago);
            }])
//            ->with(['user'])
            ->addSelect('chat_rooms.*',
                DB::raw('(SELECT ms.created_at FROM chat_room_messages as ms where ms.chat_room_id = chat_rooms.id order by ms.created_at desc limit 1) as date')
            )
            ->orderBy('date', 'DESC');
        if (strlen($type) > 0) {
            $chats = $chats->where('type', $type);
        }
        $chats = $chats->get();
        foreach ($chats as &$chat) {
            $user_last = UserChatRoom::where('chat_room_id', $chat->id)
                ->where('user_id', $user_id)->first();
            if ($user_last->last_read){
                $chat->unread = ChatRoomMessage::query()
                ->where('chat_room_id', $chat->id)
                ->where('created_at', '>', $user_last->last_read)->count();
            }else{
                $chat->unread = ChatRoomMessage::query()
                    ->where('chat_room_id', $chat->id)
                    ->count();
            }
            if ($chat->type == 'private') {
                $chat->user = UserChatRoom::query()
                    ->leftJoin('user_profile', 'user_profile.user_id', '=', 'user_chat_rooms.user_id')
                    ->where('chat_room_id', $chat->id)
                    ->where('user_profile.user_id', '!=', $user_id)
                    ->select(['user_profile.user_id', 'user_profile.first_name', 'user_profile.first_name', 'user_profile.last_name', 'user_profile.avatar_url'])
                    ->first();
            }
        }
        return $this->success(["chats" => $chats]);
    }

    /**
     * Get all chats
     */
    #[Get('/chat/{id}')]
    #[Operation(tags: ['Chats'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getChatById(Request $request, $id): JsonResponse
    {
        $type = $request->type ?? 0;
        $last = $request->last ?? 0;
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $now = now();
        $three_minutes_ago = $now->subMinutes(5);
        $user_id = auth()->guard('api')->id();
        $chats = ChatRoom::leftJoin('user_chat_rooms', 'user_chat_rooms.chat_room_id', '=', 'chat_rooms.id')
            ->where('user_chat_rooms.user_id', $user_id)
            ->where('chat_rooms.id', $id)
//            ->select([])
            ->withCount(['users', 'online' => function ($query) use ($three_minutes_ago) {
                $query->leftJoin('users', 'users.id', '=', 'user_chat_rooms.user_id')
                    ->where('users.last_online_at', '>', $three_minutes_ago);
            }])
//            ->with(['users'])
            ->addSelect('chat_rooms.*', DB::raw('(SELECT ms.created_at FROM chat_room_messages as ms where ms.chat_room_id = chat_rooms.id order by ms.created_at desc limit 1) as date'))
            ->orderBy('date', 'DESC')
            ->first();
        if (!$chats) {
            return response()->json(['error' => 'Chat Not Found'], 400);

        }
        $messages = ChatRoomMessage::where('chat_room_id', $id)->with('user');
        $user_last = UserChatRoom::where('chat_room_id', $id)
            ->where('user_id', $user_id)->first();
        if ($user_last && $user_last->last_read && $last > 0) {
//            $messages = $messages->where('created_at', '>=', $user_last->last_read);
        } else if ($user_last && $page < 0) {
            $last_date = $user_last->last_read ?? now();
            $request->page = $page * (-1);
            $request->merge(['page' => $page * (-1)]);
            $messages = $messages->where('created_at', '<', $last_date)->orderBy('created_at', 'DESC');
        } else {
            $messages = $messages->orderBy('created_at', 'ASC');
        }
        if ($type > 0) {
            $messages = $messages->where('type', $type);
        }
        $users = UserChatRoom::where('chat_room_id', $id);
//            ->leftJoin('users', 'users.id', '=', 'user_chat_rooms.user_id')
//            ->select('users.name');
        $countU = $users->count();
        $countM = $messages->count();
//        $messages = $messages->forPage($page, $per_page)->get();
        $messages = $messages->paginate($per_page);
        if ($user_last->last_read){
            foreach ($messages as $message) {
                $message->read = $message->created_at >= $user_last->last_read ? 0 : 1;
            }
        }
//        dd($messages->toArray());
        if (count($messages) > 0) {
            $time_last = $messages[0]->created_at;
            UserChatRoom::where('chat_room_id', $id)
                ->where('user_id', $user_id)
                ->where(function ($query) use ($time_last) {
                    $query->Orwhere('last_read', '<', $time_last);
                    $query->OrwhereNull('last_read');
                })
                ->update(
                    [
                        "last_read" => $messages[0]->created_at
                    ]
                );
        }
        $users = $users->forPage($page, $per_page)->pluck('user_id');
        $users = User::whereIn('id', $users)->get();
        return $this->success(["chat" => $chats, "messages" => $messages, "count_message" => $countM, "users" => $users, "count_user" => $countU]);
    }

    /**
     * Get all chats
     */
    #[Get('/check')]
    #[Operation(tags: ['Chats'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getCheck(Request $request): JsonResponse
    {
        $user_id = auth()->guard('api')->id();
        $data = $request->all();
        if (isset($request->user_id)) {
            $room = ChatRoom::query()
                ->where('type', 'private')
                ->where('name', $user_id . ' - ' . $request->user_id)
                ->orWhere('name', $request->user_id . ' - ' . $user_id)
                ->first();
            if (!$room) {
                $room = ChatRoom::query()->create(
                    [
                        "name" => $user_id . ' - ' . $request->user_id,
                        "description" => $user_id . ' - ' . $request->user_id,
                        "avatar_image" => $user_id . ' - ' . $request->user_id,
                        "type" => 'private',
                    ]
                );
                $rom_user = UserChatRoom::query()->insert([
                    [
                        'user_id' => $user_id,
                        'chat_room_id' => $room->id
                    ],
                    [
                        'user_id' => $request->user_id,
                        'chat_room_id' => $room->id
                    ],
                ]);
            }
            $data['chat_room_id'] = $room->id;
        } else {
            return response()->json(['error' => 'Not Found User ID'], 400);
        }
        return $this->success(["data" => $data]);
    }


    /**
     * Create chat
     */
    #[\Spatie\RouteAttributes\Attributes\Post('/send')]
    public function sendMessage(Request $request): JsonResponse
    {
//
//        $user_id = auth()->guard('api')->id();
//        $message = [
//            'type' => 'message',
//            'data' => 'Hello, World!',
//        ];
//
//        $channelManager = app(ChannelManager::class);
//        $channelManager->driver('redis')->broadcastToAll('user.'.$user_id, $message);
//        event(new NewChatMessage("sdfs", "sdfsdf"));
//        event(new ChatMessage("sdfs", "sdfsdf"));
//        $channelManager = App::make(ChannelManager::class);
//        $channelManager->broadcastToAll('channel-name', $message);
        $request->validate([
            'message' => 'required|min:2',
            'type' => 'required|integer',
        ]);
        if (!isset($request->chat_room_id) && !isset($request->user_id)) {
            return response()->json(['error' => 'Chat_room_id or User_id required'], 400);
        }
        $data = $request->all();
        $user_id = auth()->guard('api')->id();
        $room = ChatRoom::where('chat_rooms.id', $request->chat_room_id)
            ->leftJoin('user_chat_rooms', 'user_chat_rooms.chat_room_id', '=', 'chat_rooms.id')
            ->where('user_chat_rooms.user_id', $user_id)
            ->first();
        if (isset($request->user_id)) {
//            $room = UserChatRoom::where('chat_rooms.type', 'private')
//                ->leftJoin('chat_rooms', 'chat_rooms.id', '=', 'user_chat_rooms.chat_room_id')
//                ->where('user_chat_rooms.user_id', $user_id)
//                ->select('*')
////                ->where('user_chat_rooms.user_id', $request->user_id)
//                /*->first()*/;
            $room = ChatRoom::query()
                ->where('type', 'private')
                ->where('name', $user_id . ' - ' . $request->user_id)
                ->orWhere('name', $request->user_id . ' - ' . $user_id)
                ->first();
            if (!$room) {
                $room = ChatRoom::query()->create(
                    [
                        "name" => $user_id . ' - ' . $request->user_id,
                        "description" => $user_id . ' - ' . $request->user_id,
                        "avatar_image" => $user_id . ' - ' . $request->user_id,
                        "type" => 'private',
                    ]
                );
                $rom_user = UserChatRoom::query()->insert([
                    [
                        'user_id' => $user_id,
                        'chat_room_id' => $room->id
                    ],
                    [
                        'user_id' => $request->user_id,
                        'chat_room_id' => $room->id
                    ],
                ]);
            }
            $data['chat_room_id'] = $room->id;
        }
        if (!$room) {
            return response()->json(['error' => 'Not Found Room Or Permission denied'], 400);
        }
        $data['user_id'] = $user_id;
//        $data['reply_to'] = $user_id;
//        dd($data);
        $message = ChatRoomMessage::query()->create(
            $data
        );
        $users = UserChatRoom::query()->where('chat_room_id', $request->chat_room_id ?? $room->id)->pluck('user_id');
        $post = [];
        $post['type'] = 'chat';
        $message->user = auth('api')->user();
        $post['message'] = $message;
        $post['users'] = $users;
        $client = new Client();
        $response = $client->post(env('SOCKET_HOST') . '/chat/send-message',
            ['json' => $post]);

        return $this->success(["message" => $message, "status" => $response, "post" => $post]);
    }

    /**
     * read message
     */
    #[\Spatie\RouteAttributes\Attributes\Post('/read')]
    public function readMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|integer',
            'chat_room_id' => 'required|integer',
        ]);
        if (!isset($request->message) && !isset($request->chat_room_id)) {
            return response()->json(['error' => 'Chat_room_id or User_id required'], 400);
        }
        $data = $request->all();
        $user_id = auth()->guard('api')->id();
        $message = ChatRoomMessage::query()->find($request->message);
        $time_last = $message->created_at;
        UserChatRoom::where('chat_room_id', $request->chat_room_id)
            ->where('user_id', $user_id)
            ->where(function ($query) use ($time_last) {
                $query->Orwhere('last_read', '<', $time_last);
                $query->OrwhereNull('last_read');
            })
            ->update(
                [
                    "last_read" => $time_last
                ]
            );
        return $this->success('success');
    }

    /**
     * Left Chat
     */
    #[\Spatie\RouteAttributes\Attributes\Post('/left')]
    public function leftChat(Request $request): JsonResponse
    {
        $request->validate([
            'chat_room_id' => 'required|integer',
        ]);
        if (!isset($request->chat_room_id)) {
            return response()->json(['error' => 'Chat_room_id or User_id required'], 400);
        }
        $data = $request->all();
        $user_id = auth()->guard('api')->id();
        UserChatRoom::where('chat_room_id', $request->chat_room_id)
            ->where('user_id', $user_id)
            ->delete();
        return $this->success('success');
    }


}
