<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

class GameService
{
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
    private function get_game_table(Request $request)
    {

        if ($this->checkMobile($request)) {
            return Game::where('mobile',1);
        } else {
            return Game::query();
        }
    }
    public function get_game_table_p(Request $request)
    {
        return $this->get_game_table($request);
    }
    public function get_game_theo_tu_khoa(Request $request,$q, $limit = 50)
    {
        return $this->get_game_table($request)->where('description', 'like', '%' . $q . '%')
            ->orWhere('name', 'like', '%' . $q . '%')
            ->limit($limit)
            ->get();
    }
    public function get_infor_game(Request $request,$slug)
    {
        return $this->get_game_table($request)
            ->where('slug', $slug)->first();
    }
    public function get_game_trang_choi(Request $request,$id): array
    {

        $similar_games =    Game::where('category_id', $id)->orderBy('id', 'DESC')->limit(12)->get();

        $excludeIds = $similar_games->pluck('id')->toArray();

        $you_may_like_games = $this->get_game_table($request)
            ->orderBy('id', 'DESC')
            ->whereNotIn('id', $excludeIds)
            ->limit(12)
            ->get();

        $excludeIds = array_merge($excludeIds, $you_may_like_games->pluck('id')->toArray());
        $popular_games = $this->get_game_table($request)
            ->orderBy('id', 'DESC')
            ->whereNotIn('id', $excludeIds)
            ->limit(12)
            ->get();
        return [
            'similar_games' => $similar_games,
            'you_may_like_games' => $you_may_like_games,
            'popular_games' => $popular_games,
        ];
    }
    public function get_game_xuat_hien_trang_chu(Request $request): array
    {
        $game_dau = $this->get_game_table( $request)
            ->orderBy('trend', 'DESC')
            ->limit(15)
            ->get();
        $excludeIds = $game_dau->pluck('id')->toArray();

        $game_new = $this->get_game_table( $request)
            ->whereNotIn('id', $excludeIds)
            ->limit(10)
            ->get();
        $categories = Category::orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        return [
            'game_dau' => $game_dau,
            'game_new' => $game_new,
            'categories_home' => $categories,
        ];
    }
}
