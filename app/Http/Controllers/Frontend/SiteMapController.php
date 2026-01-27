<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SiteMapController extends Controller
{
    private $url = 'https://marios.games';
    private $cacheTime = 300; // 7 ngày tính bằng giây (60*60*24*7)

    /**
     * Sitemap Index: Danh sách các sitemap con
     */
    public function sitemap()
    {
        // Cache key riêng biệt
        $xml = Cache::remember('a_sitemap_index_xml', $this->cacheTime, function () {
            $lastmod = now()->format('Y-m-d');
            $base = $this->url;

            return <<<XML
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
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Misc Sitemap: Các trang tĩnh (Trang chủ, Giới thiệu, v.v.)
     */
    public function misc()
    {
        $xml = Cache::remember('a_sitemap_misc_xml', $this->cacheTime, function () {
            $lastmod = now()->format('Y-m-d');
            $base = $this->url;

            // LƯU Ý: Đây là các link cụ thể nên dùng thẻ <urlset> và <url>, không dùng <sitemapindex>
            return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{$base}</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>
XML;
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Categories Sitemap
     */
    public function sitemapcategories()
    {
        $xml = Cache::remember('a_sitemap_categories_xml', $this->cacheTime, function () {
            $base = $this->url;

            // Lấy dữ liệu một lần, chỉ lấy cột cần thiết
            $categories = Category::select('slug', 'updated_at')
                ->whereNotNull('slug')
                ->get();

            $xmlItems = '';
            foreach ($categories as $cat) {
                // Sử dụng updated_at thực tế nếu có, nếu không thì dùng now()
                $lastMod = $cat->updated_at ? $cat->updated_at->format('Y-m-d') : now()->format('Y-m-d');

                $xmlItems .= "
    <url>
        <loc>{$base}/c/{$cat->slug}</loc>
        <lastmod>{$lastMod}</lastmod>
        <changefreq>weekly</changefreq>
    </url>";
            }

            return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{$xmlItems}
</urlset>
XML;
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Games Sitemap
     */
    public function sitemapgames()
    {
        $xml = Cache::remember('a_sitemap_games_xml', $this->cacheTime, function () {
            $base = $this->url;
            $xmlItems = '';

            // Dùng cursor() thay vì chunk() để tiết kiệm bộ nhớ khi loop qua dữ liệu lớn
            // để nối chuỗi string
            $games = Game::select('slug', 'updated_at')
                ->whereNotNull('slug')
                ->orderBy('id', 'DESC')
                ->cursor();

            foreach ($games as $game) {
                $lastMod = $game->updated_at ? $game->updated_at->format('Y-m-d') : now()->format('Y-m-d');

                $xmlItems .= "
    <url>
        <loc>{$base}/g/{$game->slug}</loc>
        <lastmod>{$lastMod}</lastmod>
        <changefreq>daily</changefreq>
    </url>";
            }

            return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{$xmlItems}
</urlset>
XML;
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}