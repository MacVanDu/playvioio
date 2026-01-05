<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedbackff extends Model

{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "feedbackff";

    function slug()
    {
        return $this->slug;
    }
    function content()
    {
        return $this->content;
    }
}
