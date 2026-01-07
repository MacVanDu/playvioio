@extends('game.layouts.all')
@section('heads')
<title>{{ $detail->nameGame()  }} | Play on Marios.games</title>
<meta name="description" content="{{  $detail->description_h() }}">
<link rel="canonical" href="/">
@endsection
@section('body')
<div class="container-fluid">

  <div class="game-container">
    <div class="content-wrapper single-game">

      <div class="row">
        <div class="col-lg-2 order-2 order-lg-1">
          <div class="bg-body-secondary rounded-2 p-3 px-0 scroll-wrapper">
            <h2 class="mb-3 fw-semibold px-3 h4">You May <span class="text-success">Like</span></h2>
            <div class="row px-3 pg-game-row">
              @foreach($you_may_like_games as $i => $game)
              <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                <a href="{{  $game->slugGame() }}"><img
                    src="{{ $game->linkImgGame() }}" width="auto"
                    height="auto" alt="{{ $game->nameGame() }}"
                    class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                </a>
              </div>
              @endforeach
            </div>
          </div>
        </div>

				<div class="col-lg-8 game-content order-1">
					<div class="game-iframe-container">
						<iframe class="game-iframe" id="game-area" src="{{$detail->slugsplashPlay()}}"
							width="720" height="1080" frameborder="0" allowfullscreen=""></iframe>
					</div>
					<div class="single-info-container">
						<div class="header bg-body-secondary px-2">
							<div class="header-left">
								<h1 class="single-title">{{$detail->name}}</h1>
							</div>
							<div class="header-right">
								<div class="d-flex align-items-center b-action mt-2">
									<div class="rating-component stats-vote">
										<div class="rating-buttons">
											<div class="txt-stats d-none"></div>
											<i class="icon-vote fa fa-thumbs-up" id="upvote" data-id="62">
												<img src="/images/like-icon.svg" alt="Like Icon"
													width="20" height="20" class="me-2">
											</i>
											<i class="icon-vote fa fa-thumbs-down" id="downvote" data-id="62">
												<img src="/images/dislike-icon.svg" alt="dislike Icon"
													width="20" height="20" class="me-2">
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

              @foreach($popular_games as $i => $game)
              <div class="col-4 col-lg-6 mb-2 rightside-img-col pg-game">
                <a href="{{  $game->slugGame() }}"><img
                    src="{{ $game->linkImgGame() }}" width="auto"
                    height="auto" alt="{{ $game->nameGame() }}"
                    class="img-fluid rightside-img mx-auto d-block thumbnail-img">
                </a>
              </div>
              @endforeach
						</div>
					</div>
				</div>

      </div>
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 game-content">
          <div class="info-the-game">
            {!! $detail->description() !!}
            <br>
            <br>
            <b>Categories</b>
            <p class="cat-list">
              <a href="{{$detail->getTheloai()->slug()}}" class="cat-link">{{$detail->getTheloai()->name()}}</a>
            </p>
          </div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </div>

  <div class="bottom-container">
    <h3 class="my-3 fw-bold"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Similar Games</h3>
    <div class="row" id="section-similar-games">
      @foreach($similar_games as $i => $game)
      <div class="col-md-2 col-sm-3 col-4 item-grid">
        <a href="{{  $game->slugGame() }}">
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