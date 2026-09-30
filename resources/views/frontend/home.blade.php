@extends('frontend.layouts.master')

@section('meta')
    <meta name="description" content="Dried Chili - Premium quality spices, chillies, and organic seasonings.">
    <title>Dried Chili | Authentic Spices & Herbs</title>
@endsection

@section('full-content')
<main class="spice-main">
    <!-- Marquee Sale Banner -->
    <div class="spice-marquee">
        <div class="marquee-track">
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦ </span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦ </span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦ </span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦ </span>
        </div>
    </div>

    <!-- Hero Slider -->
    <section class="spice-hero-slider">
        <div class="slider-container" id="heroSlider">
            <!-- Slide 1 -->
            <div class="slide active">
                <div class="slide-split container">
                    <div class="hero-content">
                        <span class="hero-subtitle">THE ORIGINAL FLAVOR</span>
                        <h1 class="hero-title">SHRIMPLY<br>SPICY</h1>
                        <p class="hero-desc">The ultimate umami bomb. Handcrafted with real shrimp and our signature spice blend.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">Shop Now</a>
                        </div>
                    </div>
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">Chef-made</span>
                        <span class="hero-sticker sticker-2"><span>150,000+</span> jars sold</span>
                        <span class="hero-sticker sticker-3">Now in Stores</span>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="slide">
                <div class="slide-split reverse container">
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-yellow"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">New Recipe</span>
                        <span class="hero-sticker sticker-2"><span>Extra</span> Crunchy</span>
                        <span class="hero-sticker sticker-3">100% Organic</span>
                    </div>
                    <div class="hero-content">
                        <span class="hero-subtitle">NEW ARRIVAL</span>
                        <h1 class="hero-title">EXTRA<br>GARLIC CRUNCH</h1>
                        <p class="hero-desc">Take your meals to the next level with our new extra garlicky, extra crunchy chilli paste.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">Discover</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <div class="slide-split container">
                    <div class="hero-content">
                        <span class="hero-subtitle">LIMITED EDITION</span>
                        <h1 class="hero-title">FIRE<br>ROASTED</h1>
                        <p class="hero-desc">Experience the deep, smoky flavor of chillies roasted over an open flame.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">Shop Limited</a>
                        </div>
                    </div>
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-orange"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">Smoky</span>
                        <span class="hero-sticker sticker-2"><span>Award</span> Winning</span>
                        <span class="hero-sticker sticker-3">Hot!</span>
                    </div>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="slide">
                <div class="slide-split reverse container">
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-red"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">Plant Based</span>
                        <span class="hero-sticker sticker-2"><span>No</span> MSG</span>
                        <span class="hero-sticker sticker-3">Pure Spice</span>
                    </div>
                    <div class="hero-content">
                        <span class="hero-subtitle">VEGAN FRIENDLY</span>
                        <h1 class="hero-title">PURE<br>PLANT POWER</h1>
                        <p class="hero-desc">All the umami, none of the seafood. Our vegan alternative packs the same punch.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">Try Vegan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-controls">
            <div class="slider-dots">
                <span class="dot active" onclick="goToSlide(0)"></span>
                <span class="dot" onclick="goToSlide(1)"></span>
                <span class="dot" onclick="goToSlide(2)"></span>
                <span class="dot" onclick="goToSlide(3)"></span>
            </div>
        </div>
    </section>

    <!-- Value Props -->
    <section class="value-props">
        <div class="container props-grid">
            <div class="prop-item">
                <div class="prop-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>100% Authentic</h3>
                <p>Pure ingredients with no artificial additives</p>
            </div>
            <div class="prop-item">
                <div class="prop-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21.21 15.89A10 10 0 1 1 8 2.83M22 12A10 10 0 0 0 12 2v10z"/></svg>
                </div>
                <h3>Sourced Globally</h3>
                <p>Direct from the world's best spice farms</p>
            </div>
            <div class="prop-item">
                <div class="prop-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3>Fast Delivery</h3>
                <p>Freshness delivered to your doorstep</p>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="spice-categories reveal">
        <div class="container">
            <div class="section-header">
                <h2>Explore by Category</h2>
                <a href="/collections" class="view-all">View all categories &rarr;</a>
            </div>
            <div class="category-grid">
                <a href="/collection/dried-chillies" class="category-card">
                    <div class="cat-img-box">
                        <img src="{{ asset('images/cat_chillies.jpg') }}" alt="Dried Chillies">
                    </div>
                    <div class="cat-info">
                        <h3>Dried Chillies</h3>
                        <span>12 Products</span>
                    </div>
                </a>
                <a href="/collection/powders" class="category-card">
                    <div class="cat-img-box">
                        <img src="{{ asset('images/cat_powders.jpg') }}" alt="Spice Powders">
                    </div>
                    <div class="cat-info">
                        <h3>Spice Powders</h3>
                        <span>24 Products</span>
                    </div>
                </a>
                <a href="/collection/blends" class="category-card">
                    <div class="cat-img-box">
                        <img src="{{ asset('images/cat_blends.jpg') }}" alt="Curry & Blends">
                    </div>
                    <div class="cat-info">
                        <h3>Curry & Blends</h3>
                        <span>8 Products</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Trending Products -->
    <section class="trending-products reveal">
        <div class="container">
            <div class="section-header center">
                <h2>Trending Spices</h2>
                <p>Our customers' current favorites for the season</p>
            </div>
            
            <div class="product-carousel">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-badge sale">Sale</div>
                    <a href="/product/kashmiri-chilli" class="product-img-wrapper">
                        <img src="{{ asset('images/product_hero.png') }}" alt="Kashmiri Chilli Powder">
                        <div class="quick-add">Quick Add</div>
                    </a>
                    <div class="product-details">
                        <div class="product-vendor">DRIED CHILI</div>
                        <a href="/product/kashmiri-chilli" class="product-title">Premium Kashmiri Chilli Powder</a>
                        <div class="product-price">
                            <span class="price-current">$12.50</span>
                            <span class="price-compare">$15.00</span>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <a href="/product/turmeric" class="product-img-wrapper">
                        <img src="{{ asset('images/product_hero.png') }}" alt="Organic Turmeric">
                        <div class="quick-add">Quick Add</div>
                    </a>
                    <div class="product-details">
                        <div class="product-vendor">DRIED CHILI</div>
                        <a href="/product/turmeric" class="product-title">Organic Ground Turmeric</a>
                        <div class="product-price">
                            <span class="price-current">$9.00</span>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-badge hot">Hot</div>
                    <a href="/product/whole-ghost" class="product-img-wrapper">
                        <img src="{{ asset('images/product_hero.png') }}" alt="Whole Ghost Peppers">
                        <div class="quick-add">Quick Add</div>
                    </a>
                    <div class="product-details">
                        <div class="product-vendor">DRIED CHILI</div>
                        <a href="/product/whole-ghost" class="product-title">Dried Whole Ghost Peppers</a>
                        <div class="product-price">
                            <span class="price-current">$18.50</span>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <a href="/product/cinnamon" class="product-img-wrapper">
                        <img src="{{ asset('images/product_hero.png') }}" alt="Ceylon Cinnamon">
                        <div class="quick-add">Quick Add</div>
                    </a>
                    <div class="product-details">
                        <div class="product-vendor">DRIED CHILI</div>
                        <a href="/product/cinnamon" class="product-title">Ceylon Cinnamon Sticks</a>
                        <div class="product-price">
                            <span class="price-current">$14.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Image with Text -->
    <section class="spice-story reveal">
        <div class="story-grid">
            <div class="story-image">
                <img src="{{ asset('images/story_spices.jpg') }}" alt="Spices on market">
            </div>
            <div class="story-content">
                <span class="subheading">OUR STORY</span>
                <h2>Passionate About Flavor</h2>
                <p>We believe that every dish tells a story, and the spices you use are its vocabulary. Our journey began in the vibrant spice markets of Asia, bringing authentic, sun-dried chillies and hand-ground spices to home chefs who demand the best.</p>
                <a href="/about" class="btn-primary">Learn More</a>
            </div>
        </div>
    </section>
