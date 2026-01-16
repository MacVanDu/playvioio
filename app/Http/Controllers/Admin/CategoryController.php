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
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'description_seo' => 'nullable|string',
            'imagesvg' => 'nullable', // CÓ THỂ LÀ LINK HOẶC FILE
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $imagePath = null;
        $path_save = 'imgs/c';
        if ($request->hasFile('imagesvg')) {
        $path = public_path($path_save);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

            $file = $request->file('imagesvg');

            // GIỮ NGUYÊN TÊN FILE
            $filename = $file->getClientOriginalName();
        $file->move($path, $filename);


            $imagePath = '/'.$path_save.'/' . $filename;
        } 

        Category::create([
            'title'     => $request->title,
            'description'     => $request->description,
            'description_seo'     => $request->description_seo,
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
            'title'     => 'nullable',
            'description'     => 'nullable',
            'description_seo'     => 'nullable',
            'image' => 'nullable',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        // MẶC ĐỊNH GIỮ LINK CŨ
        $imagePath = $category->image;
     if ($request->hasFile('image')) {


        $path = public_path('imgs/c');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

            $file = $request->file('image');

            // GIỮ NGUYÊN TÊN FILE
            $filename = $file->getClientOriginalName();
        $file->move($path, $filename);


            $imagePath = '/imgs/c/' . $filename;
        } 
if($imagePath){
        $category->update([
            'title'     => $request->title,
            'description'     => $request->description,
            'description_seo'     => $request->description_seo,
            'name'     => $request->name,
            'slug'     => $slug,
            'imagesvg' => $imagePath,
        ]);
}else{
        $category->update([
            'title'     => $request->title,
            'description'     => $request->description,
            'description_seo'     => $request->description_seo,
            'name'     => $request->name,
            'slug'     => $slug,
        ]);
}

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
