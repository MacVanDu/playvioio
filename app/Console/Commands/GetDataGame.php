<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameLinks;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class GetDataGame extends Command
{
    protected $signature = 'app:get-data-game';
    protected $file_log = 'lay_game';
    protected $description = 'Command description';

    public function handle()
    {
        $num_game =  Setting::getValue('so_game_check_de_them_vao_web', 12, true);
        $games = GameLinks::where('status', 0)->limit($num_game)->get();
        if ($games->isEmpty()) {
            $this->logss("✅ Không có game nào cần crawl chi tiết.");
        }
        foreach ($games as $game) {
            $this->logss("🎮 Đang lấy thông tin: {$game->slug}");
            if (Game::where('slug', $game->slug)->exists()) {
                // Nếu đã có -> cập nhật status = 1 (coi như crawl xong)
                $game->update([
                    'status' => 1,
                ]);

                $this->logss("⚠️ Game '{$game->title}' đã tồn tại trong bảng games, bỏ qua.");
                continue; // bỏ qua không crawl nữa
            }

            $continue = false;
            if ($game->type === 'html5games_com') {
                $continue = $this->game_html5games_com($game);
            } else if ($game->type === 'gamepix_com') {
                $continue = $this->game_gamepix_com($game);
            }

            if ($continue) {
                $game->update([
                    'status' => 0,
                ]);
                continue;
            }
            sleep(rand(10, 25)); // tránh bị chặn
        }

        $this->logss("🎯 Hoàn tất crawl chi tiết cho $num_game game!");
    }
    public function logss($log)
    {
        Log::channel($this->file_log)->info($log);
    }
    //========================================== gamepix_com ==========================================

    public function game_gamepix_com($game)
    {
        try {
            
        $title = $game->title;
        $image = $game->img;
        $url = "https://www.gamepix.com/play/{$game->slug}";
        $playUrl = $game->url;
        $categoryName = ucfirst($game->category);
        $description =$game->description;
            $addgame = false;
            $description_dt = null;
            $addgame = $this->canEmbed($playUrl);
            if ($addgame) {
                $description_dt = $this->vietmota($url, $title, $description);
                if ($description_dt == null) {
                    $addgame = false;
                } else {
                    $addgame = true;
                }
            }
            if ($addgame) {
                $videoUrl = $this->getYouTubeVideo($title);
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    [
                        'slug' => Str::slug($categoryName),
                    ]
                );
                // 🔹 5. Cập nhật vào database
                Game::create([
                    'name' => $title,
                    'slug' => $game->slug,
                    'description' => $description_dt,
                    'image' => $image,
                    'link' => $playUrl,
                    'category_id' => $category->id,
                    'video_y_id' => $videoUrl,
                    'status' => 1,
                    'created_at' => now(),
                ]);

                $game->update([
                    'status' => 1,
                ]);
                $this->info("✅ Đã lưu game: {$title}");
            } else {
                $game->update([
                    'status' => 3,
                ]);
            }
        } catch (\Exception $e) {
            $this->logss("❌ Lỗi khi crawl {$game->title}: " . $e->getMessage());
            return true;
        }
        return false;
    }
    //========================================== html5games_com ========================================== 
    public function game_html5games_com($game)
    {

        $response = Http::timeout(30)->get($game->url);

        if ($response->failed()) {
            $this->logss("⚠️ Không thể tải trang: {$game->url}");
            return true;
        }
        try {

            $crawler = new Crawler($response->body());

            // 🔹 1. Lấy thông tin từ HTML
            $title = $crawler->filter('.main-section h1[itemprop="name"]')->count()
                ? trim($crawler->filter('.main-section h1[itemprop="name"]')->text())
                : $game->title;

            $image = $crawler->filter('.main-section a.icon img[itemprop="image"]')->count()
                ? $crawler->filter('.main-section a.icon img[itemprop="image"]')->attr('src')
                : null;

            $description = $crawler->filter('.game-description p[itemprop="description"]')->count()
                ? trim($crawler->filter('.game-description p[itemprop="description"]')->text())
                : null;

            $categoryName = $crawler->filter('.game-categories ul li a')->count()
                ? trim($crawler->filter('.game-categories ul li a')->text())
                : 'Uncategorized';

            $playUrl = $crawler->filter('.btn-highlight.play-btn')->count()
                ? $crawler->filter('.btn-highlight.play-btn')->attr('href')
                : null;

            $addgame = false;
            $description_dt = null;
            $addgame = $this->canEmbed($playUrl);
            if ($addgame) {
                $description_dt = $this->vietmota($game->url, $title, $description);
                if ($description_dt == null) {
                    $addgame = false;
                } else {
                    $addgame = true;
                }
            }
            if ($addgame) {
                $videoUrl = $this->getYouTubeVideo($title);
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    [
                        'slug' => Str::slug($categoryName),
                    ]
                );
                // 🔹 5. Cập nhật vào database
                Game::create([
                    'name' => $title,
                    'slug' => $game->slug,
                    'description' => $description_dt,
                    'image' => $image,
                    'link' => $playUrl,
                    'category_id' => $category->id,
                    'video_y_id' => $videoUrl,
                    'status' => 1,
                    'created_at' => now(),
                ]);

                $game->update([
                    'status' => 1,
                ]);
                $this->info("✅ Đã lưu game: {$title}");
            } else {
                $game->update([
                    'status' => 3,
                ]);
            }
        } catch (\Exception $e) {
            $this->logss("❌ Lỗi khi crawl {$game->title}: " . $e->getMessage());
            return true;
        }
        return false;
    }
    private function getYouTubeVideo(string $gameName): ?string
    {
        $apiKey = 'AIzaSyC4Jf8AzuhBmONmBNRFkdC2eq9MPTzEZos';

        $query = urlencode("{$gameName} gameplay video");
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=5&q={$query}&key={$apiKey}";

        try {
            $response = Http::get($url);

            if (!$response->successful()) {
                Log::warning("🎥 YouTube API search error: " . $response->body());
                return null;
            }

            $data = $response->json();

            if (empty($data['items'])) {
                return null;
            }

            // ✅ Lặp qua tối đa 5 video, kiểm tra video nào còn tồn tại
            foreach ($data['items'] as $item) {
                $videoId = $item['id']['videoId'] ?? null;
                if (!$videoId)
                    continue;

                if ($this->isYouTubeVideoAvailable($videoId, $apiKey)) {
                    return $videoId;
                }
            }

        } catch (\Throwable $e) {
            Log::error("YouTube search failed: " . $e->getMessage());
        }

        return null;
    }

    private function isYouTubeVideoAvailable(string $videoId, string $apiKey): bool
    {
        try {
            $videoUrl = "https://www.googleapis.com/youtube/v3/videos?part=status&id={$videoId}&key={$apiKey}";
            $check = Http::get($videoUrl);

            if (!$check->successful()) {
                Log::warning("YouTube video check failed: " . $check->body());
                return false;
            }

            $info = $check->json();

            if (empty($info['items'][0]['status'])) {
                return false;
            }

            $status = $info['items'][0]['status'];
            $privacy = $status['privacyStatus'] ?? 'private';
            $embeddable = $status['embeddable'] ?? false;

            return $privacy === 'public' && $embeddable === true;
        } catch (\Throwable $e) {
            Log::error("YouTube validation error: " . $e->getMessage());
            return false;
        }
    }

    public function canEmbed(string $url): bool
    {
        if ($url == null) {
            return false;
        }
        try {
            // 1️⃣ Gửi request giả lập trình duyệt
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0',
                'Referer' => 'https://www.apkgosu.fun',
                'Origin' => 'https://www.apkgosu.fun',
                'Sec-Fetch-Dest' => 'iframe',
            ])
                ->withOptions([
                    'allow_redirects' => true,
                    'verify' => false, // ⚠️ Chỉ nên dùng verify=false ở local
                ])
                ->timeout(10)
                ->get($url);

            $status = $response->status();
            if ($status >= 400)
                return false;

            // 2️⃣ Lấy headers
            $headers = collect($response->headers())
                ->mapWithKeys(fn($v, $k) => [strtolower($k) => implode('; ', $v)]);
            $xFrame = $headers->get('x-frame-options');
            $csp = $headers->get('content-security-policy');

            if ($xFrame && in_array(strtolower($xFrame), ['deny', 'sameorigin']))
                return false;
            if ($csp && str_contains(strtolower($csp), 'frame-ancestors'))
                return false;

            // 3️⃣ Phân tích nội dung HTML
            $body = strtolower($response->body());
            $patterns = [
                '/window\.top\s*!==\s*window\.self/',
                '/window\.top\s*!=\s*window\.self/',
                '/if\s*\(\s*window\s*!==\s*top\s*\)/',
                '/top\.location\s*=/',
                '/window\.parent\.location/',
                '/framebreaker/',
                '/window\.top\.location\.replace/',
                '/<meta[^>]+http-equiv=["\']content-security-policy["\']/i',
                '/<meta[^>]+http-equiv=["\']refresh["\']/i',
                '/location\.(href|replace)\s*=\s*/i',
            ];

            foreach ($patterns as $regex) {
                if (preg_match($regex, $body)) {
                    return false;
                }
            }

            if (
                str_contains($body, 'refused to connect') ||
                str_contains($body, 'blocked by') ||
                str_contains($body, 'frame-ancestors') ||
                str_contains($body, 'x-frame-options')
            ) {
                return false;
            }

            return true; // ✅ Nếu không phát hiện vấn đề nào → nhúng được

        } catch (\Throwable $e) {
            return false; // ❌ Nếu lỗi (timeout, SSL, connection, v.v.)
        }
    }
    public function vietmota(string $gameUrl, string $gameName, string $gameDescription, string $model = 'gemini-2.0-flash', int $maxTries = 5)
    {

        $prompt = <<<PROMPT
You are an experienced English SEO content writer for a gaming website.

Write ONLY a JSON object in this structure:
{
  "description": "<div>FULL GAME DESCRIPTION HERE</div>"
}

Requirements:
- Language: English.
- You will be given:
  - Game name: "{$gameName}"
  - Game URL: "{$gameUrl}"
  - Basic description: "{$gameDescription}"

- Your task:
  1. Create a short but rich article (around 400–600 words) about this game.
  2. Include the following sections inside the HTML:
     - <h2>About the Game</h2> — a detailed yet concise description of the game based on context.
     - <h2>How to Play</h2> — explain the basic controls, objectives, and gameplay mechanics.
     - <h2>Pro Tips</h2> — list at least 3 useful tricks or strategies for players (<ul>/<li> format).
     - <h2>FAQs</h2> — provide 3–5 short Q&A pairs (<p><strong>Q:</strong> ... <br><strong>A:</strong> ...</p>).
     - <h2>Conclusion</h2> — summarize why the game is fun or worth trying.
  3. Mention the game name naturally multiple times for SEO.
  4. Optionally include <figure> or <table> if contextually relevant.
  5. All HTML must be wrapped inside one single <div>...</div> tag.
  6. Do NOT include <html>, <head>, or <body> tags.
  7. The output must be ONLY valid JSON (no markdown, no explanations, no comments).
PROMPT;

        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
        ];

        $attempt = 0;

        while ($attempt < $maxTries) {
            $attempt++;
            try {
                // ✅ Endpoint chính xác
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => 'AIzaSyDH8QdVlUFO_i9_bI3LgNdv34-pkFtC3wg',
                ])->post($url, $payload);

                // Nếu rate-limit hoặc lỗi server
                if ($response->status() == 429 || $response->serverError()) {
                    continue;
                }

                // Nếu thành công
                if ($response->successful()) {
                    $result = $response->json();
                    $raw = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                    // 5️⃣ Làm sạch dữ liệu JSON trả về
                    $jsonString = preg_replace('/```(json|html)?/i', '', trim($raw));
                    $jsonString = trim(str_replace('```', '', $jsonString));
                    $data = json_decode($jsonString, true);

                    if (!$data || empty($data['description'])) {
                        return null;
                    }
                    return $data['description'];
                }

            } catch (Exception $ex) {
                continue;
            }
        }

        return null;
    }
}
