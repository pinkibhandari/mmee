<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'service_id',
        'user_id',
        'expert_id',
        'address_id',
        'status',
        'assigned_at',
        'completed_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
    'assigned_at' => 'date',
    'completed_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    //    public function address()
//    {
//        return $this->belongsTo(Address::class);
//    }
}
