<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    protected $fillable = [
        'user_id',
        'status'
    ];

    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'chat_id');
    }
}
