@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Quản lý trang</h2>

    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mb-3">
        + Thêm trang
    </a>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Slug</th>
                <th>Ngày tạo</th>
                <th width="160">Hành động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->id }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->created_at }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}"
                       class="btn btn-sm btn-warning">Sửa</a>

                    <form method="POST"
                          action="{{ route('admin.pages.destroy', $page) }}"
                          class="d-inline"
                          onsubmit="return confirm('Xoá trang này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xoá</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $pages->links() }}
</div>
@endsection
