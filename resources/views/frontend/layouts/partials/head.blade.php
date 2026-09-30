<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="Dried chili">
    <meta property="og:site_name" content="Dried chili">
    @if (renderData($systemSettings, 'google_site_verification', ''))
        <meta name="google-site-verification" content="{{ renderData($systemSettings, 'google_site_verification', '') }}">
    @endif
    <meta name="view-transition" content="same-origin" />
    @yield('meta')
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}?v=20260829">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}?v=20260829">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}?v=20260829">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}?v=20260831">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}?v=20260829">
    <meta name="theme-color" content="#333f23">
    <link rel="preload" href="{{ asset('assets/feb/haas-medium.woff2') }}" as="font" type="font/woff2" crossorigin fetchpriority="high">
    <link rel="preload" href="{{ asset('assets/feb/haas-text.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/feb-header.css') }}?v=20260918-nafu">
    <link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260918-10">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-richtext.css') }}?v=20260919-1">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-layout.css') }}?v=20260918-3">
</head>
