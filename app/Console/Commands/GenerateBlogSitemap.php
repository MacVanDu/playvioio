<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateBlogSitemap extends Command
{
    /**
     * Tên lệnh Artisan.
     *
     * @var string
     */
    protected $signature = 'sitemap:blog';

    /**
     * Mô tả lệnh.
     *
     * @var string
     */
    protected $description = '📰 Tạo sitemap cho Blog (bài viết, danh mục, tag)';

    /**
     * Thực thi lệnh.
     */
    public function handle()
    {
    }
}
