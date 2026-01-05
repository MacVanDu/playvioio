<meta charset="utf-8">
<meta name="viewport"
  content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, width=device-width, height=device-height">
<meta name="robots" content="max-image-preview:large">
<title>{{$category->names()}} Play on AkpgosuGames</title>
<link rel="manifest" href="/manifest">
<meta http-equiv="Accept-CH" content="DPR">
<meta name="description"
  content="Play top {{$category->names()}} for free on AkpgosuGames — no installation required. 🎮 Try right now!">

@if($datamd['locale'] == 'en')
  <link rel="canonical" href="https://www.apkgosu.fun/c/{{$category->slug}}">
@else
  <link rel="canonical" href="https://www.apkgosu.fun/{{ $datamd['locale'] }}/c/{{$category->slug}}">
@endif
@foreach($datamd['languages'] as $i => $l)
  @if($l == 'en')
    <link rel="alternate" href="https://www.apkgosu.fun/c/{{$category->slug}}" hreflang="en">
  @else
    <link rel="alternate" href="https://www.apkgosu.fun/{{ $l }}/c/{{$category->slug}}" hreflang="{{ $l }}">
  @endif
@endforeach
<link rel="alternate" href="https://www.apkgosu.fun/c/{{$category->slug}}" hreflang="x-default">

<meta name="theme-color" content="#15002f">
<meta name="HandheldFriendly" content="true">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="apple-touch-icon" href="https://img.apkgosu.fun/images/favicons/favicon-120x120.png">
<link rel="apple-touch-icon" sizes="152x152" href="https://img.apkgosu.fun/images/favicons/favicon-152x152.png">
<link rel="apple-touch-icon" sizes="167x167" href="https://img.apkgosu.fun/images/favicons/favicon-167x167.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://img.apkgosu.fun/images/favicons/favicon-180x180.png">
<link rel="mask-icon" href="https://img.apkgosu.fun/images/favicons/safari-pinned-tab.svg" color="#70B431">
<link rel="icon" href="https://img.apkgosu.fun/images/favicons/favicon-16x16.png" sizes="16x16">
<link rel="icon" href="https://img.apkgosu.fun/images/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" href="https://img.apkgosu.fun/images/favicons/favicon-48x48.png" sizes="48x48">
<link rel="icon" href="https://img.apkgosu.fun/images/favicons/favicon-196x196.png" sizes="196x196">
<meta name="msapplication-TileColor" content="#70B431">
<meta name="msapplication-TileImage"
  content="https://img.apkgosu.fun/images/favicons/touch-icon.png?metadata=none&amp;quality=60&amp;width=144&amp;height=144&amp;fit=crop&amp;format=png">

<meta property="og:url" content="https://www.apkgosu.fun/c/{{$category->slug}}">
<meta property="og:title" content="{{$category->names()}} Play on AkpgosuGames">
<meta property="og:description"
  content="Play top {{$category->names()}} for free on AkpgosuGames — no installation required. 🎮 Try right now!">
<meta property="og:locale" content="en_US">
@if($category->imgseo)
  <meta property="og:image" content="{{ $category->imgseo }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
@endif

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://www.apkgosu.fun/c/{{$category->slug}}">
<meta property="twitter:title" content="{{$category->names()}} Play on AkpgosuGames">
<meta property="twitter:description"
  content="Play top {{$category->names()}} for free on AkpgosuGames — no installation required. 🎮 Try right now!">
@if($category->imgseo)
  <meta property="twitter:image" content="{{ $category->imgseo }}">
@endif


<script async src="https://www.googletagmanager.com/gtag/js?id=G-FG8T82YHV0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() { dataLayer.push(arguments); } gtag('js', new Date()); gtag('config', 'G-FG8T82YHV0');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1364144378211052"
  crossorigin="anonymous"></script>
<meta name="ahrefs-site-verification" content="f26ccee12df34fe0eab6541426d0eca9a0f8496c1e2b4103e171f8c20590f48a">
<script src="https://analytics.ahrefs.com/analytics.js" data-key="VOGuBnIvy8PrEhjC2cW9NQ" async></script>