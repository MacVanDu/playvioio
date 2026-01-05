<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = ['name','key','daily_limit','used_today','active','last_used_at'];
    protected $casts = [
        'active' => 'boolean',
    ];
}
