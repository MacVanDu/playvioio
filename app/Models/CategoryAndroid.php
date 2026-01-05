<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAndroid extends Model
{
    protected $table = "category_android"; 
    function slugk($slug){
        return '/android/tl/'.$slug.'/'.$this->id;
    }
    function names(){
        return $this->name;
    }
    function icon(){
        if($this->icon){
            return 'http://apiofff.uno/anh_the_loai/'.$this->icon.'.png';
        }else{
            return $this->icon;
        }
    }
}

