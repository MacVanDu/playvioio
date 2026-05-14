<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasmenu" aria-labelledby="offcanvasmenuLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasmenuLabel">
			<a class="navbar-brand logo-center" href="{{ $localePrefix ?: '/' }}">
				<picture>
					<source srcset="/images/site-logo.webp" media="(max-width: 768px)">
					<img src="/images/site-logo.webp" alt="Marios.games Logo" width="190" height="55">
				</picture>
			</a>
		</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div id="nav-content dropdown-menu">
			<ul class="list-unstyled">
				@foreach($datamd['category']  as $i => $c)
				<li>
					<a class="mx-2 text-white" href="{{ $c->slug()}}">
						<img src="{{ $c->img()}}" width="30" height="30" alt="{{ $c->name()}}" class="me-1">
						{{ $c->name()}}
					</a>
				</li>
				@endforeach
			</ul>
			<hr>
			<div id="nav-footer-content">
				<ul class="list-unstyled text-start ms-3">
					<li><a href="{{ $localePrefix }}/page/about" class="text-error">{{ __('messages.about') }}</a></li>
					<li><a href="{{ $localePrefix }}/page/terms-of-Service" class="text-error">{{ __('messages.terms') }}</a></li>
					<li><a href="{{ $localePrefix }}/page/privacy" class="text-error">{{ __('messages.privacy') }}</a></li>
					<li><a href="{{ $localePrefix ?: '/' }}" class="text-error">{{ __('messages.all_games') }}</a></li>
					<p class="text-white">© 2026 Marios.games</p>
				</ul>
			</div>
			<hr>
			<div class="nav-button ms-1">
				<a class="nav-button ms-1" href="{{ $localePrefix }}/page/contact"><i class="fas nav-icon contact-icon p-1"></i><span class="ms-2">{{ __('messages.contact_us') }}</span></a>
			</div>
		</div>
	</div>
</div>
