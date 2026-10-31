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
    @php
        $heroFields = collect(json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR))->collapse()->all();
        $heroImage = \App\Support\AboutPageContent::value('page_layout_home_image_slide_1', $heroFields, $systemSettings);
        $heroPreloadSrcset = \App\Support\ResponsivePageImages::srcset($heroImage);
    @endphp
    @if($heroImage !== '')<link rel="preload" as="image" href="{{ asset($heroImage) }}" @if($heroPreloadSrcset !== '') imagesrcset="{{ $heroPreloadSrcset }}" imagesizes="(max-width: 768px) 210px, 410px" @endif fetchpriority="high">@endif
    @endif

    <!-- Web Fonts Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if(request()->routeIs('home'))
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=optional" media="print" onload="this.media='all'">
    @else
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&family=Manrope:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700&display=swap">
    @endif

    <!-- Core Layout CSS -->
    @if(request()->routeIs('home'))
    <style>html{-webkit-text-size-adjust:100%;font-family:sans-serif}body{margin:0}*,*::before,*::after{box-sizing:border-box}img{max-width:100%;vertical-align:middle}button,input,select,textarea{font:inherit}button{cursor:pointer}[hidden]{display:none!important}</style>
    <link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}"></noscript>
    @else
    <link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-layout.css') }}?v=20260918-3">
    <link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-richtext.css') }}?v=20260919-1" media="print" onload="this.media='all'">

    @stack('styles')
</head>
