@extends('game.mobile.all')
@section('heads')
@include('game.head.index',['title' => 'New games - ApkgosuGame'])
@endsection
@section('body')
<h1 style="text-align:center;font-family: 'Baloo Chettan', sans-serif; font-weight: normal;">New games</h1>
<div class="container" style="margin-top:40px;">
  @include('game.mobile.items.listgame', ['datagames' => $game_new])
</div>
    <div style="padding:6px;"></div>
@endsection
@section('feedback')
@endsection
@section('footer')
@endsection
@section('customModal')
@endsection
@section('scripts')
@endsection