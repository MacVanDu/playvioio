@extends('game.layouts.all')
@section('heads')
<title>{{ $names}} | Play on Marios.games</title>
<link rel="canonical" href="https://marios.games/">
@endsection
@section('body')
<style>
/* khung chứa ảnh */
.pg-game a {
    position: relative;
    display: inline-block;
    border-radius: 16px;
    overflow: hidden; /* BẮT BUỘC */
}

/* ảnh */
.pg-game img {
    display: block;
    width: 100%;
    height: auto;
}

/* overlay tên game */
.pg-game a::after {
    content: attr(data-title);
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;

    background: linear-gradient(
        to top,
        rgba(0,0,0,0.85),
        rgba(0,0,0,0.15)
    );

    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-align: center;

    padding: 8px 6px;
    opacity: 0;
    transform: translateY(100%);
    transition: all 0.25s ease;
    z-index: 2;
}

/* hover */
.pg-game a:hover::after {
    opacity: 1;
    transform: translateY(0);
}

</style>
<div class="container">
  <div class="game-container-archive">
    <div class="content-wrapper">
      @if($length != 0)
      <h3 class="item-title">{{ $thongBao }}</h3>

      <div class="game-container-category">
        <div class="row">

          @foreach($data_games as $i=>$game)
          <div class="col-md-2 col-sm-3 col-6 item-grid pg-game">
            <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
              <div class="list-game">
                <div class="list-thumbnail"><img
                    src="{{ $game->linkImgGame() }}"
                    class="small-thumb ls-is-cached lazyloaded" alt="{{ $game->nameGame() }}"></div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @else
      <h3 class="item-title">No Results! 😥</h3>
      @endif
    </div>
  </div>
</div>
@endsection