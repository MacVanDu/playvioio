<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicCacheHeaders
{
    public function handle(Request $request, Closure $next, int $maxAge = 600, int $sharedMaxAge = 3600): Response
    {
        $response = $next($request);

        if (!$request->isMethodCacheable() || $response->getStatusCode() !== 200) {
            return $response;
        }

        $response->headers->remove('Pragma');
        $response->headers->remove('Set-Cookie');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
        $response->headers->set(
            'Cache-Control',
            "public, max-age={$maxAge}, s-maxage={$sharedMaxAge}, stale-while-revalidate=86400"
        );

        return $response;
    }
}
