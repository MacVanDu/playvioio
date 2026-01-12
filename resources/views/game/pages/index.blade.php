@extends('game.layouts.all')
@section('heads')
<title>{{ $tile_trang_chu }}</title>
<meta name="description" content="{{ $description_trang_chu }}">
  {!! $ma_head_trang_chu !!}
@endsection
@section('bobys')
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TL7PC8FC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
							<a href="{{  $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
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
							<a href="{{  $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
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
<style>
	.item-vertical {
    min-height: 80px;
    width: 100%;
    display: flex;
    flex-direction: column; /* xếp từ trên xuống */
    align-items: flex-start;
}

/* reset link */
.item-link {
    text-decoration: none !important;
    color: inherit;
}

/* text mặc định không gạch */
.item-link .item-text {
    text-decoration: none !important;
    border-bottom: none !important; 
}

/* CHỈ khi hover card thì text mới gạch */
.item-link:hover .item-text {
    text-decoration: underline !important;
}

.item-link .item-text::after {
    content: none !important;         /* nếu theme dùng pseudo */
}
/* layout dọc */
.item-vertical {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
}

</style>
	<div class="col-12 mb-4 my-4 p-3">
		<div class="bg-body-secondary rounded-4 p-1 px-xl-5">
			<h2 class="mb-1 fw-bold text-center mb-3">Explore other games </h2>
			      <div class="row px-3">
					
						@foreach($datamd['category'] as $i => $c)
						
						
        @if($datamd['device']=="MB")
                                    <div class="col-6 col-lg-3 mb-2 rightside-img-col pg-game ">
          @else
                                    <div class="col-3 col-lg-3 mb-2 rightside-img-col pg-game ">
        @endif
										<a
									class="bg-third rounded-2 d-flex align-items-center p-3 fw-medium item-link"
									href="{{ $c->slug()}}">
									<div class="item-vertical">
									<img
										src="{{ $c->img()}}"
										width="50"
										height="50"
										alt="{{ $c->name()}}"
										class="me-1">
									<span class="item-text">{{ $c->name()}}</span>
									</div>
								</a>
									</div>
						@endforeach
				  </div>
		</div>
	</div>

	<div class="col-12 mb-4">
		<h2 class="my-3 fw-bold">Recommended this <span class="text-success">week</span></h2>
		@include('game.items.slider', ['datagames' => $game_new])
	</div>
	    @include('game.items.container_home')
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