@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper p-4"
        style="margin:0; padding:20px 40px; background:linear-gradient(180deg,#0f172a 0%,#111827 100%); min-height:100vh;">

        <div class="card p-4 shadow-lg"
            style="background: linear-gradient(180deg,#111827 0%,#1e293b 100%); border: none; border-radius: 16px; width:100%; max-width:700px; margin:auto;">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white mb-0"><i class="fas fa-plus-circle me-2"></i>Thêm Command Mới</h2>
                <a href="{{ route('admin.scheduled-commands.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle me-2"></i>Lỗi:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.scheduled-commands.store') }}" method="POST" class="text-light">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên Command <span class="text-danger">*</span></label>
                    <input type="text" name="command" class="form-control bg-dark text-white border-0 shadow-sm"
                        placeholder="VD: sitemap:generate" required
                        style="border-radius:8px; background:#1e293b; color:#f8fafc;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kiểu chạy</label>
                    <select name="expression" class="form-select bg-dark text-white border-0 shadow-sm"
                        style="border-radius:8px; background:#1e293b;">
                        <option value="daily">Chạy hằng ngày</option>
                        <option value="hourly">Chạy mỗi giờ</option>
                        <option value="* * * * *">Tùy chỉnh (cron)</option>
                    </select>
                    <small class="text-muted">Nhập biểu thức cron đầy đủ nếu muốn (VD: <code>0 2 * * *</code>)</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Giờ chạy (HH:MM)</label>
                    <input type="text" name="time" class="form-control bg-dark text-white border-0 shadow-sm"
                        placeholder="02:00" style="border-radius:8px; background:#1e293b; color:#f8fafc;">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="enabled" class="form-select bg-dark text-white border-0 shadow-sm"
                        style="border-radius:8px; background:#1e293b;">
                        <option value="1" selected>Bật</option>
                        <option value="0">Tắt</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-white">Ghi chú / Mô tả (tuỳ chọn)</label>
                    <textarea name="note" rows="2" class="form-control bg-dark text-white border-0 shadow-sm"
                        placeholder="VD: Lệnh này dùng để tự động reset usage key hằng ngày..."
                        style="border-radius:8px; background:#1e293b; color:#f8fafc;">{{ old('note') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.scheduled-commands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times-circle"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-gradient">
                        <i class="fas fa-save"></i> Lưu Command
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .btn-gradient {
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            transform: translateY(-1px);
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }
    </style>
@endsection