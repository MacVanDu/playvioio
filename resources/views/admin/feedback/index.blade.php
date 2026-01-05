@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Danh sách Feedback</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Slug</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>{{ Str::limit($item->content, 50) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Không có phản hồi nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

 <!-- Pagination -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small class="text-secondary">
                Hiển thị {{ $feedbacks->firstItem() }}–{{ $feedbacks->lastItem() }} / {{ $feedbacks->total() }} game
            </small>
            {{ $feedbacks->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
</div>
@endsection