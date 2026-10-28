{{-- SEO & Metadata Component for Dried Chili --}}
@php
    $pageTitle = trim(View::yieldContent('title'));
    if (empty($pageTitle)) {
        $pageTitle = 'Dried Chili — Handcrafted Premium Spices & Organic Seasonings';
    }

    $pageDescription = trim(View::yieldContent('meta_description'));
    if (empty($pageDescription)) {
        $pageDescription = 'Discover Dried Chili: authentic handcrafted shrimp chilli paste, premium dried chillies, and organic spicy seasonings delivered fresh.';
    }

    $pageKeywords = trim(View::yieldContent('meta_keywords'));
    if (empty($pageKeywords)) {
        $pageKeywords = 'dried chili, shrimp chilli paste, premium spices, organic seasonings, hot chili flakes, artisanal spice blend';
    }

    $canonicalUrl = trim(View::yieldContent('canonical_url'));
    if (empty($canonicalUrl)) {
        $canonicalUrl = url()->current();
    }

    $ogImage = trim(View::yieldContent('og_image'));
    if (empty($ogImage)) {
        $ogImage = asset('images/product_hero.png');
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
<meta property="og:site_name" content="Dried Chili">
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
      "name": "Dried Chili",
      "url": "{{ url('/') }}",
      "logo": {
        "@type": "ImageObject",
        "@id": "{{ url('/') }}#logo",
        "url": "{{ asset('assets/favicon/apple-touch-icon.png') }}",
        "caption": "Dried Chili"
      },
      "image": "{{ asset('images/product_hero.png') }}",
      "description": "Handcrafted premium dried chillies, shrimp chilli paste, and authentic organic seasonings."
    },
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}#website",
      "url": "{{ url('/') }}",
      "name": "Dried Chili",
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
