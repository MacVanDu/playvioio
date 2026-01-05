<meta charset="utf-8">
<meta name="viewport"
  content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, width=device-width, height=device-height">
<meta name="robots" content="max-image-preview:large">
<title>{{$detail->name}} 🕹️ Play on AkpgosuGames</title>
<link rel="manifest" href="/manifest">
<meta http-equiv="Accept-CH" content="DPR">
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
<meta name="msapplication-TileImage" content="https://img.apkgosu.fun/images/favicons/touch-icon.png?metadata=none&amp;quality=60&amp;width=144&amp;height=144&amp;fit=crop&amp;format=png">


@if($datamd['locale'] == 'en')
  <link rel="canonical" href="https://www.apkgosu.fun/g/{{$detail->slug}}">
@else
  <link rel="canonical" href="https://www.apkgosu.fun/{{ $datamd['locale'] }}/g/{{$detail->slug}}">
@endif
@foreach($datamd['languages'] as $i => $l)
  @if($l == 'en')
    <link rel="alternate" href="https://www.apkgosu.fun/g/{{$detail->slug}}" hreflang="en">
  @else
    <link rel="alternate" href="https://www.apkgosu.fun/{{ $l }}/g/{{$detail->slug}}" hreflang="{{ $l }}">
  @endif
@endforeach
<link rel="alternate" href="https://www.apkgosu.fun/g/{{$detail->slug}}" hreflang="x-default">

{!! $data_seo!!}
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FG8T82YHV0"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); } gtag('js', new Date()); gtag('config', 'G-FG8T82YHV0');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1364144378211052"
    crossorigin="anonymous"></script>
    <meta name="ahrefs-site-verification" content="f26ccee12df34fe0eab6541426d0eca9a0f8496c1e2b4103e171f8c20590f48a">
<script src="https://analytics.ahrefs.com/analytics.js" data-key="VOGuBnIvy8PrEhjC2cW9NQ" async></script>