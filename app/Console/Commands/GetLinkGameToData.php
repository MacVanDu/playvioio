<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\GameLinks;
use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class GetLinkGameToData extends Command
{
    protected $signature = 'app:get-link-game-to-data';
    protected $file_log = 'lay_link_game';
    protected $description = 'Command description';

    public function logss($log)
    {
        Log::channel($this->file_log)->info($log);
    }
    public function handle()
    {
        $num_game = $this->handle_html5games_com(Setting::getValue('so_game_get_link_html5games', 2, true));
        $num_game = $num_game + $this->handle_gamepix_com(Setting::getValue('so_game_get_link_gamepix', 15, true));

         $this->logss("🎮 Đẫ lấy được : $num_game Game");
    }
    public function handle_html5games_com($max)
    {
        $url = 'https://html5games.com/All-Games';
        $this->logss("🔍 Đang crawl dữ liệu từ: $url");

        $response = Http::get($url);
        if ($response->failed()) {
             $this->logss("❌ Không thể truy cập trang web.");
        }

        $crawler = new Crawler($response->body());
        $games = [];

        // 🕷️ Lấy dữ liệu chi tiết từ thẻ <li>
        $crawler->filter('.main-section li a')->each(function ($node) use (&$games) {
            $link = $node->attr('href');
            $fullUrl = 'https://html5games.com' . $link;

            // Lấy tiêu đề game
            $title = $node->filter('.name')->count()
                ? trim($node->filter('.name')->text())
                : 'No title';

            // Chỉ thêm vào mảng nếu có link và tiêu đề hợp lệ
            if ($link && $title && $title !== 'No title') {
                $games[] = [
                    'title' => $title,
                    'url' => $fullUrl,
                ];
            }
        });
        if (empty($games)) {
           $this->logss("⚠️ Không tìm thấy game nào!");
            return 0;
        }
        // 🧹 Lọc ra 20 game mới
        $newGames = collect($games)
            ->reject(fn($game) => GameLinks::where('url', $game['url'])->exists())
            ->take(limit: $max);

        // 🧱 Lưu vào DB
        $added = 0;
        foreach ($newGames as $game) {
            $slug = Str::slug($game['title']);
            $originalSlug = $slug;
            $counter = 1;

            while (GameLinks::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }

            GameLinks::create([
                'type' => 'html5games_com',
                'title' => $game['title'],
                'slug' => $slug,
                'url' => $game['url'],
            ]);

            $added++;
        }

        return $added;
    }

    public function handle_gamepix_com($max)
    {
        $num_game_lay = 0;
        $page = 1;
        while ($num_game_lay < $max) {
            $response = Http::get("https://feeds.gamepix.com/v2/json?order=quality&page={$page}&pagination=12");
            $data = $response->json();

            $game_lay_page = 0 + $num_game_lay;
            foreach ($data['items'] as $item) {
                $slug = $item['namespace'];
                $existsInGames = Game::where('slug', $slug)->exists();
                $existsInGameLinks = GameLinks::where('slug', $slug)->exists();

                if ($existsInGames || $existsInGameLinks) {
                    continue;
                }
                GameLinks::create([
                    'type' => 'gamepix_com',
                    'slug' => $item['namespace'],
                    'category' => $item['category'],
                    'description' => $item['description'],
                    'url' => $item['url'],
                    'img' => $item['banner_image'],
                    'title' => $item['title'],
                ]);
                $num_game_lay = 1 + $num_game_lay;
                if ($num_game_lay >= $max) {
                    break;
                }
            }
            if (count($data['items']) == 0) {
                $game_lay_page = 0;
                $num_game_lay = 1 + $max;
            }
            if ($game_lay_page == $num_game_lay) {
                $page++;
            }
        }
        return $num_game_lay;
    }
}
