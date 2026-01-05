<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;
use App\Http\Controllers\Controller;
use App\Http\Services\HeadService;
use App\Http\Services\GameService;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use App\Models\Game;
use App\Models\Pages;
use App\Models\Category;
use App\Models\Setting;
use Carbon\Carbon;

class HomeControllerMTLG extends Controller
{
    private $headService;
    private $gameService;

    public function __construct(HeadService $headService, GameService $gameService)
    {
        $this->headService = $headService;
        $this->gameService = $gameService;
    }


    public function checkMobile(Request $request): bool
    {
        $device = $this->detectDevice($request);
        if ($device === 'MB') {
            return true;
        } else {
            return false;
        }
    }

    public function index(Request $request)
    {
        $datamd = $this->data_mac_dinh();
        $games = $this->gameService->get_game_xuat_hien_trang_chu();
        $container_home = Setting::getValue('container_home', '', false);
        return view('game.pages.index', 
        array_merge(compact('datamd','container_home',), $games))->render();
    }
    public function pages($slug, Request $request)
    {
        $detail = Pages::where('slug', $slug)->first();
        if (!$detail) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh();
        return view('game.pages.pages', compact(
            'datamd',
            'detail',
        ));
    }
    public function category(Request $request, $slug, $page = 1)
    {
        $datamd = $this->data_mac_dinh();

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return $this->notFoundPage($request);
        }

        $perPage = 30;

      

        $gamesQuery = $this->gameService->get_game_table_p()->where('category_id', $category->id)
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

