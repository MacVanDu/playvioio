<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'note','type'];
     public static function getValue(string $key, $default = null, $castInt = false)
    {
        $value = static::where('key', $key)->value('value') ?? $default;
        return $castInt ? (int) $value : $value;
    }
}
