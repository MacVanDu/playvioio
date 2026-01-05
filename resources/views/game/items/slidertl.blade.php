

		<div class="col-12 mb-4">
			<div class="header-wrapper">
				<h3 class="my-3 fw-bold">{{ $data->name() }} <span class="text-error">Games</span></h3>
				<a class="header-wrapper-link" href="{{ $data->slug() }}">View more ›</a>
			</div>
			<div class="slider single-line">
				<ul class="slider__track py-1 mb-0">
					@foreach($data->games10() as $i => $game)
					<li>
						<div class="slide">
							<a href="{{  $game->slugGame() }}">
								<img src="{{ $game->linkImgGame() }}"
									alt="{{ $game->nameGame() }}" class="img-fluid small-thumb thumbnail-img m-1" width="160" height="160"></a>
						</div>
					</li>
					@endforeach
				</ul>
				<div class="slider__buttons start-0 align-items-center carousel-control-prev h-100">
					<button class="btn btn-slider-arrow p-0 me-auto slider-prev" disabled="" aria-label="previous button"><span class="previous-btn-icon m-0 p-5"></span></button>
				</div>
				<div class="slider__buttons end-0 align-items-center carousel-control-next h-100">
					<button class="btn btn-slider-arrow p-0 ms-auto slider-next" aria-label="Next Button"><span class="next-btn-icon m-0 p-5"></span></button>
				</div>
			</div>
		</div>