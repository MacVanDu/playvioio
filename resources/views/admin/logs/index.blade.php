@extends('admin.layouts.master')

@section('title', 'Danh sách File Log')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a;min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b;border-radius:16px;">
        
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="text-white fw-bold mb-0">
                <i class="fas fa-file-alt me-2"></i>Danh sách File Log
            </h2>
        </div>

        <!-- Bảng logs -->
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                    <tr>
                        <th>Tên file</th>
                        <th class="d-none d-sm-table-cell">Kích thước</th>
                        <th class="d-none d-sm-table-cell">Cập nhật</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($files as $file)
                        <tr style="background:#1e293b; border-bottom:1px solid #273449;">
                            <td class="text-white fw-semibold">{{ $file['name'] }}</td>
                            <td class="d-none d-sm-table-cell text-secondary small">{{ $file['size'] }}</td>
                            <td class="d-none d-sm-table-cell text-muted small">{{ $file['last_modified'] }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <!-- Xem -->
                                    <a href="{{ route('admin.logs.show', $file['name']) }}" class="btn-action view" title="Xem nội dung">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Tải -->
                                    <a href="{{ route('admin.logs.download', $file['name']) }}" class="btn-action edit" title="Tải xuống">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <!-- Xóa nội dung -->
                                    <form action="{{ route('admin.logs.clear', $file['name']) }}" method="POST" onsubmit="return confirm('Xóa nội dung file?')" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action warning" title="Xóa nội dung">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </form>
                                    <!-- Xóa file -->
                                    <form action="{{ route('admin.logs.destroy', $file['name']) }}" method="POST" onsubmit="return confirm('Xóa file này?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Xóa file">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Không có file log nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    background: #334155;
    color: #f1f5f9;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.btn-action.view {
    background: linear-gradient(135deg,#22d3ee,#06b6d4);
}

.btn-action.edit {
    background: linear-gradient(135deg,#6366f1,#3b82f6);
}

.btn-action.warning {
    background: linear-gradient(135deg,#facc15,#eab308);
    color: #0f172a;
}

.btn-action.delete {
    background: linear-gradient(135deg,#f43f5e,#dc2626);
}

tr:hover {
    background: #273449 !important;
}
</style>
@endsection
