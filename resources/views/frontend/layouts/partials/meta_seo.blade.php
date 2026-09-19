<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">

<meta name="title"
    content="{{ isset($metaData) ? checkValue($metaData, 'title', 'FEB — Websites that grow your business') : 'FEB — Websites that grow your business' }}">
<meta name="description"
    content="{{ isset($metaData) ? checkValue($metaData, 'description', 'FEB — Websites that grow your business') : 'FEB — Websites that grow your business' }}">
<meta name="keywords"
    content="{{ isset($metaData) ? checkValue($metaData, 'key_words', 'FEB — Websites that grow your business') : 'FEB — Websites that grow your business' }}">

@if (renderData($systemSettings, 'no_index', ''))
    {!! renderData($systemSettings, 'no_index', '') !!}
@else
    <meta name="robots" content="all" />
@endif

<meta name="theme-color" content="#ffffff">

<meta name="copyright" content="CÔNG TY TNHH XÂY DỰNG DỊCH VỤ KỸ THUẬT HOÀNG GIANG">
<meta name="author" content="CÔNG TY TNHH XÂY DỰNG DỊCH VỤ KỸ THUẬT HOÀNG GIANG">
<link rel="canonical" href="{{ request()->url() }}">


<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ renderData($systemSettings, 'website_og_title', 'FEB — Websites that grow your business') }}">
<meta property="og:image" content="{{ renderData($systemSettings, 'website_og_image', '') }}">
<meta property="og:description"
    content="{{ isset($metaData) ? checkValue($metaData, 'description', 'FEB — Websites that grow your business') : renderData($systemSettings, 'website_og_description', 'FEB — Websites that grow your business') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="FEB — Websites that grow your business">
<meta property="og:locale" content="en_US">

<!-- YouTube Meta Tags -->
{{-- <meta name="og:video" content="https://www.youtube.com/embed/videoid"> --}}
<meta name="og:video:type" content="text/html">
<meta name="og:video:width" content="1280">
<meta name="og:video:height" content="720">
{{-- <meta name="og:video:secure_url" content="https://www.youtube.com/embed/videoid"> --}}

<!-- TikTok Meta Tags (Custom Implementation) -->
{{-- <meta property="og:video" content="https://www.tiktok.com/embed/videoid"> --}}
<meta property="og:video:type" content="video/mp4">
<meta property="og:video:width" content="640">
<meta property="og:video:height" content="360">

<!-- Zalo Meta Tags -->
<meta property="og:title" content="{{ renderData($systemSettings, 'zalo_og_title', 'FEB — Websites that grow your business') }}">
<meta property="og:description"
    content="{{ renderData($systemSettings, 'website_og_description', 'FEB — Websites that grow your business') }}">
<meta property="og:image" content="{{ renderData($systemSettings, 'zalo_og_image', '') }}">
<meta property="og:url" content="{{ renderData($systemSettings, 'zalo_og_url', '') }}">

@yield('meta')
