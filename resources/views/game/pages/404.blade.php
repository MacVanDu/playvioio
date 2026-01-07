@extends('game.layouts.all')
@section('heads')
<title>404 | Play on Marios.games</title>
<meta name="description" content="{{  $detail->description_h() }}">
<link rel="canonical" href="/">
@endsection
@section('body')
<div class="container">
	<div class="game-container text-center">
		<img src="/content/themes/default/images/404.png">
	</div>
</div>
@endsection