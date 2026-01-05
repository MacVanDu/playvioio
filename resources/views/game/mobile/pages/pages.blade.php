@extends('game.mobile.all')
@section('heads')
@include('game.head.index',['title' => 'ApkgosuGame'])
@endsection
@section('body')
<div style="padding:10px;">
        {!! $detail->contents!!}
        </div>
@endsection
@section('feedback')
@endsection
@section('footer')
@endsection
@section('customModal')
@endsection
@section('scripts')
@endsection