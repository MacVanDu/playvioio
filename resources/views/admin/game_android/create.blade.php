@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Thêm Game Android mới</h3>

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form thêm mới --}}
    <form action="{{ route('admin.game-android.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tên game</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control"
                   value="{{ old('slug') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Màu chủ đạo</label>
            <input type="text" name="mau" class="form-control"
                   value="{{ old('mau') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Iframe (nếu có)</label>
            <input type="text" name="iframe" class="form-control"
                   value="{{ old('iframe') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <input type="text" name="tags" class="form-control"
                   placeholder="Cách nhau bằng dấu phẩy"
                   value="{{ old('tags') }}">
        </div>

        {{-- Logo link --}}
        <div class="mb-3">
            <label class="form-label">Logo (link URL)</label>
            <input type="url" name="logo" class="form-control"
                   placeholder="https://example.com/logo.png"
                   value="{{ old('logo') }}">
        </div>

        {{-- Ảnh nền link --}}
        <div class="mb-3">
            <label class="form-label">Ảnh nền (link URL)</label>
            <input type="url" name="anh_nen" class="form-control"
                   placeholder="https://example.com/background.jpg"
                   value="{{ old('anh_nen') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Video (link YouTube hoặc file .mp4)</label>
            <input type="url" name="video" class="form-control"
                   placeholder="https://youtube.com/watch?v=..."
                   value="{{ old('video') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Loại</label>
            <input type="number" name="loai" class="form-control"
                   value="{{ old('loai', 0) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nằm ngang</label>
            <select name="man_ngang" class="form-select">
                <option value="1" {{ old('man_ngang') == 1 ? 'selected' : '' }}>Có</option>
                <option value="0" {{ old('man_ngang', 0) == 0 ? 'selected' : '' }}>Không</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Hiện banner</label>
            <select name="hienbanner" class="form-select">
                <option value="1" {{ old('hienbanner') == 1 ? 'selected' : '' }}>Có</option>
                <option value="0" {{ old('hienbanner', 0) == 0 ? 'selected' : '' }}>Không</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="{{ route('admin.game-android.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
