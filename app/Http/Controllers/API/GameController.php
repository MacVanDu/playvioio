<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use App\Models\Game;
use App\Models\GameAndroid;
use App\Models\GameLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    private $categorySv;
    public function __construct()
    {
        $this->categorySv = new CategoryService();
    }
    public function check(Request $request)
    {
        // --- 1️⃣ Validate URL đầu vào ---
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ], [
            'url.required' => 'Thiếu tham số URL cần kiểm tra.',
            'url.url' => 'Giá trị không phải là URL hợp lệ.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first(),
            ], 422);
        }

        $url = $request->input('url');
        $canEmbed = true;
        $status = null;
        $xFrame = null;
        $csp = null;
        $headers = [];
        $reason = [];

        try {
            // --- 2️⃣ Gửi request mô phỏng trình duyệt ---
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:131.0) Gecko/20100101 Firefox/131.0',
                'Referer' => 'https://www.apkgosu.fun',
                'Origin' => 'https://www.apkgosu.fun',
                'Sec-Fetch-Dest' => 'iframe',
            ])
                ->withOptions([
                    'allow_redirects' => true,
                    'verify' => false, // ⚠️ Chỉ nên dùng verify=false khi local dev
                ])
                ->timeout(10)
                ->get($url);

            // --- 3️⃣ Lấy status và headers ---
            $status = $response->status();
            $headers = collect($response->headers())
                ->mapWithKeys(fn($v, $k) => [strtolower($k) => implode('; ', $v)]);

            $xFrame = $headers->get('x-frame-options');
            $csp = $headers->get('content-security-policy');

            // --- 4️⃣ Kiểm tra header ---
            if ($status >= 400) {
                $canEmbed = false;
                $reason[] = "HTTP status $status";
            }

            if ($xFrame && in_array(strtolower($xFrame), ['deny', 'sameorigin'])) {
                $canEmbed = false;
                $reason[] = "X-Frame-Options chặn nhúng: $xFrame";
            }

            if ($csp && str_contains(strtolower($csp), 'frame-ancestors')) {
                $canEmbed = false;
                $reason[] = "CSP frame-ancestors chặn nhúng";
            }

            // --- 5️⃣ Phân tích nội dung HTML ---
            $body = strtolower($response->body());

            // Các mẫu JavaScript chống iframe
            $patterns = [
                '/window\.top\s*!==\s*window\.self/',
                '/window\.top\s*!=\s*window\.self/',
                '/if\s*\(\s*window\s*!==\s*top\s*\)/',
                '/top\.location\s*=/',
                '/window\.parent\.location/',
                '/framebreaker/',
                '/document\.referrer/',
                '/window\.top\.location\.replace/',
            ];

            foreach ($patterns as $regex) {
                if (preg_match($regex, $body)) {
                    $canEmbed = false;
                    $reason[] = "Phát hiện JS chống nhúng ($regex)";
                    break;
                }
            }

            // Phát hiện meta CSP trong HTML
            if (preg_match('/<meta[^>]+http-equiv=["\']content-security-policy["\']/i', $body)) {
                $canEmbed = false;
                $reason[] = "Meta Content-Security-Policy chặn nhúng";
            }

            // Phát hiện redirect HTML
            if (preg_match('/<meta[^>]+http-equiv=["\']refresh["\']/i', $body)) {
                $canEmbed = false;
                $reason[] = "Meta Refresh redirect";
            }

            // Phát hiện redirect bằng JS
            if (preg_match('/location\.(href|replace)\s*=\s*/i', $body)) {
                $canEmbed = false;
                $reason[] = "Phát hiện JS redirect";
            }

            // Phát hiện nội dung lỗi trong body
            if (
                str_contains($body, 'refused to connect') ||
                str_contains($body, 'blocked by') ||
                str_contains($body, 'frame-ancestors') ||
                str_contains($body, 'x-frame-options')
            ) {
                $canEmbed = false;
                $reason[] = "Phát hiện thông báo chặn iframe trong body";
            }

        } catch (\Throwable $e) {
            // --- 6️⃣ Request lỗi ---
            return response()->json([
                'status' => false,
                'error' => 'Không thể truy cập URL: ' . $e->getMessage(),
                'can_embed' => false,
            ], 500);
        }

        // --- 7️⃣ Trả kết quả ---
        return response()->json([
            'status' => true,
            'url' => $url,
            'http_status' => $status,
            'headers' => [
                'x-frame-options' => $xFrame,
                'content-security-policy' => $csp,
            ],
            'can_embed' => $canEmbed,
            'reason' => $reason ?: ['Không phát hiện vấn đề rõ ràng (có thể bị chặn bằng JavaScript thực thi).'],
        ]);
    }

    public function topGames(Request $request)
    {
        $limit = (int) $request->query('limit', 12);
        $order = $request->query('order', 'popular'); // 'popular', 'latest', 'random'
        $category = $request->query('category'); // optional

        $cacheKey = "top-games:limit={$limit}:order={$order}:cat={$category}";

        $games = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit, $order, $category) {
            $query = Game::query();

            if ($category) {
                $query->where('category_id', (int) $category);
            }

            // 🔹 Sắp xếp
            if ($order === 'latest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($order === 'random') {
                $query->inRandomOrder();
            } else {
                // popular (nếu có cột plays, dùng plays, không thì dùng id)
                if (in_array('plays', \Schema::getColumnListing('games'))) {
                    $query->orderBy('plays', 'desc');
                } else {
                    $query->orderBy('id', 'desc');
                }
            }

            return $query->limit($limit)->get();
        });

        // 🔹 Dữ liệu trả về theo format mà extension cần
        $payload = [
            'games' => $games->map(function ($g) {
                $thumb = $g->linkImgGame();
                if ($thumb && strpos($thumb, 'http') !== 0) {
                    $thumb = url($thumb);
                }

                return [
                    'id' => $g->id,
                    'title' => $g->nameGame(),
                    'url' => url($g->slugPlay()),
                    'thumb' => $thumb ?: url('/imgs/default.png'),
                ];
            })->values()
        ];

        // 🔹 CORS cho phép extension truy cập
        return response()->json($payload)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
    public function topGames2(Request $request)
    {

        $url = 'https://www.gamepix.com/play/shell-shockers';


        if (empty($url)) {
            return response()->json(['error' => 'Thiếu tham số url'], 400);
        }

        if (!str_starts_with($url, 'https://www.gamepix.com/play/')) {
            return response()->json(['error' => 'Chỉ chấp nhận link gamepix.com/play/'], 400);
        }

        try {
            // ✅ Dùng proxy render JS (r.jina.ai)
            $renderUrl = 'https://r.jina.ai/' . $url;

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.5993.90 Safari/537.36',
                'Referer' => 'https://www.gamepix.com/',
                'Origin' => 'https://www.gamepix.com',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'en-US,en;q=0.9,vi;q=0.8',
                'Cache-Control' => 'no-cache',
                'Pragma' => 'no-cache',
                'Connection' => 'keep-alive'
            ])->timeout(60)->get($renderUrl);

            if (!$response->ok()) {
                return response()->json(['error' => 'Không thể tải nội dung render', 'status' => $response->status()], 500);
            }

            $html = $response->body();
            // dd($html);
            $title = null;
            $pos = strpos($html, 'Title:');
            if ($pos !== false) {
                $line = substr($html, $pos + 6); // bỏ "Title:"
                $title = $this->cleanDescription(trim(strtok($line, "\n"))); // lấy đến hết dòng
            }
            $category = null;
            $normalized = $html;
            $normalized = str_replace(["\r", "\n", "\t"], ' ', $normalized);
            $normalized = preg_replace('/\s{2,}/', ' ', $normalized);
            $normalized = preg_replace('/[▶◀]+/u', '', $normalized);
            $normalized = trim($normalized);

            $category = null;

            // Tìm vị trí "including"
            $pos = stripos($normalized, 'including');
            if ($pos !== false) {
                // Lấy 200 ký tự sau chữ including
                $snippet = substr($normalized, $pos, 200);

                // Tìm cụm **...**
                if (preg_match_all('/\*\*\s*([^*]+?)\s*\*\*/', $snippet, $matches)) {
                    $category = trim($matches[1][0] ?? '');
                }

                // Nếu vẫn chưa có -> fallback tìm chữ đầu tiên sau including
                if (!$category && preg_match('/including\s+([A-Za-z0-9\.\-]+)/i', $snippet, $fallback)) {
                    $category = trim($fallback[1]);
                }
            }
            // dd($category);

            // ✅ Lấy phần Markdown Content → Games similar
            $markdown = null;
            if (preg_match('/Markdown Content:\s*(.*?)\s*Games similar/iUs', $html, $matches)) {
                $markdown = trim($matches[1]);
            }

            if (!$markdown) {
                return response()->json([
                    'url' => $url,
                    'description' => 'Không tìm thấy nội dung Markdown.',
                ]);
            }

            // ✅ Chuyển Markdown sang HTML thủ công
            $descriptionHtml = $this->markdownToHtml($markdown);
            $descriptionHtml = $this->cleanDescription($descriptionHtml);
            return response()->json([
                'url' => $url,
                'title' => $title,
                'category' => $category,
                'description_html' => $descriptionHtml,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi khi xử lý: ' . $e->getMessage(),
                'url' => $url
            ], 500);
        }
    }
    private function markdownToHtml($text)
    {
        // Thay link [text](url)
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2" target="_blank">$1</a>', $text);

        // In đậm và nghiêng
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);
        $text = preg_replace('/__(.*?)__/s', '<strong>$1</strong>', $text);
        $text = preg_replace('/_(.*?)_/s', '<em>$1</em>', $text);

        // Tiêu đề
        $text = preg_replace('/^###### (.*)$/m', '<h6>$1</h6>', $text);
        $text = preg_replace('/^##### (.*)$/m', '<h5>$1</h5>', $text);
        $text = preg_replace('/^#### (.*)$/m', '<h4>$1</h4>', $text);
        $text = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $text);

        // Danh sách UL
        $text = preg_replace_callback('/(?:^|\n)(?:-|\*) (.+)(?=(?:\n(?![-*] )|$))/sU', function ($m) {
            $items = preg_split('/\n(?:-|\*) /', trim($m[0]));
            $li = array_map(fn($i) => '<li>' . trim($i) . '</li>', $items);
            return '<ul>' . implode('', $li) . '</ul>';
        }, $text);

        // Danh sách OL
        $text = preg_replace_callback('/(?:^|\n)\d+\.\s+(.+)(?=(?:\n(?!\d+\. )|$))/sU', function ($m) {
            $items = preg_split('/\n\d+\.\s+/', trim($m[0]));
            $li = array_map(fn($i) => '<li>' . trim($i) . '</li>', $items);
            return '<ol>' . implode('', $li) . '</ol>';
        }, $text);

        // Xuống dòng thành <p>
        $text = preg_replace("/\n{2,}/", "</p><p>", nl2br(trim($text)));
        $text = '<p>' . $text . '</p>';

        // Dọn khoảng trắng
        $text = preg_replace('/\s+<\/p>/', '</p>', $text);
        $text = preg_replace('/<p>\s+/', '<p>', $text);

        return $text;
    }
    private function cleanDescription($html)
    {
        // Xóa các đoạn "FAQ", "Game Details", "Gameplay Trailer" nếu còn sót
        $html = preg_replace('/<h2>.*?(FAQ|Game Details|Gameplay Trailer|Shell Shockers Gameplay Trailer).*?<\/h2>.*$/is', '', $html);

        // Thay thế domain và thương hiệu
        $html = str_replace('GamePix.com', 'Apkgosu.fun', $html);
        $html = str_replace('GamePix', 'Apkgosu', $html);
        $html = str_replace('https://www.gamepix.com', 'https://www.apkgosu.fun', $html);
        $html = str_replace('www.gamepix.com', 'apkgosu.fun', $html);

        // Dọn whitespace dư thừa
        $html = preg_replace('/\s{2,}/', ' ', $html);
        $html = trim($html);

        return $html;
    }
    public function topGames3(Request $request)
    {
        $indexUrl = 'https://www.gamepix.com/sitemaps/index.xml';
        $indexResponse = Http::get($indexUrl);

        if (!$indexResponse->ok()) {
            return response()->json(['error' => 'Không thể tải sitemap index'], 500);
        }

        $indexXml = new \SimpleXMLElement($indexResponse->body());
        $sitemapUrls = [];

        // B1: Lấy danh sách file games-x.xml
        foreach ($indexXml->sitemap as $sitemap) {
            $loc = (string) $sitemap->loc;
            if (strpos($loc, 'https://www.gamepix.com/sitemaps/games-') === 0) {
                $sitemapUrls[] = $loc;
            }
        }

        $games = [];
        $max = 20;

        // B2: Duyệt từng sitemap con
        foreach ($sitemapUrls as $sitemapUrl) {
            $response = Http::get($sitemapUrl);
            if (!$response->ok())
                continue;

            $xml = new \SimpleXMLElement($response->body());
            $namespaces = $xml->getDocNamespaces(true);
            $imageNs = $namespaces['image'] ?? null;

            foreach ($xml->url as $urlNode) {
                $loc = (string) $urlNode->loc;
                if (strpos($loc, 'https://www.gamepix.com/play/') !== 0)
                    continue;

                $slug = str_replace('https://www.gamepix.com/play/', '', $loc);

                // ⚙️ Kiểm tra slug trùng ở cả hai bảng
                $existsInGames = Game::where('slug', $slug)->exists();
                $existsInGameLinks = GameLinks::where('slug', $slug)->exists();

                if ($existsInGames || $existsInGameLinks) {
                    continue; // ❌ Bỏ qua nếu trùng slug ở bất kỳ bảng nào
                }

                // ✅ Lấy ảnh trong namespace <image:image><image:loc>
                $img = null;
                if ($imageNs) {
                    $imageNode = $urlNode->children($imageNs);
                    if (isset($imageNode->image)) {
                        $imageLocNode = $imageNode->image->children($imageNs);
                        if (isset($imageLocNode->loc)) {
                            $img = (string) $imageLocNode->loc;
                        }
                    }
                }

                $games[] = [
                    'slug' => $slug,
                    'link' => $loc,
                    'img' => $img,
                ];

                if (count($games) >= $max)
                    break 2;
            }
        }

        foreach ($games as $game) {
            GameLinks::create([
                'type' => 'gamepix_com',
                'slug' => $game['slug'],
                'url' => $game['link'],
                'img' => $game['img'],
                'title' => $game['slug'],
            ]);
        }
        // B3: Trả JSON kết quả
        return response()->json([
            'count' => count($games),
            'games' => $games,
        ]);
    }
     public function ajax(Request $request)
    {
    $name = $request->name;
  
    $games = Game::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->limit(10)
        ->get();

    // Nếu không có kết quả
    if ($games->isEmpty()) {
        return '
        <div class="lists">
            <ul>
                <div style="padding:5px;">No results</div>
            </ul>
        </div>';
    }

    // Tạo HTML
    $html = '<div class="lists"><ul>';

    foreach ($games as $game) {
        $html .= '
            <li class="lc">
                <a href="'.$game->slugGame().'" title="'.$game->name.'">
                    <div class="c_c1 p1">
                        <img class="lazyload r_img2" src="'.$game->image.'">
                    </div>
                    <span>'.$game->name.'</span>
                </a>
            </li>';
    }

    $html .= '</ul></div>';

    return response($html, 200)->header('Content-Type', 'text/html');
    }
     public function android_ajax(Request $request)
    {
    $name = $request->name;
  
    $games = GameAndroid::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->limit(10)
        ->get();

    // Nếu không có kết quả
    if ($games->isEmpty()) {
        return '
        <div class="lists">
            <ul>
                <div style="padding:5px;">No results</div>
            </ul>
        </div>';
    }

    // Tạo HTML
    $html = '<div class="lists"><ul>';

    foreach ($games as $game) {
        $html .= '
            <li class="lc">
                <a href="'.$game->slugGame().'" title="'.$game->nameGame().'">
                    <div class="c_c1 p1">
                        <img class="lazyload r_img2" src="'.$game->linkImgGame().'">
                    </div>
                    <span>'.$game->nameGame().'</span>
                </a>
            </li>';
    }

    $html .= '</ul></div>';

    return response($html, 200)->header('Content-Type', 'text/html');
    }
     public function rate(Request $request)
    {
        $validated = $request->validate([
            'id'   => 'required|integer',
    'vote'      => 'sometimes|nullable|in:0,1,-1',
    'prev_vote' => 'sometimes|nullable|in:0,1,-1',
        ]);

        $game = Game::findOrFail($validated['id']);

        $vote = $validated['vote'] ?? 0;
        if ($vote === "" || $vote === null) {
            $vote = 0;
        }
        $vote = (int)$vote;

        $prev = $validated['prev_vote'] ?? 0;
        if ($prev === "" || $prev === null) {
            $prev = 0;
        }
        $prev = (int)$prev;

        // Nếu không thay đổi vote thì không làm gì
        if ($vote == $prev) {
            return response()->json([
                'status' => true,
                'message' => 'Vote unchanged',
                'data' => $game
            ]);
        }

        // Nếu vote thay đổi
        if ($prev == 1 && $vote == 0) {
            // Like → Dislike
            $game->vote_like = max(0, $game->vote_like - 1);
            $game->vote_dis_like += 1;
        }

        if ($prev == 0 && $vote == 1) {
            // Dislike → Like
            $game->vote_dis_like = max(0, $game->vote_dis_like - 1);
            $game->vote_like += 1;
        }

        $game->save();

        return response()->json([
            'status' => true,
            'message' => 'Vote updated',
            'data' => [
                'like' => $game->vote_like,
                'dislike' => $game->vote_dis_like,
            ]
        ]);
    }
}
