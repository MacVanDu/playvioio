
  <div class="grid-container">
    @foreach($datagames as $i => $g)
        @include('game.mobile.items.game', ['game' => $g,'i' => $i])
    @endforeach
  </div>