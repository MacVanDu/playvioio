<div class="swiper-slide c-game-item" role="group" aria-label="{{ (($i + 4 - 1) % 5) + 1 }} / 5"
  data-swiper-slide-index="{{ (($i + 4 - 1) % 5)  }}" style="margin-right: 10px;">

  <div class="video-c">
    <a href="{{  $datamd['href'] . $game->slugGame() }}" title="{{ $game->nameGame() }}">
      <div class="p-image-home" style=" display: block;">
        <img class="p-image-home-img" src="{{ $game->linkImgGame() }}" fetchpriority="high"
          alt="{{ $game->nameGame() }}">
      </div>
      @if($game->videoGame())
        <video class="bg-video" loop="" muted="" data-src="{{ $game->videoGame() }}" style="display: none;">
          <source type="video/mp4">
        </video>
      @endif
      <div class="title-c-home">
        <div class="title-c-home_img">
          <img src="{{ $game->linkImgGame() }}" alt="{{ $game->nameGame() }}">
        </div>
        <div class="title-c-home_info">
          <div class="title-c-home_title">
            <h3>{{ $game->nameGame() }}</h3>
          </div>
          <div class="title-c-home_category">{{ $game->getTheloai()->names() }}</div>
        </div>
        <div class="title-c-home_play">
          <div class="play-button"><svg fill="#9C50C0" height="35px" width="35px" viewBox="0 0 459 459"
              xml:space="preserve">
              <g>
                <g>
                  <path
                    d="M229.5,0C102.751,0,0,102.751,0,229.5S102.751,459,229.5,459S459,356.249,459,229.5S356.249,0,229.5,0z M310.292,239.651 l-111.764,76.084c-3.761,2.56-8.63,2.831-12.652,0.704c-4.022-2.128-6.538-6.305-6.538-10.855V153.416 c0-4.55,2.516-8.727,6.538-10.855c4.022-2.127,8.891-1.857,12.652,0.704l111.764,76.084c3.359,2.287,5.37,6.087,5.37,10.151 C315.662,233.564,313.652,237.364,310.292,239.651z">
                  </path>
                </g>
              </g>
            </svg></div>
        </div>
      </div>
    </a>
  </div>
</div>