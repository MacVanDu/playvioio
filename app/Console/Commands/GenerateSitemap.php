<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Game;
use App\Models\Category;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * Tên lệnh artisan
     *
     * Chạy bằng: php artisan sitemap:generate
     */
    protected $signature = 'sitemap:generate';

    /**
     * Mô tả lệnh
     */
    protected $description = 'Tạo sitemap tự động cho web game (home, category, game)';

    /**
     * Thực thi lệnh
     */
    public function handle()
    {
        $base = 'https://www.apkgosu.fun';

        $this->info('🚀 Bắt đầu tạo sitemap cho web game...');

        /**
         * 🏠 1. Sitemap cho các trang tĩnh
         */
        Sitemap::create()
            ->add(Url::create($base . '/')
                ->setPriority(1.0)
                ->setChangeFrequency('daily'))
            ->add(Url::create($base . '/about/Privacy_Policy.html')
                ->setPriority(0.6)
                ->setChangeFrequency('monthly'))
            ->add(Url::create($base . '/about/Terms_of_Service.html')
                ->setPriority(0.6)
                ->setChangeFrequency('monthly'))
            ->writeToFile(public_path('sitemap-pages.xml'));

        $this->info('✅ Đã tạo sitemap cho trang tĩnh.');

        /**
         * 🧩 2. Sitemap cho thể loại game (/c/{slug})
         */
     if (class_exists(Category::class)) {

    // ✅ Lấy tất cả category
    $categories = Category::query()->select('id', 'slug', 'created_at', 'updated_at')->get();

    $this->info('📊 Tổng số category lấy được: ' . $categories->count());

    if ($categories->count() > 0) {

        // ✅ Tạo sitemap
        $sitemap = Sitemap::create();

        foreach ($categories as $cat) {
            if (empty($cat->slug)) {
                $this->warn('⚠️ Category ID ' . $cat->id . ' không có slug, bỏ qua.');
                continue;
            }

            // Nếu không có updated_at thì dùng created_at
            $lastMod = null;

            if (!empty($cat->updated_at)) {
                $lastMod = Carbon::parse($cat->updated_at);
            } elseif (!empty($cat->created_at)) {
                $lastMod = Carbon::parse($cat->created_at);
            } else {
                $lastMod = Carbon::now();
            }

            // ✅ Thêm URL vào sitemap
            $sitemap->add(
                Url::create($base . '/c/' . $cat->slug)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($lastMod)
            );
        }

        // ✅ Ghi file sitemap
        $sitemap->writeToFile(public_path('sitemap-categories.xml'));

        $this->info('✅ Đã tạo sitemap cho thể loại game (' . $categories->count() . ' mục).');
    } else {
        $this->warn('⚠️ Không có dữ liệu Category.');
    }
} else {
    $this->warn('⚠️ Model Category chưa tồn tại, bỏ qua sitemap categories.');
}

        /**
         * 🎮 3. Sitemap cho từng game (/g/{slug})
         */

if (class_exists(Game::class)) {

    $totalGames = Game::count();
    $this->info('🎮 Tổng số game lấy được: ' . $totalGames);

    if ($totalGames > 0) {
        $chunkSize = 1948; // Số game mỗi file sitemap
        $chunkIndex = 1;
        $allSitemapFiles = [];

        Game::query()
            ->select('id', 'slug', 'created_at', 'updated_at')
            ->orderBy('vote_like', 'DESC')
            ->chunk($chunkSize, function ($games) use (&$chunkIndex, &$allSitemapFiles, $base) {

                $sitemap = Sitemap::create();

                foreach ($games as $game) {
                    if (empty($game->slug)) continue;

                    $lastMod = $game->updated_at
                        ? Carbon::parse($game->updated_at)
                        : ($game->created_at ? Carbon::parse($game->created_at) : Carbon::now());

                    $sitemap->add(
                        Url::create($base . '/g/' . $game->slug)
                            ->setPriority(0.9)
                            ->setChangeFrequency('weekly')
                            ->setLastModificationDate($lastMod)
                    );
                }

                $filename = "sitemap-games-{$chunkIndex}.xml";
                $sitemap->writeToFile(public_path($filename));
                $allSitemapFiles[] = $filename;

                $this->info("✅ Đã tạo {$filename} (" . count($games) . " games)");
                $chunkIndex++;
            });

        // Tạo sitemap index tổng hợp
        $indexContent = "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        foreach ($allSitemapFiles as $file) {
            $indexContent .= "  <sitemap><loc>{$base}/{$file}</loc></sitemap>\n";
        }
        $indexContent .= "</sitemapindex>";

        file_put_contents(public_path('sitemap-games-index.xml'), $indexContent);

        $this->info('🎯 Đã tạo sitemap-games-index.xml chứa tất cả sitemap game.');
    } else {
        $this->warn('⚠️ Không có dữ liệu Game.');
    }
} else {
    $this->warn('⚠️ Model Game chưa tồn tại, bỏ qua sitemap games.');
}

        /**
         * 🧭 4. Sitemap tổng hợp (index)
         */
// 🧭 4. Sitemap tổng hợp (index)
$now = Carbon::now()->toAtomString(); // chuẩn ISO 8601 cho <lastmod>

$index = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>{$base}/sitemap-pages.xml</loc>
    <lastmod>{$now}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{$base}/sitemap-categories.xml</loc>
    <lastmod>{$now}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{$base}/sitemap-games-index.xml</loc>
    <lastmod>{$now}</lastmod>
  </sitemap>
</sitemapindex>
XML;

file_put_contents(public_path('sitemap.xml'), $index);

$this->info('🎯 Sitemap tổng (sitemap.xml) đã được cập nhật chuẩn SEO!');

        $this->info('🎯 Đã tạo sitemap_index.xml thành công!');
        $this->info('✅ Hoàn tất! Sitemap cho web game đã sẵn sàng.');
    }
}