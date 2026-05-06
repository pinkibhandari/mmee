<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    protected $fillable = [
        'task_id',
        'action',
        'action_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
