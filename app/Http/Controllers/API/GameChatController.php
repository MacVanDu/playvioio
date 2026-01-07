<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameChat;
use Illuminate\Http\Request;

class GameChatController extends Controller
{
   
    public function index($gameId)
    {
        return GameChat::byGame($gameId)
            ->active()
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();
    }

    public function store(Request $request, $gameId)
    {
        $request->validate([
            'username' => 'required|string|max:30',
            'message'  => 'required|string|max:300',
        ]);

        GameChat::create([
            'game_id'  => $gameId,
            'username' => $request->username,
            'message'  => e($request->message),
            'status'   => 0,
        ]);

        return response()->json(['ok' => true]);
    }
}
