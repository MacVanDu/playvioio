@extends('game.layouts.all')
@section('heads')
@include('game.head.index',['title' => 'Popular Games This Month on ApkgosuGame'])
@endsection
@section('body')
  <div class="a502">
    <h1>Trending games</h1>
  </div>
  @include('game.views.gamehome', ['datagames' => $game_hot])
@endsection
@section('feedback')
  @include('game.views.feedbackOverlay')
  @include('game.views.feedbackModal')
@endsection

@section('lang')
 @foreach(config('locales.supported_text') as  $code => $name)
    <div class="langue-option" data-url="/{{ $code }}/hot">{{ $name }}</div>
    @endforeach
@endsection
@php
    $langOptions = $__env->yieldContent('lang');
@endphp

@section('footer')
        @include('game.views.footer',['langOptions' => $langOptions])
@endsection