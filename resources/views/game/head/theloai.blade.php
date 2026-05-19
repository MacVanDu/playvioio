<meta charset="utf-8">
<meta name="viewport"
  content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, width=device-width, height=device-height">
<meta name="robots" content="max-image-preview:large">
<title>{{ $category->titleText() }}</title>
<link rel="manifest" href="/manifest">
<meta http-equiv="Accept-CH" content="DPR">
<meta name="description"
  content="{{ $category->seoDescription() }}">

<meta name="theme-color" content="#15002f">
<meta name="HandheldFriendly" content="true">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="apple-touch-icon" href="/images/site-logo.webp">
<link rel="icon" href="/favicon.ico">
<meta name="msapplication-TileColor" content="#15002f">
<meta name="msapplication-TileImage" content="/images/site-logo.webp">

<meta property="og:url" content="https://marios.games/c/{{$category->slug}}">
<meta property="og:title" content="{{ $category->titleText() }}">
<meta property="og:description"
  content="{{ $category->seoDescription() }}">
<meta property="og:locale" content="en_US">
@if($category->imgseo)
  <meta property="og:image" content="{{ $category->imgseo }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
@endif

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://marios.games/c/{{$category->slug}}">
<meta property="twitter:title" content="{{ $category->titleText() }}">
<meta property="twitter:description"
  content="{{ $category->seoDescription() }}">
@if($category->imgseo)
  <meta property="twitter:image" content="{{ $category->imgseo }}">
@endif
