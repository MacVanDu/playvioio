<?php

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

$localizedPrefixes = ['de', 'fr', 'pt', 'jp', 'kr', 'be', 'vn'];

foreach ($localizedPrefixes as $localePrefix) {
    Route::prefix($localePrefix)
        ->middleware('setlocale')
        ->name('localized.' . $localePrefix . '.')
        ->controller(HomeControllerMTLG::class)
        ->group(function () {
            Route::get('/', 'localizedIndex')->name('home.index');
            Route::get('/page/{slug}', 'localizedPages')->name('home.pages');
            Route::get('/c/{slug}/{page?}', 'localizedCategory')
                ->where('page', '[0-9]+')
                ->name('home.category');
            Route::get('/g/{slug}', 'localizedDetail')->name('home.detail');
            Route::get('/splash/{slug}', 'localizedSplash')->name('home.splash');
            Route::get('/search', 'localizedSearch')->name('home.search');
        });
}

Route::controller(SiteMapController::class)->group(function () {
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap.index');
    Route::get('/sitemaps/misc.xml', 'misc')->name('sitemap.misc');
    Route::get('/sitemaps/categories.xml', 'sitemapcategories')->name('sitemap.sitemapcategories');
    Route::get('/sitemaps/games.xml', 'sitemapgames')->name('sitemap.sitemapgames');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
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
