<div class="sidebar">
  <div class="list-games">
    <ul>
      <li>
        <a href="{{ $datamd['href'] == ''?'/': $datamd['href']}}">
          <img class="msvg" src="/gb/svg/home_ai02.svg?v3" width="28" height="28" alt="Home">
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}/new-games">
          <img class="msvg" src="/gb/svg/st_ai01.svg" width="28" height="28" alt="New games">
          <span>New games</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}/recent">
          <img class="msvg" src="/gb/svg/clock03.svg?v2" width="28" height="28" alt="Recent">
          <span>Recent</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}/hot">
          <img class="msvg" src="/gb/svg/hot_ai01.svg" width="28" height="28" alt="Trending games">
          <span>Trending games</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}{{$datamd['game_ngau_nhien']->slugGame()}}">
          <img class="msvg" src="/gb/svg/random_ai04.svg?v4" width="28" height="28" alt="Random games">
          <span>Random</span>
        </a>
      </li>
      <li class="divider"></li>
      
    @foreach($datamd['data_c'] as $i => $g)
      <li>
        <a href="{{ $datamd['href']}}{{$g->slugk()}}">
          <img class="msvg" src="{{ $g->imgCategory()}}" width="28" height="28" alt="{{$g->names()}}" />
          <span>{{$g->names()}}</span>
        </a>
      </li>
    @endforeach
    </ul>
  </div>
</div>