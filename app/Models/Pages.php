<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\GoogleTranslate;
use Illuminate\Support\Facades\DB;

class Pages extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'contents',
    ];

    public $timestamps = false;

    public function titleText()
    {
        return $this->translated('title') ?? $this->title;
    }

    public function contentsText()
    {
        return $this->translated('contents') ?? $this->contents;
    }

    public function translated($field)
    {
        $translation = $this->currentTranslation();

        if ($translation && !empty($translation->{$field})) {
            return $translation->{$field};
        }

        return $this->translateMissingField($field);
    }

    public function currentTranslation()
    {
        $locale = $this->currentLocale();

        if ($locale === config('locales.default', 'en')) {
            return null;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('page_translations')) {
            return null;
        }

        if (!$this->relationLoaded('translations')) {
            $this->loadMissing('translations');
        }

        return $this->translations->firstWhere('locale', $locale);
    }

    public function translations()
    {
        return $this->hasMany(PageTranslation::class, 'page_id', 'id');
    }
    private function translateMissingField(string $field): ?string
    {
        $locale = $this->currentLocale();

        if ($locale === config('locales.default', 'en')) {
            return null;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('page_translations')) {
            return null;
        }

        $translated = GoogleTranslate::translate($this->{$field} ?? null, $locale);
        if (!$translated) {
            return null;
        }

        DB::table('page_translations')->updateOrInsert(
            ['page_id' => $this->id, 'locale' => $locale],
            [
                $field => $translated,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return $translated;
    }

    private function currentLocale(): string
    {
        $locale = request()->route('locale') ?? request()->segment(1);

        return in_array($locale, config('locales.supported', []), true) ? $locale : config('locales.default', 'en');
    }
}
