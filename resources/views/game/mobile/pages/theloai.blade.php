@extends('game.mobile.all')
@section('heads')
  @include('game.head.theloai')
@endsection
@section('schema')
{!! $data_seo !!}
@endsection
@section('body')
  <h1 style="text-align:center;font-family: 'Baloo Chettan', sans-serif; font-weight: normal;">{{$category->names()}}</h1>
  <div class="container" style="margin-top:40px;">
    @include('game.mobile.items.listgame', ['datagames' => $data_games])
  </div>
  <div style="padding:6px;"></div>
  <div class="pagination-container">
    @include('game.items.pagination', [
      'paginator' => $data_games,
      'slug' => $slug
    ])
  </div>
  <div style="padding:6px;"></div>
    <div style="padding:10px;">
      <div class="adv">
       <h2> {{$category->names()}} </h2>
      <div class="upt2">
       <a href="{{ $datamd['href'] == ''?'/': $datamd['href']}}">Games</a> »
             <span class="we">{{$category->names()}}</span>
        </div>
         {!! $category->mo_ta() !!}
  </div>
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