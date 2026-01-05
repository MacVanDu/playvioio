<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Schema;

use App\Models\Category;

class CategoryService
{

public function checkCategory($name, $slug)
{
    // Tìm theo slug (duy nhất hơn name)
    $category = Category::where('slug', $slug)->first();

    if ($category) {
        return $category->id;
    }

    // Nếu chưa có, tạo mới — dùng save() để không cần $fillable
    try {
    $newCategory = new Category();
    $newCategory->name = $name;
    $newCategory->slug = $slug;
    $newCategory->save();

    return $newCategory->id;
} catch (\Throwable $e) {
    dd('LỖI:', $e->getMessage());
}

    return $newCategory->id;
}

}
