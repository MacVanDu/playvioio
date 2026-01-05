@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper p-4"
        style="margin:0; padding:20px 40px; background:linear-gradient(180deg,#0f172a 0%,#111827 100%); min-height:100vh;">

        <div class="card p-4 shadow-lg"
            style="background: linear-gradient(180deg,#111827 0%,#1e293b 100%); border: none; border-radius: 16px; width:100%; max-width:700px; margin:auto;">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white mb-0">
                    <i class="fas fa-clock me-2"></i>Chỉnh sửa giờ chạy
                </h2>
                <a href="{{ route('admin.scheduled-commands.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            {{-- Hiển thị lỗi --}}
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

            <form action="{{ route('admin.scheduled-commands.update', $scheduledCommand) }}" method="POST"
                class="text-light">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-white">Command:</label>
                    <input type="text" class="form-control bg-dark text-white border-0 shadow-sm"
                        value="{{ $scheduledCommand->command }}" disabled
                        style="border-radius:8px; background:#1e293b; color:#f8fafc;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-white">Giờ chạy (HH:MM):</label>
                    <input type="text" name="time" class="form-control bg-dark text-white border-0 shadow-sm"
                        value="{{ $scheduledCommand->time }}" placeholder="VD: 02:00"
                        style="border-radius:8px; background:#1e293b; color:#f8fafc;">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-white">Trạng thái:</label>
                    <select name="enabled" class="form-select bg-dark text-white border-0 shadow-sm"
                        style="border-radius:8px; background:#1e293b;">
                        <option value="1" {{ $scheduledCommand->enabled ? 'selected' : '' }}>Bật</option>
                        <option value="0" {{ !$scheduledCommand->enabled ? 'selected' : '' }}>Tắt</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold text-white">Ghi chú / Mô tả</label>
                    <textarea name="note" rows="2" class="form-control bg-dark text-white border-0 shadow-sm"
                        style="border-radius:8px; background:#1e293b; color:#f8fafc;">{{ $scheduledCommand->note }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.scheduled-commands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times-circle"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-gradient">
                        <i class="fas fa-save"></i> Lưu thay đổi
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