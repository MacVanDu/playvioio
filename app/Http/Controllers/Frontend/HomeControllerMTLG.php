<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GameService;
use App\Models\Pages;
use App\Models\Category;
use App\Models\Setting;

class HomeControllerMTLG extends Controller
{
    private $gameService;

    public function __construct( GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index(Request $request)
    {
        $datamd = $this->data_mac_dinh();
        $games = $this->gameService->get_game_xuat_hien_trang_chu();
        $container_home = Setting::getValue('container_home', '', false);
        $ma_head_trang_chu = Setting::getValue('ma_head_trang_chu', '', false);
        return view('game.pages.index', 
        array_merge(compact('datamd','container_home','ma_head_trang_chu',), $games))->render();
    }
    public function pages($slug, Request $request)
    {
        $detail = Pages::where('slug', $slug)->first();
        if (!$detail) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh();
        return view('game.pages.pages', compact(
            'datamd',
            'detail',
        ));
    }
    public function category(Request $request, $slug, $page = 1)
    {
        $datamd = $this->data_mac_dinh();

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return $this->notFoundPage($request);
        }

        $perPage = 30;

      

        $gamesQuery = $this->gameService->get_game_table_p()->where('category_id', $category->id)
            ->orderBy('id', 'DESC');

        $data_games = $gamesQuery->paginate($perPage, ['*'], 'page', $page);

       
            return view('game.pages.theloai', compact(
                'data_games',
                'category',
                'datamd',
                'slug',   
            ));
    }
    public function detail($slug, Request $request)
    {

        $detail = $this->gameService->get_infor_game($slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        $datamd = $this->data_mac_dinh();
        $games = $this->gameService->get_game_trang_choi($detail->category_id);
        return view('game.pages.thongtin', 
        array_merge(compact('datamd','detail'), $games))->render();
    }
    public function splash($slug, Request $request)
    {

        $detail = $this->gameService->get_infor_game($slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        return view('game.pages.splash', 
        compact('detail'))->render();
    }
    public function search(Request $request)
    {
        if (!$request->name) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh();

        $names = $request->name;
            $data_games = [];
            if ($request->name) {
                $data_games = $this->gameService->get_game_theo_tu_khoa($request->name);
            }
            $length = count($data_games);
            $thongBao = 'Search results: ' . $request->name;


            return view('game.pages.timkiem', compact(
                'thongBao',
                'length',
                'names',
                'datamd',
                'data_games',
            ))->render();
        
    }
    public function notFoundPage($request)
    {
        $datamd = $this->data_mac_dinh();
        return view('game.pages.404', compact(
            'datamd',
        ))->render();
    }
    public function data_mac_dinh()
    {
        return [
            'category' => Category::orderBy('id', 'DESC')
                ->limit(10)
                ->get(),
        ];
    }
}
