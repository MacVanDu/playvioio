@extends('game.layouts.all')
@section('heads')
@include('game.head.index',['title' => $tag.' games - ApkgosuGame'])
@endsection
@section('body')
    <div class="info-cat">
      <div class="c1">
        <h1>{{$tag}}</h1>
      </div>
    </div>
    @include('game.views.gamehome', ['datagames' => $data_games])
   
    <script>document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("text-container"),t=document.getElementById("read-more-btn");e.scrollHeight>300&&(t.style.display="block"),t.addEventListener("click",function(){let n=e.classList.contains("expanded");n?(e.style.maxHeight="300px",e.classList.remove("expanded"),t.textContent="Show More"):(e.style.maxHeight=`${e.scrollHeight}px`,e.classList.add("expanded"),t.textContent="Show Less")})});  </script>
@endsection
@section('feedback')
  @include('game.views.feedbackOverlay')
  @include('game.views.feedbackModal')
@endsection


@section('lang')
 @foreach(config('locales.supported_text') as  $code => $name)
    <div class="langue-option" data-url="/{{ $code }}/tag/{{ $tag }}">{{ $name }}</div>
    @endforeach
@endsection
@php
    $langOptions = $__env->yieldContent('lang');
@endphp

@section('footer')
        @include('game.views.footer',['langOptions' => $langOptions])
@endsection