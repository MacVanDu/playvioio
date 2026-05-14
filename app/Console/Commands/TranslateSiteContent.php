<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Game;
use App\Models\Pages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class TranslateSiteContent extends Command
{
    protected $signature = 'site:translate-content
        {--locale=* : Locale to translate, for example vn or jp. Repeat or comma-separate for multiple locales.}
        {--type=all : all, games, categories, or pages}
        {--limit=50 : Number of rows per type. Use 0 for all rows.}
        {--force : Re-translate rows that already have translated content}';

    protected $description = 'Translate game, category, and page content into locale translation tables using Google Translate.';

    private array $googleLocales = [
        'de' => 'de',
        'fr' => 'fr',
        'pt' => 'pt',
        'jp' => 'ja',
        'kr' => 'ko',
        'be' => 'nl',
        'vn' => 'vi',
    ];

    public function handle(): int
    {
        $locales = $this->selectedLocales();
        $type = strtolower((string) $this->option('type'));
        $limit = max(0, (int) $this->option('limit'));
        $force = (bool) $this->option('force');

        if (!in_array($type, ['all', 'games', 'categories', 'pages'], true)) {
            $this->error('Invalid --type. Use all, games, categories, or pages.');
            return self::FAILURE;
        }

        if (!$this->translationTablesExist()) {
            $this->error('Missing translation tables. Import database_multilingual.sql first.');
            return self::FAILURE;
        }

        foreach ($locales as $locale) {
            $this->info("Translating content for {$locale}...");

            if ($type === 'all' || $type === 'games') {
                $this->translateGames($locale, $limit, $force);
            }

            if ($type === 'all' || $type === 'categories') {
                $this->translateCategories($locale, $limit, $force);
            }

            if ($type === 'all' || $type === 'pages') {
                $this->translatePages($locale, $limit, $force);
            }
        }

        $this->info('Translation finished.');
        return self::SUCCESS;
    }

    private function selectedLocales(): array
    {
        $requested = [];

        foreach ((array) $this->option('locale') as $value) {
            foreach (explode(',', (string) $value) as $locale) {
                $locale = trim($locale);
                if ($locale !== '') {
                    $requested[] = $locale;
                }
            }
        }

        $supported = array_keys($this->googleLocales);
        $locales = $requested ?: $supported;

        return array_values(array_intersect($locales, $supported));
    }

    private function translationTablesExist(): bool
    {
        return Schema::hasTable('game_translations')
            && Schema::hasTable('category_translations')
            && Schema::hasTable('page_translations');
    }

    private function translateGames(string $locale, int $limit, bool $force): void
    {
        $query = Game::query()->select(['id', 'name', 'title', 'description_seo', 'description'])->orderBy('id');
        if ($limit > 0) {
            $query->limit($limit);
        }

        foreach ($query->get() as $game) {
            if (!$force && $this->hasCompleteTranslation('game_translations', 'game_id', $game->id, $locale, ['name', 'title', 'description_seo', 'description'])) {
                continue;
            }

            DB::table('game_translations')->updateOrInsert(
                ['game_id' => $game->id, 'locale' => $locale],
                [
                    'name' => $this->translateText((string) $game->name, $locale),
                    'title' => $this->translateText((string) $game->title, $locale),
                    'description_seo' => $this->translateText((string) $game->description_seo, $locale),
                    'description' => $this->translateText((string) $game->description, $locale),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $this->line("Game #{$game->id}");
        }
    }

    private function translateCategories(string $locale, int $limit, bool $force): void
    {
        $query = Category::query()->select(['id', 'name', 'title', 'description_seo', 'description'])->orderBy('id');
        if ($limit > 0) {
            $query->limit($limit);
        }

        foreach ($query->get() as $category) {
            if (!$force && $this->hasCompleteTranslation('category_translations', 'category_id', $category->id, $locale, ['name', 'title', 'description_seo', 'description'])) {
                continue;
            }

            DB::table('category_translations')->updateOrInsert(
                ['category_id' => $category->id, 'locale' => $locale],
                [
                    'name' => $this->translateText((string) $category->name, $locale),
                    'title' => $this->translateText((string) $category->title, $locale),
                    'description_seo' => $this->translateText((string) $category->description_seo, $locale),
                    'description' => $this->translateText((string) $category->description, $locale),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $this->line("Category #{$category->id}");
        }
    }

    private function translatePages(string $locale, int $limit, bool $force): void
    {
        $query = Pages::query()->select(['id', 'title', 'contents'])->orderBy('id');
        if ($limit > 0) {
            $query->limit($limit);
        }

        foreach ($query->get() as $page) {
            if (!$force && $this->hasCompleteTranslation('page_translations', 'page_id', $page->id, $locale, ['title', 'contents'])) {
                continue;
            }

            DB::table('page_translations')->updateOrInsert(
                ['page_id' => $page->id, 'locale' => $locale],
                [
                    'title' => $this->translateText((string) $page->title, $locale),
                    'contents' => $this->translateText((string) $page->contents, $locale),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $this->line("Page #{$page->id}");
        }
    }

    private function hasCompleteTranslation(string $table, string $key, int $id, string $locale, array $fields): bool
    {
        $query = DB::table($table)
            ->where($key, $id)
            ->where('locale', $locale);

        foreach ($fields as $field) {
            $query->whereNotNull($field)->where($field, '<>', '');
        }

        return $query->exists();
    }

    private function translateText(string $text, string $locale): ?string
    {
        $text = trim($text);
        if ($text === '') {
            return null;
        }

        $target = $this->googleLocales[$locale] ?? $locale;
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
                throw new \RuntimeException("Google Translate failed for locale {$locale}.");
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
    }
}
