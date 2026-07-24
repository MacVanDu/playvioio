<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Support\GoogleTranslate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'description_seo',
        'imagesvg',
    ];

    public $timestamps = true;


    public function slug()
    {
        return $this->localePrefix() . '/c/' . $this->slug;
    }

    public function name()
    {
        return $this->translated('name') ?? $this->name;
    }

    public function img()
    {
        return $this->imagesvg;
    }
    public function games()
    {
        return $this->hasMany(Game::class, 'category_id');
    }
    public function games10($device, $limit = 10)
    {
        return Cache::remember("category:{$this->id}:games:{$device}:{$limit}:v2", 1800, function () use ($device, $limit) {
            if ($device === 'MB') {
                return Game::where('category_id', $this->id)->where('mobile', '1')->orderBy('id', 'DESC')->limit($limit)->get();
            } else {
                return Game::where('category_id', $this->id)->orderBy('id', 'DESC')->limit($limit)->get();
            }
        });
    }
    public function titleText()
    {
        return $this->translated('title') ?? $this->title;
    }
    public function seoDescription()
    {
        return $this->translated('description_seo') ?? $this->description_seo;
    }
    public function descriptionText()
    {
        return $this->translated('description') ?? $this->description;
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

        if (!\Illuminate\Support\Facades\Schema::hasTable('category_translations')) {
            return null;
        }

        if (!$this->relationLoaded('translations')) {
            $this->loadMissing('translations');
        }

        return $this->translations->firstWhere('locale', $locale);
    }
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }
    private function translateMissingField(string $field): ?string
    {
        $locale = $this->currentLocale();

        if ($locale === config('locales.default', 'en')) {
            return null;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('category_translations')) {
            return null;
        }

        $translated = GoogleTranslate::translate($this->{$field} ?? null, $locale);
        if (!$translated) {
            return null;
        }

        DB::table('category_translations')->updateOrInsert(
            ['category_id' => $this->id, 'locale' => $locale],
            [
                $field => $translated,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return $translated;
    }

    private function localePrefix(): string
    {
        $locale = $this->currentLocale();
        $default = config('locales.default');

        return $locale && $locale !== $default ? '/' . $locale : '';
    }
    private function currentLocale(): string
    {
        $locale = request()->route('locale') ?? request()->segment(1);

        return in_array($locale, config('locales.supported', []), true) ? $locale : config('locales.default', 'en');
    }
}
