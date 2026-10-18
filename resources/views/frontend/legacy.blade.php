@extends('frontend.layouts.master')

@section('meta')
<title>Our Legacy | Roots & Terroir | Dried Chili</title>
<meta name="description" content="Discover the 100-year legacy behind Dried Chili: four generations of heirloom farming, ancestral 21-day solar curing, and the sacred valley terroir that gives our chili its legendary flavor.">
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v={{ time() }}">
@endpush

@section('full-content')
<main class="page-content about-page legacy-page">

    <!-- HERO SECTION: Vintage Terroir, Refined & Strictly 650px on Desktop -->
    <section class="about-hero-section legacy-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge legacy-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span>ESTABLISHED 1920 · 4 GENERATIONS OF TERROIR & CRAFT</span>
            </div>
            
            <h1 class="about-hero-title">
                A Century of Terroir<br>
                <span class="highlight-gold">Roots That Run Deep</span>
            </h1>
            
            <p class="about-hero-desc">
                Before the jars, before the modern kitchen — there was a sun-drenched valley, heirloom seeds preserved across four generations, and an unshakeable refusal to let machines replace patience.
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>1920 Established</strong>
                        <span>Century Terroir</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>4th Generation</strong>
                        <span>Family Lineage</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>21-Day Sun-Cured</strong>
                        <span>Pure Sunshine</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NAVIGATION ANCHORS (Quick Jump Bar) -->
    <nav class="about-quick-nav">
        <div class="container quick-nav-flex">
            <a href="#origin-valley" class="quick-nav-item">
                <span class="nav-step">01</span>
                <span class="nav-label">The Origin Valley</span>
            </a>
            <div class="quick-nav-divider"></div>
            <a href="#century-chronicle" class="quick-nav-item">
                <span class="nav-step">02</span>
                <span class="nav-label">Century Chronicle</span>
            </a>
            <div class="quick-nav-divider"></div>
            <a href="#sun-vs-machine" class="quick-nav-item">
                <span class="nav-step">03</span>
                <span class="nav-label">Sun vs. Machine</span>
            </a>
            <div class="quick-nav-divider"></div>
            <a href="#heritage-code" class="quick-nav-item">
                <span class="nav-step">04</span>
                <span class="nav-label">The Founder's Code</span>
            </a>
        </div>
    </nav>

    <!-- ========================================================================= -->
    <!-- PILLAR 1: THE ORIGIN VALLEY & HEIRLOOM SOIL -->
    <!-- ========================================================================= -->
    <section id="origin-valley" class="about-pillar-section bg-cream">
        <div class="container">
            <div class="pillar-grid align-center">
                
                <!-- Left: Storytelling Narrative -->
                <div class="pillar-content">
                    <div class="pillar-tag">
                        <span class="tag-number">01</span>
                        <span class="tag-text">SACRED SOIL · THE ORIGIN VALLEY</span>
                    </div>
                    <h2 class="pillar-heading">
                        Where Mountain Sun Meets <br>
                        Ancient Volcanic Terroir
                    </h2>
                    
                    <div class="pillar-body">
                        <p class="lead-text">
                            <strong>It all began in 1920</strong> in a secluded highland valley nestled between volcanic mountain ridges. The soil was rich with dark organic loam, crisp alpine breezes cooled the hills at dusk, and pure sunshine poured uninhibited for over 300 days a year.
                        </p>
                        <p>
                            Our great-grandfather recognized this rare microclimate: sharp day-night temperature swings stress the chili plants just enough to concentrate their natural capsicum oils. The result is thin-skinned pods bursting with floral aromatics, deep fruit sugars, and clean warmth that never stings the throat.
                        </p>
                        <p>
                            While commercial agriculture continuously crossbreeds hybrid varieties for transport durability, our family has hand-saved the exact same heirloom seeds generation after generation. When you taste our chili, you are tasting unchanged 1920 botanical genetics.
                        </p>
                    </div>

                    <!-- Core Identity Highlights with Lucide Icons -->
                    <div class="identity-features">
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>Highland Valley Microclimate</h4>
                                <p>Volcanic soil and sharp day-night temperature swings nurture intense essential capsicum oils and caramelized natural sweetness.</p>
                            </div>
                        </div>
                        <div class="identity-feat-item">
                            <div class="lucide-icon-box">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4.1 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
                            </div>
                            <div class="feat-details">
                                <h4>Protected Heirloom Lineage</h4>
                                <p>Uncrossed seeds collected by hand every harvest season for over a century — 100% non-GMO and free from laboratory hybridization.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual Composition -->
                <div class="pillar-visual">
                    <div class="visual-card-wrapper">
                        <div class="visual-card-main">
                            <img src="{{ asset('images/legacy_farm.jpg') }}" alt="Our Ancestral Chili Farm" class="card-img-large">
                        </div>
                        <div class="visual-card-quote">
                            <p class="quote-text">
                                “Nature dictates our schedule. We simply listen and craft the finest spices the earth can offer.”
                            </p>
                            <span class="quote-author">— The Tran Family Patriarch, Circa 1920 —</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- PILLAR 2: THE CENTURY CHRONICLE (INTERACTIVE HERITAGE TIMELINE) -->
    <!-- ========================================================================= -->
    <section id="century-chronicle" class="about-pillar-section bg-alt">
        <div class="container">
            
            <!-- Section Header -->
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">02</span>
                    <span class="tag-text">THE CENTURY CHRONICLE · 1920 TO PRESENT</span>
                </div>
                <h2 class="pillar-heading">
                    A 100-Year Family Lineage <br class="d-none d-md-block">
                    Of Unbroken Artisanal Craft
                </h2>
                <p class="section-subtitle">
                    Trace our journey from a humble valley kitchen hearth to modern culinary pantries worldwide — century by century, harvest by harvest.
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
                            1920 · THE FIRST SEED
                        </span>
                        <h3 class="timeline-title">The Farmhouse Hearth</h3>
                        <p class="timeline-desc">
                            Our great-grandfather planted the valley's first heirloom chili crop. Roasting pods over wood embers with crispy garlic and aromatic spices, he began sharing jars with traveling merchants and village cooks.
                        </p>
                    </div>
                </div>

                <!-- 1958 -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/></svg>
                            1958 · SOLAR TERRACES
                        </span>
                        <h3 class="timeline-title">The Raised Bamboo Decks</h3>
                        <p class="timeline-desc">
                            The second generation engineered elevated bamboo drying terraces along the hillsides. This allowed alpine breezes to circulate beneath the chillies, perfecting our signature 21-day solar curing method.
                        </p>
                    </div>
                </div>

                <!-- 1994 -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            1994 · THE HEIRS' PLEDGE
                        </span>
                        <h3 class="timeline-title">Resisting The Machine Age</h3>
                        <p class="timeline-desc">
                            When commercial factories adopted high-speed electrical dehydrators, our elders gathered and took an oath: we would never mechanize sun curing, even if it meant remaining small and unhurried.
                        </p>
                    </div>
                </div>

                <!-- Present Day -->
                <div class="timeline-item">
                    <div class="timeline-node"></div>
                    <div class="timeline-content-card">
                        <span class="timeline-year-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            TODAY · 4TH GENERATION
                        </span>
                        <h3 class="timeline-title">The Modern Artisanal Table</h3>
                        <p class="timeline-desc">
                            Today, under the Jojo Little Kitchen banner, the 4th generation brings this hundred-year heritage to over 150,000 food lovers globally, still crafting every batch under 200 jars.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- PILLAR 3: THE METHOD CONTRAST (SUN-CURING VS. MACHINE DEHYDRATION) -->
    <!-- ========================================================================= -->
    <section id="sun-vs-machine" class="about-pillar-section bg-cream">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">03</span>
                    <span class="tag-text">THE ARTISANAL ADVANTAGE · SUN VS MACHINE</span>
                </div>
                <h2 class="pillar-heading">
                    Why 21 Days In The Sun <br class="d-none d-md-block">
                    Cannot Be Replaced By A 3-Hour Machine
                </h2>
                <p class="section-subtitle">
                    A clear, uncompromising comparison between ancestral solar curing and modern industrial shortcut processing.
                </p>
            </div>

            <!-- Distinctive Method Contrast Grid -->
            <div class="method-contrast-grid">
                
                <!-- Our Way: 21-Day Solar Cure -->
                <div class="contrast-card craft-card">
                    <span class="contrast-badge craft-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        OUR ANCESTRAL WAY
                    </span>
                    <h3 class="contrast-heading">21-Day Natural Solar Curing</h3>
                    
                    <ul class="contrast-list">
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>Caramelized Natural Sugars:</strong>
                                14 to 21 days of gentle sun exposure allows organic fruit sugars to concentrate into deep, savory umami without scorching.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>Preserved Volatile Essential Oils:</strong>
                                Ambient solar warmth preserves delicate floral terpenes and capsaicin aromatic compounds that high heat destroys.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>Crisp, Crunchy Flake Texture:</strong>
                                Coarse stone grinding yields airy, light chili flakes that stay crisp inside oil instead of turning soggy.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon craft-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <strong>100% Pure Natural Ruby Color:</strong>
                                Glowing deep crimson derived exclusively from sun-ripened chillies — zero synthetic food coloring.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Industrial Way -->
                <div class="contrast-card factory-card">
                    <span class="contrast-badge factory-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        MASS INDUSTRIAL FACTORIES
                    </span>
                    <h3 class="contrast-heading">3-Hour Forced Dehydration</h3>
                    
                    <ul class="contrast-list">
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>Scorched Bitter Sugars:</strong>
                                180°C forced industrial blowers burn delicate fruit sugars, leaving a harsh, acrid bitter aftertaste in your mouth.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>Evaporated Aromatics:</strong>
                                Intense machine heat boils away the fragrant volatile oils, resulting in a flat, pungent sting without complexity.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>Soggy Powdery Sludge:</strong>
                                High-speed industrial metal crushers pulverize chillies into powdery dust that absorbs oil and turns gummy.
                            </div>
                        </li>
                        <li class="contrast-list-item">
                            <svg class="contrast-icon factory-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div>
                                <strong>Chemical Preservatives & Dyes:</strong>
                                Heavy reliance on sodium benzoate, artificial red colorants, and anti-caking agents to mimic freshness.
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- PILLAR 4: THE FOUR TENETS & FOUNDER'S PLEDGE -->
    <!-- ========================================================================= -->
    <section id="heritage-code" class="about-pillar-section bg-alt">
        <div class="container">
            
            <div class="section-center-head">
                <div class="pillar-tag center-tag">
                    <span class="tag-number">04</span>
                    <span class="tag-text">TIME-HONORED CODE · THE FOUR TENETS</span>
                </div>
                <h2 class="pillar-heading">
                    The Four Generational Golden Rules
                </h2>
                <p class="section-subtitle">
                    Recorded in family logs in 1920, strictly observed by every family custodian who steps before the kitchen hearth.
                </p>
            </div>

            <!-- The 4 Tenets Grid -->
            <div class="trust-cards-grid">
                
                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/></svg>
                        </div>
                        <span class="trust-number-badge">TENET I</span>
                    </div>
                    <h3 class="trust-card-title">Never Rush The Sun</h3>
                    <p class="trust-card-desc">
                        Nature sets our harvest calendar. We never harvest early and never force dehydration. If a batch requires 24 days instead of 21, it stays in the sun.
                    </p>
                </div>

                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/></svg>
                        </div>
                        <span class="trust-number-badge">TENET II</span>
                    </div>
                    <h3 class="trust-card-title">Soil Comes First</h3>
                    <p class="trust-card-desc">
                        A robust chili pod can only come from nutrient-rich living soil. We feed our fields with clean organic compost and never use synthetic chemical boosters.
                    </p>
                </div>

                <div class="trust-card highlight-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="trust-number-badge">TENET III</span>
                    </div>
                    <h3 class="trust-card-title">Taste With The Spoon</h3>
                    <p class="trust-card-desc">
                        No automated sensor can detect the delicate balance between golden crispy garlic and roasted chili sweetness. Every batch is tasted by a family custodian.
                    </p>
                </div>

                <div class="trust-card">
                    <div class="trust-card-top-row">
                        <div class="lucide-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <span class="trust-number-badge">TENET IV</span>
                    </div>
                    <h3 class="trust-card-title">Clean Heart, Pure Oil</h3>
                    <p class="trust-card-desc">
                        Zero chemical preservatives. Zero synthetic red dyes. Zero industrial additives. If our children cannot eat it straight from the jar, it doesn't leave the kitchen.
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
                        <h3>The Family Heritage Custodian Pledge</h3>
                        <span>OFFICIAL FAMILY DECLARATION · VALLEY ESTABLISHED 1920</span>
                    </div>
                </div>

                <p class="manifesto-body">
                    “To our patrons, food enthusiasts, and extended culinary family: Every jar that leaves our small kitchen carries four generations of family honor. We understand that in modern manufacturing, corners are cut to save pennies and speed up lines. We make this solemn promise: we will never surrender to electric dryers, never add artificial preservatives, and never trade a single century-old technique for convenience. Thank you for keeping our culinary flame burning bright at your family tables.”
                </p>

                <div class="manifesto-signature">
                    <span>— The Tran Family Lineage, 4th Generation Stewards of the Flame —</span>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- CALL TO ACTION (TASTE THE HERITAGE) -->
    <!-- ========================================================================= -->
    <section class="about-cta-section">
        <div class="container">
            <div class="cta-inner-card">
                <div class="cta-content">
                    <span class="cta-mini-pill">
                        TASTE 100 YEARS OF TERROIR
                    </span>
                    <h2 class="cta-title">
                        Bring A Century Of Heritage <br class="d-none d-md-block">
                        To Your Dining Table Today!
                    </h2>
                    <p class="cta-desc">
                        Experience the unforgettable savory umami and genuine crispiness born from a century of patient solar curing. Enjoy our limited <strong>Buy 2 Get 1 Free</strong> deal and <strong>Free Shipping on orders over $50</strong>.
                    </p>
                    <div class="cta-actions">
                        <a href="/shop" class="btn-cta-primary">
                            <span>Explore The Heritage Pantry</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="/about-us" class="btn-cta-secondary">
                            <span>Read Our Kitchen Story (About Us)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
