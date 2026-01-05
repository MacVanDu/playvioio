@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper p-4" style="background:linear-gradient(180deg,#0f172a 0%,#111827 100%);min-height:100vh;">
    <div class="card p-4 shadow-lg" style="background:#1e293b;border:none;border-radius:16px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-white fw-bold"><i class="fas fa-file-alt me-2"></i>{{ $filename }}</h4>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        <div style="max-height:70vh;overflow:auto;background:#0f172a;color:#d1d5db;padding:15px;border-radius:8px;font-family:monospace;font-size:14px;">
            {!! $content !!}
        </div>
    </div>
</div>
@endsection
