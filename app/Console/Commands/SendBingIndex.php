<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Game; // đổi nếu model bạn tên khác
use App\Models\Setting;

class SendBingIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bing:send-index';

    protected $file_log = 'game_index_bing';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi 100 game có imgstatus = 1 lên Bing Index API và cập nhật trạng thái sang 2';


    public function logss($log)
    {
        Log::channel($this->file_log)->info($log);
    }
    public function handle()
    {
        $siteUrl = "https://www.apkgosu.fun"; // thay domain thật
        $apiKey  = "c60809f21f03495aaaa1f376256b973c"; // nếu dùng Bing API, thay bằng key của bạn
        $endpoint = "https://ssl.bing.com/webmaster/api.svc/json/SubmitUrlbatch?apikey=$apiKey";

        $games = Game::where('imgstatus', 1)
            ->inRandomOrder()
            ->take(Setting::getValue('so_game_gui_index_cho_bing', 10, true))
            ->get();

        if ($games->isEmpty()) {
            $this->logss("Không có game nào có imgstatus = 1 để gửi.");
            return;
        }

        // Tạo danh sách URL
        $urls = $games->map(function ($g) use ($siteUrl) {
            return $siteUrl . '/g/' . $g->slug;
        })->toArray();

        // Gửi API
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($endpoint, [
                'siteUrl' => $siteUrl,
                'urlList' => $urls
            ]);

        if ($response->ok()) {
            // Cập nhật trạng thái nếu gửi thành công
            Game::whereIn('id', $games->pluck('id'))->update(['imgstatus' => 2]);

            $this->logss("✅ Đã gửi " . count($urls) . " =");
        } else {
            $this->logss("❌ Gửi thất bại: " . $response->body());
        }
    }
}
