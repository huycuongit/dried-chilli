@extends('frontend.layouts.master')

@section('title', 'Why Dried Chili? | Our Story')
@section('meta_description', 'Discover the story behind Dried Chili: Who we are, our small-batch artisanal spice craft, and why over 150,000 food lovers trust us to bring heat and umami to their tables.')

@php
    $aboutSections = json_decode(file_get_contents(config_path('about-layout.json')), true, 512, JSON_THROW_ON_ERROR);
    $aboutFields = collect($aboutSections)->collapse()->all();
    $aboutValue = static function (string $key) use ($aboutFields, $systemSettings) {
        return \App\Support\AboutPageContent::value($key, $aboutFields, $systemSettings);
    };
    $aboutLink = static function (string $key) use ($aboutValue) {
        $link = trim($aboutValue($key));
        return preg_match('~^(?:/(?!/)|https?://|#)~i', $link) ? $link : '#';
    };
    $customAboutSections = collect(\App\Support\PageContentGroups::sections())
        ->filter(fn ($fields, $name) => str_starts_with($name, 'About Us - Section '));
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v={{ time() }}">
@endpush

@section('full-content')
<main class="page-content about-page">

    <!-- HERO SECTION: Minimalist, Refined & Confident -->
    @if($aboutValue('page_about_layout_show_hero') === '1')
    <section class="about-hero-section">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <span>{{ $aboutValue('page_about_layout_hero_10') }}</span>
            </div>
            
            <h1 class="about-hero-title">
                {{ $aboutValue('page_about_layout_hero_09') }}<br>
                <span class="highlight-gold">{{ $aboutValue('page_about_layout_hero_08') }}</span>
            </h1>
            
            <p class="about-hero-desc">
                {{ $aboutValue('page_about_layout_hero_07') }}
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $aboutValue('page_about_layout_hero_06') }}</strong>
                        <span>{{ $aboutValue('page_about_layout_hero_05') }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $aboutValue('page_about_layout_hero_04') }}</strong>
                        <span>{{ $aboutValue('page_about_layout_hero_03') }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $aboutValue('page_about_layout_hero_02') }}</strong>
                        <span>{{ $aboutValue('page_about_layout_hero_01') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- NAVIGATION ANCHORS (Quick Jump Bar) -->
    @if($aboutValue('page_about_layout_show_identity') === '1' || $aboutValue('page_about_layout_show_craft') === '1' || $aboutValue('page_about_layout_show_trust') === '1')
    <nav class="about-quick-nav">
        <div class="container quick-nav-flex">
            @if($aboutValue('page_about_layout_show_identity') === '1')
            <a href="#who-we-are" class="quick-nav-item">
                <span class="nav-step">01</span>
                <span class="nav-label">{{ $aboutValue('page_about_layout_navigation_03') }}</span>
            </a>
            @endif
            @if($aboutValue('page_about_layout_show_identity') === '1' && ($aboutValue('page_about_layout_show_craft') === '1' || $aboutValue('page_about_layout_show_trust') === '1'))<div class="quick-nav-divider"></div>@endif
            @if($aboutValue('page_about_layout_show_craft') === '1')
            <a href="#what-we-do" class="quick-nav-item">
                <span class="nav-step">02</span>
                <span class="nav-label">{{ $aboutValue('page_about_layout_navigation_02') }}</span>
            </a>
            @endif
            @if($aboutValue('page_about_layout_show_craft') === '1' && $aboutValue('page_about_layout_show_trust') === '1')<div class="quick-nav-divider"></div>@endif
            @if($aboutValue('page_about_layout_show_trust') === '1')
            <a href="#why-trust-us" class="quick-nav-item">
                <span class="nav-step">03</span>
                <span class="nav-label">{{ $aboutValue('page_about_layout_navigation_01') }}</span>
            </a>
            @endif
        </div>
    </nav>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 1: WHO WE ARE (OUR IDENTITY) -->
    <!-- ========================================================================= -->
    @if($aboutValue('page_about_layout_show_identity') === '1')
    <section id="who-we-are" class="about-pillar-section bg-cream">
        <div class="container">
            <div class="pillar-grid align-center {{ $aboutValue('page_about_layout_identity_position') === 'left' ? 'about-identity-image-left' : '' }}">
                
                <!-- Left: Storytelling Narrative -->
                <div class="pillar-content">
                    <div class="pillar-tag">
                        <span class="tag-number">01</span>
                        <span class="tag-text">{{ $aboutValue('page_about_layout_who_we_are_15') }}</span>
                    </div>
                    <h2 class="pillar-heading">
                        {{ $aboutValue('page_about_layout_who_we_are_14') }} <br>
                        {{ $aboutValue('page_about_layout_who_we_are_13') }}
                    </h2>
                    
                    <div class="pillar-body">
                        <p class="lead-text">
                            {{ $aboutValue('page_about_layout_identity_lead') }}
                        </p>
                        <p>
                            {{ $aboutValue('page_about_layout_who_we_are_08') }}
                        </p>
                        <p>
                            {{ $aboutValue('page_about_layout_who_we_are_07') }}
                        </p>
                    </div>

                    <!-- Core Identity Highlights with Lucide Icons -->
                    <div class="identity-features">
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8Z"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>{{ $aboutValue('page_about_layout_who_we_are_06') }}</h4>
                                <p>{{ $aboutValue('page_about_layout_who_we_are_05') }}</p>
                            </div>
                        </div>
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>{{ $aboutValue('page_about_layout_who_we_are_04') }}</h4>
                                <p>{{ $aboutValue('page_about_layout_who_we_are_03') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual Composition -->
                <div class="pillar-visual">
                    <div class="visual-card-wrapper">
                        <div class="visual-card-main">
                            @if($aboutValue('page_about_layout_image_founders') !== '')<img src="{{ asset($aboutValue('page_about_layout_image_founders')) }}" alt="Dried Chili Artisans" class="card-img-large">@endif
                        </div>
                        <div class="visual-card-quote">
                            <p class="quote-text">
                                {{ $aboutValue('page_about_layout_who_we_are_02') }}
                            </p>
                            <span class="quote-author">{{ $aboutValue('page_about_layout_who_we_are_01') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 2: WHAT WE DO (OUR CRAFT) -->
    <!-- ========================================================================= -->
    @if($aboutValue('page_about_layout_show_craft') === '1')
    <section id="what-we-do" class="about-pillar-section bg-alt">
        <div class="container">
            
            <!-- Section Header -->
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">02</span>
                    <span class="tag-text">{{ $aboutValue('page_about_layout_what_we_do_30') }}</span>
                </div>
                <h2 class="pillar-heading">
                    {{ $aboutValue('page_about_layout_what_we_do_29') }} <br class="d-none d-md-block">
                    {{ $aboutValue('page_about_layout_what_we_do_28') }}
                </h2>
                <p class="section-subtitle">
                    {{ $aboutValue('page_about_layout_what_we_do_27') }}
                </p>
            </div>

            <!-- The 4-Step Artisanal Process with Lucide Icons -->
            <div class="process-grid">
                
                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        </div>
                        <span class="step-badge">{{ $aboutValue('page_about_layout_what_we_do_26') }}</span>
                    </div>
                    <h3 class="step-title">{{ $aboutValue('page_about_layout_what_we_do_25') }}</h3>
                    <p class="step-desc">
                        {{ $aboutValue('page_about_layout_what_we_do_24') }}
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/></svg>
                        </div>
                        <span class="step-badge">{{ $aboutValue('page_about_layout_what_we_do_23') }}</span>
                    </div>
                    <h3 class="step-title">{{ $aboutValue('page_about_layout_what_we_do_22') }}</h3>
                    <p class="step-desc">
                        {{ $aboutValue('page_about_layout_what_we_do_21') }}
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="M4 10h16"/><path d="M5 10v6a7 7 0 0 0 14 0v-6"/><path d="M9 16h6"/></svg>
                        </div>
                        <span class="step-badge">{{ $aboutValue('page_about_layout_what_we_do_20') }}</span>
                    </div>
                    <h3 class="step-title">{{ $aboutValue('page_about_layout_what_we_do_19') }}</h3>
                    <p class="step-desc">
                        {{ $aboutValue('page_about_layout_what_we_do_18') }}
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 2 2 4-4"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>
                        </div>
                        <span class="step-badge">{{ $aboutValue('page_about_layout_what_we_do_17') }}</span>
                    </div>
                    <h3 class="step-title">{{ $aboutValue('page_about_layout_what_we_do_16') }}</h3>
                    <p class="step-desc">
                        {{ $aboutValue('page_about_layout_what_we_do_15') }}
                    </p>
                </div>

            </div>

            <!-- 3 Core Product Lines Showcase -->
            <div class="showcase-banner">
                <div class="showcase-banner-header">
                    <h3>{{ $aboutValue('page_about_layout_what_we_do_14') }}</h3>
                    <p>{{ $aboutValue('page_about_layout_what_we_do_13') }}</p>
                </div>

                <div class="showcase-cards-grid">
                    
                    <!-- Product 1 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            @if($aboutValue('page_about_layout_image_product_1') !== '')<img src="{{ asset($aboutValue('page_about_layout_image_product_1')) }}" alt="Crispy Garlic Chili Crisp">@endif
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">{{ $aboutValue('page_about_layout_what_we_do_12') }}</span>
                            <h4>{{ $aboutValue('page_about_layout_what_we_do_11') }}</h4>
                            <p>{{ $aboutValue('page_about_layout_what_we_do_10') }}</p>
                            <a href="{{ $aboutLink('page_about_layout_product_link_1') }}" class="mini-card-link">{{ $aboutValue('page_about_layout_what_we_do_09') }}</a>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            @if($aboutValue('page_about_layout_image_product_2') !== '')<img src="{{ asset($aboutValue('page_about_layout_image_product_2')) }}" alt="Artisanal Umami Shrimp Chili">@endif
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">{{ $aboutValue('page_about_layout_what_we_do_08') }}</span>
                            <h4>{{ $aboutValue('page_about_layout_what_we_do_07') }}</h4>
                            <p>{{ $aboutValue('page_about_layout_what_we_do_06') }}</p>
                            <a href="{{ $aboutLink('page_about_layout_product_link_2') }}" class="mini-card-link">{{ $aboutValue('page_about_layout_what_we_do_05') }}</a>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            @if($aboutValue('page_about_layout_image_product_3') !== '')<img src="{{ asset($aboutValue('page_about_layout_image_product_3')) }}" alt="Fire-Roasted Chili Powders">@endif
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">{{ $aboutValue('page_about_layout_what_we_do_04') }}</span>
                            <h4>{{ $aboutValue('page_about_layout_what_we_do_03') }}</h4>
                            <p>{{ $aboutValue('page_about_layout_what_we_do_02') }}</p>
                            <a href="{{ $aboutLink('page_about_layout_product_link_3') }}" class="mini-card-link">{{ $aboutValue('page_about_layout_what_we_do_01') }}</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- PILLAR 3: WHY TRUST US (TRANSPARENCY & PROOF) -->
    <!-- ========================================================================= -->
    @if($aboutValue('page_about_layout_show_trust') === '1')
    <section id="why-trust-us" class="about-pillar-section bg-cream">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">03</span>
                    <span class="tag-text">{{ $aboutValue('page_about_layout_why_trust_us_28') }}</span>
                </div>
                <h2 class="pillar-heading">
                    {{ $aboutValue('page_about_layout_why_trust_us_27') }} <br class="d-none d-md-block">
                    {{ $aboutValue('page_about_layout_why_trust_us_26') }}
                </h2>
                <p class="section-subtitle">
                    {{ $aboutValue('page_about_layout_why_trust_us_25') }}
                </p>
            </div>

            <!-- The 4 Pillars of Trust Grid with Lucide Icons -->
            <div class="trust-cards-grid">
                
                <!-- Trust 1: Numbers & Social Proof -->
                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                        </div>
                        <span class="trust-number-badge">{{ $aboutValue('page_about_layout_why_trust_us_24') }}</span>
                    </div>
                    <h3 class="trust-card-title">{{ $aboutValue('page_about_layout_why_trust_us_23') }}</h3>
                    <p class="trust-card-desc">
                        {{ $aboutValue('page_about_layout_why_trust_us_22') }}
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ $aboutValue('page_about_layout_why_trust_us_21') }}
                        </span>
                    </div>
                </div>

                <!-- Trust 2: Direct-Trade & Fair Sourcing -->
                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 0 0 1.4 0l4.3-4.3a1 1 0 0 0 0-1.4l-2.6-2.6a1 1 0 0 0-1.4 0L11 14"/><path d="m13 11 1.5-1.5a1 1 0 0 0 0-1.4L13 6.6a1 1 0 0 0-1.4 0L6 12.2a2 2 0 0 0 0 2.8l2 2a2 2 0 0 0 2.8 0L13 15"/><path d="m18 11 3-3a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0l-3 3"/><path d="m2 16 3-3a1 1 0 0 1 1.4 0l2 2"/></svg>
                        </div>
                    </div>
                    <h3 class="trust-card-title">{{ $aboutValue('page_about_layout_why_trust_us_20') }}</h3>
                    <p class="trust-card-desc">
                        {{ $aboutValue('page_about_layout_why_trust_us_19') }}
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ $aboutValue('page_about_layout_why_trust_us_18') }}
                        </span>
                    </div>
                </div>

                <!-- Trust 3: Absolute 3-NO Guarantee -->
                <div class="trust-card highlight-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                    </div>
                    <h3 class="trust-card-title">{{ $aboutValue('page_about_layout_why_trust_us_17') }}</h3>
                    <p class="trust-card-desc">
                        {{ $aboutValue('page_about_layout_why_trust_us_16') }}
                    </p>
                    <ul class="trust-strict-list">
                        <li><strong>{{ $aboutValue('page_about_layout_why_trust_us_15') }}</strong> {{ $aboutValue('page_about_layout_why_trust_us_14') }}</li>
                        <li><strong>{{ $aboutValue('page_about_layout_why_trust_us_13') }}</strong> {{ $aboutValue('page_about_layout_why_trust_us_12') }}</li>
                        <li><strong>{{ $aboutValue('page_about_layout_why_trust_us_11') }}</strong> {{ $aboutValue('page_about_layout_why_trust_us_10') }}</li>
                    </ul>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ $aboutValue('page_about_layout_why_trust_us_09') }}
                        </span>
                    </div>
                </div>

                <!-- Trust 4: 100% Flavor Guarantee -->
                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                    </div>
                    <h3 class="trust-card-title">{{ $aboutValue('page_about_layout_why_trust_us_08') }}</h3>
                    <p class="trust-card-desc">
                        {{ $aboutValue('page_about_layout_guarantee_description') }}
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            {{ $aboutValue('page_about_layout_why_trust_us_04') }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Customer & Chef Testimonial Spotlight with Lucide Icons -->
            <div class="testimonial-spotlight-box">
                <div class="spotlight-quote-icon">“</div>
                <div class="spotlight-content">
                    <p class="spotlight-text">
                        {{ $aboutValue('page_about_layout_why_trust_us_03') }}
                    </p>
                    <div class="spotlight-author-info">
                        <div class="author-avatar-badge">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 13.8a4.4 4.4 0 0 1-3-4.3c0-2.4 2-4.5 4.5-4.5.3 0 .7 0 1 .1A6 6 0 0 1 18 6.5a4.4 4.4 0 0 1 3 4.3 4.4 4.4 0 0 1-3 4.3"/><path d="M6 14h12v4a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-4z"/><line x1="6" y1="17" x2="18" y2="17"/></svg>
                        </div>
                        <div>
                            <strong>{{ $aboutValue('page_about_layout_why_trust_us_02') }}</strong>
                            <span>{{ $aboutValue('page_about_layout_why_trust_us_01') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- ========================================================================= -->
    <!-- CALL TO ACTION (TASTE THE CRAFT) -->
    <!-- ========================================================================= -->
    @foreach($customAboutSections as $sectionFields)
        @php
            $activeKey = collect(array_keys($sectionFields))->first(fn ($key) => str_ends_with($key, '_published'));
            $prefix = $activeKey ? substr($activeKey, 0, -10) : '';
            $customValue = static function (string $suffix) use ($prefix, $sectionFields, $systemSettings) {
                $key = $prefix . '_' . $suffix;
                return (string) ($systemSettings['nafu_home_' . $key] ?? $sectionFields[$key]['value'] ?? '');
            };
        @endphp
        @if($activeKey && $customValue('published') === '1')
            @php
                $purifierConfig = \HTMLPurifier_Config::createDefault();
                $purifierConfig->set('Cache.DefinitionImpl', null);
                $purifier = new \HTMLPurifier($purifierConfig);
                $layout = $customValue('layout');
                $image = $customValue('image');
            @endphp
            <section class="about-pillar-section bg-alt about-custom-section">
                <div class="container">
                    @if($customValue('type') === 'card')
                        <div class="section-center-head"><h2 class="pillar-heading">{{ $customValue('title') }}</h2><p>{{ $customValue('text') }}</p></div>
                        <div class="about-custom-cards">
                            @for($index = 1; $index <= 3; $index++)
                                <article class="trust-card"><span>{{ $customValue('icon_' . $index) }}</span><h3>{{ $customValue('title_' . $index) }}</h3><p>{{ $customValue('text_' . $index) }}</p></article>
                            @endfor
                        </div>
                    @else
                        <div class="about-custom-grid {{ $layout === 'full-text' || !$image ? 'about-custom-full' : '' }} {{ $layout === 'reverse' ? 'about-custom-image-right' : '' }}">
                            @if($image && $layout !== 'full-text')<img src="{{ asset($image) }}" alt="" loading="lazy" decoding="async">@endif
                            <div><h2 class="pillar-heading">{{ $customValue('title') }}</h2><div class="about-custom-content">{!! $purifier->purify($customValue('text')) !!}</div></div>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endforeach
    @if($aboutValue('page_about_layout_show_cta') === '1')
    <section class="about-cta-section">
        <div class="container">
            <div class="cta-inner-card">
                <div class="cta-content">
                    <span class="cta-mini-pill">
                        {{ $aboutValue('page_about_layout_call_to_action_09') }}
                    </span>
                    <h2 class="cta-title">
                        {{ $aboutValue('page_about_layout_call_to_action_08') }} <br class="d-none d-md-block">
                        {{ $aboutValue('page_about_layout_call_to_action_07') }}
                    </h2>
                    <p class="cta-desc">
                        {{ $aboutValue('page_about_layout_cta_description') }}
                    </p>
                    <div class="cta-actions">
                        <a href="{{ $aboutLink('page_about_layout_cta_primary_link') }}" class="btn-cta-primary">
                            <span>{{ $aboutValue('page_about_layout_call_to_action_02') }}</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="{{ $aboutLink('page_about_layout_cta_secondary_link') }}" class="btn-cta-secondary">
                            <span>{{ $aboutValue('page_about_layout_call_to_action_01') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

</main>
@endsection
