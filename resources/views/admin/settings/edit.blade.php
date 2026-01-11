@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper p-4" style="background:#0f172a;min-height:100vh;">
    <div class="card p-4 shadow-lg"
         style="background:#1e293b;border:none;border-radius:16px;max-width:600px;margin:auto;">

        <h3 class="text-white fw-bold mb-3">
            <i class="fas fa-edit me-2"></i>Chỉnh sửa cấu hình
        </h3>

        <form method="POST"
              action="{{ route('admin.settings.update', $setting) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- KEY --}}
            <div class="mb-3">
                <label class="form-label text-white">Key</label>
                <input type="text"
                       value="{{ $setting->key }}"
                       class="form-control bg-dark text-white border-0"
                       disabled>
            </div>

            {{-- VALUE --}}
            <div class="mb-3">
                <label class="form-label text-white">Giá trị</label>

                @if((int)$setting->type === 2)
                    {{-- IMAGE --}}
                    <div class="mb-2">
                        <small class="text-secondary">Ảnh hiện tại</small>
                        <div style="background:#020617;padding:12px;border-radius:12px;">
                            <img src="{{ asset($setting->value) }}"
                                 alt="Current image"
                                 style="max-height:160px;max-width:100%;border-radius:8px;object-fit:contain;">
                        </div>
                    </div>

                    {{-- UPLOAD NEW --}}
                    <input type="file"
                           name="file"
                           id="file-input"
                           accept="image/*"
                           class="form-control bg-dark text-white border-0">

                    {{-- PREVIEW --}}
                    <div id="image-preview" class="mt-3 d-none">
                        <small class="text-secondary">Ảnh mới</small>
                        <div style="background:#020617;padding:12px;border-radius:12px;">
                            <img id="preview-img"
                                 src=""
                                 style="max-height:160px;max-width:100%;border-radius:8px;object-fit:contain;">
                        </div>
                    </div>
                @else
                    {{-- TEXT --}}
                    <textarea name="value"
                              class="form-control bg-dark text-white border-0"
                              style="min-height:200px">{{ $setting->value }}</textarea>
                @endif
            </div>

            {{-- NOTE --}}
            <div class="mb-3">
                <label class="form-label text-white">Chú thích</label>
                <textarea name="note"
                          class="form-control bg-dark text-white border-0">{{ $setting->note }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.settings.index') }}"
                   class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const fileInput  = document.getElementById('file-input');
const previewBox = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');

if (fileInput) {
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file || !file.type.startsWith('image/')) {
            previewBox.classList.add('d-none');
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewBox.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
