@extends('admin.layouts.master')

@section('content')
<div class="container mt-4 text-white">
    <h2>Thêm Game mới</h2>

    <form method="POST" action="{{ route('admin.games.store') }}">
        @csrf

        <div class="row">

            @include('admin.components.input', [
                'label' => 'Tên Game',
                'name' => 'name',
                'required' => true
            ])

            @include('admin.components.input', [
                'label' => 'Slug',
                'name' => 'slug'
            ])

            @include('admin.components.input', [
                'label' => 'Ảnh (URL)',
                'name' => 'image'
            ])
            @include('admin.components.input', [
                'label' => 'Ảnh SEO',
                'name' => 'imgseo'
            ])

            @include('admin.components.input', [
                'label' => 'Link game (URL/iframe)',
                'name' => 'link'
            ])

            @include('admin.components.input', [
                'label' => 'Video ngắn (URL)',
                'name' => 'video_short'
            ])

            @include('admin.components.input', [
                'label' => 'Tags (phân cách bởi dấu ,)',
                'name' => 'tags'
            ])

            <!-- select category -->
            <div class="col-md-6 mb-3">
                <label>Thể loại</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Chọn thể loại --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- description -->
            <div class="col-md-12 mb-3">
                <label>Mô tả</label>
                <textarea name="description" rows="5" class="form-control"></textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-success mt-3">Lưu Game</button>
    </form>
</div>
<script>
function slugify(str) {
    return str
        .toLowerCase()
        .trim()
        .normalize('NFD')               // bỏ dấu tiếng Việt
        .replace(/[\u0300-\u036f]/g, '') // xoá dấu
        .replace(/[^a-z0-9\s-]/g, '')   // xoá ký tự đặc biệt
        .replace(/\s+/g, '-')           // khoảng trắng -> dấu -
        .replace(/-+/g, '-');           // xoá bớt --- thành -
}

// Auto tạo slug khi gõ tên
document.addEventListener("DOMContentLoaded", function () {
    let nameInput = document.querySelector('input[name="name"]');
    let slugInput = document.querySelector('input[name="slug"]');

    if (nameInput && slugInput) {
        nameInput.addEventListener("input", function () {
            // Chỉ auto điền nếu slug đang trống hoặc slug đang autofill
            if (slugInput.value === "" || slugInput.dataset.auto === "true") {
                slugInput.value = slugify(nameInput.value);
                slugInput.dataset.auto = "true";
            }
        });

        // Nếu user sửa slug bằng tay → tắt auto-fill
        slugInput.addEventListener("input", function () {
            slugInput.dataset.auto = "false";
        });
    }
});
</script>

@endsection
