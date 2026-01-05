<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasmenu" aria-labelledby="offcanvasmenuLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasmenuLabel">
			<a class="navbar-brand logo-center" href="/">
				<picture>
					<source srcset="/images/site-logo.webp" media="(max-width: 768px)">
					<img src="/images/site-logo.webp" alt="Playvio Logo" width="190" height="55">
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
					<li><a href="/page/about" class="text-error">About</a></li>
					<li><a href="/page/developer" class="text-error">Developer</a></li>
					<li><a href="/page/terms" class="text-error">Terms &amp; conditions</a></li>
					<li><a href="/page/privacy" class="text-error">Privacy</a></li>
					<li><a href="/" class="text-error">All games</a></li>
					<p class="text-white">© 2026 playvio.io</p>
				</ul>
			</div>
			<hr>
			<div class="nav-button ms-1">
				<a class="nav-button ms-1" href="/page/contact"><i class="fas nav-icon contact-icon p-1"></i><span class="ms-2">Contact
						us</span></a>
			</div>
		</div>
	</div>
</div>