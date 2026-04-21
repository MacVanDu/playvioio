<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
 public function checkMobile(Request $request): bool
    {
        $device = $this->detectDevice($request);
        if ($device === 'MB') {
            return true;
        } else {
            return false;
        }
    }
    public function detectDevice(Request $request): string
    {
        $userAgent = $request->header('User-Agent');

        // iPad
        if (preg_match('/ipad/i', $userAgent)) {
            return 'TL';
        }

        // Android Tablet (có Android nhưng KHÔNG có Mobile)
        if (preg_match('/android/i', $userAgent) && !preg_match('/mobile/i', $userAgent)) {
            return 'TL'; // Tablet
        }

        // Các loại tablet khác (generic)
        if (preg_match('/tablet/i', $userAgent)) {
            return 'TL';
        }


        // iPhone / Android / iPod
        if (preg_match('/mobile|android|iphone|ipod/i', $userAgent)) {
            return 'MB'; // Mobile
        }

        // Desktop
        return 'PC';
    }

    public function data_mac_dinh(Request $request)
    {
        $anh_nen = Setting::getValue('anh_nen', '/images/bg2.png', false);
        $fb_link = Setting::getValue('fb_link', '#', false);
        $x_link = Setting::getValue('x_link', '#', false);
        $r_link = Setting::getValue('r_link', '#', false);
        $head_qc = Setting::getValue('head_qc', '', false);
        $qc_trang_chu = Setting::getValue('qc_trang_chu', '', false);
        $qc_trang_game728x90 = Setting::getValue('qc_trang_game728x90', '', false);
        $qc_trang_game300x600 = Setting::getValue('qc_trang_game300x600', '', false);
        $qc_trang_game160x600 = Setting::getValue('qc_trang_game160x600', '', false);
        $device = $this->detectDevice($request);
        return [
            'anh_nen' => $anh_nen,
            'r_link' => $r_link,
            'x_link' => $x_link,
            'fb_link' => $fb_link,
            'device' => $device,
            'head_qc' => $head_qc,
            'qc_trang_chu' => $qc_trang_chu,
            'qc_trang_game728x90' => $qc_trang_game728x90,
            'qc_trang_game300x600' => $qc_trang_game300x600,
            'qc_trang_game160x600' => $qc_trang_game160x600,
            'category' => Category::orderBy('id', 'DESC')
                ->limit(10)
                ->get(),
        ];
    }
    public function render($request, Throwable $exception)
    {
        // dd($exception);
        // return parent::render($request, $exception);
        
        // $datamd = $this->data_mac_dinh($request);
    return response()->view('game.pages.404', [], 404);
    }
}