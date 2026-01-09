@extends('admin.layouts.master')

@section('title', 'Thêm thể loại mới')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4"
         style="background:#1e293b; border-radius:12px; max-width:800px; margin:auto;">

        <!-- Tiêu đề -->
        <h2 class="fw-bold text-white mb-4">
            <i class="fas fa-plus-circle me-2"></i>Thêm thể loại mới
        </h2>

        <!-- Form -->
        <form method="POST"
              action="{{ route('admin.categories.store') }}"
              enctype="multipart/form-data">
            @csrf

            <!-- Tên -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Tên thể loại <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-control bg-dark text-white border-0 @error('name') is-invalid @enderror"
                       placeholder="Nhập tên thể loại"
                       required>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-3">
                <label class="form-label text-white">Slug (tuỳ chọn)</label>
                <input type="text"
                       name="slug"
                       value="{{ old('slug') }}"
                       class="form-control bg-dark text-white border-0 @error('slug') is-invalid @enderror"
                       placeholder="vi-du-the-loai">
                @error('slug')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Upload ảnh -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Upload ảnh (SVG / PNG / JPG)
                </label>
                <input type="file"
                       name="imagesvg_file"
                       accept=".svg,.png,.jpg,.jpeg"
                       class="form-control bg-dark text-white border-0 @error('imagesvg_file') is-invalid @enderror">
                @error('imagesvg_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Hoặc nhập link -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Hoặc nhập link ảnh
                </label>
                <input type="text"
                       name="imagesvg_link"
                       value="{{ old('imagesvg_link') }}"
                       class="form-control bg-dark text-white border-0 @error('imagesvg_link') is-invalid @enderror"
                       placeholder="https://example.com/icon.svg">
                @error('imagesvg_link')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preview -->
            <div id="imagePreview" class="mb-3" style="display:none;">
                <label class="form-label text-white">Xem trước</label><br>
                <img id="previewImg" src="" width="80" height="80"
                     style="object-fit:contain; background:#020617; padding:8px; border-radius:8px;">
            </div>

            <!-- Nút -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Script -->
<script>
/* Auto slug */
let slugTouched = false;

document.querySelector('input[name="slug"]').addEventListener('input', () => {
    slugTouched = true;
});

document.querySelector('input[name="name"]').addEventListener('input', function () {
    if (slugTouched) return;

    document.querySelector('input[name="slug"]').value = this.value
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
});

/* Preview link */
document.querySelector('input[name="imagesvg_link"]').addEventListener('input', function () {
    if (!this.value) return;
    document.getElementById('previewImg').src = this.value;
    document.getElementById('imagePreview').style.display = 'block';
});

/* Preview file */
document.querySelector('input[name="imagesvg_file"]').addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
    };
    reader.readAsDataURL(this.files[0]);
});
</script>
@endsection
