<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasSearchLabel">
			<div class="offcanvas-header">
				<form class="position-relative mx-auto my-3 search-bar" action="{{ $localePrefix }}/search">
										<input type="text" class="form-control searchInput search" placeholder="{{ __('messages.search_placeholder') }}" name="name" minlength="2" required="">
					<button class="btn end-0 position-absolute top-0" type="submit">
						<img src="/images/search-icon.svg?v=1" width="18" height="18" alt="search icon ">
					</button>
				</form>
				<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
		</div>
