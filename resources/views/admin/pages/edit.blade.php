@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Sửa trang</h2>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text"
                   name="title"
                   class="form-control"
                   value="{{ $page->title }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text"
                   class="form-control"
                   value="{{ $page->slug }}"
                   disabled>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea id="contents"
                      name="contents"
                      class="form-control">{{ $page->contents }}</textarea>
        </div>

        <button class="btn btn-success">Cập nhật</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#contents',
    height: 400,
    branding: false,
    promotion: false
});
</script>
@endsection
