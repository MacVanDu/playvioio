<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AndroidGameController;
use App\Http\Controllers\Frontend\HomeControllerMTLG;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FCMController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GameAndroidController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GameController;
use \App\Http\Controllers\Admin\PostController;
use \App\Http\Controllers\Admin\ScheduledCommandController;
use \App\Http\Controllers\Admin\LogController;
use \App\Http\Controllers\Admin\SettingController;


Route::controller(HomeControllerMTLG::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/page/{slug}', 'pages')->name('home.pages');
    Route::get('/c/{slug}/{page?}', 'category')
        ->where('page', '[0-9]+')
        ->name('home.category');

    Route::get('/new-games', 'newgames')->name('home.newgames');
    Route::get('/recent', 'recent')->name('home.recent');
    Route::get('/hot', 'hot')->name('home.hot');
    Route::get('/search', 'search')->name('home.search');
    Route::get('/iframe', 'iframe')->name('home.iframe');
    Route::get('/g/{slug}', 'detail')->name('home.detail');
    Route::get('/splash/{slug}', 'splash')->name('home.splash');
    Route::get('/tag/{tag}', 'tag')->name('home.tag');



    Route::get('/play/{slug}', 'detail')->name('home.play');

    Route::get('/sitemaps.xml', 'sitemap')->name('home.sitemaps1');
    Route::get('/sitemap.xml', 'sitemap')->name('home.sitemaps');
    Route::get('/sitemaps/index.xml', 'sitemap')->name('home.sitemap');
    Route::get('/sitemaps/misc.xml', 'misc')->name('home.misc');
    Route::get('/sitemaps/categories.xml', 'sitemapcategories')->name('home.sitemapcategories');
    Route::get('/sitemaps/games.xml', 'sitemapgames')->name('home.sitemapgames');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Trang đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Trang quản trị
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::resource('game-android', GameAndroidController::class);
        Route::resource('feedback', FeedbackController::class)->only(['index', 'destroy']);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('games', GameController::class);
        Route::resource('posts', PostController::class);
        Route::resource('scheduled-commands', ScheduledCommandController::class);
        Route::resource('settings', SettingController::class);
        

        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/', [LogController::class, 'index'])->name('index');
            Route::get('/view/{filename}', [LogController::class, 'show'])->name('show');
            Route::get('/download/{filename}', [LogController::class, 'download'])->name('download');
            Route::post('/clear/{filename}', [LogController::class, 'clear'])->name('clear');
            Route::delete('/delete/{filename}', [LogController::class, 'destroy'])->name('destroy');
        });

        Route::post('/games/{id}/update-status-index', [GameController::class, 'updateStatusIndex'])
            ->name('admin.games.updateStatusIndex');

        Route::post('/games/{id}/toggle-trend', [GameController::class, 'toggleTrend']);
    });
});
