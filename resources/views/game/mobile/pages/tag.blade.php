@extends('game.mobile.all')
@section('heads')
@include('game.head.index',['title' => $tag.' games - ApkgosuGame'])
@endsection
@section('body')
  <h1 style="text-align:center;font-family: 'Baloo Chettan', sans-serif; font-weight: normal;">{{$tag}}</h1>
  <div class="container" style="margin-top:40px;">
    @include('game.mobile.items.listgame', ['datagames' => $data_games])
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