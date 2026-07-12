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
            return Game::query();
            // return Game::where('mobile',1);
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

        $similar_games =  $this->get_game_table($request)->where('category_id', $id)->orderBy('id', 'DESC')->limit(24)->get();

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
        $categories = $this->homeCategories();
        return [
            'game_dau' => $game_dau,
            'game_new' => $game_new,
            'categories_home' => $categories,
        ];
    }

    private function homeCategories()
    {
        $categories = Category::orderBy('id', 'DESC')
            ->limit(10)
            ->get();

        $twoPlayerMario = Category::where('slug', '2-player-mario')->first();
        if ($twoPlayerMario) {
            $categories = $categories
                ->prepend($twoPlayerMario)
                ->unique('id')
                ->values();
        }

        $contraIndex = $categories->search(function ($category) {
            return str_contains(strtolower($category->slug ?? ''), 'contra')
                || str_contains(strtolower($category->name ?? ''), 'contra');
        });

        $superMarioIndex = $categories->search(function ($category) {
            $slug = strtolower($category->slug ?? '');
            $name = strtolower($category->name ?? '');

            return str_contains($slug, 'super-mario')
                || str_contains($name, 'super mario');
        });

        if ($contraIndex !== false && $superMarioIndex !== false) {
            $items = $categories->values()->all();
            [$items[$contraIndex], $items[$superMarioIndex]] = [$items[$superMarioIndex], $items[$contraIndex]];
            $categories = collect($items);
        }

        $superMario = $categories->first(function ($category) {
            $slug = strtolower($category->slug ?? '');
            $name = strtolower($category->name ?? '');

            return str_contains($slug, 'super-mario')
                || str_contains($name, 'super mario');
        });

        if ($twoPlayerMario && $superMario) {
            $categories = $categories
                ->reject(fn ($category) => $category->id === $twoPlayerMario->id)
                ->values();

            $superMarioIndex = $categories->search(fn ($category) => $category->id === $superMario->id);
            $items = $categories->values()->all();
            array_splice($items, $superMarioIndex + 1, 0, [$twoPlayerMario]);
            $categories = collect($items);
        }

        return $categories->take(6)->values();
    }
}
