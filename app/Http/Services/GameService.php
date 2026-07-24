<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $device = $this->detectDevice($request);

        return Cache::remember("game:by-slug:{$slug}:{$device}:v2", 1800, function () use ($request, $slug) {
            return $this->get_game_table($request)
                ->where('slug', $slug)->first();
        });
    }
    public function get_game_trang_choi(Request $request,$id): array
    {
        $device = $this->detectDevice($request);

        return Cache::remember("game-page:blocks:{$id}:{$device}:v2", 1800, function () use ($request, $id) {
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
        });
    }
    public function get_game_xuat_hien_trang_chu(Request $request): array
    {
        $device = $this->detectDevice($request);
        $locale = app()->getLocale();
        $week = now()->format('o-W');

        $game_dau = Cache::remember("home:trend:{$device}:{$locale}:v3", 1800, function () use ($request) {
            return $this->get_game_table($request)
                ->orderBy('trend', 'DESC')
                ->limit(30)
                ->get();
        });

        $excludeIds = $game_dau->pluck('id')->toArray();

        $weeklySeed = (int) sprintf('%u', crc32(now()->format('o-W')));
        $game_new = Cache::remember("home:recommended:{$device}:{$locale}:{$week}:v2", 3600, function () use ($request, $excludeIds, $weeklySeed) {
            return $this->get_game_table($request)
                ->whereNotIn('id', $excludeIds)
                ->orderByRaw('RAND(?)', [$weeklySeed])
                ->limit(10)
                ->get();
        });

        $categories = $this->homeCategories();
        return [
            'game_dau' => $game_dau,
            'game_new' => $game_new,
            'categories_home' => $categories,
        ];
    }

    private function homeCategories()
    {
        $locale = app()->getLocale();

        return Cache::remember("home:categories:{$locale}:v3", 1800, function () {
            $categories = Category::orderBy('id', 'DESC')
                ->limit(10)
                ->get();

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

            $donkeyKong = $categories->first(function ($category) {
                $slug = strtolower($category->slug ?? '');
                $name = strtolower($category->name ?? '');

                return str_contains($slug, 'donkey-kong')
                    || str_contains($name, 'donkey kong');
            });

            if ($donkeyKong) {
                return $categories
                    ->reject(fn ($category) => $category->id === $donkeyKong->id)
                    ->take(5)
                    ->push($donkeyKong)
                    ->values();
            }

            return $categories->take(6)->values();
        });
    }
}
