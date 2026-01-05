@extends('game.layouts.all')
@section('heads')
<title>{{ $detail->title }} | Play on PlayVio</title>
<meta name="description" content="Play hundreds of free online browser games instantly on PlayVio.io. No downloads required. Action, puzzle, adventure, and multiplayer games for all ages.">
<link rel="canonical" href="https://playvio.io/">
@endsection
@section('body')
<div class="container">
	<div class="game-container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<h1 class="singlepage-title">{{ $detail->title }}</h1>
				<div class="page-content">
					{!! $detail->contents!!}
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
@endsection