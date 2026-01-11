@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper p-4" style="background:#0f172a;min-height:100vh;">
    <div class="card p-4 shadow-lg"
         style="background:#1e293b;border:none;border-radius:16px;max-width:600px;margin:auto;">

        <h3 class="text-white fw-bold mb-3">
            <i class="fas fa-plus-circle me-2"></i>Thêm cấu hình mới
        </h3>

        <form method="POST"
              action="{{ route('admin.settings.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- KEY --}}
            <div class="mb-3">
                <label class="form-label text-white">Key</label>
                <input type="text"
                       name="key"
                       class="form-control bg-dark text-white border-0"
                       placeholder="VD: site-logo"
                       required>
            </div>

            {{-- TYPE --}}
            <div class="mb-3">
                <label class="form-label text-white">Loại</label>
                <select name="type"
                        id="setting-type"
                        class="form-select bg-dark text-white border-0">
                    <option value="1">Text</option>
                    <option value="2">Upload file</option>
                </select>
            </div>

            {{-- VALUE TEXT --}}
            <div class="mb-3" id="value-text">
                <label class="form-label text-white">Giá trị</label>
                <textarea name="value"
                          class="form-control bg-dark text-white border-0"
                          style="min-height:200px"
                          placeholder="VD: 3"></textarea>
            </div>

            {{-- VALUE FILE --}}
            <div class="mb-3 d-none" id="value-file">
                <label class="form-label text-white">Upload file</label>
                <input type="file"
                       name="file"
                       id="file-input"
                       accept="image/*"
                       class="form-control bg-dark text-white border-0">

                {{-- PREVIEW --}}
                <div id="image-preview" class="mt-3 d-none">
                    <label class="form-label text-white">Xem trước</label>
                    <div style="background:#020617;padding:12px;border-radius:12px;">
                        <img id="preview-img"
                             src=""
                             alt="Preview"
                             style="max-height:180px;max-width:100%;border-radius:8px;object-fit:contain;">
                    </div>
                </div>
            </div>

            {{-- NOTE --}}
            <div class="mb-3">
                <label class="form-label text-white">Chú thích</label>
                <textarea name="note"
                          class="form-control bg-dark text-white border-0"
                          placeholder="VD: Logo website"></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.settings.index') }}"
                   class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const typeSelect = document.getElementById('setting-type');
const valueText  = document.getElementById('value-text');
const valueFile  = document.getElementById('value-file');
const fileInput  = document.getElementById('file-input');
const previewBox = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');

// Toggle input theo type
typeSelect.addEventListener('change', function () {
    const isFile = this.value === '2';

    valueText.classList.toggle('d-none', isFile);
    valueFile.classList.toggle('d-none', !isFile);

    if (!isFile) {
        previewBox.classList.add('d-none');
        previewImg.src = '';
        fileInput.value = '';
    }
});

// Preview ảnh
fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file || !file.type.startsWith('image/')) {
        previewBox.classList.add('d-none');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewBox.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
