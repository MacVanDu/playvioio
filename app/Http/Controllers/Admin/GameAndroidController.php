<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameAndroid;

class GameAndroidController extends Controller
{
    public function index()
    {
        $games = GameAndroid::latest()->paginate(10);
        return view('admin.game_android.index', compact('games'));
    }

    public function create()
    {
        return view('admin.game_android.create');
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'name'        => 'required|string|max:200',
        'slug'        => 'required|string|max:255|unique:game_android,slug',
        'mau'         => 'nullable|string|max:100',
        'iframe'      => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'tags'        => 'nullable|string|max:300',
        'logo'        => 'nullable|url|max:255',
        'anh_nen'     => 'nullable|url|max:255',
        'video'       => 'nullable|url|max:400',
        'loai'        => 'nullable|integer|min:0',
        'man_ngang'   => 'required|integer|in:0,1',
        'hienbanner'  => 'required|integer|in:0,1',
    ]);

    GameAndroid::create($validated);

    return redirect()
        ->route('admin.game-android.index')
        ->with('success', 'Thêm game thành công!');
    }

    public function edit(GameAndroid $game_android)
    {
        return view('admin.game_android.edit', compact('game_android'));
    }

    public function update(Request $request, GameAndroid $game_android)
    {
      $validated = $request->validate([
        'name'        => 'required|string|max:200',
        'mau'         => 'nullable|string|max:100',
        'iframe'      => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'tags'        => 'nullable|string|max:300',
        'logo'        => 'nullable|url|max:255',
        'anh_nen'     => 'nullable|url|max:255',
        'video'       => 'nullable|url|max:400',
        'loai'        => 'nullable|integer|min:0',
        'man_ngang'   => 'required|integer|in:0,1',
        'hienbanner'  => 'required|integer|in:0,1',
    ]);

    $game_android->update($validated);
    return redirect()->route('admin.game-android.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(GameAndroid $game_android)
    {
        $game_android->delete();
        return back()->with('success', 'Đã xóa thành công!');
    }
}
