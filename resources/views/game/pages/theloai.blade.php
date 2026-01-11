@extends('game.layouts.all')
@section('heads')
<title>{{ $category->title}}</title>
<meta name="description" content="{{ $category->description_seo }}">
<link rel="canonical" href="https://marios.games/">
@endsection
@section('body')
<style>
    /* khung thumbnail */
    .list-thumbnail {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        /* BẮT BUỘC */
    }

    /* ảnh */
    .list-thumbnail img {
        display: block;
        width: 100%;
        height: auto;
    }

    /* overlay tên game */
    .list-thumbnail::after {
        content: attr(data-title);
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;

        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.85),
                rgba(0, 0, 0, 0.1));

        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-align: center;

        padding: 8px 6px;
        opacity: 0;
        transform: translateY(100%);
        transition: all 0.25s ease;
    }

    /* hover */
    a:hover .list-thumbnail::after {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<div class="container">
    <div class="game-container-archive">
        <div class="content-wrapper">
            <h3 class="item-title">{{ $category->name() }} Games</h3>
            <div class="game-container-category">
                <div class="row">

                    @foreach($data_games as $i=>$game)

                    <div class="col-md-2 col-sm-3 col-6 item-grid">
                        <a href="{{ $game->slugGame() }}">
                            <div class="list-game">
                                <div class="list-thumbnail" data-title="{{ $game->nameGame() }}"><img
                                        src="{{ $game->linkImgGame() }}"
                                        class="small-thumb ls-is-cached lazyloaded" alt="{{ $game->nameGame() }}"></div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pagination-wrapper">
                @include('game.items.pagination', [
                'paginator' => $data_games,
                'slug' => $slug
                ])
            </div>
            <div class="game-container-category">
                <div class="row">
                    @include('game.items.description_c')
                </div>
            </div>

        </div>
    </div>
</div>


@endsection