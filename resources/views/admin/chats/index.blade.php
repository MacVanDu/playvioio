@extends('admin.layouts.master')

@section('title', 'Quản lý Comment')

@php
function sortLink($column, $label) {
    $currentSort = request('sort_by');
    $currentOrder = request('sort_order', 'asc');
    $newOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';

    $query = array_merge(request()->query(), [
        'sort_by' => $column,
        'sort_order' => $newOrder,
    ]);

    $icon = '';
    if ($currentSort === $column) {
        $icon = $currentOrder === 'asc' ? '▲' : '▼';
    }

    return "<a href=\"?".http_build_query($query)."\" style=\"color:#94a3b8; text-decoration:none;\">
                {$label} <span style='font-size:10px'>{$icon}</span>
            </a>";
}

$columns = [
    [
        'label' => 'ID',
        'field' => 'id',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($c) => $c->id
    ],
    [
        'label' => 'Game ID',
        'field' => 'game_id',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($c) => $c->game_id
    ],
    [
        'label' => 'Username',
        'field' => 'username',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($c) => "<strong class='text-white'>{$c->username}</strong>"
    ],
    [
        'label' => 'Nội dung',
        'field' => null,
        'sortable' => false,
        'responsive' => '',
        'render' => fn($c) =>
            "<div style='max-width:380px; white-space:normal; color:#e5e7eb'>{$c->message}</div>"
    ],
    [
        'label' => 'Status',
        'field' => 'status',
        'sortable' => true,
        'responsive' => '',
        'render' => fn($c) => match($c->status) {
            0 => "<span class='badge bg-warning text-dark'>Pending</span>",
            1 => "<span class='badge bg-success'>Active</span>",
            2 => "<span class='badge bg-secondary'>Hidden</span>",
        }
    ],
    [
        'label' => 'Ngày tạo',
        'field' => 'created_at',
        'sortable' => true,
        'responsive' => 'd-none d-md-table-cell',
        'render' => fn($c) => $c->created_at->format('d/m/Y H:i')
    ],
];
@endphp

@section('content')
<div class="content-wrapper px-2 py-2 px-md-4 py-md-4" style="background:#0f172a; min-height:100vh;">
    <div class="card shadow-lg border-0 p-3 p-md-4" style="background:#1e293b; border-radius:16px;">

        <h2 class="fw-bold text-white mb-4">
            <i class="fas fa-comments me-2"></i>Quản lý Comment
        </h2>

        <!-- Filter -->
        <form method="GET" class="mb-4 d-flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control"
                placeholder="🔍 Tìm username / nội dung"
                style="max-width:260px">

            <select name="status" class="form-select" style="max-width:180px">
                <option value="">-- Status --</option>
                <option value="0" @selected(request('status')==='0')>Pending</option>
                <option value="1" @selected(request('status')==='1')>Active</option>
                <option value="2" @selected(request('status')==='2')>Hidden</option>
            </select>

            <button class="btn btn-gradient">
                <i class="fas fa-filter"></i> Lọc
            </button>
        </form>

        {{-- ================= BULK FORM ================= --}}
        <form method="POST" action="{{ route('admin.chats.bulk') }}">
            @csrf

            <div class="d-flex gap-2 mb-3">
                <select name="action" class="form-select w-auto" required>
                    <option value="">-- Hành động --</option>
                    <option value="approve">Duyệt</option>
                    <option value="hide">Ẩn</option>
                    <option value="delete">Xoá</option>
                </select>

                <button type="submit"
                        class="btn btn-warning"
                        onclick="return confirm('Áp dụng hành động cho các comment đã chọn?')">
                    Áp dụng
                </button>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead style="color:#94a3b8; font-size:13px; text-transform:uppercase;">
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="checkAll">
                        </th>
                        @foreach($columns as $c)
                            <th class="{{ $c['responsive'] }}">
                                {!! $c['sortable'] && $c['field'] ? sortLink($c['field'], $c['label']) : $c['label'] !!}
                            </th>
                        @endforeach
                        <th class="text-center">Hành động</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($chats as $chat)
                        <tr style="background:#1e293b;border-bottom:1px solid #273449;">
                            <td>
                                <input type="checkbox"
                                       class="row-check"
                                       name="ids[]"
                                       value="{{ $chat->id }}">
                            </td>

                            @foreach($columns as $c)
                                <td class="{{ $c['responsive'] }}">{!! $c['render']($chat) !!}</td>
                            @endforeach

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    @if($chat->status != 1)
                                    <form method="POST" action="/admin/chats/{{ $chat->id }}/approve">
                                        @csrf
                                        <button class="btn-action edit" title="Duyệt">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if($chat->status != 2)
                                    <form method="POST" action="/admin/chats/{{ $chat->id }}/hide">
                                        @csrf
                                        <button class="btn-action view" title="Ẩn">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <form method="POST" action="/admin/chats/{{ $chat->id }}"
                                          onsubmit="return confirm('Xoá comment này?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-action delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" class="text-center text-muted py-4">
                                Không có comment nào.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <small class="text-secondary">
                Hiển thị {{ $chats->firstItem() }}–{{ $chats->lastItem() }} / {{ $chats->total() }}
            </small>
            {{ $chats->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

{{-- ================= CHECK ALL SCRIPT ================= --}}
<script>
document.getElementById('checkAll')?.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.checked = this.checked;
    });
});
</script>
@endsection