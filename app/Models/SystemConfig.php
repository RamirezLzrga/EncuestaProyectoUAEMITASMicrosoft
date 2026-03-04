<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SystemConfig extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'system_config';

    protected $fillable = [
        'general',
        'mail',
        'security',
        'limits',
    ];

    protected $casts = [
        'general' => 'array',
        'mail' => 'array',
        'security' => 'array',
        'limits' => 'array',
    ];
}

