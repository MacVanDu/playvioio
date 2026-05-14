<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeControllerMTLG;
use App\Http\Controllers\Frontend\SiteMapController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GameChatController;
use App\Http\Controllers\Admin\ImageOptimizerController;
use App\Http\Controllers\Admin\PagessController;
use App\Http\Controllers\Admin\SettingController;

$frontendRoutes = function () {
    Route::controller(HomeControllerMTLG::class)->middleware('setlocale')->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/page/{slug}', 'pages')->name('home.pages');
        Route::get('/c/{slug}/{page?}', 'category')
            ->where('page', '[0-9]+')
            ->name('home.category');
        Route::get('/g/{slug}', 'detail')->name('home.detail');
        Route::get('/splash/{slug}', 'splash')->name('home.splash');
        Route::get('/search', 'search')->name('home.search');
    });
};

$frontendRoutes();

Route::prefix('{locale}')
    ->whereIn('locale', array_values(array_diff(config('locales.supported'), [config('locales.default')])))
    ->middleware('setlocale')
    ->name('localized.')
    ->group(function () {
        Route::get('/', function (Request $request) {
            return app(HomeControllerMTLG::class)->index($request);
        })->name('home.index');

        Route::get('/page/{slug}', function (Request $request, string $locale, string $slug) {
            return app(HomeControllerMTLG::class)->pages($slug, $request);
        })->name('home.pages');

        Route::get('/c/{slug}/{page?}', function (Request $request, string $locale, string $slug, int $page = 1) {
            return app(HomeControllerMTLG::class)->category($request, $slug, $page);
        })->where('page', '[0-9]+')->name('home.category');

        Route::get('/g/{slug}', function (Request $request, string $locale, string $slug) {
            return app(HomeControllerMTLG::class)->detail($slug, $request);
        })->name('home.detail');

        Route::get('/splash/{slug}', function (Request $request, string $locale, string $slug) {
            return app(HomeControllerMTLG::class)->splash($slug, $request);
        })->name('home.splash');

        Route::get('/search', function (Request $request) {
            return app(HomeControllerMTLG::class)->search($request);
        })->name('home.search');
    });

Route::controller(SiteMapController::class)->group(function () {
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap.index');
    Route::get('/sitemaps/misc.xml', 'misc')->name('sitemap.misc');
    Route::get('/sitemaps/categories.xml', 'sitemapcategories')->name('sitemap.sitemapcategories');
    Route::get('/sitemaps/games.xml', 'sitemapgames')->name('sitemap.sitemapgames');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('games', GameController::class);
        Route::resource('chats', GameChatController::class);
        Route::resource('pages', PagessController::class);
        Route::resource('settings', SettingController::class);
        Route::get('/image-optimizer', [ImageOptimizerController::class, 'index'])->name('image-optimizer.index');
        Route::post('/image-optimizer', [ImageOptimizerController::class, 'optimize'])->name('image-optimizer.optimize');
        Route::post('/games/{id}/toggle-trend', [GameController::class, 'toggleTrend']);
        Route::post('/games/{id}/mobile', [GameController::class, 'mobile']);

        Route::post('chats/{id}/approve', [GameChatController::class, 'approve']);
        Route::post('chats/{id}/hide', [GameChatController::class, 'hide']);
        Route::delete('chats/{id}', [GameChatController::class, 'destroy']);
        Route::post('chats/bulk', [GameChatController::class, 'bulk'])->name('chats.bulk');
    });
});
