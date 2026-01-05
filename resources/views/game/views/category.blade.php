<div class="py-2 bg-black mb-4 mt-4 w-100 d-none d-lg-block">
	<nav class="px-md-5 px-3">
				@foreach($datamd['category']  as $i => $c)
					<a class="mx-2 text-white" href="{{ $c->slug()}}">
						<img src="{{ $c->img()}}" width="30" height="30" alt="{{ $c->name()}}" class="me-1">
						{{ $c->name()}}
					</a>
				@endforeach
	</nav>
</div>