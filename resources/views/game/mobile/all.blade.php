<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="p:domain_verify" content="a15adc933277f8d609c5c0a0f6d2c6df"/>
    <link rel="preconnect" href="https://img.apkgosu.fun/" crossorigin="anonymous">
    <link rel="preconnect" href="https://tientai15468.github.io/" crossorigin="anonymous">

    @php($ver = 1)
    @yield('heads')

    <link rel="preload" href="/gb/css/all_mb.css?v={{ $ver }}" as="style">
    <link rel="stylesheet" href="/gb/css/all_mb.css?v={{ $ver }}" media="print" onload="this.media='all'">
    
    <script type="text/javascript" src="/gb/js/jquery.min.js?v={{ $ver }}"></script>
    <meta name="p:domain_verify" content="a15adc933277f8d609c5c0a0f6d2c6df"/>
</head>

<body>
    @include('game.mobile.header')
    <div class="home-play" style="margin-top:10px;">
            @yield('schema')
        @yield(section: 'body')
        @include('game.mobile.myMenu')
    </div>
    <div class="overlay" style="display: none;"></div>
    @yield('customModal')
    @include('game.mobile.favlist')

    @php($verjs = 1)
    <script src="/gb/js/jquery.cookie.js?v={{ $verjs }}"></script>
    <script src="/gb/js/lazyload.min.js?v={{ $verjs }}"></script>
    <script src="/gb/js/swiper-bundle.min_v2.js?v={{ $verjs }}"></script>
    <script src="/gb/js/all_mb.js?v={{ $verjs }}"></script>
    @yield('scripts')
</body>

</html>