<?php

namespace App\Http\Services;

use App\Models\ApiKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiKeyManager
{
    // Lấy 1 key còn quota (atomic)
public function acquireKey(int $minRemaining = 1): ?ApiKey
{
    return DB::transaction(function () use ($minRemaining) {

        // 🔹 Lấy key còn quota
        $key = ApiKey::where('active', true)
            ->whereColumn('used_today', '<', 'daily_limit')
            ->orderByRaw('daily_limit - used_today DESC')
            ->lockForUpdate()
            ->first();

        // 🔹 Nếu không có key nào khả dụng → reset lại toàn bộ
        if (! $key) {
            Log::warning('⚠️ Không còn key khả dụng — tiến hành reset quota.');
            ApiKey::query()->update(['used_today' => 0, 'active' => true]);

            // 🔹 Lấy lại 1 key sau reset
            $key = ApiKey::where('active', true)
                ->orderBy('id')
                ->lockForUpdate()
                ->first();
        }

        return $key;
    });
}


    // Tăng bộ đếm sau khi dùng (atomic)
    public function incrementUsage(ApiKey $apiKey, int $amount = 1)
    {
        DB::transaction(function () use ($apiKey, $amount) {
            $apiKey->used_today = DB::raw("used_today + {$amount}");
            $apiKey->last_used_at = now();
            $apiKey->save();
        });
    }

    // Gọi API với logic fallback (thử nhiều key khi gặp 429/errors)
public function callGemini(array $payload, string $model = 'gemini-2.0-flash', int $maxTries = 5)
{
    $attempt = 0;
    $lastException = null;

    while ($attempt < $maxTries) {
        $attempt++;
        $apiKey = $this->acquireKey();
        if (! $apiKey) {
            throw new Exception('Không còn API key khả dụng (hết quota tất cả key).');
        }

        try {
            // ✅ Endpoint chính xác
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey->key,
            ])->post($url, $payload);

            // Nếu rate-limit hoặc lỗi server
            if ($response->status() == 429 || $response->serverError()) {
                Log::warning("Key {$apiKey->id} lỗi {$response->status()}, thử key khác.");
                $apiKey->active = false;
                $apiKey->save();
                continue;
            }

            // Nếu thành công
            if ($response->successful()) {
                $this->incrementUsage($apiKey, 1);
                return $response->json();
            }

            // Nếu lỗi khác
            throw new Exception('Lỗi khi gọi Gemini: ' . $response->body());
        } catch (Exception $ex) {
            $lastException = $ex;
            Log::error("Lỗi khi dùng key {$apiKey->id}: " . $ex->getMessage());
            continue;
        }
    }

    throw $lastException ?: new Exception('Gọi Gemini thất bại sau nhiều lần thử.');
}

}
