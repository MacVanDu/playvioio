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
            ->orderBy('trend', 'DESC')
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
}
