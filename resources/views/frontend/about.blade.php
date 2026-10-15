@extends('frontend.layouts.master')

@section('meta')
<title>Why Dried Chili? | Our Story</title>
@endsection

@section('full-content')
<main class="page-content about-page">

    <!-- HERO SECTION: The Fire & The Passion -->
    <section class="about-hero-section">
        <div class="about-hero-backdrop"></div>
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <span class="badge-sparkle">✦</span>
                <span>OUR STORY · HANDCRAFTED SPICY GOODS</span>
                <span class="badge-sparkle">✦</span>
            </div>
            <h1 class="about-hero-title">
                Igniting Everyday Meals With <br class="d-none d-md-block">
                <span class="highlight-gold">Artisanal Spice Craft</span>
            </h1>
            <p class="about-hero-desc">
                We don't do mass-produced industrial sauces. At <strong>Dried Chili</strong>, every jar is born from an uncompromising love for authentic Asian heat — slow-roasted sun-dried chillies, golden crispy garlic, and deep, natural umami.
            </p>

            <!-- Quick Highlight Pills -->
            <div class="hero-stats-ribbon">
                <div class="stat-pill">
                    <span class="stat-icon">🌱</span>
                    <div class="stat-info">
                        <strong>100% Natural</strong>
                        <span>Pure, raw ingredients</span>
                    </div>
                </div>
                <div class="stat-pill">
                    <span class="stat-icon">🔥</span>
                    <div class="stat-info">
                        <strong>Small-Batch Craft</strong>
                        <span>Stone-ground roasting</span>
                    </div>
                </div>
                <div class="stat-pill">
                    <span class="stat-icon">⭐</span>
                    <div class="stat-info">
                        <strong>150,000+ Jars Sold</strong>
                        <span>Trusted by food lovers</span>
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

                    <!-- Core Identity Highlights -->
                    <div class="identity-features">
                        <div class="identity-feat-item">
                            <div class="feat-icon-box">👨‍🍳</div>
                            <div class="feat-details">
                                <h4>Chef-Crafted Recipes</h4>
                                <p>Every formulation is refined through hundreds of kitchen tastings to achieve the golden balance of Heat, Crunch, and Umami.</p>
                            </div>
                        </div>
                        <div class="identity-feat-item">
                            <div class="feat-icon-box">🥘</div>
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
                            <div class="visual-badge-floating">
                                <div class="badge-icon-fire">🔥</div>
                                <div class="badge-text-group">
                                    <strong>Since 2018</strong>
                                    <span>Heritage Asian Spice Craft</span>
                                </div>
                            </div>
                        </div>
                        <div class="visual-card-quote">
                            <p class="quote-text">
                                "To us, spicy food isn't an endurance test. It's a multisensory spark that elevates every meal on your family table."
                            </p>
                            <span class="quote-author">— The Dried Chili Founding Team</span>
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

            <!-- The 4-Step Artisanal Process -->
            <div class="process-grid">
                
                <div class="process-step-card">
                    <div class="step-badge">STEP 01</div>
                    <div class="step-icon">🌶️</div>
                    <h3 class="step-title">Sun-Ripened Selection</h3>
                    <p class="step-desc">
                        We harvest only uniformly ripe chillies from clean agricultural partners, naturally sun-drying them to concentrate their volatile essential oils and distinctive fiery aroma.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-badge">STEP 02</div>
                    <div class="step-icon">🪨</div>
                    <h3 class="step-title">Roasting & Stone Crushing</h3>
                    <p class="step-desc">
                        Chillies are gently roasted over low embers to release deep smoky notes, then coarsely crushed using traditional stone mills to preserve light, crispy flakes instead of powdery dust.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-badge">STEP 03</div>
                    <div class="step-icon">🧄</div>
                    <h3 class="step-title">Crispy Garlic & Dried Shrimp</h3>
                    <p class="step-desc">
                        Whole garlic cloves are slow-fried to golden crunchiness in clean vegetable oil, blended with premium sun-dried shrimp for deep natural umami that lingers on the palate.
                    </p>
                </div>

                <div class="process-step-card">
                    <div class="step-badge">STEP 04</div>
                    <div class="step-icon">✨</div>
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

            <!-- The 4 Pillars of Trust Grid -->
            <div class="trust-cards-grid">
                
                <!-- Trust 1: Numbers & Social Proof -->
                <div class="trust-card">
                    <div class="trust-icon-wrapper">
                        <span class="trust-number-badge">150K+</span>
                    </div>
                    <h3 class="trust-card-title">150,000+ Jars Delivered</h3>
                    <p class="trust-card-desc">
                        Embraced in tens of thousands of home kitchens and relied upon by over 120 restaurants and food creators. Supported by an 84%+ repeat order rate from loyal customers.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">✓ 4.9 / 5.0 Average Customer Rating ⭐</span>
                    </div>
                </div>

                <!-- Trust 2: Direct-Trade & Fair Sourcing -->
                <div class="trust-card">
                    <div class="trust-icon-wrapper">
                        <span class="trust-icon-emoji">🤝</span>
                    </div>
                    <h3 class="trust-card-title">Direct-Trade Farm Partners</h3>
                    <p class="trust-card-desc">
                        We collaborate directly with family farming collectives who practice sustainable agriculture. We pay fair prices above market benchmarks, ensuring clean crops and full origin traceability.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">✓ 100% Traceable ingredient supply chain</span>
                    </div>
                </div>

                <!-- Trust 3: Absolute 3-NO Guarantee -->
                <div class="trust-card highlight-card">
                    <div class="trust-icon-wrapper">
                        <span class="trust-icon-emoji">🛡️</span>
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
                        <span class="trust-check">✓ Certified Food Safety & Lab Inspected</span>
                    </div>
                </div>

                <!-- Trust 4: 100% Flavor Guarantee -->
                <div class="trust-card">
                    <div class="trust-icon-wrapper">
                        <span class="trust-icon-emoji">💎</span>
                    </div>
                    <h3 class="trust-card-title">100% Flavor Guarantee</h3>
                    <p class="trust-card-desc">
                        We stand behind every small batch we brew. If you pop open your jar and aren't completely thrilled by the crunch, fragrance, and heat balance, we will replace it or issue a <strong>100% full refund</strong> — no questions asked.
                    </p>
                    <div class="trust-card-footer">
                        <span class="trust-check">✓ 7-Day Hassle-Free Satisfaction Guarantee</span>
                    </div>
                </div>

            </div>

            <!-- Customer & Chef Testimonial Spotlight -->
            <div class="testimonial-spotlight-box">
                <div class="spotlight-quote-icon">“</div>
                <div class="spotlight-content">
                    <p class="spotlight-text">
                        "As a professional chef, I am notoriously strict with oil-based condiments. Dried Chili won me over completely: the garlic is genuinely crisp as if straight from the wok, the roasted chillies have a warm smoky depth without stinging your throat, and the shrimp leaves a savory sweet umami finish. It is a permanent fixture in my kitchen."
                    </p>
                    <div class="spotlight-author-info">
                        <div class="author-avatar-badge">👨‍🍳</div>
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
                    <span class="cta-mini-pill">🔥 READY TO TASTE THE CRAFT?</span>
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

