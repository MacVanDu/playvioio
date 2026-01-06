<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pages extends Model
{

    protected $table = "pages"; 
    protected $guarded = [
        'title',
        'slug',
        'contents'
    ]; 
        public $timestamps = false; 
}
