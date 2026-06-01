<?php

namespace App\Http\Controllers\Api;

use App\Events\SupportMessageSent;
use App\Http\Controllers\Controller;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
  
    // CREATE CHAT
    public function createChat()
      {
        $chat = SupportChat::where('user_id', auth()->id() )
                ->where('status', 'open')
                ->first();
        if (!$chat) {
            $chat = SupportChat::create([
                'user_id' => auth()->id(),
                'status' => 'open'
            ]);
        }
        return response()->json([
            'code'=> 200,
            'status' => true,
            'message' => 'Chat created',
            'data' => $chat
        ]);
    }

    // SEND MESSAGE
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:support_chats,id',
            'message' => 'required',
        ]);

        $message = SupportMessage::create([
            'chat_id' => $request->chat_id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_seen' => false
        ]);
        //  REALTIME EVENT
        broadcast(
            new SupportMessageSent($message)
        )->toOthers();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Message sent',
            'data' => $message
        ]);
    }

    //  GET CHAT MESSAGES
    public function messages($chat_id)
    {
        $messages = SupportMessage::where( 'chat_id', $chat_id )
                ->orderBy('id', 'asc')
               ->get();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Messages retrieved',
            'data' => $messages
        ]);
    }

}
