@extends('game.layouts.all')
@section('heads')
<title>{{ $detail->title }} | Play on Marios.games</title>
<meta name="description" content="{{ $description_trang_chu }}">
<link rel="canonical" href="https://marios.games/">
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