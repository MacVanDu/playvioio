@extends('game.layouts.all')
@section('heads')
@include('game.head.index',['title' => 'Recently played games - ApkgosuGame'])
@endsection
@section('body')
  <div class="info-cat">
    <div class="c1">
      <h1>Recently played games</h1>
      <p>Here you can find all games that you have recently played.</p>
    </div>
  </div>
  <div id="recentPlayedGames" class="games-container"></div>
  <script>
    function getRecentGames() {
      const e = localStorage.getItem("AIrecentGames");
      return e ? JSON.parse(e) : []
    }
    function displayRecentPlayedGames() {
      const e = getRecentGames()
        , t = document.getElementById("recentPlayedGames");
      if (t.innerHTML = "",
        0 === e.length) {
        const e = document.createElement("div");
        e.innerHTML = '<div class="no_g">There are no recently played games!</div>',
          t.appendChild(e)
      } else {
        e.sort((e, t) => t.timestamp - e.timestamp);
        let n = e.length > 500 ? e.slice(-500) : e;
        n = n.reverse(),
          n.forEach(e => {
            const n = document.createElement("a");
            n.classList.add("game", "lodr2"),
              n.href = "" + e.url;
            const a = document.createElement("img");
            a.loading = "eager",
              a.src = `${e.image}`,
              a.alt = e.name,
              a.style.display = "block",
              n.appendChild(a);
            const o = document.createElement("div");
            o.classList.add("title-game"),
              o.textContent = e.name,
              n.appendChild(o),
              t.appendChild(n)
          }
          ),
          initializeLazyLoading(t)
      }
    }
    document.addEventListener("DOMContentLoaded", () => {
      displayRecentPlayedGames()
    }
    );
  </script>
@endsection