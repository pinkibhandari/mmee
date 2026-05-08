<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'site_id',
        'task_code',
        'task_type',
        'task_name',
        'title',
        'description',
        'work_notes',
        'created_by',
        'assigned_to',
        'priority',
        'status',
        'latitude',
        'longitude',
        'address',
        'due_date',
        'customer_name',
        'customer_phone',
        'started_at',
        'completed_at',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class);
    }
}
