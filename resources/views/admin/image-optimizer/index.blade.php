@extends('admin.layouts.master')

@section('title', 'Nén ảnh WebP')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
        <div>
            <h2 class="text-white fw-bold mb-1">Nén ảnh WebP</h2>
            <div class="text-secondary">Tạo file .webp cho ảnh JPG/PNG trong public/imgs.</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!$imageEngine)
        <div class="alert alert-warning">
            Server cần có ffmpeg, Imagick hoặc PHP GD để nén ảnh WebP.
        </div>
    @else
        <div class="alert alert-info">
            Engine đang dùng: <strong>{{ strtoupper($imageEngine) }}</strong>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-white p-3">
                <div class="text-secondary small">Ảnh JPG/PNG</div>
                <div class="fs-3 fw-bold">{{ number_format($stats['sourceCount']) }}</div>
                <div class="small">{{ number_format($stats['sourceBytes'] / 1024, 1) }} KB</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-white p-3">
                <div class="text-secondary small">Ảnh WebP</div>
                <div class="fs-3 fw-bold">{{ number_format($stats['webpCount']) }}</div>
                <div class="small">{{ number_format($stats['webpBytes'] / 1024, 1) }} KB</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-dark border-secondary text-white p-3 h-100">
                <div class="text-secondary small mb-2">Thư mục quét</div>
                @foreach($folders as $folder)
                    <span class="badge bg-secondary me-2 mb-2">public/{{ $folder }}</span>
                @endforeach
            </div>
        </div>
    </div>

    @if(session('results'))
        @php($results = session('results'))
        <div class="card bg-dark border-secondary text-white mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Kết quả lần chạy vừa rồi</h5>
                <div class="row g-3">
                    <div class="col-md-2"><div class="text-secondary small">Tạo WebP</div><div class="fs-4">{{ $results['created'] }}</div></div>
                    <div class="col-md-2"><div class="text-secondary small">Bỏ qua</div><div class="fs-4">{{ $results['skipped'] }}</div></div>
                    <div class="col-md-2"><div class="text-secondary small">Đã xóa gốc</div><div class="fs-4">{{ $results['deleted'] ?? 0 }}</div></div>
                    <div class="col-md-2"><div class="text-secondary small">Cập nhật DB</div><div class="fs-4">{{ $results['updated'] ?? 0 }}</div></div>
                    <div class="col-md-2"><div class="text-secondary small">Lỗi</div><div class="fs-4">{{ $results['failed'] }}</div></div>
                    <div class="col-md-2"><div class="text-secondary small">WebP mới</div><div class="fs-4">{{ number_format($results['after'] / 1024, 1) }} KB</div></div>
                </div>

                @if(!empty($results['errors']))
                    <hr class="border-secondary">
                    <div class="text-danger fw-semibold mb-2">File lỗi</div>
                    <ul class="mb-0">
                        @foreach(array_slice($results['errors'], 0, 10) as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    <div class="card bg-dark border-secondary text-white">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.image-optimizer.optimize') }}">
                @csrf

                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Chất lượng WebP</label>
                        <input type="number" min="40" max="95" name="quality" value="75" class="form-control bg-dark text-white border-secondary">
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="overwrite" value="1" id="overwrite">
                            <label class="form-check-label" for="overwrite">
                                Ghi đè WebP đã tồn tại
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="delete_original" value="1" id="delete_original" checked>
                            <label class="form-check-label" for="delete_original">
                                Xóa ảnh gốc sau khi nén thành công
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <button class="btn btn-gradient" type="submit" @disabled(!$imageEngine)>
                            Chạy nén ảnh
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
