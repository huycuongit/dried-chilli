@extends('frontend.layouts.master')

@section('title', 'Our Legacy | Roots & Terroir | Dried Chili')
@section('meta_description', 'Discover the 100-year legacy behind Dried Chili: four generations of heirloom farming, ancestral 21-day solar curing, and the sacred valley terroir that gives our chili its legendary flavor.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v={{ time() }}">
@endpush

@php
    $pageLayoutGroups = json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR);
    $pageLayoutFields = collect($pageLayoutGroups)->collapse()->all();
    $pageLayoutValue = static fn (string $key) => \App\Support\AboutPageContent::value($key, $pageLayoutFields, $systemSettings);
    $pageLayoutLink = static function (string $key) use ($pageLayoutValue) {
        $link = trim($pageLayoutValue($key));
        return preg_match('~^(?:/(?!/)|https?://|#)~i', $link) ? $link : '#';
    };
@endphp

@section('full-content')
<main class="page-content about-page legacy-page">

    <!-- HERO SECTION: Vintage Terroir, Refined & Strictly 650px on Desktop -->
    @if($pageLayoutValue('page_layout_legacy_show_hero') === '1')
    <section class="about-hero-section legacy-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge legacy-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span>{{ $pageLayoutValue('page_layout_legacy_opening_banner_01') }}</span>
            </div>
            
            <h1 class="about-hero-title">
                {{ $pageLayoutValue('page_layout_legacy_opening_banner_02') }}<br>
                <span class="highlight-gold">{{ $pageLayoutValue('page_layout_legacy_opening_banner_03') }}</span>
            </h1>
            
            <p class="about-hero-desc">
                {{ $pageLayoutValue('page_layout_legacy_opening_banner_04') }}
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $pageLayoutValue('page_layout_legacy_opening_banner_05') }}</strong>
                        <span>{{ $pageLayoutValue('page_layout_legacy_opening_banner_06') }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $pageLayoutValue('page_layout_legacy_opening_banner_07') }}</strong>
                        <span>{{ $pageLayoutValue('page_layout_legacy_opening_banner_08') }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $pageLayoutValue('page_layout_legacy_opening_banner_09') }}</strong>
                        <span>{{ $pageLayoutValue('page_layout_legacy_opening_banner_10') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- NAVIGATION ANCHORS (Quick Jump Bar) -->
    <nav class="about-quick-nav">
        <div class="container quick-nav-flex">
            @if($pageLayoutValue('page_layout_legacy_show_origin') === '1')
            <a href="#origin-valley" class="quick-nav-item">
                <span class="nav-step">01</span>
                <span class="nav-label">{{ $pageLayoutValue('page_layout_legacy_quick_links_01') }}</span>
            </a>
            @endif
            <div class="quick-nav-divider"></div>
            @if($pageLayoutValue('page_layout_legacy_show_timeline') === '1')
            <a href="#century-chronicle" class="quick-nav-item">
                <span class="nav-step">02</span>
                <span class="nav-label">{{ $pageLayoutValue('page_layout_legacy_quick_links_02') }}</span>
            </a>
            @endif
            <div class="quick-nav-divider"></div>
            @if($pageLayoutValue('page_layout_legacy_show_sun') === '1')
            <a href="#sun-vs-machine" class="quick-nav-item">
                <span class="nav-step">03</span>
                <span class="nav-label">{{ $pageLayoutValue('page_layout_legacy_quick_links_03') }}</span>
            </a>
            @endif
            <div class="quick-nav-divider"></div>
            @if($pageLayoutValue('page_layout_legacy_show_heritage') === '1')
            <a href="#heritage-code" class="quick-nav-item">
                <span class="nav-step">04</span>
                <span class="nav-label">{{ $pageLayoutValue('page_layout_legacy_quick_links_04') }}</span>
            </a>
            @endif
        </div>
    </nav>

    <!-- ========================================================================= -->
    <!-- PILLAR 1: THE ORIGIN VALLEY & HEIRLOOM SOIL -->
    <!-- ========================================================================= -->
    @if($pageLayoutValue('page_layout_legacy_show_origin') === '1')
    <section id="origin-valley" class="about-pillar-section bg-cream">
        <div class="container">
            <div class="pillar-grid align-center">
                
                <!-- Left: Storytelling Narrative -->
                <div class="pillar-content">
                    <div class="pillar-tag">
                        <span class="tag-number">01</span>
                        <span class="tag-text">{{ $pageLayoutValue('page_layout_legacy_origin_valley_01') }}</span>
                    </div>
                    <h2 class="pillar-heading">
                        {{ $pageLayoutValue('page_layout_legacy_origin_valley_02') }} 
                    </h2>
                    
                    <div class="pillar-body">
                        <p class="lead-text">
                            <strong>{{ $pageLayoutValue('page_layout_legacy_origin_valley_03') }}</strong> {{ $pageLayoutValue('page_layout_legacy_origin_valley_04') }}
                        </p>
                        <p>
                            {{ $pageLayoutValue('page_layout_legacy_origin_valley_05') }}
                        </p>
                        <p>
                            {{ $pageLayoutValue('page_layout_legacy_origin_valley_06') }}
                        </p>
                    </div>

                    <!-- Core Identity Highlights with Lucide Icons -->
                    <div class="identity-features">
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>{{ $pageLayoutValue('page_layout_legacy_origin_valley_07') }}</h4>
                                <p>{{ $pageLayoutValue('page_layout_legacy_origin_valley_08') }}</p>
                            </div>
                        </div>
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4.1 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>{{ $pageLayoutValue('page_layout_legacy_origin_valley_09') }}</h4>
                                <p>{{ $pageLayoutValue('page_layout_legacy_origin_valley_10') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual Composition -->
                <div class="pillar-visual">
                    <div class="visual-card-wrapper">
                        <div class="visual-card-main">
                            @if($pageLayoutValue('page_layout_legacy_image_farm') !== '')<img src="{{ asset($pageLayoutValue('page_layout_legacy_image_farm')) }}" alt="Our Ancestral Chili Farm" class="card-img-large">@endif
                        </div>
                        <div class="visual-card-quote">
                            <p class="quote-text">
                                {{ $pageLayoutValue('page_layout_legacy_origin_valley_11') }}
                            </p>
                            <span class="quote-author">{{ $pageLayoutValue('page_layout_legacy_origin_valley_12') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 2: THE CENTURY CHRONICLE (INTERACTIVE HERITAGE TIMELINE) -->
    <!-- ========================================================================= -->
    @if($pageLayoutValue('page_layout_legacy_show_timeline') === '1')
    <section id="century-chronicle" class="about-pillar-section bg-alt">
        <div class="container">
            
            <!-- Section Header -->
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">02</span>
                    <span class="tag-text">{{ $pageLayoutValue('page_layout_legacy_family_timeline_01') }}</span>
                </div>
                <h2 class="pillar-heading">
                    {{ $pageLayoutValue('page_layout_legacy_family_timeline_02') }} <br class="d-none d-md-block">
                    {{ $pageLayoutValue('page_layout_legacy_family_timeline_03') }}
                </h2>
                <p class="section-subtitle">
                    {{ $pageLayoutValue('page_layout_legacy_family_timeline_04') }}
                </p>
            </div>

            <!-- Distinctive Heritage Timeline -->
            <div class="legacy-timeline">
                
                <!-- 1920 -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_05') }}
                        </span>
                        <h3 class="timeline-title">{{ $pageLayoutValue('page_layout_legacy_family_timeline_06') }}</h3>
                        <p class="timeline-desc">
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_07') }}
                        </p>
                    </div>
                </div>

                <!-- 1958 -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/></svg>
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_08') }}
                        </span>
                        <h3 class="timeline-title">{{ $pageLayoutValue('page_layout_legacy_family_timeline_09') }}</h3>
                        <p class="timeline-desc">
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_10') }}
                        </p>
                    </div>
                </div>

                <!-- 1994 -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_11') }}
                        </span>
                        <h3 class="timeline-title">{{ $pageLayoutValue('page_layout_legacy_family_timeline_12') }}</h3>
                        <p class="timeline-desc">
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_13') }}
                        </p>
                    </div>
                </div>

                <!-- Present Day -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_14') }}
                        </span>
                        <h3 class="timeline-title">{{ $pageLayoutValue('page_layout_legacy_family_timeline_15') }}</h3>
                        <p class="timeline-desc">
                            {{ $pageLayoutValue('page_layout_legacy_family_timeline_16') }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 3: THE METHOD CONTRAST (SUN-CURING VS. MACHINE DEHYDRATION) -->
    <!-- ========================================================================= -->
    @if($pageLayoutValue('page_layout_legacy_show_sun') === '1')
    <section id="sun-vs-machine" class="about-pillar-section bg-cream">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">03</span>
                    <span class="tag-text">{{ $pageLayoutValue('page_layout_legacy_sun_drying_01') }}</span>
                </div>
                <h2 class="pillar-heading">
                    {{ $pageLayoutValue('page_layout_legacy_sun_drying_02') }} <br class="d-none d-md-block">
                    {{ $pageLayoutValue('page_layout_legacy_sun_drying_03') }}
                </h2>
                <p class="section-subtitle">
                    {{ $pageLayoutValue('page_layout_legacy_sun_drying_04') }}
                </p>
            </div>

            <!-- Distinctive Method Contrast Grid -->
            <div class="method-contrast-grid">
                
                <!-- Our Way: 21-Day Solar Cure -->
                <div class="contrast-card craft-card">
                    <span class="contrast-badge craft-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $pageLayoutValue('page_layout_legacy_sun_drying_05') }}
                    </span>
                    <h3 class="contrast-heading">{{ $pageLayoutValue('page_layout_legacy_sun_drying_06') }}</h3>
                    
                    <ul class="contrast-list">
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_07') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_08') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_09') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_10') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_11') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_12') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_13') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_14') }}
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Industrial Way -->
                <div class="contrast-card factory-card">
                    <span class="contrast-badge factory-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        {{ $pageLayoutValue('page_layout_legacy_sun_drying_15') }}
                    </span>
                    <h3 class="contrast-heading">{{ $pageLayoutValue('page_layout_legacy_sun_drying_16') }}</h3>
                    
                    <ul class="contrast-list">
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_17') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_18') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_19') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_20') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_21') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_22') }}
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>{{ $pageLayoutValue('page_layout_legacy_sun_drying_23') }}</strong>
                                {{ $pageLayoutValue('page_layout_legacy_sun_drying_24') }}
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 4: THE FOUR TENETS & FOUNDER'S PLEDGE -->
    <!-- ========================================================================= -->
    @if($pageLayoutValue('page_layout_legacy_show_heritage') === '1')
    <section id="heritage-code" class="about-pillar-section bg-alt">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">04</span>
                    <span class="tag-text">{{ $pageLayoutValue('page_layout_legacy_heritage_values_01') }}</span>
                </div>
                <h2 class="pillar-heading">
                    {{ $pageLayoutValue('page_layout_legacy_heritage_values_02') }}
                </h2>
                <p class="section-subtitle">
                    {{ $pageLayoutValue('page_layout_legacy_heritage_values_03') }}
                </p>
            </div>

            <!-- The 4 Tenets Grid -->
            <div class="trust-cards-grid">
                
                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/></svg>
                        </div>
                        <span class="trust-number-badge">{{ $pageLayoutValue('page_layout_legacy_heritage_values_04') }}</span>
                    </div>
                    <h3 class="trust-card-title">{{ $pageLayoutValue('page_layout_legacy_heritage_values_05') }}</h3>
                    <p class="trust-card-desc">
                        {{ $pageLayoutValue('page_layout_legacy_heritage_values_06') }}
                    </p>
                </div>

                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/></svg>
                        </div>
                        <span class="trust-number-badge">{{ $pageLayoutValue('page_layout_legacy_heritage_values_07') }}</span>
                    </div>
                    <h3 class="trust-card-title">{{ $pageLayoutValue('page_layout_legacy_heritage_values_08') }}</h3>
                    <p class="trust-card-desc">
                        {{ $pageLayoutValue('page_layout_legacy_heritage_values_09') }}
                    </p>
                </div>

                <div class="trust-card highlight-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="trust-number-badge">{{ $pageLayoutValue('page_layout_legacy_heritage_values_10') }}</span>
                    </div>
                    <h3 class="trust-card-title">{{ $pageLayoutValue('page_layout_legacy_heritage_values_11') }}</h3>
                    <p class="trust-card-desc">
                        {{ $pageLayoutValue('page_layout_legacy_heritage_values_12') }}
                    </p>
                </div>

                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <span class="trust-number-badge">{{ $pageLayoutValue('page_layout_legacy_heritage_values_13') }}</span>
                    </div>
                    <h3 class="trust-card-title">{{ $pageLayoutValue('page_layout_legacy_heritage_values_14') }}</h3>
                    <p class="trust-card-desc">
                        {{ $pageLayoutValue('page_layout_legacy_heritage_values_15') }}
                    </p>
                </div>

            </div>

            <!-- Archival Founder's Manifesto & Family Seal -->
            <div class="founder-manifesto-box">
                <div class="manifesto-header">
                    <div class="manifesto-seal">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="manifesto-title">
                        <h3>{{ $pageLayoutValue('page_layout_legacy_heritage_values_16') }}</h3>
                        <span>{{ $pageLayoutValue('page_layout_legacy_heritage_values_17') }}</span>
                    </div>
                </div>

                <p class="manifesto-body">
                    {{ $pageLayoutValue('page_layout_legacy_heritage_values_18') }}
                </p>

                <div class="manifesto-signature">
                    <span>{{ $pageLayoutValue('page_layout_legacy_heritage_values_19') }}</span>
                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- CALL TO ACTION (TASTE THE HERITAGE) -->
    <!-- ========================================================================= -->
    @if($pageLayoutValue('page_layout_legacy_show_cta') === '1')
    <section class="about-cta-section">
        <div class="container">
            <div class="cta-inner-card">
                <div class="cta-content">
                    <span class="cta-mini-pill">
                        {{ $pageLayoutValue('page_layout_legacy_closing_banner_01') }}
                    </span>
                    <h2 class="cta-title">
                        {{ $pageLayoutValue('page_layout_legacy_closing_banner_02') }} <br class="d-none d-md-block">
                        {{ $pageLayoutValue('page_layout_legacy_closing_banner_03') }}
                    </h2>
                    <p class="cta-desc">
                        {{ $pageLayoutValue('page_layout_legacy_closing_banner_04') }} <strong>{{ $pageLayoutValue('page_layout_legacy_closing_banner_05') }}</strong> {{ $pageLayoutValue('page_layout_legacy_closing_banner_06') }} <strong>{{ $pageLayoutValue('page_layout_legacy_free_shipping') }}</strong>.
                    </p>
                    <div class="cta-actions">
                        <a href="{{ $pageLayoutLink('page_layout_legacy_cta_primary_link') }}" class="btn-cta-primary">
                            <span>{{ $pageLayoutValue('page_layout_legacy_closing_banner_07') }}</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="{{ $pageLayoutLink('page_layout_legacy_cta_secondary_link') }}" class="btn-cta-secondary">
                            <span>{{ $pageLayoutValue('page_layout_legacy_closing_banner_08') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'Our Legacy'])
</main>
@endsection
