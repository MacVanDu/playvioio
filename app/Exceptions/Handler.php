<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\Category;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function data_mac_dinh()
    {
        return [
            'category' => Category::
                orderBy('id', 'DESC')
                ->limit(10)
                ->get(),
        ];
    }
    public function render($request, Throwable $exception)
    {
        dd($exception);
        // return parent::render($request, $exception);
        
        $datamd = $this->data_mac_dinh();
            return view('game.pages.404', compact(
                'datamd',
            ))->render();
    }
}