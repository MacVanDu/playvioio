@extends('game.layouts.all')
@section('heads')
<title>{{ $detail->titleText() }} </title>
<meta name="description" content="{{ $detail->seoDescription() }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url(($localePrefix ?: '') . '/g/' . $detail->slug) }}">
{{-- Open Graph (Facebook, Zalo) --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url(($localePrefix ?: '') . '/g/' . $detail->slug) }}">
<meta property="og:title" content="{{ $detail->titleText() }}">
<meta property="og:description" content="{{ $detail->seoDescription() }}">
<meta property="og:image" content="{{ 'https://marios.games'.$detail->linkImgGame()}}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url(($localePrefix ?: '') . '/g/' . $detail->slug) }}">
<meta name="twitter:title" content="{{ $detail->titleText() }}">
<meta name="twitter:description" content="{{ $detail->seoDescription() }}">
<meta name="twitter:image" content="{{ 'https://marios.games'.$detail->linkImgGame()}}">
@php
    $gameUrl = url(($localePrefix ?: '') . '/g/' . $detail->slug);
    $category = $detail->getTheloai();
    $categoryUrl = $category ? url($category->slug()) : url($localePrefix ?: '/');
    $gameImage = $detail->linkImgGame();
    if ($gameImage && !\Illuminate\Support\Str::startsWith($gameImage, ['http://', 'https://'])) {
        $gameImage = url($gameImage);
    }

    $schemas = [
        [
            '@type' => 'BreadcrumbList',
            '@id' => $gameUrl . '#breadcrumb',
            'itemListElement' => array_values(array_filter([
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => __('messages.home'),
                    'item' => url($localePrefix ?: '/'),
                ],
                $category ? [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $category->name() . ' ' . __('messages.games'),
                    'item' => $categoryUrl,
                ] : null,
                [
                    '@type' => 'ListItem',
                    'position' => $category ? 3 : 2,
                    'name' => $detail->nameGame(),
                    'item' => $gameUrl,
                ],
            ])),
        ],
        [
            '@type' => 'VideoGame',
            '@id' => $gameUrl . '#videogame',
            'name' => $detail->nameGame(),
            'url' => $gameUrl,
            'image' => $gameImage,
            'description' => $detail->seoDescription() ?: $detail->description_h(),
            'applicationCategory' => 'Game',
            'gamePlatform' => ['Web browser'],
            'operatingSystem' => 'Any',
            'genre' => $category ? $category->name() : null,
            'playMode' => 'SinglePlayer',
        ],
        [
            '@type' => 'ItemList',
            '@id' => $gameUrl . '#similar-games',
            'name' => __('messages.similar_games'),
            'itemListElement' => collect($similar_games)->values()->map(function ($game, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => url($game->slugGame()),
                    'name' => $game->nameGame(),
                ];
            })->all(),
        ],
    ];

    $faqItems = [];
    $descriptionHtml = $detail->description();
    preg_match_all('/<strong>\s*Q:\s*<\/strong>\s*(.*?)\s*<br\s*\/?>\s*<strong>\s*A:\s*<\/strong>\s*(.*?)(?=<\/p>|<br\s*\/?>\s*<strong>\s*Q:|$)/is', $descriptionHtml, $faqMatches, PREG_SET_ORDER);

    foreach ($faqMatches as $match) {
        $question = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($match[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $answer = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8')));

        if ($question !== '' && $answer !== '') {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer,
                ],
            ];
        }
    }

    if (!empty($faqItems)) {
        $schemas[] = [
            '@type' => 'FAQPage',
            '@id' => $gameUrl . '#faq',
            'mainEntity' => $faqItems,
        ];
    }

    $schemas = collect($schemas)->map(function ($schema) {
        return array_filter($schema, function ($value) {
            return $value !== null && $value !== '';
        });
    })->all();
@endphp
@include('game.partials.schema', ['schemas' => $schemas])
@endsection

