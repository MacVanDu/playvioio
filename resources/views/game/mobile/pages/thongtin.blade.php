@extends('game.mobile.all')
@section('heads')
@include('game.head.thongtin')
@php($ver = 1)
    <link rel="preload" href="/gb/css/game_mb.css?v={{ $ver }}" as="style">
    <link rel="stylesheet" href="/gb/css/game_mb.css?v={{ $ver }}" media="print" onload="this.media='all'">
@endsection
@section('schema')
{!! $schema_game !!}
@endsection
@section('body')
  <div id="fullscreenModal" class="fullscreen-modal" style="display: none;"><button id="exitFullscreenButton"
      class="exit-fullscreen-button" style="top: 100px;"> <span>‹</span>
      <img src="https://img.apkgosu.fun/images/favicons/apple-touch-icon-57x57.png" width="25" alt="Apkgosu"></button>
    <div id="continueGameButton" class="continueGameButton" style="display: none;">
      <div class="c_play_svg"><svg viewBox="0 0 142.448 142.448">
          <g>
            <path d="M142.411,68.9C141.216,31.48,110.968,1.233,73.549,0.038c-20.361-0.646-39.41,7.104-53.488,21.639
              C6.527,35.65-0.584,54.071,0.038,73.549c1.194,37.419,31.442,67.667,68.861,68.861c0.779,0.025,1.551,0.037,2.325,0.037
              c19.454,0,37.624-7.698,51.163-21.676C135.921,106.799,143.033,88.377,142.411,68.9z M111.613,110.336
              c-10.688,11.035-25.032,17.112-40.389,17.112c-0.614,0-1.228-0.01-1.847-0.029c-29.532-0.943-53.404-24.815-54.348-54.348
              c-0.491-15.382,5.122-29.928,15.806-40.958c10.688-11.035,25.032-17.112,40.389-17.112c0.614,0,1.228,0.01,1.847,0.029
              c29.532,0.943,53.404,24.815,54.348,54.348C127.91,84.76,122.296,99.306,111.613,110.336z"></path>
            <path d="M94.585,67.086L63.001,44.44c-3.369-2.416-8.059-0.008-8.059,4.138v45.293
              c0,4.146,4.69,6.554,8.059,4.138l31.583-22.647C97.418,73.331,97.418,69.118,94.585,67.086z"></path>
          </g>
        </svg></div> <span>Tap to continue game </span>
    </div><iframe id="gameIframe" allowfullscreen="" src=""></iframe>
  </div>

  <div class="content">
    <div class="js1">
      <div id="video-container">
        <div id="preloader-image"
          style="background-image: url(&quot;{{$detail->linkImgGame()}}&quot;); background-size: cover; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; ">
        </div>
        @if($detail->videoGame())
          <video id="background-video" loop="" muted="" autoplay=""
            style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; object-fit: cover; display: block;">
            <source src="{{ $detail->videoGame() }}" type="video/mp4">
          </video>
        @endif
      </div>
      <div class="bge1"></div>
    </div>


    <div class="sbu">
      <h1 style="text-shadow: 2px 2px #000;"> {{$detail->nameGame()}}</h1>
      <div class="bplay">
        <a href="/iframe/?gameURL={{$detail->getLinkIframe()}}" target="_blank" title="Play Now" id="play"
          class="button-new" attr-disabled="false">Play Now <svg class="play_svg" viewBox="0 0 142.448 142.448">
            <g>
              <path d="M142.411,68.9C141.216,31.48,110.968,1.233,73.549,0.038c-20.361-0.646-39.41,7.104-53.488,21.639
            C6.527,35.65-0.584,54.071,0.038,73.549c1.194,37.419,31.442,67.667,68.861,68.861c0.779,0.025,1.551,0.037,2.325,0.037
            c19.454,0,37.624-7.698,51.163-21.676C135.921,106.799,143.033,88.377,142.411,68.9z M111.613,110.336
            c-10.688,11.035-25.032,17.112-40.389,17.112c-0.614,0-1.228-0.01-1.847-0.029c-29.532-0.943-53.404-24.815-54.348-54.348
            c-0.491-15.382,5.122-29.928,15.806-40.958c10.688-11.035,25.032-17.112,40.389-17.112c0.614,0,1.228,0.01,1.847,0.029
            c29.532,0.943,53.404,24.815,54.348,54.348C127.91,84.76,122.296,99.306,111.613,110.336z"></path>
              <path d="M94.585,67.086L63.001,44.44c-3.369-2.416-8.059-0.008-8.059,4.138v45.293
            c0,4.146,4.69,6.554,8.059,4.138l31.583-22.647C97.418,73.331,97.418,69.118,94.585,67.086z"></path>
            </g>
          </svg>
        </a>
      </div>
      <div style="margin-bottom:25px; padding-top:20px;">
        <div id="rating" data-game-id="{{ $detail->id }}">
          <div class="rating">
            <div class="bt5">
              <div class="icon-bt5 fa-thumbs-o-up thumbs-up likes" id="thumbs-up">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                  </path>
                </svg>
                <span>{{$detail->likes()}}</span>
              </div>
              <div class="icon-bt5 fa-thumbs-o-down thumbs-down dislikes" id="thumbs-down">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17">
                  </path>
                </svg>
                <span>{{$detail->dislikes()}}</span>
              </div>
            </div>
          </div>
          <div class="icon-bt5" id="add-to-favorites">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
              </path>
            </svg>
            <span class="dd1">Favorites</span>
          </div>
          <div class="icon-bt5 view-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="18" cy="5" r="3"></circle>
              <circle cx="6" cy="12" r="3"></circle>
              <circle cx="18" cy="19" r="3"></circle>
              <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
              <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
            </svg>
            <span class="dd1">Share</span>
          </div>
        </div>
      </div>
    </div>

    <div style="padding:10px; margin-bottom:5px;">

      @include('game.mobile.items.listgame', ['datagames' => $games_lien_quan])
      <div style="padding:10px; margin-bottom:5px;">
        <section class="adv" style="margin-top:20px;">
          <div style=" padding:10px; color:#FFF; font: 300 16px/1.73 'Open Sans',sans-serif;">
            <div class="upt">
              <a href="{{ $datamd['href'] == ''?'/': $datamd['href']}}">Games</a>
              <span class="ar"></span>
              <a href="{{$datamd['href'].$detail->getTheloai()->slugk()}}">{{$detail->getTheloai()->names()}}</a>
              <span class="ar"></span>
              <span class="we">{{$detail->name}} </span>
            </div>

            {!! $detail->description() !!}
            <div style="margin-top:10px;">
              @foreach($detail->tag_arr() as $i => $t)
                <div class="tags">
                  <a href="{{  $datamd['href'] }}/tag/{{ $t }}">
                    <span class="tag-text">{{ $t }}</span>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        </section>

      </div>

    </div>

      @include('game.mobile.mod')
@endsection
  @section('feedback')
  @endsection
  @section('footer')
  @endsection
  @section('customModal')
  
  @endsection
  @section('scripts')
  <script>
 
document.addEventListener("DOMContentLoaded", () => {
    let e = document.getElementById("add-to-favorites");
    if (e) {
        let t = {
         name: "{{ $detail->nameGame() }}",
          image: "{{ $detail->linkImgGame() }}",
          url: "{{  $datamd['href'].$detail->slugGame() }}"
        };
        e && isInFavorites(t) && e.classList.add("favorite"),
        e.addEventListener("click", () => {
            isInFavorites(t) ? (removeFavorite(t),
            e.classList.remove("favorite")) : (addFavorite(t),
            e.classList.add("favorite"),
            openfavlistButton.classList.add("pulse"),
            setTimeout( () => {
                openfavlistButton.classList.remove("pulse")
            }
            , 600)),
            displayFavorites()
        }
        )
    }
    displayFavorites()
}
)
 </script>
    @php($verjs = 1)
    <script src="/gb/js/game_mb.js?v={{ $verjs }}"></script>
  @endsection