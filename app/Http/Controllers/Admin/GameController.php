<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function updateStatusIndex(Request $request, $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['success' => false]);
        }

        $game->status_index = $request->input('status_index');
        $game->save();

        return response()->json(['success' => true]);
    }
    public function index(Request $request)
    {
        // --- Tạo query cơ bản kèm load thể loại ---
        $query = Game::query()->with('category');

        // --- Tìm kiếm theo tên hoặc slug ---
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // --- Các cột được phép sắp xếp ---
        $sortable = ['id', 'name', 'created_at', 'video_y_id', 'blog_count', 'video_short','vote_like','vote_dis_like'];

        // Lấy cột và chiều sắp xếp từ query string (?sort_by=&sort_order=)
        $sortBy = $request->input('sort_by');
        $sortOrder = $request->input('sort_order', 'asc');

        // --- Kiểm tra nếu cột hợp lệ ---
        if (in_array($sortBy, $sortable)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Nếu không có tham số, mặc định sắp xếp theo id giảm dần (game mới nhất lên đầu)
            $query->orderBy('id', 'desc');
        }

        // --- Phân trang 20 game / trang ---
        $games = $query->paginate(20)->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);

        // --- Trả về view ---
        return view('admin.games.index', compact('games', 'search', 'sortBy', 'sortOrder'));
    }




    public function create()
    {
        $categories = Category::all();
        return view('admin.games.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'imgseo' => 'nullable|string|max:255',
        'link' => 'nullable|string',
        'video_short' => 'nullable|string',
        'tags' => 'nullable|string|max:200',
        'category_id' => 'required|integer',
        'description' => 'nullable|string',
    ]);

    Game::create($request->all());

    Cache::forget("homepage_games_d_7d");
    Cache::forget("homepage_games_mb");
    return redirect()
        ->route('admin.games.index')
        ->with('success', 'Thêm game thành công!');
}

    public function edit(Game $game)
    {
        $categories = Category::all();
        return view('admin.games.edit', compact('game', 'categories'));
    }
public function update(Request $request, Game $game)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|string|max:255',
        'imgseo' => 'nullable|string|max:255',
        'link' => 'nullable|string',
        'video_short' => 'nullable|string',
        'video_y_id' => 'nullable|string',
        'duration' => 'nullable|string|max:200',
        'tags' => 'nullable|string|max:200',
        'trend' => 'nullable|integer',
        'vote_like' => 'nullable|integer',
        'vote_dis_like' => 'nullable|integer',
        'imgstatus' => 'nullable|integer',
        'status' => 'nullable|integer',
        'status_index' => 'nullable|integer',
        'blog_count' => 'nullable|integer',
        'category_id' => 'required|integer',
        'description' => 'nullable|string',
    ]);
$data = $request->except('slug');
    // Cập nhật tất cả fields
    $game->update($data);

    Cache::forget("page_game_tt_3_h3_{$game->slug}_10");
    Cache::forget("page_game_tt_3_h3_{$game->slug}_36");
    return redirect()
        ->route('admin.games.index')
        ->with('success', 'Cập nhật game thành công!');
}

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Đã xoá game!');
    }
    
    public function toggleTrend($id, Request $request)
    {
        $game = Game::findOrFail($id);
        $game->trend = $request->trend;
        $game->save();

        return response()->json(['success' => true]);
    }
}
