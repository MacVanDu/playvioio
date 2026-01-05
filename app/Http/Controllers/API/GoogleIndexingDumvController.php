<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Indexing;

class GoogleIndexingDumvController extends Controller
{
    /*
    list cac maill
    ==========du1320132
        epindexlaravel2@epindexlaravel2.iam.gserviceaccount.com
    	epindex-dumv-1@epindexlaravel.iam.gserviceaccount.com
    */

    public function __construct() {}

    public function updateUrlIndex(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $keys = [
            storage_path('app/google/key1.json'),
            storage_path('app/google/key2.json')
        ];

        foreach ($keys as $key) {
            $client = new Client();
            $client->setAuthConfig($key); // Đường dẫn tới file json
            $client->addScope('https://www.googleapis.com/auth/indexing');
            $client->setAccessType('offline');

            $indexingService = new Indexing($client);
            $content = new \Google\Service\Indexing\UrlNotification();
            $content->setUrl($request->url);
            $content->setType('URL_UPDATED');

            try {
                $response = $indexingService->urlNotifications->publish($content);
                return response()->json(['success' => true, 'response' => $response]);
            } catch (\Exception $e) {
                continue;
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Tất cả key đều lỗi hoặc vượt hạn mức.',
        ]);
    }
}
