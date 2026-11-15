{{-- SEO & Metadata Component for Dried Chili --}}
@php
    $pageTitle = trim(View::yieldContent('title'));
    $isJojoHome = request()->routeIs('home');
    $siteName = $isJojoHome ? 'Jojo Little Kitchen' : 'Dried Chili';
    $siteLogo = asset('images/jojo-logo-pdf.svg');
    $siteImage = $isJojoHome ? asset('images/jojo-shrimp-hero-clean.webp') : asset('images/product_hero.png');
    $siteDescription = $isJojoHome
        ? 'Signature shrimp chilli made for bold flavour and everyday cooking.'
        : 'Handcrafted premium dried chillies, shrimp chilli paste, and authentic organic seasonings.';
    if (empty($pageTitle)) {
        $pageTitle = 'Dried Chili — Handcrafted Premium Spices & Organic Seasonings';
    }

    $pageDescription = trim(View::yieldContent('meta_description'));
    if (empty($pageDescription)) {
        $pageDescription = 'Discover Dried Chili: authentic handcrafted shrimp chilli paste, premium dried chillies, and organic spicy seasonings delivered fresh.';
    }

    $pageKeywords = trim(View::yieldContent('meta_keywords'));
    if (empty($pageKeywords)) {
        $pageKeywords = $isJojoHome
            ? 'Jojo Little Kitchen, shrimp chilli, chilli oil, crispy chilli, Asian chilli sauce'
            : 'dried chili, shrimp chilli paste, premium spices, organic seasonings, hot chili flakes, artisanal spice blend';
    }

    $canonicalUrl = trim(View::yieldContent('canonical_url'));
    if (empty($canonicalUrl)) {
        $canonicalUrl = url()->current();
    }

    $ogImage = trim(View::yieldContent('og_image'));
    if (empty($ogImage)) {
        $ogImage = $siteImage;
    }

    $ogType = trim(View::yieldContent('og_type'));
    if (empty($ogType)) {
        $ogType = 'website';
    }
@endphp

<title>{!! e($pageTitle, false) !!}</title>
<meta name="description" content="{!! e($pageDescription, false) !!}">
<meta name="keywords" content="{!! e($pageKeywords, false) !!}">
<meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{!! e($pageTitle, false) !!}">
<meta property="og:description" content="{!! e($pageDescription, false) !!}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="en_US">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{!! e($pageTitle, false) !!}">
<meta name="twitter:description" content="{!! e($pageDescription, false) !!}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- Schema.org Global Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "{{ url('/') }}#organization",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}",
      "logo": {
        "@type": "ImageObject",
        "@id": "{{ url('/') }}#logo",
        "url": "{{ $siteLogo }}",
        "caption": "{{ $siteName }}"
      },
      "image": "{{ $siteImage }}",
      "description": "{{ $siteDescription }}"
    },
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}#website",
      "url": "{{ url('/') }}",
      "name": "{{ $siteName }}",
      "publisher": {
        "@id": "{{ url('/') }}#organization"
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/shop') }}?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>

@yield('schema_json')
@yield('meta')
