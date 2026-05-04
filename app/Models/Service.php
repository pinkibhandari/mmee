<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function serviceRequest()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
