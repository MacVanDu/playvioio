<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $supported = config('locales.supported');
        $default = config('locales.default');

        $locale = $request->route('locale') ?? $default;

        // Nếu locale không hợp lệ thì dùng tiếng Anh
        if (!in_array($locale, $supported)) {
            $locale = $default;
        }

        app()->setLocale($locale);

        return $next($request);
    }

}
