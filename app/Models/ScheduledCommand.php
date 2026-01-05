<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ScheduledCommand extends Model
{
    protected $fillable = ['command', 'expression', 'time', 'enabled','note'];
}