@extends('game.layouts.all')
@section('heads')
<title>{{ $category->name() }} | Play on Marios.games</title>
<link rel="canonical" href="https://marios.games/">
@endsection
@section('body')
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
								<div class="list-thumbnail"><img
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
  </div>
  </div>
  </div>


   @endsection
