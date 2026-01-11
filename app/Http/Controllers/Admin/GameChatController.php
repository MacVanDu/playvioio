<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\GameChat;
use App\Models\Category;
use Illuminate\Http\Request;

class GameChatController extends Controller
{
 
public function index(Request $request)
{
    $query = GameChat::query();

    // 🔍 SEARCH
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // 🎯 FILTER STATUS
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🎯 FILTER GAME
    if ($request->filled('game_id')) {
        $query->where('game_id', $request->game_id);
    }

    // 🧱 CÁC CỘT ĐƯỢC PHÉP SORT
    $sortable = ['id', 'game_id', 'username', 'status', 'created_at'];

    $sortBy    = $request->input('sort_by');
    $sortOrder = $request->input('sort_order', 'asc');

    // 🔃 SORT
    if (in_array($sortBy, $sortable)) {
        $query->orderBy($sortBy, $sortOrder);
    } else {
        $query->orderBy('id', 'desc');
    }

    // 📄 PAGINATE (GIỐNG HỆ GAME)
    $chats = $query->paginate(20)->appends([
        'search'     => $search,
        'status'     => $request->status,
        'game_id'    => $request->game_id,
        'sort_by'    => $sortBy,
        'sort_order' => $sortOrder,
    ]);

    return view(
        'admin.chats.index',
        compact('chats', 'search', 'sortBy', 'sortOrder')
    );
}
   // ===== DUYỆT COMMENT =====
    public function approve($id)
    {
        GameChat::where('id', $id)->update([
            'status' => 1, // active
        ]);

        return redirect()
            ->route('admin.chats.index')
            ->with('success', 'Đã duyệt comment');
    }

    // ===== ẨN COMMENT =====
    public function hide($id)
    {
        GameChat::where('id', $id)->update([
            'status' => 2, // hidden
        ]);

        return redirect()
            ->route('admin.chats.index')
            ->with('success', 'Đã ẩn comment');
    }

    // ===== XOÁ COMMENT =====
    public function destroy($id)
    {
        GameChat::where('id', $id)->delete();

        return redirect()
            ->route('admin.chats.index')
            ->with('success', 'Đã xoá comment');
    }
    public function bulk(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'action' => 'required|string',
    ]);

    switch ($request->action) {
        case 'approve':
            GameChat::whereIn('id', $request->ids)->update(['status' => 1]);
            break;
        case 'hide':
            GameChat::whereIn('id', $request->ids)->update(['status' => 2]);
            break;
        case 'delete':
            GameChat::whereIn('id', $request->ids)->delete();
            break;
    }

    return back()->with('success', 'Đã xử lý '.count($request->ids).' comment');
}

}
