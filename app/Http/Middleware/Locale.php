<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Config;
use Session;

class Locale extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = Session::get('website_language', config('app.locale'));
        // Lấy dữ liệu lưu trong Session, không có thì trả về default lấy trong config

        // Config::set('app.locale', $language);
        // Chuyển ứng dụng sang ngôn ngữ được chọn
        return $next($request);
    }
}
