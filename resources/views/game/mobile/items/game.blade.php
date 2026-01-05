    @if( $i%10 ==0)
  <a class="grid-thumb grid-3x3 thumb thumb-3x3" href="{{  $datamd['href'].$game->slugGame() }}" title="{{ $game->nameGame() }}">
    @else
  <a class="thumb grid-thumb" href="{{  $datamd['href'].$game->slugGame() }}" title="{{ $game->nameGame() }}"><
    @endif
    @if($game->isInLast40())
        <div class="ribbon_box"><span class="ribbon_e"></span></div>
    @elseif($game->isTrend())
        <div class="ribbon_box"><span class="ribbon_h"></span></div>
    @elseif($game->isTopLike())
        <div class="ribbon_box"><span class="ribbon_t"></span></div>
    @elseif($game->isUpdatedThisMonth())
        <div class="ribbon_box"><span class="ribbon_u"></span></div>
    @endif

    <span class="thumb-container">
      <picture>
        <img class="crop lazyload loading" src="{{ $game->linkImgGame() }}" width="100" height="100" alt=" {{ $game->nameGame() }}" style="width: auto;" itemprop="image" data-was-processed="true">
      </picture>
      <span class="thumb-name"> {{ $game->nameGame() }}</span>
    </span>

</a>