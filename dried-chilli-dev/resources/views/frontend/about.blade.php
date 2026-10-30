@extends('frontend.layouts.master')

@section('meta')
<title>Why Dried Chili? | Our Story</title>
<meta name="description" content="Discover the story behind Dried Chili: Who we are, our small-batch artisanal spice craft, and why over 150,000 food lovers trust us to bring heat and umami to their tables.">
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v={{ time() }}">
@endpush

@section('full-content')
<main class="page-content about-page">

    <!-- HERO SECTION: Minimalist, Refined & Confident -->
    <section class="about-hero-section">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <span>OUR STORY · HANDCRAFTED SPICY GOODS</span>
            </div>
            
            <h1 class="about-hero-title">
                Small-Batch Heat<br>
                <span class="highlight-gold">Uncompromising Flavor</span>
            </h1>
            
            <p class="about-hero-desc">
                We craft small-batch condiments using sun-dried chillies, golden crispy garlic, and rich natural umami — dedicated to elevating everyday meals with authentic Asian spice craft
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>100% Natural</strong>
                        <span>Raw Ingredients</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Small-Batch</strong>
                        <span>Stone-Ground</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>150,000+ Jars</strong>
                        <span>Delivered</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NAVIGATION ANCHORS (Quick Jump Bar) -->
    <nav class="about-quick-nav">
        <div class="container quick-nav-flex">
            <a href="#who-we-are" class="quick-nav-item">
                <span class="nav-step">01</span>
                <span class="nav-label">Who We Are</span>
            </a>
            <div class="quick-nav-divider"></div>
            <a href="#what-we-do" class="quick-nav-item">
                <span class="nav-step">02</span>
                <span class="nav-label">What We Do</span>
            </a>
            <div class="quick-nav-divider"></div>
            <a href="#why-trust-us" class="quick-nav-item">
                <span class="nav-step">03</span>
                <span class="nav-label">Why Trust Us</span>
            </a>
        </div>
    </nav>

    <!-- ========================================================================= -->
    <!-- PILLAR 1: WHO WE ARE (OUR IDENTITY) -->
    <!-- ========================================================================= -->
    <section id="who-we-are" class="about-pillar-section bg-cream">
        <div class="container">
            <div class="pillar-grid align-center">
                
                <!-- Left: Storytelling Narrative -->
                <div class="pillar-content">
                    <div class="pillar-tag">
                        <span class="tag-number">01</span>
                        <span class="tag-text">WHO WE ARE · OUR IDENTITY</span>
                    </div>
                    <h2 class="pillar-heading">
                        Small-Kitchen Artisans <br>
                        Keeping The Culinary Fire Alive
                    </h2>
                    
                    <div class="pillar-body">
                        <p class="lead-text">
                            <strong>Dried Chili</strong> (born out of the <em>Jojo Little Kitchen</em> family) didn't start in an industrial laboratory or an automated packaging line. We started at the family stove, driven by an uncompromising love for authentic Asian spice craftsmanship.
                        </p>
                        <p>
                            Years ago, we grew tired of mainstream supermarket chilli oils loaded with artificial preservatives, synthetic colorants, and the cloying sweetness of flavor enhancers. Real heat — that fragrant, smoky warmth of sun-dried chillies that gently warms your palate and awakens every sense — had been lost in the pursuit of mass manufacturing.
                        </p>
                        <p>
                            We chose to return to the source: tracking down heirloom chilli varieties, honoring the slow-roasting techniques passed down by our grandmothers, and perfecting every step to meet the uncompromising standards of modern food lovers.
                        </p>
                    </div>

                    <!-- Core Identity Highlights with Lucide Icons -->
                    <div class="identity-features">
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8Z"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>Chef-Crafted Recipes</h4>
                                <p>Every formulation is refined through hundreds of kitchen tastings to achieve the golden balance of Heat, Crunch, and Umami.</p>
                            </div>
                        </div>
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>Batches Under 200 Jars</h4>
                                <p>No shortcuts. Every batch is tended by hand over gentle heat to prevent bitterness and ensure our garlic turns golden-crisp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual Composition -->
                <div class="pillar-visual">
                    <div class="visual-card-wrapper">
                        <div class="visual-card-main">
                            <img src="{{ asset('images/about_founders.jpg') }}" alt="Dried Chili Artisans" class="card-img-large">
                        </div>
                        <div class="visual-card-quote">
                            <p class="quote-text">
                                “To us, spicy food isn't an endurance test. It's a multisensory spark that elevates every meal on your family table.”
                            </p>
                            <span class="quote-author">— The Dried Chili Founding Team —</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- PILLAR 2: WHAT WE DO (OUR CRAFT) -->
    <!-- ========================================================================= -->
    <section id="what-we-do" class="about-pillar-section bg-alt">
        <div class="container">
            
            <!-- Section Header -->
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">02</span>
                    <span class="tag-text">WHAT WE DO · OUR CRAFT</span>
                </div>
                <h2 class="pillar-heading">
                    Handcrafted In Small Batches <br class="d-none d-md-block">
                    Fresh, Pure & Crunchy To The Very Last Spoon
                </h2>
                <p class="section-subtitle">
                    We turn sun-ripened chillies into pantry essentials that elevate everything from late-night ramen and crispy fried eggs to family holiday feasts.
                </p>
            </div>

            <!-- The 4-Step Artisanal Process with Lucide Icons -->
            <div class="process-grid">
                
                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        </div>
                        <span class="step-badge">STEP 01</span>
                    </div>
                    <h3 class="step-title">Sun-Ripened Selection</h3>
                    <p class="step-desc">
                        We harvest only uniformly ripe chillies from clean agricultural partners, naturally sun-drying them to concentrate their volatile essential oils and distinctive fiery aroma.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/></svg>
                        </div>
                        <span class="step-badge">STEP 02</span>
                    </div>
                    <h3 class="step-title">Roasting & Stone Crushing</h3>
                    <p class="step-desc">
                        Chillies are gently roasted over low embers to release deep smoky notes, then coarsely crushed using traditional stone mills to preserve light, crispy flakes instead of powdery dust.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4"/><path d="M4 10h16"/><path d="M5 10v6a7 7 0 0 0 14 0v-6"/><path d="M9 16h6"/></svg>
                        </div>
                        <span class="step-badge">STEP 03</span>
                    </div>
                    <h3 class="step-title">Crispy Garlic & Dried Shrimp</h3>
                    <p class="step-desc">
                        Whole garlic cloves are slow-fried to golden crunchiness in clean vegetable oil, blended with premium sun-dried shrimp for deep natural umami that lingers on the palate.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-card-header">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 2 2 4-4"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>
                        </div>
                        <span class="step-badge">STEP 04</span>
                    </div>
                    <h3 class="step-title">Small-Batch Sealing</h3>
                    <p class="step-desc">
                        Every glass jar is heat-sterilized, hot-filled in limited runs under 200 jars, and vacuum-sealed to lock in crunch and peak freshness for months without artificial additives.
                    </p>
                </div>

            </div>

            <!-- 3 Core Product Lines Showcase -->
            <div class="showcase-banner">
                <div class="showcase-banner-header">
                    <h3>Our 3 Signature Product Lines</h3>
                    <p>Each crafted with a distinct personality to complete your culinary pantry</p>
                </div>

                <div class="showcase-cards-grid">
                    
                    <!-- Product 1 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            <img src="{{ asset('images/product_hero.png') }}" alt="Crispy Garlic Chili Crisp">
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">BESTSELLER · TOP 1</span>
                            <h4>Crispy Garlic Chili Crisp</h4>
                            <p>Mellow warmth, addictive garlic crunch, and savory oil. The ultimate spoonable topping for noodles, warm rice, dumplings, and sunny-side eggs.</p>
                            <a href="/shop" class="mini-card-link">Explore this blend →</a>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            <img src="{{ asset('images/shrimp_chilli_2.png') }}" alt="Artisanal Umami Shrimp Chili">
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">SIGNATURE · UMAMI BOMB</span>
                            <h4>Artisanal Umami Shrimp Chili</h4>
                            <p>Rich, slow-simmered dried shrimp folded into ruby-red aromatic oil. The soulful backbone for broths, hotpots, and seafood dips.</p>
                            <a href="/shop" class="mini-card-link">Explore this blend →</a>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-mini-card">
                        <div class="mini-card-img">
                            <img src="{{ asset('images/cat_powders.jpg') }}" alt="Fire-Roasted Chili Powders">
                        </div>
                        <div class="mini-card-content">
                            <span class="mini-tag">PURE SPICE · 100% RAW</span>
                            <h4>Fire-Roasted Flakes & Seasonings</h4>
                            <p>100% whole roasted chillies stone-ground into coarse flakes. Free of fillers or artificial salt. Essential for BBQ rubs and pan sears.</p>
                            <a href="/shop" class="mini-card-link">Explore this blend →</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- PILLAR 3: WHY TRUST US (TRANSPARENCY & PROOF) -->
    <!-- ========================================================================= -->
    <section id="why-trust-us" class="about-pillar-section bg-cream">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">03</span>
                    <span class="tag-text">WHY TRUST US · RADICAL TRANSPARENCY</span>
                </div>
                <h2 class="pillar-heading">
                    Radical Transparency <br class="d-none d-md-block">
                    Full Accountability In Every Single Jar
                </h2>
                <p class="section-subtitle">
                    We understand that spices go directly into the food you prepare for yourself and your loved ones. Real trust isn't earned through advertising, but through transparent actions and strict standards.
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
                        <span class="trust-number-badge">150K+</span>
                    </div>
                    <h3 class="trust-card-title">150,000+ Jars Delivered</h3>
                    <p class="trust-card-desc">
                        Embraced in tens of thousands of home kitchens and relied upon by over 120 restaurants and food creators. Supported by an 84%+ repeat order rate from loyal customers.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            4.9 / 5.0 Average Customer Rating
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
                    <h3 class="trust-card-title">Direct-Trade Farm Partners</h3>
                    <p class="trust-card-desc">
                        We collaborate directly with family farming collectives who practice sustainable agriculture. We pay fair prices above market benchmarks, ensuring clean crops and full origin traceability.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            100% Traceable ingredient supply chain
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
                    <h3 class="trust-card-title">The Strict "3-NO" Standard</h3>
                    <p class="trust-card-desc">
                        Your health is our red line. We refuse to compromise on quality:
                    </p>
                    <ul class="trust-strict-list">
                        <li><strong>NO chemical preservatives</strong> (Zero Benzoate or Sorbate additives)</li>
                        <li><strong>NO synthetic dyes</strong> (100% vibrant red from natural chillies and annatto)</li>
                        <li><strong>NO artificial thickeners</strong> or synthetic chemical heat intensifiers</li>
                    </ul>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            Certified Food Safety & Lab Inspected
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
                    <h3 class="trust-card-title">100% Flavor Guarantee</h3>
                    <p class="trust-card-desc">
                        We stand behind every small batch we brew. If you pop open your jar and aren't completely thrilled by the crunch, fragrance, and heat balance, we will replace it or issue a <strong>100% full refund</strong> — no questions asked.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            7-Day Hassle-Free Satisfaction Guarantee
                        </span>
                    </div>
                </div>

            </div>

            <!-- Customer & Chef Testimonial Spotlight with Lucide Icons -->
            <div class="testimonial-spotlight-box">
                <div class="spotlight-quote-icon">“</div>
                <div class="spotlight-content">
                    <p class="spotlight-text">
                        As a professional chef, I am notoriously strict with oil-based condiments. Dried Chili won me over completely: the garlic is genuinely crisp as if straight from the wok, the roasted chillies have a warm smoky depth without stinging your throat, and the shrimp leaves a savory sweet umami finish. It is a permanent fixture in my kitchen.
                    </p>
                    <div class="spotlight-author-info">
                        <div class="author-avatar-badge">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 13.8a4.4 4.4 0 0 1-3-4.3c0-2.4 2-4.5 4.5-4.5.3 0 .7 0 1 .1A6 6 0 0 1 18 6.5a4.4 4.4 0 0 1 3 4.3 4.4 4.4 0 0 1-3 4.3"/><path d="M6 14h12v4a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-4z"/><line x1="6" y1="17" x2="18" y2="17"/></svg>
                        </div>
                        <div>
                            <strong>Chef Minh Quan Le</strong>
                            <span>Asian Fusion Restaurateur & Customer since 2021</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- CALL TO ACTION (TASTE THE CRAFT) -->
    <!-- ========================================================================= -->
    <section class="about-cta-section">
        <div class="container">
            <div class="cta-inner-card">
                <div class="cta-content">
                    <span class="cta-mini-pill">
                        READY TO TASTE THE CRAFT?
                    </span>
                    <h2 class="cta-title">
                        Take Your Everyday Meals <br class="d-none d-md-block">
                        To The Next Level!
                    </h2>
                    <p class="cta-desc">
                        Say goodbye to dull, mass-produced sauces. Order today to experience authentic crunch and fiery aroma — plus enjoy our limited <strong>Buy 2 Get 1 Free</strong> deal and <strong>Free Shipping on orders over $50</strong>.
                    </p>
                    <div class="cta-actions">
                        <a href="/shop" class="btn-cta-primary">
                            <span>Explore The Pantry Now</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="/sale" class="btn-cta-secondary">
                            <span>View Bestseller Deals (Sale)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
