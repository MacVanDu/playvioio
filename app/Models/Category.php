<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = [
        'name',
        'slug',
        'imagesvg',
    ];

    public $timestamps = true;


    public function slug()
    {
        return '/c/' . $this->slug;
    }

    public function name()
    {
        return $this->name;
    }

    public function img()
    {
        return $this->imagesvg;
    }
    public function games()
    {
        return $this->hasMany(Game::class, 'category_id');
    }
    public function games10($device)
    {
        if ($device === 'MB') {
        return Game::where('category_id', $this->id)->where('mobile','1')->orderBy('id', 'DESC')->limit(10)->get();;
        } else {
        return Game::where('category_id', $this->id)->orderBy('id', 'DESC')->limit(10)->get();
        }
    }
}
