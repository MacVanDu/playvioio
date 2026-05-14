<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameChat;
use App\Models\Game;
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

      public function ajax(Request $request)
    {
    $name = $request->name;
  
    $games = Game::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->limit(10)
        ->get();

    // Nếu không có kết quả
    if ($games->isEmpty()) {
        return '
        <div class="lists">
            <ul>
                <div style="padding:5px;">No results</div>
            </ul>
        </div>';
    }

    // Tạo HTML
    $html = '<div class="lists"><ul>';

    foreach ($games as $game) {
        $html .= '
            <li class="lc">
                <a href="'.$game->slugGame().'" title="'.$game->nameGame().'">
                    <div class="c_c1 p1">
                        <img class="lazyload r_img2" src="'.$game->linkImgGame().'">
                    </div>
                    <span>'.$game->nameGame().'</span>
                </a>
            </li>';
    }

    $html .= '</ul></div>';

    return response($html, 200)->header('Content-Type', 'text/html');
    }
}
