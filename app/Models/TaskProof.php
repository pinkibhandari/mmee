<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProof extends Model
{
    protected $fillable = [
        'task_id',
        'file_path',
        'file_type',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
