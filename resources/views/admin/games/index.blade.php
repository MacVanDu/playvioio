@extends('admin.layouts.master')

@section('title', 'Danh sách Game')

@php
// --- HÀM SORT ---
function sortLink($column, $label) {
    $currentSort = request('sort_by');
    $currentOrder = request('sort_order', 'asc');

    // đảo chiều sort
    $newOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';

    // giữ nguyên search
    $query = array_merge(request()->query(), [
        'sort_by' => $column,
        'sort_order' => $newOrder,
    ]);

    // icon
    $icon = '';
    if ($currentSort === $column) {
        $icon = $currentOrder === 'asc' ? '▲' : '▼';
    }

    return "<a href=\"?".http_build_query($query)."\" style=\"color:#94a3b8; text-decoration:none;\">
                {$label} <span style='font-size:10px'>{$icon}</span>
            </a>";
}


// --- CONFIG COLUMNS ---
$columns = [

    [
        'label' => 'ID',
        'field' => 'id',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($g) => $g->id
    ],

    [
        'label' => 'Ảnh',
        'field' => null,
        'sortable' => false,
        'responsive' => '',
        'render' => fn($g) =>
            $g->image
                ? "<img src='{$g->image}' width='70' height='70' style='object-fit:cover;border-radius:10px;border:2px solid #334155;'>"
                : "<span class='text-muted'>—</span>"
    ],

    [
        'label' => 'Trend',
        'field' => 'trend',
        'sortable' => true,
        'responsive' => 'd-none d-lg-table-cell',
        'render' => fn($g) =>
            "<label class='switch'>
                <input type='checkbox' class='trend-toggle' data-id='{$g->id}' ".($g->trend ? 'checked' : '').">
                <span class='slider round'></span>
             </label>"
    ],
    [
        'label' => 'Mobile',
        'field' => 'mobile',
        'sortable' => true,
        'responsive' => 'd-none d-lg-table-cell',
        'render' => fn($g) =>
            "<label class='switch'>
                <input type='checkbox' class='mobile-toggle' data-id='{$g->id}' ".($g->mobile ? 'checked' : '').">
                <span class='slider round'></span>
             </label>"
    ],

    [
        'label' => 'Thông Tin',
        'field' => 'name',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($g) =>
            "<div class='fw-bold text-white'>{$g->name}</div>
             <div class='text-muted small'>{$g->slug}</div>
             <div class='small badge bg-info text-dark'>{$g->category?->name}</div>"
    ],

    [
        'label' => 'Ngày tạo',
        'field' => 'created_at',
        'sortable' => true,
        'responsive' => 'd-none d-md-table-cell',
        'render' => fn($g) => $g->created_at->format('d/m/Y')
    ],

];
@endphp

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b; border-radius:16px;">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="fw-bold text-white mb-0">
                <i class="fas fa-gamepad me-2"></i>Danh sách Game
            </h2>
            <a href="{{ route('admin.games.create') }}" class="btn btn-gradient">
                <i class="fas fa-plus-circle"></i> Thêm Game
            </a>
        </div>

        <!-- Form tìm kiếm -->
        <form method="GET" action="" class="mb-4 d-flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="🔍 Tìm theo tên hoặc slug..."
                style="max-width:300px; border-radius:8px; background:#f8fafc; color:#0f172a;">
            <button type="submit" class="btn btn-gradient">
                <i class="fas fa-search"></i> Tìm
            </button>
        </form>

        <!-- Bảng -->
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                <tr>
                    @foreach($columns as $c)
                        <th class="{{ $c['responsive'] }}">
                            @if($c['sortable'] && $c['field'])
                                {!! sortLink($c['field'], $c['label']) !!}
                            @else
                                {{ $c['label'] }}
                            @endif
                        </th>
                    @endforeach

                    <th class="text-center">Hành động</th>
                </tr>
                </thead>

                <tbody>
                @forelse($games as $game)
                    <tr style="background-color:#1e293b; border-bottom:1px solid #273449;">

                        @foreach($columns as $c)
                            <td class="{{ $c['responsive'] }}">{!! $c['render']($game) !!}</td>
                        @endforeach

                        <!-- Hành động -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('home.detail', $game->slug) }}" target="_blank" class="btn-action view">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.games.edit', $game) }}" class="btn-action edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.games.destroy', $game) }}" method="POST"
                                      onsubmit="return confirm('Xóa game này?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="20" class="text-center text-muted py-4">Không tìm thấy game nào.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-secondary">
                Hiển thị {{ $games->firstItem() }}–{{ $games->lastItem() }} / {{ $games->total() }} game
            </small>
            {{ $games->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.trend-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const id = this.dataset.id;
            const value = this.checked ? 1 : 0;

            fetch(`/admin/games/${id}/toggle-trend`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ trend: value })
            });
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.mobile-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const id = this.dataset.id;
            const value = this.checked ? 1 : 0;

            fetch(`/admin/games/${id}/mobile`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mobile: value })
            });
        });
    });
});
</script>
<style>
.switch{position:relative;display:inline-block;width:48px;height:24px;}
.switch input{display:none;}
.slider{position:absolute;cursor:pointer;background:#ccc;border-radius:34px;top:0;left:0;right:0;bottom:0;transition:.4s;}
.slider:before{position:absolute;content:"";height:18px;width:18px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.4s;}
input:checked + .slider{background:#22c55e;}
input:checked + .slider:before{transform:translateX(24px);}
</style>

@endsection