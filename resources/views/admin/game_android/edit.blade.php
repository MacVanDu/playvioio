@extends('admin.layouts.master')


@section('content')
<div class="container mt-4">
    <h3>Sửa Game Android</h3>

    {{-- Hiển thị thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    {{-- Form update --}}
    <form action="{{ route('admin.game-android.update', $game_android->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên game</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $game_android->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control"
                   value="{{ old('slug', $game_android->slug) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Màu chủ đạo</label>
            <input type="text" name="mau" class="form-control"
                   value="{{ old('mau', $game_android->mau) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Iframe (nếu có)</label>
            <input type="text" name="iframe" class="form-control"
                   value="{{ old('iframe', $game_android->iframe) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $game_android->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <input type="text" name="tags" class="form-control"
                   value="{{ old('tags', $game_android->tags) }}">
        </div>

        {{-- Logo link --}}
        <div class="mb-3">
            <label class="form-label">Logo (link URL)</label>
            <input type="url" name="logo" class="form-control"
                   placeholder="https://example.com/logo.png"
                   value="{{ old('logo', $game_android->logo) }}">
            @if($game_android->logo)
                <div class="mt-2">
                    <img src="{{ $game_android->linkImgGame() }}" alt="Logo preview" width="100" class="border rounded">
                </div>
            @endif
        </div>

        {{-- Ảnh nền link --}}
        <div class="mb-3">
            <label class="form-label">Ảnh nền (link URL)</label>
            <input type="url" name="anh_nen" class="form-control"
                   placeholder="https://example.com/background.jpg"
                   value="{{ old('anh_nen', $game_android->anh_nen) }}">
            @if($game_android->anhNen())
                <div class="mt-2">
                    <img src="{{ $game_android->anhNen() }}" alt="Ảnh nền" width="150" class="border rounded">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Video (link YouTube hoặc file .mp4)</label>
            <input type="url" name="video" class="form-control"
                   value="{{ old('video', $game_android->video) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Loại</label>
            <input type="number" name="loai" class="form-control"
                   value="{{ old('loai', $game_android->loai) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nằm ngang</label>
            <select name="man_ngang" class="form-select">
                <option value="1" {{ $game_android->man_ngang == 1 ? 'selected' : '' }}>Có</option>
                <option value="0" {{ $game_android->man_ngang == 0 ? 'selected' : '' }}>Không</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Hiện banner</label>
            <select name="hienbanner" class="form-select">
                <option value="1" {{ $game_android->hienbanner == 1 ? 'selected' : '' }}>Có</option>
                <option value="0" {{ $game_android->hienbanner == 0 ? 'selected' : '' }}>Không</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.game-android.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection