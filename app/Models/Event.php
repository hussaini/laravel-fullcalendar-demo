<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_enabled' => 'boolean',
    ];

    protected $dateFormat = 'U';
}
