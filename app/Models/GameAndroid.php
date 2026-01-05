<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Facades\Log;

class GameAndroid extends Model
{

    protected $table = "game_android";
    protected $fillable = [
        'name', 'slug', 'mau', 'iframe', 'description',
        'tags', 'logo', 'anh_nen', 'video',
        'loai', 'man_ngang', 'hienbanner',
    ];
    function slugGame()
    {
        return '/android/g/' . $this->id;
    }
    function slugPlay()
    {
        return '/android/play/' . $this->id;
    }
    function linkImgGame()
    {
        if (str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        } else {
            return 'https://apiofff.uno/game_logo/' . $this->slug . '/' . $this->logo . '.jpg';
        }
    }
    function anhNen()
    {
        if (str_starts_with($this->anh_nen, 'https://')) {
            return $this->anh_nen;
        } else {
        $length_anh_nen = strlen('' . $this->anh_nen);
        if ($length_anh_nen > 5) {
            return 'https://apiofff.uno/game_banner/' . $this->slug . '/' . $this->anh_nen . '.jpg';
        } else {
            return $this->linkImgGame();
        }
        }
    }
    function nameGame()
    {
        return '' . $this->name;
    }
    function motaGame()
    {
        return $this->description;
    }
    function mauGame()
    {
        return '#' . $this->mau;
    }
    function videoGame()
    {
        return $this->video;
    }
    function getLinkIframe()
    {
        return $this->iframe;
    }
    public function getTheloai()
    {
        $data_c = CategoryAndroid::select(array('slug', 'name'))
            ->where('id', $this->loai)
            ->first();
        return $data_c;
    }
}
