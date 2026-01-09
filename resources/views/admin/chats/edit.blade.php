@extends('admin.layouts.master')

@section('content')
<div class="container mt-4 text-white">
    <h2 class="fw-bold mb-4">Sửa Game</h2>

    <form method="POST"
          action="{{ route('admin.games.update', $game) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <!-- NAME -->
            <div class="col-md-6 mb-3">
                <label>Tên Game</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $game->name) }}"
                    required
                >
            </div>

            <!-- SLUG -->
            <div class="col-md-6 mb-3">
                <label>Slug</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $game->slug }}"
                    disabled
                >
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="col-md-6 mb-3">
                <label>Ảnh hiện tại</label><br>
                @if($game->image)
                    <img src="{{ $game->image }}"
                         style="max-width:200px;border-radius:8px;margin-bottom:10px">
                @else
                    <div class="text-muted">Chưa có ảnh</div>
                @endif
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="col-md-6 mb-3">
                <label>Đổi ảnh (upload)</label>
                <input
                    type="file"
                    name="image_file"
                    class="form-control"
                    accept="image/*"
                >
                <small class="text-muted">
                    Giữ nguyên tên file gốc. Nếu không chọn → giữ ảnh cũ.
                </small>
            </div>

            <!-- LINK -->
            <div class="col-md-6 mb-3">
                <label>Link Game</label>
                <input
                    type="text"
                    name="link"
                    class="form-control"
                    value="{{ old('link', $game->link) }}"
                >
            </div>

            <!-- FLAGS -->
            <div class="col-md-6 mb-3">
                <label>Trend</label>
                <label class="switch">
                    <input type="hidden" name="trend" value="0">
                    <input type="checkbox" name="trend" value="1"
                        {{ old('trend', $game->trend ?? 0) == 1 ? 'checked' : '' }}>
                </label>

                <label class="ms-4">Mobile</label>
                <label class="switch">
                    <input type="hidden" name="mobile" value="0">
                    <input type="checkbox" name="mobile" value="1"
                        {{ old('mobile', $game->mobile ?? 0) == 1 ? 'checked' : '' }}>
                </label>
            </div>

            <!-- CATEGORY -->
            <div class="col-md-6 mb-3">
                <label>Thể loại</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Chọn thể loại --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $game->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- DESCRIPTION -->
            <div class="col-12 mb-3">
                <label>Mô tả</label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    class="form-control"
                >{{ old('description', $game->description) }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

{{-- ================= TINYMCE ================= --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#description',
    height: 420,
    menubar: true,
    plugins: [
        'advlist autolink lists link image charmap preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table help wordcount'
    ],
    toolbar:
        'undo redo | bold italic underline | ' +
        'alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | ' +
        'link image table | code fullscreen',
    branding: false,
    promotion: false
});
</script>

<style>
body { background-color: #0f172a !important; }
.container {
    background-color: #1e293b;
    border-radius: 12px;
    padding: 30px;
}
label { color: #cbd5e1; }
.form-control, .form-select {
    background:#f8fafc !important;
}
</style>
@endsection
