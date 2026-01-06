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
    Route::get('/g/{slug}', 'detail')->name('home.detail');
    Route::get('/splash/{slug}', 'splash')->name('home.splash');
    Route::get('/search', 'search')->name('home.search');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Trang quản trị
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('games', GameController::class);
        Route::resource('settings', SettingController::class);
        Route::post('/games/{id}/toggle-trend', [GameController::class, 'toggleTrend']);
    });
});
