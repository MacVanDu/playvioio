<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{ public function index()
    {
        $categories = Category::orderBy('imgseo', 'DESC')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'imagesvg'    => 'nullable|string|max:200',
            'imgseo'      => 'nullable|string|max:200',
            'mo_ta_ngan'  => 'nullable|string|max:300',
            'mo_ta'       => 'nullable|string',
        ]);

        $slug = $request->slug ?? Str::slug($request->name);

        Category::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'imagesvg'    => $request->imagesvg,
            'imgseo'      => $request->imgseo,
            'mo_ta_ngan'  => $request->mo_ta_ngan,
            'mo_ta'       => $request->mo_ta,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm thể loại thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'imagesvg'    => 'nullable|string|max:200',
            'imgseo'      => 'nullable|string|max:200',
            'mo_ta_ngan'  => 'nullable|string|max:300',
            'mo_ta'       => 'nullable|string',
        ]);

        $slug = $request->slug ?? Str::slug($request->name);

        $category->update([
            'name'        => $request->name,
            'slug'        => $slug,
            'imagesvg'    => $request->imagesvg,
            'imgseo'      => $request->imgseo,
            'mo_ta_ngan'  => $request->mo_ta_ngan,
            'mo_ta'       => $request->mo_ta,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xoá thể loại!');
    }
}
