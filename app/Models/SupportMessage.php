<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
     protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'message_type',
        'is_seen'
    ];
}
