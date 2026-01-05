<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AndroidGameController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\PageController;

use App\Http\Controllers\API\GameController;
// Route::get('/top-games', [GameController::class, 'topGames2']);

Route::post('/feedback', [AndroidGameController::class, 'store']);
Route::post('/feedbackgame', [FeedbackController::class, 'store']);
Route::post('/track-click', [FeedbackController::class, 'trackclick']);
Route::post('/contact', [FeedbackController::class, 'contact']);
Route::post('/feedbackWeb', [FeedbackController::class, 'FeedbackPage']);
Route::post('/games/rate', [GameController::class, 'rate']);
Route::post('/ajax', [GameController::class, 'ajax']);
Route::post('/android/ajax', [GameController::class, 'android_ajax']);
Route::get('/pagedata/{slug}', [PageController::class, 'store']);

