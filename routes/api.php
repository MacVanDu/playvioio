<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\GameChatController;

Route::prefix('games')->group(function () {
    Route::get('{gameId}/chat', [GameChatController::class, 'index']);
    Route::post('{gameId}/chat', [GameChatController::class, 'store']);
});

Route::get('/pagedata/{slug}', [PageController::class, 'store']);