<style>
    /* =========================================================================
       ABOUT US PAGE STYLES - MODERN ARTISANAL DTC AESTHETICS (NO BLACK BORDERS)
       FONT: MANROPE FOR HEADINGS, INTER FOR BODY
       ========================================================================= */

    .about-page {
        --font-heading: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: var(--spice-bg);
        color: var(--spice-text);
        font-family: var(--font-body);
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* Container alignment */
    .about-page .container {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    /* Background Utility Colors */
    .bg-cream {
        background-color: var(--spice-bg);
    }
    .bg-alt {
        background-color: #F7EFE6;
    }

    /* --- 1. HERO SECTION --- */
    .about-hero-section {
        position: relative;
        background: linear-gradient(145deg, #1A0501 0%, #2A0800 50%, #3D1207 100%);
        color: var(--spice-bg);
        padding: 5rem 0 4.5rem;
        text-align: center;
        overflow: hidden;
    }

    .about-hero-backdrop {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 50% 20%, rgba(228, 93, 62, 0.25) 0%, transparent 65%);
        pointer-events: none;
    }

    .about-hero-container {
        position: relative;
        z-index: 2;
        max-width: 900px !important;
    }

    .about-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 179, 0, 0.3);
        color: var(--spice-secondary);
        padding: 0.45rem 1.4rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        margin-bottom: 1.75rem;
        backdrop-filter: blur(8px);
    }

    .badge-sparkle {
        color: var(--spice-secondary);
        font-size: 0.9rem;
    }

    .about-hero-title {
        font-family: var(--font-heading);
        font-size: clamp(2.4rem, 4.5vw, 3.8rem);
        font-weight: 800;
        line-height: 1.18;
        color: #FFFFFF;
        margin-bottom: 1.5rem;
        letter-spacing: -0.8px;
    }

    .about-hero-title .highlight-gold {
        color: var(--spice-secondary);
        font-style: normal;
        font-weight: 800;
    }

    .about-hero-desc {
        font-size: clamp(1.05rem, 1.4vw, 1.25rem);
        line-height: 1.75;
        color: rgba(253, 249, 241, 0.88);
        max-width: 780px;
        margin: 0 auto 3rem;
    }

    .hero-stats-ribbon {
        display: flex;
        justify-content: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 0.75rem 1.4rem;
        border-radius: 20px;
        text-align: left;
        backdrop-filter: blur(6px);
        transition: transform 0.25s ease, background 0.25s ease;
    }

    .stat-pill:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.1);
    }

    .stat-icon {
        font-size: 1.6rem;
    }

    .stat-info strong {
        display: block;
        color: #FFFFFF;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .stat-info span {
        display: block;
        color: rgba(253, 249, 241, 0.7);
        font-size: 0.8rem;
    }

    /* --- QUICK ANCHOR NAVIGATION --- */
    .about-quick-nav {
        background: #FFFFFF;
        border-bottom: 1px solid rgba(40, 18, 11, 0.07);
        position: sticky;
        top: 0;
        z-index: 99;
        box-shadow: 0 4px 20px rgba(40, 18, 11, 0.03);
    }

    .quick-nav-flex {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
        gap: 2rem;
    }

    .quick-nav-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        color: var(--spice-text);
        font-weight: 700;
        font-size: 0.95rem;
        font-family: var(--font-heading);
        transition: color 0.2s ease;
        padding: 0.3rem 0.6rem;
        border-radius: 8px;
    }

    .quick-nav-item:hover {
        color: var(--spice-primary);
    }

    .nav-step {
        font-family: var(--font-heading);
        font-weight: 800;
        color: var(--spice-primary);
        font-size: 1.1rem;
    }

    .quick-nav-divider {
        width: 1px;
        height: 24px;
        background: rgba(40, 18, 11, 0.12);
    }

    /* --- PILLAR SECTION COMMON STYLES --- */
    .about-pillar-section {
        padding: 6rem 0;
        position: relative;
    }

    .pillar-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(228, 93, 62, 0.1);
        border: 1px solid rgba(228, 93, 62, 0.2);
        color: var(--spice-primary);
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 1px;
        font-family: var(--font-heading);
        margin-bottom: 1.25rem;
    }

    .pillar-tag.center-tag {
        margin-left: auto;
        margin-right: auto;
    }

    .tag-number {
        background: var(--spice-primary);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
    }

    .pillar-heading {
        font-family: var(--font-heading);
        font-size: clamp(2rem, 3.2vw, 2.75rem);
        font-weight: 800;
        color: var(--spice-bg-dark);
        line-height: 1.22;
        margin-bottom: 1.5rem;
        letter-spacing: -0.6px;
    }

    .section-center-head {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 4rem;
    }

    .section-subtitle {
        font-size: 1.15rem;
        color: #5C4B41;
        line-height: 1.7;
        margin: 0;
    }

    /* --- PILLAR 1: WHO WE ARE (GRID & NARRATIVE) --- */
    .pillar-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.95fr;
        gap: 4.5rem;
        align-items: center;
    }

    .pillar-body p {
        font-size: 1.05rem;
        line-height: 1.75;
        color: #4A3A32;
        margin-bottom: 1.25rem;
    }

    .pillar-body p.lead-text {
        font-size: 1.2rem;
        color: var(--spice-bg-dark);
        line-height: 1.7;
    }

    .identity-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2.5rem;
    }

    .identity-feat-item {
        background: #FFFFFF;
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 8px 24px rgba(40, 18, 11, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .identity-feat-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(40, 18, 11, 0.08);
    }

    .feat-icon-box {
        font-size: 2.2rem;
        margin-bottom: 0.85rem;
    }

    .feat-details h4 {
        font-family: var(--font-heading);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--spice-bg-dark);
        margin-bottom: 0.4rem;
    }

    .feat-details p {
        font-size: 0.9rem;
        line-height: 1.55;
        color: #6C5B52;
        margin: 0;
    }

    /* Right visual composition */
    .visual-card-wrapper {
        position: relative;
    }

    .visual-card-main {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(40, 18, 11, 0.12);
        background: #FAF4E6;
    }

    .card-img-large {
        width: 100%;
        height: auto;
        display: block;
        aspect-ratio: 4 / 4.8;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .visual-card-main:hover .card-img-large {
        transform: scale(1.02);
    }

    .visual-badge-floating {
        position: absolute;
        bottom: 1.5rem;
        left: 1.5rem;
        right: 1.5rem;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 18px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .badge-icon-fire {
        font-size: 1.8rem;
    }

    .badge-text-group strong {
        display: block;
        font-size: 1rem;
        color: var(--spice-bg-dark);
        font-family: var(--font-heading);
        font-weight: 800;
    }

    .badge-text-group span {
        display: block;
        font-size: 0.82rem;
        color: #6C5B52;
    }

    .visual-card-quote {
        margin-top: 1.5rem;
        background: #FFFFFF;
        border-left: 4px solid var(--spice-primary);
        border-radius: 0 16px 16px 0;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 6px 20px rgba(40, 18, 11, 0.04);
    }

    .quote-text {
        font-family: var(--font-heading);
        font-style: italic;
        font-size: 1.05rem;
        line-height: 1.6;
        color: var(--spice-bg-dark);
        margin-bottom: 0.5rem;
    }

    .quote-author {
        font-size: 0.85rem;
        font-family: var(--font-heading);
        font-weight: 700;
        color: var(--spice-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* --- PILLAR 2: WHAT WE DO (PROCESS & SHOWCASE) --- */
    .process-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 5rem;
    }

    .process-step-card {
        background: #FFFFFF;
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 20px;
        padding: 2rem 1.5rem;
        box-shadow: 0 10px 30px rgba(40, 18, 11, 0.04);
        position: relative;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .process-step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(40, 18, 11, 0.08);
    }

    .step-badge {
        display: inline-block;
        background: rgba(228, 93, 62, 0.12);
        color: var(--spice-primary);
        font-size: 0.72rem;
        font-weight: 800;
        font-family: var(--font-heading);
        letter-spacing: 1px;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        width: fit-content;
        margin-bottom: 1.25rem;
    }

    .step-icon {
        font-size: 2.8rem;
        margin-bottom: 1rem;
        line-height: 1;
    }

    .step-title {
        font-family: var(--font-heading);
        font-size: 1.22rem;
        font-weight: 700;
        color: var(--spice-bg-dark);
        margin-bottom: 0.75rem;
        line-height: 1.32;
        letter-spacing: -0.3px;
    }

    .step-desc {
        font-size: 0.92rem;
        line-height: 1.65;
        color: #5C4B41;
        margin: 0;
    }

    /* Showcase Banner */
    .showcase-banner {
        background: #FFFFFF;
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 24px;
        padding: 3.5rem 3rem;
        box-shadow: 0 16px 40px rgba(40, 18, 11, 0.05);
    }

    .showcase-banner-header {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 3rem;
    }

    .showcase-banner-header h3 {
        font-family: var(--font-heading);
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--spice-bg-dark);
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .showcase-banner-header p {
        font-size: 1rem;
        color: #6C5B52;
        margin: 0;
    }

    .showcase-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .product-mini-card {
        background: #FDF9F1;
        border: 1px solid rgba(40, 18, 11, 0.06);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .product-mini-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(40, 18, 11, 0.08);
    }

    .mini-card-img {
        background: #F3EAE0;
        padding: 2rem 1.5rem 1rem;
        text-align: center;
        aspect-ratio: 16 / 11;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mini-card-img img {
        max-height: 160px;
        width: auto;
        max-width: 85%;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(40, 18, 11, 0.08);
        transition: transform 0.3s ease;
    }

    .product-mini-card:hover .mini-card-img img {
        transform: scale(1.06);
    }

    .mini-card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .mini-tag {
        font-size: 0.72rem;
        font-weight: 800;
        font-family: var(--font-heading);
        color: var(--spice-primary);
        letter-spacing: 1px;
        margin-bottom: 0.4rem;
        display: inline-block;
    }

    .mini-card-content h4 {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--spice-bg-dark);
        margin-bottom: 0.6rem;
        letter-spacing: -0.3px;
    }

    .mini-card-content p {
        font-size: 0.9rem;
        line-height: 1.55;
        color: #5C4B41;
        margin-bottom: 1.25rem;
        flex: 1;
    }

    .mini-card-link {
        font-weight: 700;
        font-family: var(--font-heading);
        font-size: 0.9rem;
        color: var(--spice-primary);
        text-decoration: none;
        transition: color 0.2s ease, transform 0.2s ease;
        display: inline-block;
    }

    .mini-card-link:hover {
        color: var(--spice-accent);
        transform: translateX(4px);
    }

    /* --- PILLAR 3: WHY TRUST US --- */
    .trust-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .trust-card {
        background: #FFFFFF;
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(40, 18, 11, 0.04);
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .trust-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(40, 18, 11, 0.08);
    }

    .trust-card.highlight-card {
        background: #FFFDF9;
        border: 1.5px solid rgba(228, 93, 62, 0.25);
    }

    .trust-icon-wrapper {
        margin-bottom: 1.25rem;
    }

    .trust-number-badge {
        font-family: var(--font-heading);
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--spice-primary);
        line-height: 1;
        display: inline-block;
        letter-spacing: -0.5px;
    }

    .trust-icon-emoji {
        font-size: 2.4rem;
        line-height: 1;
        display: inline-block;
    }

    .trust-card-title {
        font-family: var(--font-heading);
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--spice-bg-dark);
        margin-bottom: 0.85rem;
        letter-spacing: -0.3px;
    }

    .trust-card-desc {
        font-size: 0.98rem;
        line-height: 1.7;
        color: #5C4B41;
        margin-bottom: 1.25rem;
        flex: 1;
    }

    .trust-strict-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
    }

    .trust-strict-list li {
        font-size: 0.95rem;
        color: #4A3A32;
        margin-bottom: 0.6rem;
        position: relative;
        padding-left: 1.5rem;
    }

    .trust-strict-list li::before {
        content: "•";
        color: var(--spice-primary);
        font-size: 1.4rem;
        position: absolute;
        left: 0.2rem;
        top: -0.3rem;
    }

    .trust-card-footer {
        padding-top: 1rem;
        border-top: 1px solid rgba(40, 18, 11, 0.08);
    }

    .trust-check {
        font-size: 0.88rem;
        font-weight: 700;
        color: #2E6B3A;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Testimonial Spotlight */
    .testimonial-spotlight-box {
        background: #FFFFFF;
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 12px 35px rgba(40, 18, 11, 0.05);
        display: flex;
        gap: 2.5rem;
        align-items: flex-start;
        position: relative;
    }

    .spotlight-quote-icon {
        font-family: var(--font-heading);
        font-size: 5rem;
        line-height: 0.8;
        color: var(--spice-primary);
        opacity: 0.3;
        flex-shrink: 0;
    }

    .spotlight-text {
        font-family: var(--font-heading);
        font-style: italic;
        font-size: 1.2rem;
        line-height: 1.75;
        color: var(--spice-bg-dark);
        margin-bottom: 1.5rem;
    }

    .spotlight-author-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .author-avatar-badge {
        font-size: 2rem;
        background: rgba(228, 93, 62, 0.1);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spotlight-author-info strong {
        display: block;
        font-size: 1rem;
        color: var(--spice-bg-dark);
        font-family: var(--font-heading);
        font-weight: 700;
    }

    .spotlight-author-info span {
        display: block;
        font-size: 0.85rem;
        color: #7A6960;
    }

    /* --- 5. CALL TO ACTION (CTA) SECTION --- */
    .about-cta-section {
        padding: 4rem 0 6rem;
        background: var(--spice-bg);
    }

    .cta-inner-card {
        background: linear-gradient(145deg, #1A0501 0%, #2A0800 60%, #3B1107 100%);
        border: 1px solid rgba(255, 179, 0, 0.2);
        border-radius: 24px;
        padding: 4.5rem 3rem;
        text-align: center;
        color: #FFFFFF;
        box-shadow: 0 25px 60px rgba(42, 8, 0, 0.25);
        position: relative;
        overflow: hidden;
    }

    .cta-inner-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(228, 93, 62, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }

    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
        margin: 0 auto;
    }

    .cta-mini-pill {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 179, 0, 0.4);
        color: var(--spice-secondary);
        font-size: 0.8rem;
        font-weight: 800;
        font-family: var(--font-heading);
        letter-spacing: 1.5px;
        padding: 0.35rem 1.2rem;
        border-radius: 999px;
        margin-bottom: 1.5rem;
    }

    .cta-title {
        font-family: var(--font-heading);
        font-size: clamp(2rem, 3.5vw, 2.75rem);
        font-weight: 800;
        color: #FFFFFF;
        line-height: 1.25;
        margin-bottom: 1.25rem;
        letter-spacing: -0.6px;
    }

    .cta-desc {
        font-size: 1.15rem;
        line-height: 1.7;
        color: rgba(253, 249, 241, 0.85);
        margin-bottom: 2.5rem;
    }

    .cta-actions {
        display: flex;
        justify-content: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    .btn-cta-primary {
        background: var(--spice-primary);
        color: #FFFFFF;
        font-weight: 700;
        font-family: var(--font-heading);
        font-size: 1rem;
        padding: 1rem 2rem;
        border-radius: 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        box-shadow: 0 10px 25px rgba(228, 93, 62, 0.4);
        transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-cta-primary:hover {
        background: var(--spice-accent);
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(199, 59, 27, 0.5);
        color: #FFFFFF;
    }

    .btn-cta-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #FFFFFF;
        border: 1px solid rgba(255, 255, 255, 0.3);
        font-weight: 600;
        font-family: var(--font-heading);
        font-size: 1rem;
        padding: 1rem 1.85rem;
        border-radius: 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: #FFFFFF;
        color: #FFFFFF;
    }

    /* --- RESPONSIVE BREAKPOINTS --- */
    @media (max-width: 992px) {
        .pillar-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .process-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        .showcase-cards-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .trust-cards-grid {
            grid-template-columns: 1fr;
        }

        .testimonial-spotlight-box {
            flex-direction: column;
            gap: 1.5rem;
            padding: 2rem;
        }

        .spotlight-quote-icon {
            font-size: 3.5rem;
        }

        .quick-nav-flex {
            gap: 1rem;
        }
        
        .quick-nav-item {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 768px) {
        .about-pillar-section {
            padding: 4rem 0;
        }

        .identity-features {
            grid-template-columns: 1fr;
        }

        .process-grid {
            grid-template-columns: 1fr;
        }

        .showcase-banner {
            padding: 2rem 1.25rem;
        }

        .cta-inner-card {
            padding: 3rem 1.5rem;
        }

        .cta-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn-cta-primary,
        .btn-cta-secondary {
            width: 100%;
            justify-content: center;
        }

        .quick-nav-flex {
            flex-direction: column;
            gap: 0.5rem;
        }

        .quick-nav-divider {
            display: none;
        }
    }
</style>
@endsection
