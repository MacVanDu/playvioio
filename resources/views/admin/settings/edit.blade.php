@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper p-4" style="background:#0f172a;min-height:100vh;">
    <div class="card p-4 shadow-lg" style="background:#1e293b;border:none;border-radius:16px;max-width:600px;margin:auto;">
        <h3 class="text-white fw-bold mb-3"><i class="fas fa-edit me-2"></i>Chỉnh sửa cấu hình</h3>

        <form method="POST" action="{{ route('admin.settings.update', $setting) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label text-white">Key</label>
                <input type="text" value="{{ $setting->key }}" class="form-control bg-dark text-white border-0" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Giá trị</label>
                <input type="text" name="value" value="{{ $setting->value }}" class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Chú thích</label>
                <textarea name="note" class="form-control bg-dark text-white border-0">{{ $setting->note }}</textarea>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-gradient"><i class="fas fa-save"></i> Cập nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection
