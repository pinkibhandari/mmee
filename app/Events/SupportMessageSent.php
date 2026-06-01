<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SupportMessage;

class SupportMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public function __construct(SupportMessage $message)
    {
        $this->message = $message;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('support-chat.' . $this->message->chat_id),
        ];
    }

    public function broadcastAs()
    {
        return 'support.message';
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'sender_id' => $this->message->sender_id,
            'message' => $this->message->message,
            'message_type' => $this->message->message_type,
            'created_at' => $this->message->created_at,
        ];
    }
}
