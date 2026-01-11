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

            <!-- Title SEO -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Title (SEO) <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="form-control bg-dark text-white border-0 @error('title') is-invalid @enderror"
                       placeholder="Nhập title SEO"
                       required>
                @error('title')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description SEO -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Description (SEO) <span class="text-danger">*</span>
                </label>
                <textarea name="description_seo"
                          rows="3"
                          class="form-control bg-dark text-white border-0 @error('description_seo') is-invalid @enderror"
                          placeholder="Meta description (150–160 ký tự)"
                          required>{{ old('description_seo') }}</textarea>
                @error('description_seo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Mô tả chi tiết <span class="text-danger">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="8"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Upload ảnh -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Upload ảnh (SVG / PNG / JPG)
                </label>
                <input type="file"
                       id="imagesvg"
                       name="imagesvg"
                       accept=".svg,.png,.jpg,.jpeg"
                       class="form-control bg-dark text-white border-0 @error('imagesvg') is-invalid @enderror">
                @error('imagesvg')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preview ảnh -->
            <div id="imagePreview" class="mb-3 d-none">
                <label class="form-label text-white">Xem trước ảnh</label><br>
                <img id="previewImg"
                     width="120"
                     height="120"
                     style="object-fit:contain;
                            background:#020617;
                            padding:8px;
                            border-radius:8px;
                            border:1px solid #334155;">
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

{{-- ================= SCRIPT ================= --}}

<script>
/* Auto slug */
let slugTouched = false;

const nameInput = document.querySelector('input[name="name"]');
const slugInput = document.querySelector('input[name="slug"]');

slugInput.addEventListener('input', () => slugTouched = true);

nameInput.addEventListener('input', function () {
    if (slugTouched) return;

    slugInput.value = this.value
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
});

/* Preview ảnh */
document.getElementById('imagesvg').addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;

    const file = this.files[0];

    if (!file.type.startsWith('image/')) {
        alert('Vui lòng chọn file ảnh hợp lệ');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});
</script>

{{-- ================= TinyMCE 6 – FREE ================= --}}
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
@endsection
