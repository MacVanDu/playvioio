<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PageController;

Route::get('/pagedata/{slug}', [PageController::class, 'store']);

