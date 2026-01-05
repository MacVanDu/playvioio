@extends('game.layouts.all')
@section('heads')
@include('game.head.index',['title' => 'New games - ApkgosuGame'])
@endsection
@section('body')

    <div class="a502"><h1>New games</h1></div>
    @include('game.views.gamehome', ['datagames' => $game_new])

@endsection

@section('feedback')
  @include('game.views.feedbackOverlay')
  @include('game.views.feedbackModal')
@endsection


@section('lang')
 @foreach(config('locales.supported_text') as  $code => $name)
    <div class="langue-option" data-url="/{{ $code }}/new-games">{{ $name }}</div>
    @endforeach
@endsection
@php
    $langOptions = $__env->yieldContent('lang');
@endphp

@section('footer')
        @include('game.views.footer',['langOptions' => $langOptions])
@endsection