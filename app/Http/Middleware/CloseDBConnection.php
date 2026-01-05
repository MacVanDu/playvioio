<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CloseDBConnection
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Đảm bảo đóng kết nối MySQL sau khi xử lý xong
        DB::disconnect();

        return $response;
    }
}