@section('scripts')
<script>
function open_fullscreen() {
    const game = document.getElementById('game-area');
    if (!game) {
        return;
    }

    const isIPhone = /iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    if (isIPhone) {
        if (!document.getElementById('ios-fs-style')) {
            const style = document.createElement('style');
            style.id = 'ios-fs-style';
            style.innerHTML = '.ios-fullscreen{position:fixed!important;top:0!important;left:0!important;width:100vw!important;height:100vh!important;z-index:999999!important;border:0!important}.ios-close-btn{position:fixed;top:10px;right:10px;z-index:1000000;background:rgba(0,0,0,.55);color:#fff;border:0;padding:8px 15px;border-radius:5px;font-family:sans-serif}';
            document.head.appendChild(style);
        }

        game.classList.add('ios-fullscreen');
        const closeBtn = document.createElement('button');
        closeBtn.innerText = 'X';
        closeBtn.className = 'ios-close-btn';
        closeBtn.onclick = function () {
            game.classList.remove('ios-fullscreen');
            closeBtn.remove();
        };
        document.body.appendChild(closeBtn);
        return;
    }

    if (game.requestFullscreen) {
        game.requestFullscreen();
    } else if (game.webkitRequestFullscreen) {
        game.webkitRequestFullscreen();
    } else if (game.mozRequestFullScreen) {
        game.mozRequestFullScreen();
    } else if (game.msRequestFullscreen) {
        game.msRequestFullscreen();
    }
}
</script>
@endsection
@section('body')
<style>
    .pc-warning {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 90%;
        max-width: 400px;

        background: #ff3c3c;
        color: #fff;

        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        text-align: center;

        padding: 16px;
        border: 4px solid #000;
        border-radius: 8px;

        box-shadow:
            0 6px 0 #000,
            0 8px 12px rgba(0, 0, 0, 0.4);

        z-index: 10;

        animation: bounce 1.2s infinite;
    }

    /* khung chứa ảnh */
    .pg-game a {
        position: relative;
        display: inline-block;
        border-radius: 16px;
        overflow: hidden;
        /* BẮT BUỘC */
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

        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.85),
                rgba(0, 0, 0, 0.15));

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
                    <div >
                        {!! $datamd['qc_trang_game160x600'] !!}
                    </div>
                    <div class="bg-body-secondary rounded-2 p-3 px-0 scroll-wrapper">
                        <h2 class="mb-3 fw-semibold px-3 h4">{{ __('messages.you_may_like') }} <span class="text-success">{{ __('messages.like') }}</span></h2>
                        <div class="row px-3 pg-game-row">
                            @foreach ($you_may_like_games as $i => $game)
                            <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                                <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}"><img
                                        src="{{ $game->linkImgGame() }}" width="auto" height="auto"
                                        alt="{{ $game->nameGame() }}"
                                        class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 game-content order-1">
                    <div class="game-iframe-container game-play-container">


                        @if($datamd['device']=="MB" && $detail->mobile == 0)
                        <div class="pc-warning">
                            ⚠️ This game is only available on PC.<br>
                            Please switch to a desktop or laptop to play.
                        </div>
                        @else
                        <iframe class="game-iframe" id="game-area" src="{{ $detail->slugsplashPlay() }}" width="720"
                            height="1080" frameborder="0" allowfullscreen=""></iframe>
                        @endif
                    </div>
                    <div class="single-info-container">
                        <div class="header bg-body-secondary px-2">
                            <div class="header-left">
                                <h1 class="single-title">{{ $detail->nameGame() }}</h1>
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
                    <div class="game-ad-container">
                        {!! $datamd['qc_trang_game728x90'] !!}
                    </div>
                    <div class="game-iframe-container" style="min-height: 400px !important;">
                        @include('game.items.description_game')
                    </div>
                </div>

                <div class="col-lg-3 order-3 pg-game-col">
                    <div >
                        {!! $datamd['qc_trang_game300x600'] !!}
                    </div>
                    <div class="bg-body-secondary rounded-2 p-3 px-0 scroll-wrapper">
                        <h2 class="mb-3 fw-semibold px-3 h4">{{ __('messages.popular') }} <span class="text-success">{{ __('messages.games') }}</span></h2>
                        <div class="row px-3 pg-game-row">

                            @foreach ($popular_games as $i => $game)
                            @if ($i < 6)
                                <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                                <a href="{{ $game->slugGame() }}" data-title="{{ $game->nameGame() }}"><img
                                        src="{{ $game->linkImgGame() }}" width="auto" height="auto"
                                        alt="{{ $game->nameGame() }}"
                                        class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                                </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class=" rounded-2 p-3 px-0 scroll-wrapper">
                    @include('game.views.gamechat')
                </div>
            </div>

        </div>
    </div>
</div>

<div class="bottom-container">
    <h3 class="my-3 fw-bold"><i class="fa fa-thumbs-up" aria-hidden="true"></i>{{ __('messages.similar_games') }}</h3>
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
