@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Danh sách Game Android</h3>
    <a href="{{ route('admin.game-android.create') }}" class="btn btn-success mb-3">+ Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Tên</th><th>Slug</th><th>Logo</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
            <tr>
                <td>{{ $game->id }}</td>
                <td>{{ $game->name }}</td>
                <td>{{ $game->slug }}</td>
                <td>
                    @if($game->logo)
                        <img src="{{ $game->linkImgGame()}}" width="60">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.game-android.edit', $game) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.game-android.destroy', $game) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Xóa game này?')" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

        <!-- Pagination -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-secondary">
                Hiển thị {{ $games->firstItem() }}–{{ $games->lastItem() }} / {{ $games->total() }} game
            </small>
            {{ $games->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
</div>
@endsection
