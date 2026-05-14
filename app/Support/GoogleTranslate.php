<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GoogleTranslate
{
    private static array $localeMap = [
        'de' => 'de',
        'fr' => 'fr',
        'pt' => 'pt',
        'jp' => 'ja',
        'kr' => 'ko',
        'be' => 'nl',
        'vn' => 'vi',
    ];

    public static function translate(?string $text, string $locale): ?string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return null;
        }

        $target = self::$localeMap[$locale] ?? null;
        if (!$target) {
            return null;
        }

        return Cache::remember('google_translate_' . $locale . '_' . md5($text), 86400 * 30, function () use ($text, $locale, $target) {
        try {
            $chunks = mb_str_split($text, 3500, 'UTF-8');
            $translated = [];

            foreach ($chunks as $chunk) {
                $response = Http::timeout(30)
                    ->retry(2, 500)
                    ->get('https://translate.googleapis.com/translate_a/single', [
                        'client' => 'gtx',
                        'sl' => 'en',
                        'tl' => $target,
                        'dt' => 't',
                        'q' => $chunk,
                    ]);

                if (!$response->ok()) {
                    return null;
                }

                $payload = $response->json();
                $translated[] = collect($payload[0] ?? [])
                    ->map(function ($part) {
                        return $part[0] ?? '';
                    })
                    ->implode('');

                usleep(150000);
            }

            return trim(implode('', $translated));
        } catch (\Throwable $exception) {
            Log::warning('Google translate failed', [
                'locale' => $locale,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
        });
    }
}
