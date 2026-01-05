<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameFeedback extends Model
{
    protected $table = 'game_feedbacks';

    protected $fillable = [
        'name',
        'email',
        'message',
        'idGame',
        'selectedSubject',
        'subject_text',
    ];
}