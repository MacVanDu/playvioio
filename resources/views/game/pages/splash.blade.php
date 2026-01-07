<html>

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta name="description" content="">
  <link rel="stylesheet" type="text/css" href="/content/themes/default/css/style.css">
  <style type="text/css">
    @font-face {
      font-family: 'Readex Pro';
      src: url('/content/themes/default/fonts/ReadexPro-Regular.woff2') format('woff2'), url('/content/themes/default/fonts/ReadexPro-Regular.woff') format('woff');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }

    body {
      color: #eee;
      position: inherit;
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100%;
      background: #000
    }

    #splash-game-content {
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 0;
      overflow: hidden;
      max-width: 100%;
      max-height: 100%;
      min-width: 100%;
      min-height: 100%;
      box-sizing: border-box
    }

    .splash {
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      width: 100%;
      z-index: 1
    }

    .splash-content {
      position: absolute;
      top: 42%;
      left: 50%;
      z-index: 2;
      transform: translate(-50%, -50%)
    }

    .splash-content img {
      width: 180px;
      height: auto;
      border: 2px solid #fff;
      border-radius: 8px
    }

    .btn-play {
      position: absolute;
      top: 75%;
      left: 50%;
      width: 184px;
      height: 60px;
      font-size: 25px;
      font-weight: bold;
      background: orange;
      border: 0;
      border-radius: 40px;
      transform: translate(-50%, -50%);
      color: #fff
    }

    .btn-play:hover {
      cursor: pointer
    }

    .splash-game-title {
      position: absolute;
      top: 63%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 20px
    }

    .glow-background {
      background-repeat: no-repeat;
      position: absolute;
      background-size: cover;
      background-position: 50%;
      filter: blur(5px);
      opacity: .7;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      z-index: -1
    }

    .brand-logo {
      text-align: center;
      position: absolute;
      top: 15%;
      left: 50%;
      z-index: 2;
      transform: translate(-50%, -50%)
    }

    .splash-game-title {
      position: absolute;
      top: 64%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 30px;
      font-family: "Readex Pro";
      font-weight: 800
    }
  </style>
</head>

<body>
  <div class="splash" id="splash">
    <div class="glow-background" style="{{ $detail->linkImgGameBG() }}"></div>
    <div class="brand-logo"><img src="/images/brand-logo.webp" width="382" height="110" alt="Marios.games Logo" class="img-fluid"></div>
    <div class="splash-content">
      <div class="splash-thumbnail">
        <img src="{{$detail->linkImgGame()}}">
      </div>
    </div>
    <div class="splash-game-title">Stickman Parkour 3</div>
    <button class="btn-play" onclick="play_game()">Play</button>
  </div>
  <iframe id="splash-game-content" frameborder="0" allow="autoplay" allowfullscreen="" seamless="" scrolling="no" data-src="{{$detail->getLinkIframe()}}"></iframe>
  <script type="text/javascript">
    function play_game() {
      document.getElementById("splash").style.opacity = "0.8";

      document.querySelector(".splash-content").innerHTML =
        '<h3 style="text-align:center">Loading...</h3>';

      document.getElementById("splash-game-content").src =
        document.getElementById("splash-game-content").dataset.src;

      document.getElementById("splash-game-content").onload = function() {
        document.getElementById("splash").remove();
      };
    }
    // ca_api.on_ad_closed = ()=>{
    // 	//
    // }
  </script>




</body>

</html>