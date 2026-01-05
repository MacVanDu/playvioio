<?php

namespace App\Utility;

use Artisan;
use Auth;
use DB;
use Cache;
use Hash;
use Illuminate\Support\Str;
use Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Body;


class WorkerUtility
{
    public static function PUSH_HTML($key = 'test1', $html = '', $is_r2 = 2)
    {
        $response = Http::attach('key', $key)
            ->attach('html', $html) 
            ->attach('is_r2', $is_r2)
            ->withHeaders([ 
                'Accept'=> '*/*'
            ]) 
            ->post('https://api-push-html-multi-worker.lingering-haze-d098.workers.dev/api/save-html'); 
            
        $result =  $response->body();
        return json_decode($result);
    }

    public static function DELETE_HTML($key = 'test1', $is_r2 = 2)
    {
        $response = Http::attach('key', $key)
            ->attach('is_r2', $is_r2)
            ->withHeaders([ 
                'Accept'=> '*/*'
            ]) 
            ->post('https://api-push-html-multi-worker.lingering-haze-d098.workers.dev/api/delete-html'); 

        $result =  $response->body();
        return json_decode($result);
    }
}
