@extends('admin.layouts.master')

@section('title', 'Quản lý Command Scheduler')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b; border-radius:16px;">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="fw-bold text-white mb-0">
                <i class="fas fa-terminal me-2"></i>Quản lý Command Scheduler
            </h2>
            <a href="{{ route('admin.scheduled-commands.create') }}" class="btn btn-gradient">
                <i class="fas fa-plus-circle"></i> Thêm Command
            </a>
        </div>

        <!-- Flash message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Bảng danh sách -->
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                    <tr>
                        <th>ID</th>
                        <th>Tên Command</th>
                        <th class="d-none d-sm-table-cell">Kiểu chạy</th>
                        <th class="d-none d-md-table-cell">Giờ chạy</th>
                        <th>Trạng thái</th>
                        <th class="d-none d-md-table-cell">Ghi chú</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commands as $cmd)
                        <tr style="background:#1e293b; border-bottom:1px solid #273449;">
                            <td class="text-muted small">{{ $cmd->id }}</td>
                            <td>
                                <div class="fw-bold text-white">
                                    <i class="fas fa-code me-1 text-info"></i>{{ $cmd->command }}
                                </div>
                                <div class="text-muted small">{{ $cmd->created_at->format('d/m/Y H:i') }}</div>
                            </td>

                            <td class="d-none d-sm-table-cell">
                                <span class="badge bg-primary">{{ $cmd->expression }}</span>
                            </td>

                            <td class="d-none d-md-table-cell text-info fw-semibold">
                                {{ $cmd->time ?? '—' }}
                            </td>

                            <td>
                                @if($cmd->enabled)
                                    <span class="badge bg-success">Đang bật</span>
                                @else
                                    <span class="badge bg-secondary">Tạm tắt</span>
                                @endif
                            </td>

                            <td class="d-none d-md-table-cell text-muted small">
                                {{ $cmd->note ?: '—' }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    <!-- Sửa -->
                                    <a href="{{ route('admin.scheduled-commands.edit', $cmd) }}" 
                                       class="btn-action edit" title="Sửa giờ chạy">
                                        <i class="fas fa-clock"></i>
                                    </a>

                                    <!-- Bật / Tắt -->
                                    <form action="{{ route('admin.scheduled-commands.update', $cmd) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="time" value="{{ $cmd->time }}">
                                        <input type="hidden" name="enabled" value="{{ $cmd->enabled ? 0 : 1 }}">
                                        <button type="submit" 
                                                class="btn-action {{ $cmd->enabled ? 'disable' : 'enable' }}"
                                                title="{{ $cmd->enabled ? 'Tắt Command' : 'Bật Command' }}">
                                            <i class="fas {{ $cmd->enabled ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Xóa -->
                                    <form action="{{ route('admin.scheduled-commands.destroy', $cmd) }}" method="POST"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa command này không?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Xóa Command">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không có command nào được cấu hình.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-secondary">
                {{ __('Hiển thị :from–:to / :total command', [
                    'from' => $commands->firstItem(),
                    'to' => $commands->lastItem(),
                    'total' => $commands->total()
                ]) }}
            </small>
            {{ $commands->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
