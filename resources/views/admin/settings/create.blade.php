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
                       class="form-control bg-dark text-white border-0">
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
document.getElementById('setting-type').addEventListener('change', function () {
    const isFile = this.value === '2';
    document.getElementById('value-text').classList.toggle('d-none', isFile);
    document.getElementById('value-file').classList.toggle('d-none', !isFile);
});
</script>
@endsection
