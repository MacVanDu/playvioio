@extends('game.layouts.all')
@section('heads')
@include('game.head.index',['title' => 'Search Games - ApkgosuGame'])
@endsection
@section('body')
    <div style="text-align: center;">
      <h1>{{$thongBao}}</h1>
    </div>
    @if($length != 0)
    @include('game.views.gamehome', ['datagames' => $data_games])
    @else
      <div style="font-size:18px;" class="a512">
        <h2>No Results! 😥</h2>
      </div>
    @endif
    <div style="width: 100%;text-align: center;font-size:18px;">
      <h2>Popular games</h2>
    </div>
    @include('game.views.gamehome', ['datagames' => $gameNgauNhien])
@endsection


@section('feedback')
  @include('game.views.feedbackOverlay')
  @include('game.views.feedbackModal')
@endsection

@section('lang')
 @foreach(config('locales.supported_text') as  $code => $name)
    <div class="langue-option" data-url="/{{ $code }}/search?name={{ $names }}">{{ $name }}</div>
    @endforeach
@endsection
@php
    $langOptions = $__env->yieldContent('lang');
@endphp

@section('footer')
        @include('game.views.footer',['langOptions' => $langOptions])
@endsection