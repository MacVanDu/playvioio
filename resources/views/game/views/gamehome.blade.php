<div class="games-container">
    @foreach($datagames as $g)
        @include('game.items.game', ['game' => $g])
    @endforeach
</div>