        $detail = $this->gameService->get_infor_game($slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        $datamd = $this->data_mac_dinh();
        $games = $this->gameService->get_game_trang_choi($detail->category_id);
        return view('game.pages.thongtin', 
        array_merge(compact('datamd','detail'), $games))->render();
    }
    public function splash($slug, Request $request)
    {

        $detail = $this->gameService->get_infor_game($slug);
        if (!$detail) {
            return $this->notFoundPage($request);
        }

        return view('game.pages.splash', 
        compact('detail'))->render();
    }
    public function search(Request $request)
    {
        if (!$request->name) {
            return $this->notFoundPage($request);
        }
        $datamd = $this->data_mac_dinh();

        $names = $request->name;
            $data_games = [];
            if ($request->name) {
                $data_games = $this->gameService->get_game_theo_tu_khoa($request->name);
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
    //---------------------------------------------------
    public function newgames(Request $request)
    {
        $datamd = $this->data_mac_dinh();

        if ($this->checkMobile($request)) {
            $games = $this->gameService->get_game_new(32);
            return view('game.mobile.pages.newgames', array_merge(compact('datamd'), $games))
                ->render();
        } else {
            $games = $this->gameService->get_game_new();
            return view('game.pages.newgames', array_merge(compact('datamd'), $games))
                ->render();
        }
    }
    public function recent(Request $request)
    {
        $datamd = $this->data_mac_dinh();
        return view('game.pages.recent', compact('datamd'))
            ->render();
    }
    public function hot(Request $request)
    {
        $datamd = $this->data_mac_dinh();
        if ($this->checkMobile($request)) {
            $games = $this->gameService->get_game_hot(30);
            return view('game.mobile.pages.hotgames', array_merge(compact('datamd'), $games))
                ->render();
        } else {

            $games = $this->gameService->get_game_hot();
            return view('game.pages.hotgames', array_merge(compact('datamd'), $games))
                ->render();
        }
    }
    public function iframe(Request $request)
    {

        if (!$request->gameURL) {
            return $this->notFoundPage($request);
        }

        $gameURL = $request->gameURL;
        return view('game.gameURL', compact(
            'gameURL'
        ))->render();
    }
    public function detail_lang($lang = '', $slug, Request $request)
    {
        return $this->detail($slug, $request);
    }
    public function tag_lang($lang = '', Request $request, $tag)
    {
        return $this->tag($request, $tag);
    }
    public function tag(Request $request, $tag)
    {
        $datamd = $this->data_mac_dinh();
        $limit = 40;
        $data_game_1 = $this->gameService->get_game_table_p()->where('name', 'LIKE', '%' . $tag . '%')
            ->orWhere('tags', 'LIKE', '%' . $tag . '%')
            ->orderBy('id', 'DESC')
            ->get();
        $excludeIds = $data_game_1->pluck('id')->toArray();
        $data_game_2 = $this->gameService->get_game_table_p()->whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->limit($limit - count($excludeIds)) // hoặc ->limit(40)
            ->get();

        $data_games = $data_game_1
            ->concat($data_game_2)
            ->values();

        $data_seo = '';
        if ($this->checkMobile($request)) {
            return view('game.mobile.pages.tag', compact(
                'data_games',
                'data_seo',
                'datamd',
                'tag',
            ));
        } else {
            return view('game.pages.tag', compact(
                'data_games',
                'data_seo',
                'datamd',
                'tag',
            ));
        }
    }

    public function category_lang($lang = '', Request $request, $slug, $page = 1)
    {
        return $this->category($request, $slug, $page);
    }

    public function notFoundPage($request)
    {
        $datamd = $this->data_mac_dinh();
        return view('game.pages.404', compact(
            'datamd',
        ))->render();
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
    public function data_mac_dinh()
    {
        return [
            'category' => Category::orderBy('id', 'DESC')
                ->limit(10)
                ->get(),
        ];
    }
    public function sitemapgames()
    {

        $chunkSize = 2000;
        $locale = app()->getLocale();
        $base = 'https://www.apkgosu.fun';
        // if ($locale !== 'en') {
        $base = $base . '/' . $locale;
        // }

        $xmlItems = '';
        Game::query()
            ->select('id', 'slug', 'created_at', 'updated_at')
            ->orderBy('vote_like', 'DESC')
            ->chunk($chunkSize, function ($games) use (&$xmlItems, $base) {



                foreach ($games as $game) {
                    if (empty($game->slug))
                        continue;

                    $lastMod = now();
                    $lastMod = Carbon::parse($lastMod)->format('Y-m-d');

                    $xmlItems .= "
    <url>
        <loc>{$base}/g/{$game->slug}</loc>
        <lastmod>{$lastMod}</lastmod>
        <changefreq>daily</changefreq>
    </url>";
                }
            });
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset 
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
>
$xmlItems
</urlset>
XML;
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    public function sitemapcategories()
    {
        $categories = Category::query()
            ->select('id', 'slug', 'created_at', 'updated_at')
            ->get();

        // Log nếu cần: info('Total categories: '.$categories->count());

        $locale = app()->getLocale();
        $base = 'https://www.apkgosu.fun';

        // if ($locale !== 'en') {
        $base = $base . '/' . $locale;
        // };

        $xmlItems = '';
        foreach ($categories as $cat) {

            if (empty($cat->slug)) {
                continue; // Bỏ qua category không có slug
            }

            // Lấy lastmod
            $lastMod = now();
            $lastMod = Carbon::parse($lastMod)->format('Y-m-d');

            $xmlItems .= "
    <url>
        <loc>{$base}/c/{$cat->slug}</loc>
        <lastmod>{$lastMod}</lastmod>
        <changefreq>weekly</changefreq>
    </url>";
        }

        // XML hoàn chỉnh
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset 
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
>
$xmlItems
</urlset>
XML;

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    public function sitemap()
    {
        $lastmod = now()->format('Y-m-d');

        $locale = app()->getLocale();
        $base = 'https://www.apkgosu.fun';

        // if ($locale !== 'en') {
        $base = $base . '/' . $locale;
        // };
        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

            <sitemap>
                <loc>{$base}/sitemaps/misc.xml</loc>
                <lastmod>{$lastmod}</lastmod>
            </sitemap>
            <sitemap>
                <loc>{$base}/sitemaps/categories.xml</loc>
                <lastmod>{$lastmod}</lastmod>
            </sitemap>
            <sitemap>
                <loc>{$base}/sitemaps/games.xml</loc>
                <lastmod>{$lastmod}</lastmod>
            </sitemap>
        </sitemapindex>
        XML;

        return new Response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
    public function misc()
    {
        $lastmod = now()->format('Y-m-d');

        $locale = app()->getLocale();
        $base = 'https://www.apkgosu.fun';

        // if ($locale !== 'en') {
        $base = $base . '/' . $locale;
        // };

        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <sitemap>
                <loc>{$base}</loc>
                <lastmod>{$lastmod}</lastmod>
                <changefreq>daily</changefreq>
            </sitemap>
        </sitemapindex>
        XML;

        return new Response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
