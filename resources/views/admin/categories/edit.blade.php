@extends('admin.layouts.master')

@section('title', 'Sửa thể loại')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b; border-radius:12px; max-width:800px; margin:auto;">

        <!-- Tiêu đề -->
        <h2 class="fw-bold text-white mb-4">
            <i class="fas fa-edit me-2"></i>Sửa thể loại
        </h2>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <!-- Tên -->
            <div class="mb-3">
                <label class="form-label text-white">Tên thể loại <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       value="{{ old('name', $category->name) }}"
                       class="form-control bg-dark text-white border-0 @error('name') is-invalid @enderror"
                       placeholder="Nhập tên thể loại" required>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug (readonly) -->
            <div class="mb-3">
                <label class="form-label text-white">Slug (tự sinh, không thể sửa)</label>
                <input type="text" name="slug"
                       value="{{ $category->slug }}"
                       class="form-control bg-dark text-muted border-0"
                       readonly>
                <small class="text-secondary">Slug được tự động tạo từ tên, không thể chỉnh sửa trực tiếp.</small>
            </div>

            <!-- Ảnh SVG -->
            <div class="mb-3">
                <label class="form-label text-white">Ảnh SVG (URL hoặc đường dẫn)</label>
                <input type="text" name="imagesvg"
                       value="{{ old('imagesvg', $category->imagesvg) }}"
                       class="form-control bg-dark text-white border-0 @error('imagesvg') is-invalid @enderror"
                       placeholder="https://example.com/icon.svg">
                @error('imagesvg')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                @if($category->imagesvg)
                    <div class="mt-2">
                        <img src="{{ $category->imagesvg }}" alt="Preview SVG" width="60" height="60">
                    </div>
                @endif
            </div>

            <!-- Nút -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
