@extends('admin.layouts.master')

@section('title', 'Danh sách Thể loại')

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b; border-radius:12px;">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="fw-bold text-white mb-0">
                <i class="fas fa-layer-group me-2"></i>Danh sách thể loại
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-gradient">
                <i class="fas fa-plus"></i> Thêm thể loại
            </a>
        </div>

        <!-- Thông báo -->
        @if(session('success'))
            <div class="alert alert-success text-center fw-semibold py-2">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bảng -->
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                        <th>ID</th>
                        <th>Tên thể loại</th>
                        <th class="d-none d-md-table-cell">Slug</th>
                        <th class="d-none d-md-table-cell text-center">Ảnh SVG</th>
                        <th class="d-none d-lg-table-cell">Mô tả ngắn</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $item)
                        <tr style="background:#1e293b; border-bottom:1px solid #273449;">
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td class="fw-semibold text-white">
                                {{ $item->name }}
                            </td>
                            <td class="d-none d-md-table-cell text-secondary small">{{ $item->slug }}</td>
                            <td class="d-none d-md-table-cell text-center">
                                <img src="{{ $item->imgCategory() }}" alt="icon" width="32" height="32"
                                     style="object-fit:contain;" />
                            </td>
                            <td class="d-none d-lg-table-cell text-secondary small">
                                {{ Str::limit($item->mo_ta_ngan, 60) }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <!-- Xem -->
                                    <a href="{{ $item->slugk() }}" target="_blank"
                                       class="btn-action view" title="Xem trên web">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Sửa -->
                                    <a href="{{ route('admin.categories.edit', $item) }}" 
                                       class="btn-action edit" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- Xoá -->
                                    <form method="POST" 
                                          action="{{ route('admin.categories.destroy', $item) }}" 
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Xoá"
                                            onclick="return confirm('Bạn có chắc muốn xoá thể loại này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Không có thể loại nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        @if ($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-secondary">
                    {{ __('Hiển thị :from–:to / :total thể loại', [
                        'from' => $categories->firstItem(),
                        'to' => $categories->lastItem(),
                        'total' => $categories->total()
                    ]) }}
                </small>
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
