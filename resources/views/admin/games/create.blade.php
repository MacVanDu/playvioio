@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4 text-white">
        <h2>Thêm Game mới</h2>

        <form method="POST" action="{{ route('admin.games.store') }}">
            @csrf

            <div class="row">

                @include('admin.components.input', [
                    'label' => 'Tên Game',
                    'name' => 'name',
                    'required' => true,
                    'value' => old('name'),
                ])

                @include('admin.components.input', [
                    'label' => 'Slug',
                    'name' => 'slug',
                    'value' => old('slug'),
                ])
                @include('admin.components.input', [
                    'label' => 'Title',
                    'name' => 'title',
                    'value' => old('title'),
                ])
                @include('admin.components.input', [
                    'label' => 'Description',
                    'name' => 'description_seo',
                    'value' => old('description_seo'),
                ])

                @include('admin.components.input', [
                    'label' => 'Ảnh (URL)',
                    'name' => 'image',
                    'value' => old('image'),
                ])

                @include('admin.components.input', [
                    'label' => 'Link game (URL / iframe)',
                    'name' => 'link',
                    'value' => old('link'),
                ])
                <div class="col-md-6 mb-3">
                    <label>Trend</label>
                    <label class='switch'>
                        <input type="hidden" name="trend" value="0">
                        <input type="checkbox" name="trend" value="1"
                            {{ old('trend', $item->trend ?? 0) == 1 ? 'checked' : '' }}>
                    </label>
                    <label>mobile</label>
                    <label class='switch'>
                        <input type="hidden" name="mobile" value="0">
                        <input type="checkbox" name="mobile" value="1"
                            {{ old('mobile', $item->mobile ?? 0) == 1 ? 'checked' : '' }}>
                    </label>
                </div>
                {{-- Category --}}
                <div class="col-md-6 mb-3">
                    <label>Thể loại</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn thể loại --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="col-md-12 mb-3">
                    <label>Mô tả</label>
                    <textarea id="description" name="description" rows="8" class="form-control">{{ old('description') }}</textarea>
                </div>

            </div>

            <button type="submit" class="btn btn-success mt-3">
                Lưu Game
            </button>
        </form>
    </div>

    {{-- ================= AUTO SLUG ================= --}}
    <script>
        function slugify(str) {
            return str
                .toLowerCase()
                .trim()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.querySelector('input[name="name"]');
            const slugInput = document.querySelector('input[name="slug"]');

            if (!nameInput || !slugInput) return;

            nameInput.addEventListener("input", function() {
                if (slugInput.value === "" || slugInput.dataset.auto === "true") {
                    slugInput.value = slugify(nameInput.value);
                    slugInput.dataset.auto = "true";
                }
            });

            slugInput.addEventListener("input", function() {
                slugInput.dataset.auto = "false";
            });
        });
    </script>

    {{-- ================= TinyMCE 6 – FREE (NO API KEY) ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: '#description',
            height: 420,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table help wordcount'
            ],
            toolbar: 'undo redo | bold italic underline | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | ' +
                'link image table | code fullscreen',
            branding: false, // ❌ không logo Tiny
            promotion: false, // ❌ không quảng cáo
            content_style: `
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    `
        });
    </script>
    
@endsection
