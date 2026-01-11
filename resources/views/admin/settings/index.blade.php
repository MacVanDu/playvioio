@extends('admin.layouts.master')

@section('title', 'Cấu hình hệ thống')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a;min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b;border-radius:16px;">
        
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="text-white fw-bold mb-0">
                <i class="fas fa-sliders-h me-2"></i>Cấu hình hệ thống
            </h2>
            <a href="{{ route('admin.settings.create') }}" class="btn btn-gradient">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                    <tr>
                        <th>Key</th>
                        <th>Giá trị</th>
                        <th class="d-none d-sm-table-cell">Chú thích</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr style="background:#1e293b; border-bottom:1px solid #273449;">
                            
                            <!-- KEY -->
                            <td>
                                <code class="text-info">{{ $setting->key }}</code>
                            </td>

                            <!-- VALUE -->
                            <td class="text-white small">
                                @if($setting->type == 2 && $setting->value)
                                    {{-- IMAGE --}}
                                        <img 
                                            src="{{ $setting->value }}"
                                            alt="{{ $setting->key }}"
                                            style="max-height:60px;max-width:120px;border-radius:8px;object-fit:cover;"
                                        >
                                @else
                                    {{-- TEXT --}}
                                    {{ Str::limit($setting->value, 50) ?: '—' }}
                                @endif
                            </td>

                            <!-- NOTE -->
                            <td class="d-none d-sm-table-cell text-muted small">
                                {{ Str::limit($setting->note, 60) ?: '—' }}
                            </td>

                            <!-- ACTION -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('admin.settings.edit', $setting) }}" 
                                       class="btn-action edit" title="Sửa cấu hình">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.settings.destroy', $setting) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Xóa cấu hình này?')" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Xóa cấu hình">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Chưa có cấu hình nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-secondary">
                {{ __('Hiển thị :from–:to / :total cấu hình', [
                    'from' => $settings->firstItem(),
                    'to' => $settings->lastItem(),
                    'total' => $settings->total()
                ]) }}
            </small>
            {{ $settings->onEachSide(1)->links('pagination::bootstrap-5') }}
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

.btn-action.edit {
    background: linear-gradient(135deg,#6366f1,#22d3ee);
}

.btn-action.delete {
    background: linear-gradient(135deg,#f43f5e,#dc2626);
}

tr:hover {
    background: #273449 !important;
}

.btn-gradient {
    background: linear-gradient(90deg,#6366f1,#22d3ee);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.25s ease;
}

.btn-gradient:hover {
    background: linear-gradient(90deg,#4f46e5,#0ea5e9);
    transform: translateY(-2px);
}
</style>
@endsection
