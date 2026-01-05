<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loai extends Model
{
    protected $table = "loai"; 
    
    function names(){
        return $this->name;
    } 
       function icon(){
        return '/data/logo/'.$this->icon.'.png';
    }
       function iconfd(){
        return '/data/footer_logo/'.$this->icon.'.png';
    }
}

