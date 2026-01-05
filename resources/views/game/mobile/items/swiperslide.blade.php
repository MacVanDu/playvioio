
    @foreach($datagames as $i => $g)
        @include('game.mobile.items.gameswiper', ['game' => $g,'i' => $i])
    @endforeach
    