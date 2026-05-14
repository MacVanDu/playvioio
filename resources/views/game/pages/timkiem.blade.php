@extends('game.layouts.all')
@section('heads')
<title>{{ $names }} | Play on Marios.games</title>
<link rel="canonical" href="{{ url(($localePrefix ?: '') . '/search') }}">
@endsection
@section('body')
<style>
.pg-game a {
    position: relative;
    display: inline-block;
    border-radius: 16px;
    overflow: hidden;
}

.pg-game img {
    display: block;
    width: 100%;
    height: auto;
}

.pg-game a::after {
    content: attr(data-title);
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.85), rgba(0,0,0,0.15));
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

.pg-game a:hover::after {
    opacity: 1;
    transform: translateY(0);
}

.no-results-wrap {
    max-width: 860px;
    margin: 0 auto 34px;
    padding: 34px 22px;
    text-align: center;
    background: rgba(10, 16, 28, .86);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 18px;
    box-shadow: 0 18px 44px rgba(0, 0, 0, .28);
}

.no-results-icon {
    width: 74px;
    height: 74px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    border-radius: 18px;
    background: linear-gradient(135deg, #ff8a00, #ff4d4d);
    color: #fff;
    font-size: 34px;
    font-weight: 800;
}

.no-results-title {
    margin-bottom: 10px;
    color: #fff;
    font-size: clamp(26px, 4vw, 40px);
    font-weight: 800;
}

.no-results-text {
    max-width: 620px;
    margin: 0 auto 22px;
    color: #b8c3d9;
    font-size: 16px;
    line-height: 1.65;
}

.no-results-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}

.no-results-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 0 18px;
    border-radius: 12px;
    font-weight: 700;
}

.no-results-btn.primary {
    background: #ff8c00;
    color: #111827;
}

.no-results-btn.secondary {
    border: 1px solid rgba(255, 255, 255, .22);
    color: #fff;
}

.suggested-title {
    margin: 4px 0 18px;
    color: #fff;
    font-weight: 800;
}
</style>

<div class="container">
    <div class="game-container-archive">
        <div class="content-wrapper">
            @if($length != 0)
                <h3 class="item-title">{{ $thongBao }}</h3>

                <div class="game-container-category">
                    <div class="row">
                        @foreach($data_games as $game)
                            <div class="col-md-2 col-sm-3 col-6 item-grid pg-game">
                                <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
                                    <div class="list-game">
                                        <div class="list-thumbnail">
                                            <img src="{{ $game->linkImgGame() }}" class="small-thumb ls-is-cached lazyloaded" alt="{{ $game->nameGame() }}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="no-results-wrap">
                    <div class="no-results-icon">?</div>
                    <h1 class="no-results-title">{{ __('messages.no_games_found') }}</h1>
                    <p class="no-results-text">
                        {!! __('messages.no_results_text', ['query' => '<strong>' . e($names) . '</strong>']) !!}
                    </p>
                    <div class="no-results-actions">
                        <a class="no-results-btn primary" href="{{ $localePrefix ?: '/' }}">{{ __('messages.back_to_home') }}</a>
                        <a class="no-results-btn secondary" href="{{ $localePrefix }}/search?name=mario">{{ __('messages.search_mario') }}</a>
                    </div>
                </div>

                @if(isset($suggested_games) && $suggested_games->count())
                    <h3 class="suggested-title">{{ __('messages.try_these_games') }}</h3>
                    <div class="game-container-category">
                        <div class="row">
                            @foreach($suggested_games as $game)
                                <div class="col-md-2 col-sm-3 col-6 item-grid pg-game">
                                    <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
                                        <div class="list-game">
                                            <div class="list-thumbnail">
                                                <img src="{{ $game->linkImgGame() }}" class="small-thumb ls-is-cached lazyloaded" alt="{{ $game->nameGame() }}">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
