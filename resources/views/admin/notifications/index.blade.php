@extends('admin.layouts.master')


@section('content')
<div class="container mt-4">

    <h3 class="mb-4">📢 Gửi Thông Báo Firebase</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.notifications.send') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="body" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Token (nếu gửi cho 1 máy)</label>
            <input type="text" name="token" class="form-control" placeholder="Để trống để gửi tất cả">
        </div>

        <div class="mb-3">
            <label>Topic (mặc định: all)</label>
            <input type="text" name="topic" class="form-control" value="all">
        </div>

        <button class="btn btn-primary w-100">Gửi Thông Báo</button>
    </form>

</div>
@endsection