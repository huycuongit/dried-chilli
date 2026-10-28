<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="Dried Chili">
    @if (renderData($systemSettings, 'google_site_verification', ''))
    <meta name="google-site-verification" content="{{ renderData($systemSettings, 'google_site_verification', '') }}">
    @endif

    @include('frontend.layouts.partials.meta_seo')

    <style>
        @view-transition { navigation: auto; }
    </style>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}?v=20261015-chili">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}?v=20261015-chili">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}?v=20261015-chili">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}?v=20261015-chili">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon/favicon.ico') }}?v=20261015-chili">
    <!-- Critical Assets Preload for LCP & CLS Optimization -->
    @if(request()->is('/') || request()->routeIs('home'))
    <link rel="preload" as="image" href="{{ asset('images/product_hero.webp') }}" type="image/webp" fetchpriority="high">
    @endif
    <link rel="preload" as="image" href="{{ asset('images/logo_dried.webp') }}" type="image/webp" fetchpriority="high">

    <!-- Web Fonts Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&family=Manrope:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700&display=swap">

    <!-- Core Layout CSS -->
    <link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-layout.css') }}?v=20260918-3">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-richtext.css') }}?v=20260919-1" media="print" onload="this.media='all'">

    <!-- Lucide Icons (Deferred so it does not block HTML parser) -->
    <script src="{{ asset('js/lucide.min.js') }}" defer></script>
    @stack('styles')
</head>
