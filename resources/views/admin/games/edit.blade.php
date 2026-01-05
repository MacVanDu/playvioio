@extends('admin.layouts.master')

@section('content')
<div class="container mt-4 text-white">
    <h2 class="fw-bold mb-4">Sửa Game</h2>

    <form method="POST" action="{{ route('admin.games.update', $game) }}">
        @csrf @method('PUT')

        <div class="row">

            <!-- NAME -->
            <div class="col-md-6 mb-3">
                <label>Tên Game</label>
                <input type="text" name="name" class="form-control" value="{{ $game->name }}" required>
            </div>

            <!-- SLUG -->
            <div class="col-md-6 mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $game->slug }}" disabled>
            </div>

            <!-- IMAGE -->
            <div class="col-md-6 mb-3">
                <label>Ảnh (URL)</label>
                <input type="text" name="image" class="form-control" value="{{ $game->image }}">
            </div>
            <!-- IMAGE SEO-->
            <div class="col-md-6 mb-3">
                <label>Ảnh Seo</label>
                <input type="text" name="imgseo" class="form-control" value="{{ $game->imgseo }}">
            </div>

            <!-- LINK -->
            <div class="col-md-6 mb-3">
                <label>Link Game</label>
                <input type="text" name="link" class="form-control" value="{{ $game->link }}">
            </div>

            <!-- VIDEO SHORT -->
            <div class="col-md-6 mb-3">
                <label>Video ngắn</label>
                <input type="text" name="video_short" class="form-control" value="{{ $game->video_short }}">
            </div>

            <!-- VIDEO YOUTUBE -->
            <div class="col-md-6 mb-3">
                <label>Video YouTube ID</label>
                <input type="text" name="video_y_id" class="form-control" value="{{ $game->video_y_id }}">
            </div>

            <!-- DURATION -->
            <div class="col-md-6 mb-3">
                <label>Thời lượng (duration)</label>
                <input type="text" name="duration" class="form-control" value="{{ $game->duration }}">
            </div>

            <!-- TAGS -->
            <div class="col-md-6 mb-3">
                <label>Tags (cách nhau bằng dấu ,)</label>
                <input type="text" name="tags" class="form-control" value="{{ $game->tags }}">
            </div>

            <!-- TREND -->
            <div class="col-md-6 mb-3">
                <label>Trend</label>
                <input type="number" name="trend" class="form-control" value="{{ $game->trend }}">
            </div>

            <!-- VOTE LIKE -->
            <div class="col-md-6 mb-3">
                <label>Vote Like</label>
                <input type="number" name="vote_like" class="form-control" value="{{ $game->vote_like }}">
            </div>

            <!-- VOTE DISLIKE -->
            <div class="col-md-6 mb-3">
                <label>Vote Dislike</label>
                <input type="number" name="vote_dis_like" class="form-control" value="{{ $game->vote_dis_like }}">
            </div>

            <!-- CATEGORY -->
            <div class="col-md-6 mb-3">
                <label>Thể loại</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Chọn thể loại --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $game->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- IMGSTATUS -->
            <div class="col-md-6 mb-3">
                <label>Trạng thái ảnh</label>
                <select name="imgstatus" class="form-select">
                    <option value="1" {{ $game->imgstatus == 1 ? 'selected' : '' }}>Ảnh Ants Game</option>
                    <option value="0" {{ $game->imgstatus == 0 ? 'selected' : '' }}>Ảnh khác</option>
                </select>
            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="1" {{ $game->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $game->status == 0 ? 'selected' : '' }}>Ẩn</option>
                    <option value="2" {{ $game->status == 2 ? 'selected' : '' }}>Pending</option>
                    <option value="3" {{ $game->status == 3 ? 'selected' : '' }}>Trùng (ẩn)</option>
                </select>
            </div>

            <!-- STATUS INDEX -->
            <div class="col-md-6 mb-3">
                <label>Vị trí hiển thị (status_index)</label>
                <input type="number" name="status_index" class="form-control" value="{{ $game->status_index }}">
            </div>

            <!-- BLOG COUNT -->
            <div class="col-md-6 mb-3">
                <label>Blog Count</label>
                <input type="number" name="blog_count" class="form-control" value="{{ $game->blog_count }}">
            </div>

            <!-- DESCRIPTION -->
            <div class="col-12 mb-3">
                <label>Mô tả</label>
                <textarea name="description" rows="6" class="form-control">{{ $game->description }}</textarea>
            </div>

        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<style>
body { background-color: #0f172a !important; }
.container {
    background-color: #1e293b;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 25px rgba(0,0,0,0.3);
}
label { color: #cbd5e1; font-weight: 500; }
.form-control, .form-select, textarea {
    background-color: #f8fafc !important;
    border: 1px solid #94a3b8 !important;
    color: #0f172a !important;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 15px;
    transition: all 0.2s ease;
}
.form-control:focus, .form-select:focus, textarea:focus {
    background-color: #ffffff !important;
    border-color: #6366f1 !important;
    box-shadow: 0 0 10px rgba(99,102,241,0.4) !important;
}
.btn-success {
    background: linear-gradient(90deg, #4f46e5, #22d3ee);
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.btn-success:hover {
    background: linear-gradient(90deg, #4338ca, #0ea5e9);
    transform: translateY(-2px);
}
.btn-secondary {
    background: #475569;
    border: none;
    color: #fff;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.btn-secondary:hover {
    background: #334155;
    transform: translateY(-2px);
}
</style>
@endsection
