@extends('admin.layouts.master')

@section('content')
<div class="container mt-4 text-white">
    <h2 class="fw-bold mb-4">Sửa Game</h2>

    <form method="POST" action="{{ route('admin.games.update', $game) }}">
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

            <!-- SLUG (không cho sửa) -->
            <div class="col-md-6 mb-3">
                <label>Slug</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $game->slug }}"
                    disabled
                >
            </div>

            <!-- IMAGE -->
            <div class="col-md-6 mb-3">
                <label>Ảnh (URL)</label>
                <input
                    type="text"
                    name="image"
                    class="form-control"
                    value="{{ old('image', $game->image) }}"
                >
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

                <div class="col-md-6 mb-3">
                    <label>Trend</label>
                    <label class='switch'>
                        <input type="hidden" name="trend" value="0">
                        <input type="checkbox" name="trend" value="1"
                            {{ old('trend', $game->trend ?? 0) == 1 ? 'checked' : '' }}>
                    </label>
                    <label>mobile</label>
                    <label class='switch'>
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

            <!-- DESCRIPTION (TinyMCE) -->
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

{{-- ================= TINYMCE 6 – FREE (NO API KEY) ================= --}}
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
    promotion: false,
    content_style: `
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    `
});
</script>

<style>
body { background-color: #0f172a !important; }
.container {
    background-color: #1e293b;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 25px rgba(0,0,0,0.3);
}
label { color: #cbd5e1; font-weight: 500; }
.form-control, .form-select, textarea {
    background-color: #f8fafc !important;
    border: 1px solid #94a3b8 !important;
    color: #0f172a !important;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 15px;
    transition: all 0.2s ease;
}
.form-control:focus, .form-select:focus, textarea:focus {
    background-color: #ffffff !important;
    border-color: #6366f1 !important;
    box-shadow: 0 0 10px rgba(99,102,241,0.4) !important;
}
.btn-success {
    background: linear-gradient(90deg, #4f46e5, #22d3ee);
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.btn-success:hover {
    background: linear-gradient(90deg, #4338ca, #0ea5e9);
    transform: translateY(-2px);
}
.btn-secondary {
    background: #475569;
    border: none;
    color: #fff;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.btn-secondary:hover {
    background: #334155;
    transform: translateY(-2px);
}
</style>
@endsection
