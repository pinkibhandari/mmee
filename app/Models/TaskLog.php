<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = [
        'task_id',
        'action',
        'action_at',
        'latitude',
        'longitude',
        'status',
        'comment'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function files()
    {
        return $this->hasMany(TaskLogFile::class);
    }
}
