<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        $sortable = ['id', 'title', 'created_at', 'published_at'];
        $sortBy = $request->input('sort_by');
        $sortOrder = $request->input('sort_order', 'desc');

        if (in_array($sortBy, $sortable)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', 'desc');
        }

        $posts = $query->paginate(20)->appends($request->all());

        return view('admin.blog.posts.index', compact('posts', 'search', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        $data['slug'] = Str::slug($request->title);
        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Thêm bài viết thành công!');
    }

    public function edit(Post $post)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
        ]);

        $post->update($data);
        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Xóa bài viết thành công!');
    }
}

