<div id="myMenu" class="left-menu">
  <span id="closeBtn">X</span>
  <div class="list-games" style="padding:15px;">
    <ul>
      <li class="ave">
        <a href="{{ $datamd['href']}}">
          <img src="/gb/svg/home_ai02.svg?v3" width="28" height="28" alt="Home">
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}/new-games">
          <img src="/gb/svg/st_ai01.svg" width="28" height="28" alt="New games">
          <span>New games</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}/hot">
          <img src="/gb/svg/hot_ai01.svg" width="28" height="28" alt="Trending games">
          <span>Trending games</span>
        </a>
      </li>
      <li>
        <a href="{{ $datamd['href']}}{{$datamd['game_ngau_nhien']->slugGame()}}">
          <img src="/gb/svg/random_ai04.svg?v4" width="28" height="28" alt="Random">
          <span>Random</span>
        </a>
      </li>
      <li class="divider"></li>
    @foreach($datamd['data_c'] as $i => $g)
      <li>
        <a href="{{ $datamd['href']}}{{$g->slugk()}}">
          <img src="{{ $g->imgCategory()}}" width="28" height="28" alt="{{$g->names()}}" />
          <span>{{$g->names()}}</span>
        </a>
      </li>
    @endforeach
      <li class="divider"></li>
      <li class="l1l">
        <a href="https://chromewebstore.google.com/detail/apk-gosu-%E2%80%93-game-hub/bmpkbjadbncjifjnnebfhmeohffillla#extension">Add us to your desktop</a>
      </li>
      <li class="l1l">
        <a href="{{ $datamd['href']}}/pages/terms-of-use">Terms of Use</a>
      </li>
      <li class="l1l">
        <a href="{{ $datamd['href']}}/pages/privacy-policy">Privacy Policy</a>
      </li>
    </ul>
  </div>
</div>