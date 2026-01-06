<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PagessController extends Controller
{
   public function index()
    {
        $pages = Pages::latest()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:200',
            'slug'     => 'nullable|string|max:100|unique:pages,slug',
            'contents' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        Pages::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Đã thêm trang');
    }

    public function edit(Pages $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Pages $page)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:200',
            'contents' => 'nullable|string',
        ]);

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Đã cập nhật trang');
    }

    public function destroy(Pages $page)
    {
        $page->delete();

        return back()->with('success', 'Đã xoá trang');
    }
}
