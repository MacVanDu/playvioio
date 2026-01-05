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


    function  copylink()
    {
        return 'https://www.apkgosu.fun/g/' . $this->slug;
    }
    function slugGame()
    {
        return '/g/' . $this->slug;
    }
    function slugPlay()
    {
        return '/play/' . $this->slug;
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
    function wImgGame()
    {

        if (str_contains($this->image, 'img.gamepix.com')) {
            return 320;
        } else if (str_contains($this->image, 'img.cdn.famobi.com')) {
            return 320;
        } else if (str_contains($this->image, 'imgr2.akdgame.com')) {
            return 220;
        }
        return 200;
    }
    function hImgGame()
    {

        if (str_contains($this->image, 'img.gamepix.com')) {
            return 200;
        } else if (str_contains($this->image, 'img.cdn.famobi.com')) {
            return 320;
        } else if (str_contains($this->image, 'imgr2.akdgame.com')) {
            return 220;
        }
        return 200;
    }
    function nameGame()
    {
        return '' . $this->name;
    }
    function videoGame()
    {
        if (!empty($this->video_short)) {
            if (str_contains($this->video_short, 'https://')) {
                return $this->video_short;
            }

            return 'https://assets.ant.games' . $this->video_short;
        }
return $this->video_short;
        // return 'https://assets.ant.games/203/thumbnail.3x3.h264.mp4';
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

    function icon_h()
    {
        return '' . $this->linkImgGame();
    }
    function description_h()
    {
        $rawHtml = $this->description;
        $plainText = strip_tags($rawHtml);
        $truncated = Str::limit($plainText, 100, '...');
        return $truncated;
    }
    function description()
    {
        $description = str_replace('https://ant.games', '', $this->description);

        return $description;
    }
    function likes()
    {
        return ''.$this->vote_like;
    }
    function dislikes()
    {
        return ''.$this->vote_dis_like;
    }
    //======================================================
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function tag_arr()
    {
        if (empty($this->tags)) {
        return array_map('trim', explode(' ', $this->name));
        }
        return array_map('trim', explode(',', $this->tags));
        
    }
    public function tag_arr_string()
    {
        if (empty($this->tags)) {
        return $this->name;
        }
        return $this->tags;
        
    }

    public function isInLast40()
{
    $ids = Game::orderBy('id', 'DESC')
               ->limit(20)
               ->pluck('id');
    return $ids->contains($this->id);
}
    public function isTrend()
{
    return $this->trend === 1;
}

public function isUpdatedThisMonth()
{
    if (!$this->updated_at) return false;

    return $this->updated_at->isSameMonth(Carbon::now());
}
public function isTopLike()
{
    $ids = Game::orderBy('vote_like', 'DESC')
                ->limit(10)
               ->pluck('id');
    return $ids->contains($this->id);
}


}
   