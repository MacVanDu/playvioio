@extends('admin.layouts.master')

@section('title', 'Sửa thể loại')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4"
         style="background:#1e293b; border-radius:12px; max-width:800px; margin:auto;">

        <!-- Tiêu đề -->
        <h2 class="fw-bold text-white mb-4">
            <i class="fas fa-edit me-2"></i>Sửa thể loại
        </h2>

        <!-- Form -->
        <form method="POST"
              action="{{ route('admin.categories.update', $category) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tên -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Tên thể loại <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       class="form-control bg-dark text-white border-0 @error('name') is-invalid @enderror"
                       required>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Slug (tự sinh, không thể sửa)
                </label>
                <input type="text"
                       value="{{ $category->slug }}"
                       class="form-control bg-dark text-muted border-0"
                       readonly>
                <small class="text-secondary">
                    Slug được tạo từ tên thể loại
                </small>
            </div>

            <!-- Title SEO -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Title (SEO) <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $category->title) }}"
                       class="form-control bg-dark text-white border-0 @error('title') is-invalid @enderror"
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
                          required>{{ old('description_seo', $category->description_seo) }}</textarea>
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
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ảnh thể loại -->
            <div class="mb-3">
                <label class="form-label text-white">
                    Ảnh thể loại (SVG / PNG / JPG)
                </label>

                <!-- Upload ảnh mới -->
                <input type="file"
                       id="imageFile"
                       name="image"
                       accept=".svg,.png,.jpg,.jpeg"
                       class="form-control bg-dark text-white border-0 @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <!-- Preview -->
                <div class="mt-3 d-flex align-items-center gap-4">

                    {{-- Ảnh hiện tại --}}
                    @if($category->imagesvg)
                        <div id="oldImage">
                            <small class="text-secondary d-block mb-1">
                                Ảnh hiện tại
                            </small>
                            <img src="{{ asset($category->imagesvg) }}"
                                 width="90"
                                 height="90"
                                 style="object-fit:contain;
                                        background:#020617;
                                        padding:6px;
                                        border-radius:6px;
                                        border:1px solid #334155;">
                        </div>
                    @endif

                    {{-- Ảnh mới --}}
                    <div id="newImagePreview" class="d-none">
                        <small class="text-success d-block mb-1">
                            Ảnh mới
                        </small>
                        <img id="previewImg"
                             width="90"
                             height="90"
                             style="object-fit:contain;
                                    background:#020617;
                                    padding:6px;
                                    border-radius:6px;
                                    border:1px solid #22c55e;">
                    </div>

                </div>

                <small class="text-secondary">
                    Chỉ chọn ảnh mới nếu muốn thay thế ảnh hiện tại
                </small>
            </div>

            <!-- Nút -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= PREVIEW IMAGE SCRIPT ================= --}}
<script>
document.getElementById('imageFile').addEventListener('change', function () {
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
        document.getElementById('newImagePreview').classList.remove('d-none');

        const oldImage = document.getElementById('oldImage');
        if (oldImage) oldImage.style.opacity = '0.3';
    };
    reader.readAsDataURL(file);
});
</script>

{{-- ================= TINYMCE 6 – FREE ================= --}}
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
