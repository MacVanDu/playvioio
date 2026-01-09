<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    @php($ver = '1.0.2')
    @yield('heads')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/content/themes/default/css/updated.css?v={{ $ver }}">
    <link rel="stylesheet" href="/content/themes/default/css/font.css?v={{ $ver }}">
    <link rel="preload" as="image" href="/thumbs/space-waves-thumb-2.webp" fetchpriority="high">
    <link href="/favicon.ico?v={{ $ver }}" rel="shortcut icon" type="image/x-icon">
    <style>
        .text-gold {
            color: gold;
        }

        .text-success-new {
            color: #FFD700;
            text-decoration: underline;
        }

        @media (min-width:768px) {
            .px-md-5 {
                padding-right: 3rem !important;
                padding-left: 3rem !important
            }
        }
    </style>
</head>

<body id="page-top">
    @yield('bobys')
    @include('game.views.header')
    @include('game.views.offcanvasSearch')
    @include('game.views.offcanvasmenu')
    <div class="py-4"></div>
    @include('game.views.category')
    @yield('body')
    @include('game.views.footer')

    @php($ver = '1.0.1')
    <script src="/js/jquery.min.js?v={{ $ver }}" defer=""></script>
    <script src="/content/themes/default/js/bootstrap.bundle.min.js?v={{ $ver }}" defer=""></script>
    <script src="/content/themes/default/js/lazysizes.min.js?v={{ $ver }}" async=""></script>
    <script src="/js/comment-system.js?v={{ $ver }}" defer=""></script>
    <script src="/content/themes/default/js/script.js?v={{ $ver }}" defer=""></script>
    <script src="/content/themes/default/js/custom.js?v={{ $ver }}" defer=""></script>
    <script src="/js/stats.js?v={{ $ver }}" defer=""></script>
    @yield('scripts')
</body>

</html>