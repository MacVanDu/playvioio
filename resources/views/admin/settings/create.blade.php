@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper p-4" style="background:#0f172a;min-height:100vh;">
    <div class="card p-4 shadow-lg" style="background:#1e293b;border:none;border-radius:16px;max-width:600px;margin:auto;">
        <h3 class="text-white fw-bold mb-3"><i class="fas fa-plus-circle me-2"></i>Thêm cấu hình mới</h3>

        <form method="POST" action="{{ route('admin.settings.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label text-white">Key</label>
                <input type="text" name="key" class="form-control bg-dark text-white border-0" placeholder="VD: num-game" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Giá trị</label>
                <textarea type="text" name="value" class="form-control bg-dark text-white border-0" placeholder="VD: 3"  style="min-height: 200px;"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Chú thích</label>
                <textarea name="note" class="form-control bg-dark text-white border-0" placeholder="VD: Số lượng game hiển thị trên trang chủ"></textarea>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-gradient"><i class="fas fa-save"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection
