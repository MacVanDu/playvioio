<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Game;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckGameImageJob implements ShouldQueue
{
    public $game;

    // Nhận model Game từ Controller
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handle()
    {
        $images = json_decode($this->game->images, true);

        if ($images && isset($images['path']) && !empty($images['sizes'])) {
            foreach ($images['sizes'] as $size) {
                $url = 'https://imgr2.akdgame.com/220x220' . $images['path'] . '/' . $size;

                try {
                    $response = Http::timeout(3)->head($url);

                    if ($response->successful()) {
                        $this->game->update([
                            'image' => $url,
                            'status2' => 1
                        ]);
                        return; // Dừng sau khi tìm thấy ảnh hợp lệ
                    }
                } catch (\Exception $e) {
                    Log::warning("Không kiểm tra được ảnh: {$url} ({$e->getMessage()})");
                }
            }
        }

        // Không có ảnh hợp lệ
        $this->game->update(['image' => null, 'status2' => 1]);
    }
}