</main>

<style>
    /* Buttons - Graza/Fishwife Style */
    .btn-primary {
        display: inline-block;
        background-color: var(--spice-primary);
        color: var(--spice-bg);
        padding: 1rem 2.5rem;
        font-family: var(--font-body);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        border: 2px solid var(--spice-text);
        border-radius: 8px;
        box-shadow: 4px 4px 0px var(--spice-text);
        transition: transform 0.1s, box-shadow 0.1s;
    }

    .btn-primary:hover {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px var(--spice-text);
    }

    .btn-outline {
        display: inline-block;
        background-color: var(--spice-bg);
        color: var(--spice-text);
        padding: 1rem 2.5rem;
        font-family: var(--font-body);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        border: 2px solid var(--spice-text);
        border-radius: 8px;
        box-shadow: 4px 4px 0px var(--spice-text);
        transition: transform 0.1s, box-shadow 0.1s;
    }

    .btn-outline:hover {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px var(--spice-text);
    }

    /* Marquee */
    .spice-marquee {
        background-color: var(--spice-accent);
        color: white;
        padding: 0.75rem 0;
        overflow: hidden;
        white-space: nowrap;
        font-family: var(--font-body);
        font-weight: 700;
        letter-spacing: 1px;
    }
    .marquee-track {
        display: inline-block;
        animation: scrollMarquee 20s linear infinite;
    }
    .marquee-track span { margin-right: 2rem; }
    @keyframes scrollMarquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* Hero Slider */
    .spice-hero-slider {
        position: relative;
        background-color: #EFE4D3; /* Soft earthy background */
        overflow: hidden;
        min-height: 550px;
        display: flex;
        align-items: center;
    }

    .slider-container {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .slide {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s ease-in-out, visibility 0.8s;
        display: flex;
        align-items: center;
    }

    .slide.active {
        opacity: 1;
        visibility: visible;
        position: relative;
    }

    .slide-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 4rem;
        height: 100%;
        padding: 4rem 2rem;
    }

    .hero-content {
        color: var(--spice-text);
        animation: slideUp 0.8s ease-out forwards;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-subtitle {
        font-size: 1rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--spice-primary);
        font-weight: 700;
        display: block;
        margin-bottom: 1rem;
        border: 2px solid var(--spice-primary);
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
    }

    .hero-title {
        font-family: var(--font-heading);
        font-size: clamp(3.5rem, 6vw, 5rem);
        line-height: 1;
        margin: 0 0 1.5rem 0;
        color: var(--spice-text);
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .hero-desc {
        font-size: 1.2rem;
        line-height: 1.6;
        margin: 0 0 2.5rem 0;
        opacity: 0.9;
        max-width: 550px;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
    }

    .hero-stage {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        min-height: 400px;
    }

    /* High-contrast Flat Hero Burst (Graza/Fishwife style) */
    .hero-burst {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        padding-top: 120%;
        border-radius: 50%;
        z-index: 1;
        background: repeating-conic-gradient(var(--spice-secondary) 0 12deg, transparent 12deg 24deg);
        opacity: 1;
        animation: spinBurst 40s linear infinite;
        mask-image: radial-gradient(circle, black 30%, transparent 70%);
        -webkit-mask-image: radial-gradient(circle, black 30%, transparent 70%);
    }

    .burst-yellow { background: repeating-conic-gradient(#E8A33D 0 12deg, transparent 12deg 24deg); }
    .burst-orange { background: repeating-conic-gradient(#C1440E 0 12deg, transparent 12deg 24deg); }
    .burst-red { background: repeating-conic-gradient(#A8320A 0 12deg, transparent 12deg 24deg); }

    @keyframes spinBurst {
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .hero-can {
        position: relative;
        z-index: 5;
        height: 450px;
        width: 300px;
        object-fit: contain;
        animation: floatImg 6s ease-in-out infinite alternate;
        filter: drop-shadow(10px 10px 0px rgba(43,29,20,1)); /* Hard retro shadow */
    }

    @keyframes floatImg {
        0% { transform: translateY(0); }
        100% { transform: translateY(-20px); }
    }

    /* Flat Retro Stickers */
    .hero-sticker {
        position: absolute;
        z-index: 10;
        font-family: var(--font-heading);
        font-weight: 700;
        color: var(--spice-bg);
        background: var(--spice-text);
        border: 2px solid var(--spice-text);
        box-shadow: 4px 4px 0px rgba(43,29,20,1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 1.15rem;
        white-space: nowrap;
        animation: floatSticker 5s ease-in-out infinite alternate;
    }

    .hero-sticker span {
        color: var(--spice-text);
        background: var(--spice-secondary);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        margin-right: 0.25rem;
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 1rem;
    }

    .sticker-1 {
        top: 15%;
        left: -5%;
        transform: rotate(-5deg);
        animation-delay: 0s;
    }

    .sticker-2 {
        bottom: 20%;
        left: -10%;
        transform: rotate(3deg);
        animation-delay: 1.5s;
    }

    .sticker-3 {
        top: 45%;
        right: -15%;
        transform: rotate(6deg);
        animation-delay: 0.7s;
    }

    @keyframes floatSticker {
        0% { transform: translateY(0) rotate(var(--rotation, -5deg)); }
        100% { transform: translateY(-15px) rotate(var(--rotation, 5deg)); }
    }

    .slider-controls {
        position: absolute;
        bottom: 2rem;
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 10;
    }

    .slider-dots {
        display: flex;
        gap: 0.5rem;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(43,29,20,0.3);
        cursor: pointer;
        transition: all 0.3s;
    }

    .dot.active {
        background-color: var(--spice-primary);
        transform: scale(1.2);
    }

    /* Value Props */
    .value-props {
        background-color: var(--spice-primary);
        color: white;
        padding: 3rem 0;
    }

    .props-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        text-align: center;
    }

    .prop-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .prop-icon {
        color: var(--spice-secondary);
        margin-bottom: 1rem;
    }

    .prop-item h3 {
        font-family: var(--font-heading);
        font-size: 1.25rem;
        margin: 0 0 0.5rem 0;
    }

    .prop-item p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.8;
    }

    /* Categories */
    .spice-categories {
        padding: 6rem 0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 3rem;
    }

    .section-header.center {
        text-align: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .section-header h2 {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        color: var(--spice-primary);
        margin: 0;
    }

    .section-header p {
        color: var(--spice-text);
        opacity: 0.7;
        margin: 0.5rem 0 0 0;
    }

    .view-all {
        color: var(--spice-text);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--spice-primary);
        padding-bottom: 2px;
        transition: color 0.3s;
    }

    .view-all:hover {
        color: var(--spice-primary);
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .category-card {
        text-decoration: none;
        color: var(--spice-text);
        group: hover;
    }

    .cat-img-box {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }

    .cat-img-box img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .category-card:hover .cat-img-box img {
        transform: scale(1.05);
    }

    .cat-info h3 {
        font-family: var(--font-heading);
        font-size: 1.5rem;
        margin: 0 0 0.25rem 0;
        transition: color 0.3s;
    }

    .category-card:hover .cat-info h3 {
        color: var(--spice-primary);
    }

    .cat-info span {
        font-size: 0.9rem;
        opacity: 0.6;
    }

    /* Trending Products Fishwife Style */
    .trending-products {
        padding: 5rem 0;
        background-color: var(--spice-bg-alt);
        border-top: 2px solid var(--spice-text);
        border-bottom: 2px solid var(--spice-text);
    }

    .product-carousel {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 3rem;
    }

    .product-card {
        background: var(--spice-bg);
        border: 2px solid var(--spice-text);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 6px 6px 0px var(--spice-text);
        display: flex;
        flex-direction: column;
    }

    .product-img-wrapper {
        position: relative;
        display: block;
        padding-top: 100%;
        overflow: hidden;
        background: white;
        border-bottom: 2px solid var(--spice-text);
    }

    .product-details {
        text-align: center;
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-title {
        display: block;
        font-family: var(--font-heading);
        font-size: 1.25rem;
        color: var(--spice-text);
        text-decoration: none;
        margin-bottom: 0.5rem;
    }

    .quick-add {
        background: var(--spice-primary);
        color: var(--spice-bg);
        text-align: center;
        padding: 1rem 0;
        font-weight: 700;
        text-transform: uppercase;
        border-top: 2px solid var(--spice-text);
        cursor: pointer;
        transition: background 0.2s;
    }

    .quick-add:hover {
        background: var(--spice-accent);
    }

    .product-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        padding: 0.25rem 0.75rem;
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
    }

    .product-badge.sale { background-color: var(--spice-accent); }
    .product-badge.hot { background-color: var(--spice-secondary); color: var(--spice-text); }

    .product-img-wrapper img {
        position: absolute;
        top: 10%; left: 10%; width: 80%; height: 80%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }

    .product-vendor {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.6;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-weight: 700;
        margin-top: 0.5rem;
    }

    .price-current {
        color: var(--spice-primary);
        font-size: 1.1rem;
    }

    .price-compare {
        text-decoration: line-through;
        opacity: 0.5;
        margin-left: 0.5rem;
        font-weight: 400;
    }

    /* Spice Story */
    .spice-story {
        padding: 0;
    }

    /* Spice Story Warby Parker Grid */
    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-bottom: 2px solid var(--spice-text);
    }

    .story-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-height: 500px;
        border-right: 2px solid var(--spice-text);
    }

    .story-content {
        padding: 6rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        background-color: var(--spice-bg);
        color: var(--spice-text);
    }

    .story-content h2 {
        font-family: var(--font-heading);
        font-size: 3rem;
        margin: 0 0 1.5rem 0;
    }

    .story-content p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin: 0 0 2.5rem 0;
        opacity: 0.9;
    }



    @media (max-width: 900px) {
        .props-grid, .category-grid, .story-grid { grid-template-columns: 1fr; }
        .product-carousel { grid-template-columns: repeat(2, 1fr); }
        .hero-title { font-size: 3rem; }
        .slide-split { grid-template-columns: 1fr; text-align: center; gap: 2rem; padding: 3rem 1rem; }
        .hero-actions { justify-content: center; }
        .story-content { padding: 4rem 2rem; }
        .hero-visual img { max-height: 300px; }
    }
    
    @media (max-width: 600px) {
        .product-carousel { grid-template-columns: 1fr; }
        .hero-actions { flex-direction: column; }
    }
</style>

<script>
    // Hero Slider Logic
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlideIdx = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let slideInterval;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        window.goToSlide = function(index) {
            currentSlideIdx = index;
            showSlide(currentSlideIdx);
            resetInterval();
        };

        function nextSlide() {
            currentSlideIdx = (currentSlideIdx + 1) % slides.length;
            showSlide(currentSlideIdx);
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }

        if(slides.length > 0) {
            resetInterval();
        }
    });
</script>
@endsection
