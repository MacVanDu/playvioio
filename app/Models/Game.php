<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = true;
    protected $table = "games";
    protected $guarded = [];


    function slugGame()
    {
        return $this->localePrefix() . '/g/' . $this->slug;
    }
    function slugsplashPlay()
    {
        return $this->localePrefix() . '/splash/' . $this->slug;
    }
    function linkImgGame()
    {
        $image = $this->image;
        return $this->webpImage($image);
    }
    function linkImgGameBG()
    {
        $image = $this->webpImage($this->image);
        return 'background-image: url('.$image.');';
    }
    function nameGame()
    {
        return '' . ($this->translated('name') ?? $this->name);
    }
    function getLinkIframe()
    {
        return $this->link;
    }
    public function getTheloai()
    {
        $data_c = Category::where('id', $this->category_id)
            ->first();
        return $data_c;
    }
    public function getMangTheLoai()
    {
        $arr = Category::where('id', $this->category_id)
            ->get();
        return $arr;
    }
    public function name_schema()
    {
        return ($this->translated('name') ?? $this->name) . ' ';
    }

    function description()
    {
        $description = str_replace('https://ant.games', '', $this->translated('description') ?? $this->description);

        return $description;
    }
    function titleText()
    {
        return $this->translated('title') ?? $this->title;
    }
    function seoDescription()
    {
        return $this->translated('description_seo') ?? $this->description_seo;
    }
    //======================================================
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    function webpImage($image)
    {
        if (!$image) {
            return $image;
        }

        $path = parse_url($image, PHP_URL_PATH);

        if (!$path || !preg_match('/\.(jpe?g|png)$/i', $path)) {
            return $image;
        }

        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
        $publicPath = public_path(ltrim($webpPath, '/'));

        if (is_file($publicPath)) {
            return $webpPath;
        }

        return $image;
    }
    function translated($field)
    {
        $translation = $this->currentTranslation();

        return $translation && !empty($translation->{$field}) ? $translation->{$field} : null;
    }
    function currentTranslation()
    {
        $locale = $this->currentLocale();

        if ($locale === config('locales.default', 'en')) {
            return null;
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('game_translations')) {
            return null;
        }

        if (!$this->relationLoaded('translations')) {
            $this->loadMissing('translations');
        }

        return $this->translations->firstWhere('locale', $locale);
    }
    public function translations()
    {
        return $this->hasMany(GameTranslation::class, 'game_id', 'id');
    }
    function description_h()
    {
        $rawHtml = $this->translated('description') ?? $this->description ?? '';

    // 1. Decode HTML entities (&nbsp; &aacute; ...)
    $decoded = html_entity_decode($rawHtml, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 2. Bỏ toàn bộ thẻ HTML
    $plainText = trim(strip_tags($decoded));

    // 3. Chuẩn hoá khoảng trắng
    $plainText = preg_replace('/\s+/u', ' ', $plainText);

    // 4. Giới hạn ký tự (SEO ~150–160)
    return Str::limit($plainText, 160, '...');
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
   
