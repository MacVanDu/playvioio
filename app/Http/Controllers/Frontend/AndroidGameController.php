<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameAndroid;
use App\Models\Setting;
use App\Models\Feedbackff;
use App\Models\CategoryAndroid;
use App\Models\Loai;

class AndroidGameController extends Controller
{
    public function index(Request $request)
    {
        return $this->index2('jumpingshell', $request);
    }
    public function quang_cao(Request $request)
    {
        $data = '';
        return view('kuioo.quang_cao.index', compact(
            'data'
        ))->render();
    }
    public function bat_quang_cao(Request $request)
    {
        $bat_quang_cao = Setting::where('key', 'bat_quang_cao')->value('value');
        $id_app_app_install = Setting::where('key', 'id_app_app_install')->value('value');
        return response()->json([
            'bat_quang_cao' => $bat_quang_cao === '1' ? true : false,
            'id_app_app_install' => json_decode($id_app_app_install, true) ?? []
        ]);

    }
    public function index2($slug = 'jumpingshell', Request $request)
    {
        $game_new = $this->getGame_new();
        $game_infotop = $this->getGame_infotop($slug);
        $id_b = [];
        foreach ($game_infotop as $data) {
            $id_b[] = $data->id;
        }
        foreach ($game_new as $data) {
            $id_b[] = $data->id;
        }
        $game_infocenter = $this->getGame_infocenter($id_b, $slug);
        foreach ($game_infocenter as $data) {
            $id_b[] = $data->id;
        }
        $data_game_all = GameAndroid::whereNotIn('id', $id_b)
            ->inRandomOrder()
            ->limit(15)
            ->get();

        $datamd = $this->data_mac_dinh();
        $ctl = Loai::where('slug', $slug)->first();
        return view('kuioo.pages.' . $slug, compact(
            'game_new',
            'game_infotop',
            'game_infocenter',
            'data_game_all',
            'slug',
            'ctl',
            'datamd',
        ))->render();
    }
    public function data_mac_dinh()
    {
        return [
            'data_c' => CategoryAndroid::limit(20)->get(),
            'game_ngau_nhien' => GameAndroid::inRandomOrder()
                ->limit(1)
                ->first()
        ];
    }
    public function allgame($slug = 'jumpingshell', Request $request)
    {
        $num = 1;
        $game_khac = GameAndroid::where('slug', '!=', $slug)
            ->orderBy('id', 'ASC')
            ->get();

        $ctl = Loai::where('slug', $slug)->first();

        return view('kuioo.pages.allgame', compact(
            'game_khac',
            'slug',
            'ctl'
        ))->render();
    }
    public function category($slug = 'jumpingshell', Request $request)
    {
        $arr_Category = CategoryAndroid::orderBy('id', 'ASC')
            ->get();
        $ctl = Loai::where('slug', $slug)->first();

        return view('kuioo.pages.category', compact(
            'slug',
            'ctl',
            'arr_Category',
        ))->render();
    }
    public function feedback($slug = 'jumpingshell', Request $request)
    {
        $ctl = Loai::where('slug', $slug)->first();
        return view('kuioo.pages.feedback', compact(
            'slug',
            'ctl',
        ))->render();
    }
    public function search(Request $request)
    {
        $slug = 'jumpingshell';
        $game_khac = GameAndroid::where('name', 'like', '%' . $request->name . '%')
            ->limit(30)
            ->get();
        $ctl = Loai::where('slug', $slug)->first();
        $datamd = $this->data_mac_dinh();
        return view('kuioo.pages.category2', compact(
            'slug',
            'ctl',
            'game_khac',
            'datamd',
        ))->render();
    }
    public function tlallgame($slug = 'jumpingshell', $idtl = '1', Request $request)
    {
        $game_khac = GameAndroid::where('loai', $idtl)
            ->orderBy('id', 'ASC')
            ->get();
        $ctl = Loai::where('slug', $slug)->first();
        if ($slug == 'jumpingshell') {
            $datamd = $this->data_mac_dinh();
            return view('kuioo.pages.category2', compact(
                'slug',
                'ctl',
                'game_khac',
                'datamd',
            ))->render();
        } else {
            return view('kuioo.pages.allgame', compact(
                'game_khac',
                'slug',
                'ctl'
            ))->render();
        }
    }
    public function detail($slug, Request $request)
    {
        $detail = GameAndroid::where('id', $slug)
            ->first();
        if (!$detail) {
            return $this->notFoundPage($request);
        }
        $detail['imgss']=$detail->linkImgGame();
        return view('kuioo.pages.thongtin', compact(
            'detail',
        ))->render();
    }  
     public function getGame_new()
    {
        $limit = 16;
            $game_new = GameAndroid::orderBy('id', 'DESC')
                ->limit($limit)
                ->get();
        return $game_new;
    }
    public function getGame_infotop($slug = 'jumpingshell')
    {
        $limit = 5;
        if ($slug == 'jumpingshell') {
            $limit = 5;
        }
        if ($slug == 'battlewheels') {
            $limit = 1;
        }
        $data_games = GameAndroid::where('slug', 'like', '%' . $slug . '%')
            ->limit($limit)
            ->orderBy('id', 'ASC')
            ->get();
        return $data_games;
    }
    public function getGame_infocenter($id_b = [], $slug = 'jumpingshell')
    {
        $data_game = GameAndroid::where('slug', 'like', '%' . $slug . '%')
            ->whereNotIn('id', $id_b)
            ->orderBy('id', 'DESC')
            ->get();
        return $data_game;
    }
    public function notFoundPage($request)
    {
        return $this->index($request);
    }
    public function get_game_data($request)
    {

        $idapp = $request->query('idapp');

        if (!$idapp) {
            return response()->json([]);
        }

        try {
            $data = GameAndroid::where('package', $idapp)->get();

            $arr_data = [];

            foreach ($data as $obj) {
                $item = [
                    'anh' => $obj->avatar,
                    'link' => $obj->linkGame,
                    'ten' => $obj->name,
                    'manDoc' => $obj->chieuManDoc == 0,
                    'setChieuManHinh' => $obj->setChieuMan == 1,
                ];

                $arr_data[] = $item;
            }

            return response()->json($arr_data);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }
    public function store(Request $request)
    {
        try {
            $feedback = new Feedbackff;
            $feedback->slug = $request->slug;
            $feedback->content = $request->content;
            $feedback->save();

            return response()->json(['status' => 'success', 'message' => 'Feedback sended successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'errors' => [$th->getMessage()]], 400);
        }
    }
}
