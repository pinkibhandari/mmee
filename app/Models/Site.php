<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
    'site_name',
    'latitude',
    'longitude',
    'address',
    'status'
];
}
