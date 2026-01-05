@extends('game.mobile.all')
@section('heads')
@include('game.head.index',['title' => 'Search Games - ApkgosuGame'])
@endsection
@section('body')
  <h1 style="text-align:center;font-family: 'Baloo Chettan', sans-serif; font-weight: normal;">{{$thongBao}}</h1>
  @if($length != 0)
    @include('game.mobile.items.listgame', ['datagames' => $data_games])
  @else
    <h2 style="padding:0px; margin:0px;">No Results! 😔</h2>
  @endif
  <h2 style="text-align: center;">Popular games</h2>
  <div class="container" style="margin-top:40px;">
    @include('game.mobile.items.listgame', ['datagames' => $gameNgauNhien])

@endsection
  @section('feedback')
  @endsection
  @section('footer')
  @endsection
  @section('customModal')
  @endsection
  @section('scripts')
  @endsection