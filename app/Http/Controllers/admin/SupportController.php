<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\SupportMessageSent;
use App\Models\SupportChat;
use App\Models\SupportMessage;

class SupportController extends Controller
{
    public function index()
    {
        $chats = SupportChat::latest()
            ->get();
        return view('admin.support.index', compact('chats'));
    }

    public function chatMessages($chat_id)
    {
        // GET ALL CHATS
        $chats = SupportChat::latest()->get();
        // GET SELECTED CHAT
        $chat = SupportChat::findOrFail($chat_id);
        //  CHAT MESSAGES 
        $messages = SupportMessage::where('chat_id', $chat_id)
            ->orderBy('id', 'asc')
            ->get();
        return view('admin.support.index', compact('chats', 'chat', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:support_chats,id',
            'message' => 'nullable',
        ]);
        $messageText = $request->message;
        $message = SupportMessage::create([
            'chat_id' => $request->chat_id,
            'sender_id' => auth()->id(),
            'message' => $messageText,
            'is_seen' => false
        ]);
        broadcast(new SupportMessageSent($message))->toOthers();
        return redirect()->back()
            ->with('success', 'Message sent successfully');
    }

    public function closeChat(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:support_chats,id',
        ]);
        $chat = SupportChat::findOrFail($request->chat_id);
        $chat->status = 'closed';
        $chat->save();
        return redirect()->back()
            ->with('success', 'Chat closed successfully');
    }

}
