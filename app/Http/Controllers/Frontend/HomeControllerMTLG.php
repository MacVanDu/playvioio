<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GameService;
use App\Models\Pages;
use App\Models\GameChat;
use App\Models\Category;
use App\Models\Setting;

class HomeControllerMTLG extends Controller
{
    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index(Request $request)
    {
        $datamd = $this->data_mac_dinh($request);
        $games = $this->gameService->get_game_xuat_hien_trang_chu($request);
        $container_home = Setting::getValue('container_home', '', false);
        $tile_trang_chu = Setting::getValue('tile_trang_chu', '', false);
        $description_trang_chu = Setting::getValue('description_trang_chu', '', false);
        $ma_head_trang_chu = Setting::getValue('ma_head_trang_chu', '', false);
        return view(
            'game.pages.index',
            array_merge(compact(
                'datamd',
                'container_home',
                'tile_trang_chu',
                'description_trang_chu',
                'ma_head_trang_chu',
            ), $games)
        )->render();
    }
    public function pages($slug, Request $request)
    {
        $detail = Pages::where('slug', $slug)->first();
        if (!$detail) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh($request);
        return view('game.pages.pages', compact(
            'datamd',
            'detail',
        ));
    }
    public function category(Request $request, $slug, $page = 1)
    {
        $datamd = $this->data_mac_dinh($request);

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return $this->notFoundPage($request);
        }

        $perPage = 20;



        $gamesQuery = $this->gameService->get_game_table_p($request)->where('category_id', $category->id)
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

        $detail = $this->gameService->get_infor_game($request, $slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        $datamd = $this->data_mac_dinh($request);
        $games = $this->gameService->get_game_trang_choi($request, $detail->category_id);
        $chats = GameChat::byGame($detail->id)
            ->active()
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        return view(
            'game.pages.thongtin',
            array_merge(
                compact('datamd', 'detail', 'chats'),
                $games
            )
        );
    }
    public function splash($slug, Request $request)
    {

        $detail = $this->gameService->get_infor_game($request, $slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        return view(
            'game.pages.splash',
            compact('detail')
        )->render();
    }
    public function search(Request $request)
    {
        if (!$request->name) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh($request);

        $names = $request->name;
        $data_games = [];
        if ($request->name) {
            $data_games = $this->gameService->get_game_theo_tu_khoa($request, $request->name);
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
        $datamd = $this->data_mac_dinh($request);
        return view('game.pages.404', compact(
            'datamd',
        ))->render();
    }
    public function data_mac_dinh(Request $request)
    {
        $fb_link = Setting::getValue('fb_link', '#', false);
        $x_link = Setting::getValue('x_link', '#', false);
        $r_link = Setting::getValue('r_link', '#', false);
        $device = $this->detectDevice($request);
        return [
            'r_link' => $r_link,
            'x_link' => $x_link,
            'fb_link' => $fb_link,
            'device' => $device,
            'category' => Category::orderBy('id', 'DESC')
                ->limit(10)
                ->get(),
        ];
    }

    //=======================

    public function checkMobile(Request $request): bool
    {
        $device = $this->detectDevice($request);
        if ($device === 'MB') {
            return true;
        } else {
            return false;
        }
    }
    public function detectDevice(Request $request): string
    {
        $userAgent = $request->header('User-Agent');

        // iPad
        if (preg_match('/ipad/i', $userAgent)) {
            return 'TL';
        }

        // Android Tablet (có Android nhưng KHÔNG có Mobile)
        if (preg_match('/android/i', $userAgent) && !preg_match('/mobile/i', $userAgent)) {
            return 'TL'; // Tablet
        }

        // Các loại tablet khác (generic)
        if (preg_match('/tablet/i', $userAgent)) {
            return 'TL';
        }


        // iPhone / Android / iPod
        if (preg_match('/mobile|android|iphone|ipod/i', $userAgent)) {
            return 'MB'; // Mobile
        }

        // Desktop
        return 'PC';
    }
}
