<?php

namespace App\Utility;

use Artisan;
use Auth;
use DB;
use Cache;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CommonUtility
{
    public static function PUGE_CACHE_CLOUDFLARE()
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/4506e32820a6a6748bdb8fd8b8e765db/purge_cache",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"purge_everything\": true \n}",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-Auth-Email: hieutt@ant.games",
                "X-Auth-Key: 1c73bbfe52ef37999483f026fd2163778b756"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
    }

    public static function PUGE_CACHE_CLOUDFLARE_BY_URL($url)
    {
        $shortUrl = str_replace(`https://`.config('app.domain'), '', $url);
        $response = Http::withBody(
            '{
                "domain":"'.config('app.domain').'",
                "host":"https://a.'.config('app.domain').'",
                "pathname":"'.$shortUrl.'"
            }',
                'json'
            )
            ->withHeaders([
                'Accept' => '*/*',
                'User-Agent' => 'Thunder Client (https://www.thunderclient.com)',
                'Content-Type' => 'application/json',
            ])
            ->post('https://'.config('app.domain').'/api/save');
        echo $response->body();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cloudflare.com/client/v4/zones/4506e32820a6a6748bdb8fd8b8e765db/purge_cache',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "files": [
                    {
                        "url":"' . $url . '"
                    }
                ]
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Auth-Email: hieutt@ant.games',
                'X-Auth-Key: 1c73bbfe52ef37999483f026fd2163778b756',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
