<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Stickman Parkour 3</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <style>
        @font-face {
            font-family: 'Readex Pro';
            src: url('/content/themes/default/fonts/ReadexPro-Regular.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: #000;
            font-family: 'Readex Pro', sans-serif;
            overflow: hidden;
            color: #fff;
        }

        /* Container chính */
        .splash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Tập trung vào giữa */
            gap: 25px; /* Khoảng cách giữa các thành phần */
            z-index: 10;
            box-sizing: border-box;
            transition: opacity 0.4s ease;
        }

        /* Background mờ */
        .glow-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(20px) brightness(0.5);
            opacity: 0.8;
            z-index: -1;
            transform: scale(1.1);
        }

        /* Logo thương hiệu phía trên cùng */
        .brand-logo {
            position: absolute;
            top: 5%;
            width: 100%;
            text-align: center;
        }
        .brand-logo img {
            max-width: 180px;
            height: auto;
        }

        /* Thumbnail Game */
        .splash-thumbnail {
            width: 140px;
            height: 140px;
            border: 3px solid rgba(255,255,255,0.8);
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.6);
            overflow: hidden;
        }
        .splash-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Tiêu đề Game */
        .splash-game-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        /* Nút Play đã được thu gọn & tinh tế hơn */
        .play-btn {
            position: relative;
            padding: 10px 45px; /* Nhỏ gọn hơn */
            font-size: 24px;   /* Giảm kích thước chữ */
            border: none;
            cursor: pointer;
            border-radius: 30px;
            background: linear-gradient(180deg, #9dfa48 0%, #46c412 100%);
            box-shadow: 
                0px 4px 0px #2d7d0a, /* Độ dày nút mỏng hơn */
                0px 8px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.1s;
            outline: none;
        }

        .play-btn span {
            color: #fff;
            font-weight: 800;
            text-transform: uppercase;
            text-shadow: 2px 2px 0px rgba(0,0,0,0.5);
        }

        /* Hiệu ứng bóng sáng trên nút */
        .play-btn::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 15%;
            width: 25px;
            height: 8px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            filter: blur(1px);
        }

        .play-btn:active {
            transform: translateY(3px);
            box-shadow: 0px 1px 0px #2d7d0a;
        }

        /* Iframe game */
        #game-iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            display: none;
        }

        .loading-text {
            color: #9dfa48;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }

        /* Mobile tối ưu */
        @media (max-width: 480px) {
            .splash-thumbnail { width: 120px; height: 120px; }
            .splash-game-title { font-size: 18px; }
            .play-btn { padding: 8px 40px; font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="splash" id="splash">
        <div class="glow-background" style="background-image: url('{{ $detail->linkImgGameBG() }}');"></div>
        
        <div class="brand-logo">
            <img src="/images/brand-logo.webp" alt="Logo">
        </div>

        <div class="splash-thumbnail" id="thumb-container">
            <img src="{{$detail->linkImgGame()}}" alt="Thumbnail">
        </div>

        <div class="splash-game-title">{{ $detail->nameGame() }}</div>

        <button class="play-btn" id="play-btn-el" onclick="play_game()">
            <span>PLAY</span>
        </button>
    </div>

    <iframe id="game-iframe" 
            allow="autoplay" 
            allowfullscreen 
            scrolling="no" 
            data-src="{{$detail->getLinkIframe()}}">
    </iframe>

    <script type="text/javascript">
        function play_game() {
            const splash = document.getElementById("splash");
            const iframe = document.getElementById("game-iframe");
            const btn = document.getElementById("play-btn-el");
            const thumb = document.getElementById("thumb-container");

            // Đổi nút thành trạng thái loading
            btn.style.display = "none";
            thumb.innerHTML = '<div class="loading-text">LOADING...</div>';
            
            iframe.src = iframe.dataset.src;
            iframe.style.display = "block";

            iframe.onload = function() {
                splash.style.opacity = "0";
                setTimeout(() => { splash.remove(); }, 400);
            };
        }
    </script>
</body>
</html>