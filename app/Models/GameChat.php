<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameChat extends Model
{
    protected $table = 'game_chats';

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_HIDDEN  = 2;

    protected $fillable = [
        'game_id',
        'username',
        'message',
        'status',
    ];

    protected $casts = [
        'game_id' => 'integer',
        'status'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeByGame($query, $gameId)
    {
        return $query->where('game_id', $gameId);
    }
}
