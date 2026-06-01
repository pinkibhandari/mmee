<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
