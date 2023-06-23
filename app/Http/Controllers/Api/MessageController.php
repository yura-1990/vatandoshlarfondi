<?php

namespace App\Http\Controllers\Api;

use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function broadcast(Request $request) {
        if (! $request->filled('message')) {
            return response()->json([
                'message' => 'No message to send'
            ], 422);
        }

        // TODO: Sanitize input
        $user_id = auth()->guard('api')->id();
        event(new NewChatMessage($request->message, $user_id));

        return response()->json([], 200);

    }
}
