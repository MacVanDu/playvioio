<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GameService;
use App\Models\Pages;
use App\Models\GameChat;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

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
        $container_home = Setting::getTranslatedValue('container_home', '', false);
        $tile_trang_chu = Setting::getTranslatedValue('tile_trang_chu', '', false);
        $description_trang_chu = Setting::getTranslatedValue('description_trang_chu', '', false);
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

    public function localizedIndex(Request $request)
    {
        return $this->index($request);
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

    public function localizedPages($slug, Request $request)
    {
        return $this->pages($slug, $request);
    }
    public function category(Request $request, $slug, $page = 1)
    {
        $datamd = $this->data_mac_dinh($request);

        $category = Cache::remember("category:by-slug:{$slug}:v2", 1800, function () use ($slug) {
            return Category::where('slug', $slug)->first();
        });
        if (!$category) {
            return $this->notFoundPage($request);
        }

        $perPage = 20;

        $device = $this->detectDevice($request);
        $locale = app()->getLocale();
        $data_games = Cache::remember("category:{$category->id}:page:{$page}:{$device}:{$locale}:v2", 1800, function () use ($request, $category, $perPage, $page) {
            return $this->gameService->get_game_table_p($request)
                ->where('category_id', $category->id)
                ->orderBy('id', 'DESC')
                ->paginate($perPage, ['*'], 'page', $page);
        });


        return view('game.pages.theloai', compact(
            'data_games',
            'category',
            'datamd',
            'slug',
        ));
    }

    public function localizedCategory(Request $request, $slug, $page = 1)
    {
        return $this->category($request, $slug, $page);
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

    public function localizedDetail($slug, Request $request)
    {
        return $this->detail($slug, $request);
    }
    public function splash($slug, Request $request)
    {

        $detail = $this->gameService->get_infor_game($request, $slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        return response(view(
            'game.pages.splash',
            compact('detail')
        )->render())->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function localizedSplash($slug, Request $request)
    {
        return $this->splash($slug, $request);
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
        $thongBao = __('messages.search_results', ['query' => $request->name]);
        $suggested_games = $length === 0
            ? $this->gameService->get_game_table_p($request)
                ->orderBy('trend', 'DESC')
                ->orderBy('id', 'DESC')
                ->limit(12)
                ->get()
            : collect();


        return view('game.pages.timkiem', compact(
            'thongBao',
            'length',
            'names',
            'datamd',
            'data_games',
            'suggested_games',
        ))->render();
    }

    public function localizedSearch(Request $request)
    {
        return $this->search($request);
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
        $device = $this->detectDevice($request);
        $locale = app()->getLocale();

        return Cache::remember("frontend:default-data:{$locale}:{$device}:v3", 1800, function () use ($device) {
            return [
                'anh_nen' => Setting::getValue('anh_nen', '/images/bg2.png', false),
                'r_link' => Setting::getValue('r_link', '#', false),
                'x_link' => Setting::getValue('x_link', '#', false),
                'fb_link' => Setting::getValue('fb_link', '#', false),
                'device' => $device,
                'head_qc' => Setting::getValue('head_qc', '', false),
                'qc_trang_chu' => Setting::getValue('qc_trang_chu', '', false),
                'qc_trang_game728x90' => Setting::getValue('qc_trang_game728x90', '', false),
                'qc_trang_game300x600' => Setting::getValue('qc_trang_game300x600', '', false),
                'qc_trang_game160x600' => Setting::getValue('qc_trang_game160x600', '', false),
                'category' => Category::orderBy('id', 'DESC')
                    ->limit(10)
                    ->get(),
            ];
        });
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
