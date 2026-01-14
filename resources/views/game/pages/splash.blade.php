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

    /* .btn-play {
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
    } */

      .play-btn {
         position: absolute;
      top: 75%;
      left: calc(50% - 114px);
            padding: 15px 60px;
            font-size: 40px;
            border: none;
            cursor: pointer;
            outline: none;
            
            /* 2. Hình dáng */
            border-radius: 50px; /* Bo tròn hình viên thuốc */
            border: 5px solid #ffffff; /* Viền trắng dày */

            /* 3. Màu sắc và hiệu ứng 3D của nút */
            background: linear-gradient(180deg, #9dfa48 0%, #68d81b 50%, #46c412 100%);
            
            /* Đổ bóng phức tạp để tạo độ sâu */
            box-shadow: 
                /* Bóng đổ bên ngoài nút (để tách biệt với nền) */
                0px 6px 5px rgba(0, 0, 0, 0.2),
                /* Bóng đổ khối cứng bên dưới (tạo độ dày 3D) */
                0px 4px 0px #3a960e,
                /* Hiệu ứng bóng kính (Inner glow) - màu trắng mờ ở trên */
                inset 0px 8px 10px rgba(255, 255, 255, 0.6),
                /* Bóng tối bên trong ở dưới đáy */
                inset 0px -5px 10px rgba(0, 0, 0, 0.1);
            
            transition: transform 0.1s;
        }

        /* 4. Xử lý chữ "Play" */
        .play-btn span {
            font-family: 'Fredoka', sans-serif; /* Font chữ tròn */
            color: #ffffff;
            font-weight: 800;
            letter-spacing: 1px;
            
            /* Tạo viền đen dày xung quanh chữ bằng text-shadow */
            text-shadow: 
                3px 3px 0 #000,
               -1px -1px 0 #000,  
                1px -1px 0 #000,
               -1px 1px 0 #000,
                1px 1px 0 #000;
            
            /* Để chữ nổi lên trên các hiệu ứng khác */
            position: relative;
            z-index: 2;
        }

        /* 5. Tạo điểm sáng (đốm trắng) góc trái trên để giống nút thạch */
        .play-btn::after {
            content: '';
            position: absolute;
            top: 5px;
            left: 15px;
            width: 25px;
            height: 15px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            filter: blur(2px);
            transform: rotate(-20deg);
        }

        /* Hiệu ứng khi nhấn chuột */
        .play-btn:active {
            transform: translateY(4px); /* Nút lún xuống */
            box-shadow: 
                0px 2px 3px rgba(0, 0, 0, 0.2),
                inset 0px 8px 10px rgba(255, 255, 255, 0.6); /* Giữ nguyên hiệu ứng bóng kính */
        }
      .btn-play {
      position: absolute;
      top: 75%;
      left: 38%;
      width: 184px;
      height: 60px;
      font-size: 25px;
      font-weight: bold;
    border: none;
    background: #ffffff;
    padding: 8px;
    border-radius: 999px;
    cursor: pointer;
}

/* Mặt nút */
.btn-play span {
    position: relative;
    display: block;
    padding: 16px 60px;
    border-radius: 999px;

    background: linear-gradient(
        to bottom,
        #7DFF2F 0%,
        #4EEB1F 45%,
        #28C418 100%
    );

    font-family: Arial, Helvetica, sans-serif;
    font-size: 32px;
    font-weight: 900;
    color: #ffffff;

    /* Viền chữ đen giống ảnh */
    -webkit-text-stroke: 3px #000;
    text-shadow:
        0 3px 0 rgba(0,0,0,0.25);

    /* Độ nổi */
    box-shadow:
        inset 0 4px 0 rgba(255,255,255,0.5),
        inset 0 -6px 0 rgba(0,0,0,0.25),
        0 6px 0 #1b8e12;
}

/* Highlight bóng góc trái */
.btn-play span::before {
    content: "";
    position: absolute;
    top: 8px;
    left: 14px;
    width: 60px;
    height: 28px;
    border-radius: 999px;
    background: rgba(255,255,255,0.55);
}

/* Nhấn */
.btn-play:active span {
    transform: translateY(4px);
    box-shadow:
        inset 0 4px 0 rgba(255,255,255,0.4),
        inset 0 -3px 0 rgba(0,0,0,0.25),
        0 2px 0 #1b8e12;
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
  
    <!-- <button class="btn-play" onclick="play_game()">
  <span>Play</span>
</button> -->
<button class="play-btn" onclick="play_game()">
        <span>Play</span>
    </button>

    <!-- <div class="play-wrap">
    <button class="play-btn"  >
        <span>Play</span>
    </button> -->
<!-- </div> -->

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