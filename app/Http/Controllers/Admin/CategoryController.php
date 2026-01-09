<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    /* =====================
       STORE – THÊM CATEGORY
    ===================== */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:categories,name',
            'slug'     => 'nullable|string|max:255|unique:categories,slug',
            'imagesvg' => 'nullable', // CÓ THỂ LÀ LINK HOẶC FILE
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $imagePath = null;

        /**
         * TRƯỜNG imagesvg:
         * - Nếu là FILE → upload & lấy link
         * - Nếu là STRING → coi là link
         */
        if ($request->hasFile('imagesvg')) {
            $file = $request->file('imagesvg');

            // GIỮ NGUYÊN TÊN FILE
            $filename = $file->getClientOriginalName();

            $file->storeAs('public/categories', $filename);

            $imagePath = '/storage/categories/' . $filename;
        } else {
            // imagesvg là link
            $imagePath = $request->imagesvg;
        }

        Category::create([
            'name'     => $request->name,
            'slug'     => $slug,
            'imagesvg' => $imagePath,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Thêm thể loại thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /* =====================
       UPDATE – SỬA CATEGORY
    ===================== */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug'     => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'imagesvg' => 'nullable',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        // MẶC ĐỊNH GIỮ LINK CŨ
        $imagePath = $category->imagesvg;

        if ($request->hasFile('imagesvg')) {
            $file = $request->file('imagesvg');
            $filename = $file->getClientOriginalName();

            $file->storeAs('public/categories', $filename);
            $imagePath = 'storage/categories/' . $filename;
        } elseif ($request->filled('imagesvg')) {
            // User nhập link mới
            $imagePath = $request->imagesvg;
        }

        $category->update([
            'name'     => $request->name,
            'slug'     => $slug,
            'imagesvg' => $imagePath,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Đã xoá thể loại!');
    }
}
