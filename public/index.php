<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$request = Request::capture();

$response = $kernel->handle($request);

// 👇 Debug kiểu của response để tránh lỗi
if (!method_exists($response, 'send')) {
    // Ghi log lỗi hoặc hiển thị lỗi rõ ràng
    $type = gettype($response);
    $message = "Invalid response type: {$type}. Expected Response object.";
    error_log($message);
    exit($message); // hoặc return 500
}

$response->send();

$kernel->terminate($request, $response);
