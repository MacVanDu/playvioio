@extends('admin.layouts.master')

@section('content')
<div class="container mt-4 text-white">
    <h2>Thêm Game mới</h2>

    <form method="POST"
          action="{{ route('admin.games.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row">

            @include('admin.components.input', [
                'label' => 'Tên Game',
                'name' => 'name',
                'required' => true,
                'value' => old('name'),
            ])

            @include('admin.components.input', [
                'label' => 'Slug',
                'name' => 'slug',
                'value' => old('slug'),
            ])

            @include('admin.components.input', [
                'label' => 'Title',
                'name' => 'title',
                'value' => old('title'),
            ])

            @include('admin.components.input', [
                'label' => 'Description',
                'name' => 'description_seo',
                'value' => old('description_seo'),
            ])

            @include('admin.components.input', [
                'label' => 'Link game (URL / iframe)',
                'name' => 'link',
                'value' => old('link'),
            ])

            {{-- Trend / Mobile --}}
            <div class="col-md-6 mb-3">
                <label>Trend</label>
                <label class="switch">
                    <input type="hidden" name="trend" value="0">
                    <input type="checkbox" name="trend" value="1"
                        {{ old('trend', 0) == 1 ? 'checked' : '' }}>
                </label>

                <label class="ms-3">Mobile</label>
                <label class="switch">
                    <input type="hidden" name="mobile" value="0">
                    <input type="checkbox" name="mobile" value="1"
                        {{ old('mobile', 0) == 1 ? 'checked' : '' }}>
                </label>
            </div>

            {{-- Upload ảnh --}}
            <div class="col-md-6 mb-3">
                <label class="form-label text-white">
                    Upload ảnh (SVG / PNG / JPG)
                </label>
                <input type="file"
                       id="image_file"
                       name="image_file"
                       accept=".svg,.png,.jpg,.jpeg"
                       class="form-control bg-dark text-white border-0 @error('image_file') is-invalid @enderror">
                @error('image_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Preview ảnh (ẨN BAN ĐẦU) --}}
            <div class="col-md-6 mb-3 d-none" id="imagePreview">
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

            {{-- Thể loại --}}
            <div class="col-md-6 mb-3">
                <label>Thể loại</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Chọn thể loại --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Description --}}
            <div class="col-md-12 mb-3">
                <label>Mô tả</label>
                <textarea id="description"
                          name="description"
                          rows="8"
                          class="form-control">{{ old('description') }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-success mt-3">
            Lưu Game
        </button>
    </form>
</div>

{{-- ================= AUTO SLUG (GIỮ 1 ĐOẠN DUY NHẤT) ================= --}}
<script>
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
</script>

{{-- ================= PREVIEW ẢNH ================= --}}
<script>
document.getElementById('image_file').addEventListener('change', function () {
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
    promotion: false
});
</script>
@endsection
