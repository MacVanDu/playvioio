<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class GameService
{
    private function get_game_table()
    {
        return Game::query();
    }
    public function get_game_table_p()
    {
        return $this->get_game_table();
    }
    public function get_game_theo_tu_khoa($q, $limit = 50)
    {
        return $this->get_game_table()->where('description', 'like', '%' . $q . '%')
            ->orWhere('name', 'like', '%' . $q . '%')
            ->limit($limit)
            ->get();
    }
    public function get_infor_game($slug)
    {
        return $this->get_game_table()
            ->where('slug', $slug)->first();
    }
    public function get_game_ngau_nhien($limit = 40)
    {
        return $this->get_game_table()->inRandomOrder()
            ->limit($limit)
            ->get();
    }
    public function get_1_game_ngau_nhien()
    {
        return $this->get_game_table()->inRandomOrder()
            ->limit(1)
            ->first();
    }
    public function get_game_ngau_nhien_co_video()
    {
        return $this->get_game_table()->inRandomOrder()
            ->whereNotNull('video_short')
            ->limit(1)
            ->first();
    }
    public function get_game_new($limit = 56): array
    {
        return Cache::remember('game_new_1_' . $limit, now()->addMinutes(30), function () use ($limit) {

            // 1. 10 game mới nhất
            $game_new = $this->get_game_table()
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
            $excludeIds = $game_new->pluck('id')->toArray();

            $game_rd = $this->get_game_table()
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit(value: $limit)
                ->get();

            $game_new = $game_new
                ->concat($game_rd)
                ->values();



            return [
                'game_new' => $game_new,
            ];
        });
    }
    public function get_game_hot($limit = 56): array
    {
        return Cache::remember('game_hot_1_' . $limit, now()->addDay(), function () use ($limit) {
            $game_trend = $this->get_game_table()
                ->where('trend', 1)
                ->limit($limit)
                ->get();
            $excludeIds = $game_trend->pluck('id')->toArray();

            $game_like = $this->get_game_table()
                ->whereNotIn('id', $excludeIds)
                ->orderBy('vote_like', 'DESC')
                ->limit(value: $limit - count($game_trend))
                ->get();

            $game_hot = $game_trend
                ->concat($game_like)
                ->values();



            return [
                'game_hot' => $game_hot,
            ];
        });
    }

    public function get_game_trang_choi($id): array
    {

    $similar_games =    Game::where('category_id', $id)->orderBy('id', 'DESC')->limit(12)->get();
    
            $excludeIds = $similar_games->pluck('id')->toArray();
            
            $you_may_like_games = $this->get_game_table()
                ->orderBy('id', 'DESC')
                ->whereNotIn('id', $excludeIds)
                ->limit(12)
                ->get();

            $excludeIds = array_merge($excludeIds, $you_may_like_games->pluck('id')->toArray());
          $popular_games = $this->get_game_table()
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
    public function get_game_xuat_hien_trang_chu(): array
    {
        $game_dau = $this->get_game_table()
            ->orderBy('id', 'DESC')
            ->limit(15)
            ->get();
            $excludeIds = $game_dau->pluck('id')->toArray();

        $game_new = $this->get_game_table()
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
    public function get_game_theo_the_loai($game, $limit = 10)
    {
        $query = $this->get_game_table()
            ->where('id', '!=', $game->id)
            ->where(function ($q) use ($game) {
                // Ưu tiên cùng category
                $q->where('category_id', $game->category_id);

                // Thêm điều kiện có tag giống nhau
                $tags = $game->tag_arr();
                $q->orWhere(function ($sub) use ($tags) {
                    foreach ($tags as $tag) {
                        $sub->orWhere('tags', 'like', "%$tag%");
                    }
                });
            });

        // Lấy danh sách id ngẫu nhiên giới hạn theo $limit
        $ids = $query->pluck('id')->shuffle()->take($limit)->toArray();

        if (count($ids) < $limit) {
            $remaining = $limit - count($ids);

            $extraIds = $this->get_game_table()
                ->where('id', '!=', $game->id)
                ->whereNotIn('id', $ids)
                ->inRandomOrder()
                ->limit($remaining)
                ->pluck('id')
                ->toArray();

            $ids = array_merge($ids, $extraIds);
        }

        return $this->get_game_table()->whereIn('id', $ids)->get();

    }
    public function get_game_the_loai($category_id, $limit = 10)
    {
        $cacheKey = "category_g_{$category_id}";

        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($category_id, $limit) {

            $query = $this->get_game_table()->where('category_id', $category_id);

            $ids = $query->pluck('id')->shuffle()->take($limit)->toArray();

            if (count($ids) < $limit) {
                $remaining = $limit - count($ids);

                $extraIds = $this->get_game_table()->where('category_id', '!=', $category_id)
                    ->inRandomOrder()
                    ->limit($remaining)
                    ->pluck('id')
                    ->toArray();

                $ids = array_merge($ids, $extraIds);
            }

            return $this->get_game_table()->whereIn('id', $ids)->get();
        });
    }
}
