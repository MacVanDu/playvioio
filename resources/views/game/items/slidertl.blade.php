

		<div class="col-12 mb-4">
			<div class="header-wrapper">
				<h3 class="my-3 fw-bold">{{ $data->name() }} <span class="text-error">{{ __('messages.games') }}</span></h3>
				<a class="header-wrapper-link" href="{{ $data->slug() }}">{{ __('messages.view_more') }} ›</a>
			</div>
			<div class="slider category-featured position-relative">
				<ul class="slider__track py-1 mb-0">
					@foreach($data->games10($datamd['device'], 30) as $i => $game)
					@if($i % 5 == 0)
					<li class="d-flex flex-column">
						<div class="slide">
							<a href="{{  $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
								<img src="{{ $game->linkImgGame() }}"
									alt="{{ $game->nameGame() }}" class="img-fluid thumbnail-img m-1 rounded-2" width="390" height="390"></a>
						</div>
					</li>
					@endif

					@if($i % 5 == 1 || $i % 5 == 3)
					<li class="d-flex flex-column">
					@endif

						@if($i % 5 >= 1 && $i % 5 <= 4)
							<div class="slide mb-1">
								<a href="{{  $game->slugGame() }}" data-title="{{ $game->nameGame() }}">
									<img src="{{ $game->linkImgGame() }}"
										alt="{{ $game->nameGame() }}" class="img-fluid small-thumb thumbnail-img m-1 rounded-2" width="160" height="160"></a>
							</div>
						@endif

					@if($i % 5 == 2 || $i % 5 == 4)
					</li>
					@endif
					@endforeach
				</ul>
				<div class="slider__buttons slider__buttons-prev start-0 align-items-center carousel-control-prev h-100">
					<button class="btn btn-slider-arrow p-0 me-auto slider-prev" disabled="" aria-label="previous button"><span class="previous-btn-icon m-0 p-5"></span></button>
				</div>
				<div class="slider__buttons slider__buttons-next end-0 align-items-center carousel-control-next h-100">
					<button class="btn btn-slider-arrow p-0 ms-auto slider-next" aria-label="next button"><span class="next-btn-icon m-0 p-5"></span></button>
				</div>
			</div>
		</div>
