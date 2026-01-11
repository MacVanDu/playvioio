@extends('game.layouts.all')
@section('heads')
    <title>{{ $detail->title }} </title>
    <meta name="description" content="{{ $detail->description_seo }}">
    <link rel="canonical" href="/">
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
    <div class="container-fluid">

        <div class="game-container">
            <div class="content-wrapper single-game">

                <div class="row">
                    <div class="col-lg-2 order-2 order-lg-1">
                        <div class="bg-body-secondary rounded-2 p-3 px-0 scroll-wrapper">
                            <h2 class="mb-3 fw-semibold px-3 h4">You May <span class="text-success">Like</span></h2>
                            <div class="row px-3 pg-game-row">
                                @foreach ($you_may_like_games as $i => $game)
                                    <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                                        <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}"><img src="{{ $game->linkImgGame() }}"
                                                width="auto" height="auto" alt="{{ $game->nameGame() }}"
                                                class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 game-content order-1">
                        <div class="game-iframe-container">
                            <iframe class="game-iframe" id="game-area" src="{{ $detail->slugsplashPlay() }}" width="720"
                                height="1080" frameborder="0" allowfullscreen=""></iframe>
                        </div>
                        <div class="single-info-container">
                            <div class="header bg-body-secondary px-2">
                                <div class="header-left">
                                    <h1 class="single-title">{{ $detail->name }}</h1>
                                </div>
                                <div class="header-right">
                                    <div class="d-flex align-items-center b-action mt-2">
                                        <div class="rating-component stats-vote">
                                            <div class="rating-buttons">
                                                <div class="txt-stats d-none"></div>
                                                <i class="icon-vote fa fa-thumbs-up" id="upvote" data-id="62">
                                                    <img src="/images/like-icon.svg" alt="Like Icon" width="20"
                                                        height="20" class="me-2">
                                                </i>
                                                <i class="icon-vote fa fa-thumbs-down" id="downvote" data-id="62">
                                                    <img src="/images/dislike-icon.svg" alt="dislike Icon" width="20"
                                                        height="20" class="me-2">
                                                </i>
                                                <div class="vote-status"></div>
                                            </div>
                                        </div>
                                        <button class="btn bg-third p-0" onclick="open_fullscreen()">
                                            <img src="/images/fullscreen-icon.svg" width="20" height="20"
                                                alt="Fullscreen Image" class="m-2">
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 order-3 pg-game-col">
                        <div class="bg-body-secondary rounded-2 p-3 px-0 scroll-wrapper">
                            <h2 class="mb-3 fw-semibold px-3 h4">Popular <span class="text-success">Games</span></h2>
                            <div class="row px-3 pg-game-row">

                                @foreach ($popular_games as $i => $game)
                                    <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                                        <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}"><img src="{{ $game->linkImgGame() }}"
                                                width="auto" height="auto" alt="{{ $game->nameGame() }}"
                                                class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12 game-content">
                        <div class="row">
                            @include('game.items.description_game')
                                @include('game.views.gamechat')
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-container">
            <h3 class="my-3 fw-bold"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Similar Games</h3>
            <div class="row" id="section-similar-games">
                @foreach ($similar_games as $i => $game)
                    <div class="col-md-1 col-sm-3 col-4 item-grid pg-game">
                        <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
                            <div class="list-game">
                                <div class="list-thumbnail"><img src="{{ $game->linkImgGame() }}"
                                        class="small-thumb ls-is-cached lazyloaded" alt="{{ $game->nameGame() }}"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
