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
        return '/g/' . $this->slug;
    }
    function slugsplashPlay()
    {
        return '/splash/' . $this->slug;
    }
    function linkImgGame()
    {
        $image = $this->image;
        return $image;
    }
    function linkImgGameBG()
    {
        $image = $this->image;
        return 'background-image: url('.$image.');';
    }
    function nameGame()
    {
        return '' . $this->name;
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
        return $this->name . ' ';
    }

    function description()
    {
        $description = str_replace('https://ant.games', '', $this->description);

        return $description;
    }
    //======================================================
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    function description_h()
    {
        $rawHtml = $this->description ?? '';

    // 1. Decode HTML entities (&nbsp; &aacute; ...)
    $decoded = html_entity_decode($rawHtml, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 2. Bỏ toàn bộ thẻ HTML
    $plainText = trim(strip_tags($decoded));

    // 3. Chuẩn hoá khoảng trắng
    $plainText = preg_replace('/\s+/u', ' ', $plainText);

    // 4. Giới hạn ký tự (SEO ~150–160)
    return Str::limit($plainText, 160, '...');
    }
}
   