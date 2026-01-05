@extends('game.layouts.all')
@section('heads')
<title>PlayVio.io | Free Online Browser Game</title>
<meta name="description" content="Play hundreds of free online browser games instantly on PlayVio.io. No downloads required. Action, puzzle, adventure, and multiplayer games for all ages.">
<link rel="canonical" href="https://playvio.io/">
@endsection
@section('body')
<div class="container" role="main">
	<div class="game-container" id="home-game-container">

		<div class="col-12 mb-4">
			<div class="slider first position-relative">
				<ul class="slider__track py-1 mb-0">

					@foreach($game_dau as $i => $game)

					{{-- GAME LỚN --}}
					@if($i % 6 == 0)
					<li class="d-flex flex-column">
						<div class="slide">
							<a href="{{  $game->slugGame() }}">
								<img
									src="{{ $game->linkImgGame() }}"
									alt="{{ $game->nameGame() }}"
									class="img-fluid thumbnail-img m-1 rounded-2"
									width="390"
									height="390">
							</a>
						</div>
					</li>
					@endif

					{{-- 2 CỘT GAME NHỎ --}}
					@if($i % 6 == 1 || $i % 6 == 3)
					<li class="d-flex flex-column">
						@endif

						@if($i % 6 >= 1 && $i % 6 <= 4)
							<div class="slide mb-1">
							<a href="{{  $game->slugGame() }}">
								<img
									src="{{ $game->linkImgGame() }}"
									alt="{{ $game->nameGame() }}"
									class="img-fluid small-thumb thumbnail-img m-1 rounded-2"
									width="160"
									height="160">
							</a>
			</div>
			@endif

			@if($i % 6 == 2 || $i % 6 == 4)
			</li>
			@endif

			@endforeach

			</ul>

			{{-- BUTTONS --}}
			<div class="slider__buttons start-0 align-items-center carousel-control-prev h-100">
				<button class="btn btn-slider-arrow p-0 me-auto slider-prev" disabled aria-label="previous">
					<span class="previous-btn-icon m-0 p-5"></span>
				</button>
			</div>

			<div class="slider__buttons end-0 align-items-center carousel-control-next h-100">
				<button class="btn btn-slider-arrow p-0 ms-auto slider-next" aria-label="next">
					<span class="next-btn-icon m-0 p-5"></span>
				</button>
			</div>
		</div>
	</div>


	@foreach($categories_home as $i => $c_home)
	
		@include('game.items.slidertl', ['data' => $c_home])
	@endforeach

	<div class="col-12 mb-4 my-4 p-3">
		<div class="bg-body-secondary rounded-4 p-3 px-xl-5">
			<h2 class="mb-1 fw-bold text-center mb-3">Play what you <span class="text-success">LOVE</span>❤️</h2>
			<div class="table-responsive">
				<table class="w-100" style="min-width: 700px;">
					<tbody>
						@foreach($datamd['category'] as $i => $c)
						@if($i % 3 == 0)
						<tr>
							@endif

							<td class="p-2">
								<a
									class="bg-third rounded-2 d-flex align-items-center p-3 fw-medium"
									href="{{ $c->slug()}}">
									<img
										src="{{ $c->img()}}"
										width="30"
										height="30"
										alt="{{ $c->name()}}"
										class="me-1">
									<span>{{ $c->name()}}</span>
								</a>
							</td>
							@if($i % 3 == 2)
						</tr>
						@endif
						@endforeach
						@if(count($datamd['category']) % 3 != 0)
						</tr>
						@endif

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-12 mb-4">
		<h2 class="my-3 fw-bold">Recommended this <span class="text-success">week</span></h2>
		@include('game.items.slider', ['datagames' => $game_new])
	</div>
	<div class="col-12 mb-4">
		{!! $container_home!!}
	</div>
</div>
<div class="mb-4 mt-4 hp-bottom-container">
</div>
</div>
@endsection

@section('scripts')
<script>
	document.querySelectorAll(".slider").forEach(slider => {
		const track = slider.querySelector(".slider__track");
		const prev = slider.querySelector(".slider-prev");
		const next = slider.querySelector(".slider-next");
		if (track) {
			prev.addEventListener("click", () => {
				next.removeAttribute("disabled");
				track.scrollTo({
					left: track.scrollLeft - track.firstElementChild.offsetWidth,
					behavior: "smooth"
				});
			});
			next.addEventListener("click", () => {
				prev.removeAttribute("disabled");
				track.scrollTo({
					left: track.scrollLeft + track.firstElementChild.offsetWidth,
					behavior: "smooth"
				});
			});
			track.addEventListener("scroll", () => {
				const trackScrollWidth = track.scrollWidth;
				const trackOuterWidth = track.clientWidth;
				prev.removeAttribute("disabled");
				next.removeAttribute("disabled");
				if (track.scrollLeft <= 0) {
					prev.setAttribute("disabled", "");
				}
				let scrollPos = Math.ceil(track.scrollLeft);
				if (scrollPos >= trackScrollWidth - trackOuterWidth) {
					next.setAttribute("disabled", "");
				}
			});
		}
	});
</script>
@endsection