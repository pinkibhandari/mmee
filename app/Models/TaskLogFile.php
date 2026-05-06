<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLogFile extends Model
{
    protected $fillable = [
        'task_log_id',
        'file_path',
        'file_type',
    ];

    public function log()
    {
        return $this->belongsTo(TaskLog::class, 'task_log_id');
    }
}
