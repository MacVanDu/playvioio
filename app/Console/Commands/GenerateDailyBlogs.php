<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class GenerateDailyBlogs extends Command
{
    protected $signature = 'blog:auto-generate';
    protected $file_log = 'tao_blog';
    public function logss($log)
    {
        Log::channel($this->file_log)->info($log);
    }
    protected $description = 'Tự động sinh 2 bài blog mỗi ngày bằng Gemini và ping Google.';

    public function handle()
    {
    }

}
