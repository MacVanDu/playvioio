<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
        $prefix = $locale === $default ? '' : '/' . $locale;

        View::share('currentLocale', $locale);
        View::share('localePrefix', $prefix);
        View::share('supportedLocales', config('locales.supported_text'));

        return $next($request);
    }

}
