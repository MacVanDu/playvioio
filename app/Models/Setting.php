<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\GoogleTranslate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'note','type'];
     public static function getValue(string $key, $default = null, $castInt = false)
    {
        $value = static::where('key', $key)->value('value') ?? $default;
        return $castInt ? (int) $value : $value;
    }

    public static function getTranslatedValue(string $key, $default = null, $castInt = false)
    {
        $value = static::getValue($key, $default, false);
        $locale = request()->route('locale') ?? request()->segment(1);
        $defaultLocale = config('locales.default', 'en');

        if ($castInt || !$locale || $locale === $defaultLocale || !in_array($locale, config('locales.supported', []), true)) {
            return $castInt ? (int) $value : $value;
        }

        if (!Schema::hasTable('setting_translations')) {
            return $value;
        }

        $translated = DB::table('setting_translations')
            ->where('setting_key', $key)
            ->where('locale', $locale)
            ->value('value');

        if ($translated) {
            return $translated;
        }

        $translated = GoogleTranslate::translate($value, $locale);
        if (!$translated) {
            return $value;
        }

        DB::table('setting_translations')->updateOrInsert(
            ['setting_key' => $key, 'locale' => $locale],
            [
                'value' => $translated,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return $translated;
    }
}
