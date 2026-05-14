<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Game;
use App\Models\Pages;
use Illuminate\Support\Facades\Cache;

class SiteMapController extends Controller
{
    private string $url = 'https://marios.games';
    private int $cacheTime = 86400;

    public function sitemap()
    {
        $xml = Cache::remember('a_sitemap_index_xml_v2', $this->cacheTime, function () {
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

    public function misc()
    {
        $xml = Cache::remember('a_sitemap_misc_xml_v2', $this->cacheTime, function () {
            $lastmod = now()->format('Y-m-d');
            $items = $this->urlEntry('', $lastmod, 'daily', '1.0');

            Pages::select('slug')->whereNotNull('slug')->orderBy('id')->get()->each(function ($page) use (&$items, $lastmod) {
                $items .= $this->urlEntry('/page/' . $page->slug, $lastmod, 'monthly', '0.6');
            });

            return $this->urlSet($items);
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function sitemapcategories()
    {
        $xml = Cache::remember('a_sitemap_categories_xml_v2', $this->cacheTime, function () {
            $items = '';

            Category::select('slug', 'updated_at')
                ->whereNotNull('slug')
                ->orderBy('id')
                ->get()
                ->each(function ($cat) use (&$items) {
                    $lastmod = $cat->updated_at ? $cat->updated_at->format('Y-m-d') : now()->format('Y-m-d');
                    $items .= $this->urlEntry('/c/' . $cat->slug, $lastmod, 'weekly', '0.8');
                });

            return $this->urlSet($items);
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function sitemapgames()
    {
        $xml = Cache::remember('a_sitemap_games_xml_v2', $this->cacheTime, function () {
            $items = '';

            foreach (Game::select('slug', 'updated_at')->whereNotNull('slug')->orderBy('id', 'DESC')->cursor() as $game) {
                $lastmod = $game->updated_at ? $game->updated_at->format('Y-m-d') : now()->format('Y-m-d');
                $items .= $this->urlEntry('/g/' . $game->slug, $lastmod, 'weekly', '0.9');
            }

            return $this->urlSet($items);
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    private function urlSet(string $items): string
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
{$items}
</urlset>
XML;
    }

    private function urlEntry(string $path, string $lastmod, string $changefreq, string $priority): string
    {
        $loc = $this->escape($this->localizedUrl('', $path));
        $alternates = $this->alternateLinks($path);

        return "
    <url>
        <loc>{$loc}</loc>
{$alternates}
        <lastmod>{$lastmod}</lastmod>
        <changefreq>{$changefreq}</changefreq>
        <priority>{$priority}</priority>
    </url>";
    }

    private function alternateLinks(string $path): string
    {
        $links = '';

        foreach ($this->localeCodes() as $locale) {
            $hreflang = $locale === '' ? 'en' : $locale;
            $href = $this->escape($this->localizedUrl($locale, $path));
            $links .= "        <xhtml:link rel=\"alternate\" hreflang=\"{$hreflang}\" href=\"{$href}\" />\n";
        }

        $xDefault = $this->escape($this->localizedUrl('', $path));
        $links .= "        <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$xDefault}\" />\n";

        return rtrim($links);
    }

    private function localizedUrl(string $locale, string $path): string
    {
        $path = '/' . ltrim($path, '/');
        $path = $path === '/' ? '' : $path;

        return $locale === '' ? $this->url . $path : $this->url . '/' . $locale . $path;
    }

    private function localeCodes(): array
    {
        return array_keys(config('locales.supported_text', ['' => 'English']));
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }
}
