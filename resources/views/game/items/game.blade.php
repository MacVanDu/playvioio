<div>
    @if($game->isInLast40())
        <div class="ribbon_box"><span class="ribbon_e"></span></div>
    @elseif($game->isTrend())
        <div class="ribbon_box"><span class="ribbon_h"></span></div>
    @elseif($game->isTopLike())
        <div class="ribbon_box"><span class="ribbon_t"></span></div>
    @elseif($game->isUpdatedThisMonth())
        <div class="ribbon_box"><span class="ribbon_u"></span></div>
    @endif
    <a href="{{  $datamd['href']. $game->slugGame() }}" class="game lodr2">
        <img loading="eager" src="{{ $game->linkImgGame() }}" alt="" style="display: block;" alt="{{ $game->nameGame() }}">
        @if($game->videoGame())
            <video class="game-video" loop="" muted="" preload="none" style="display: none;">
                <source src="{{ $game->videoGame() }}" type="video/mp4">
            </video>
        @endif
        <div class="title-game"> {{ $game->nameGame() }}</div>
    </a>
</div>