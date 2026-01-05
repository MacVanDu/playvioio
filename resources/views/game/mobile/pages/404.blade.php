@extends('game.mobile.all')
@section('heads')
@include('game.head.index',['title' => 'ApkgosuGame'])
@endsection
@section('body')
<h1 style="text-align:center;font-family: 'Baloo Chettan', sans-serif; font-weight: normal;">Error 404</h1>
<div style="text-align:center;"><h2> The requested page does not exist! 😪</h2></div>
<div class="container" style="margin-top:40px;">
  @include('game.mobile.items.listgame', ['datagames' => $gameNgauNhien])
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