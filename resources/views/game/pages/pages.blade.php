@extends('game.layouts.all')
@section('heads')
<title>{{ $detail->titleText() }} | Play on Marios.games</title>
<link rel="canonical" href="{{ url(($localePrefix ?: '') . '/page/' . $detail->slug) }}">
@endsection
@section('body')
<div class="container">
	<div class="game-container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<h1 class="singlepage-title">{{ $detail->titleText() }}</h1>
				<div class="page-content">
					{!! $detail->contentsText() !!}
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
@endsection
