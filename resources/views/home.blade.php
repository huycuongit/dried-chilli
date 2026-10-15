@extends('frontend.layouts.master')

@section('meta')
    <meta name="description" content="Jojo Little Kitchen - Shrimply Spicy Chilli Paste">
    <title>JOJO | Shrimply Spicy</title>
@endsection

@section('full-content')
<main class="yumyum-main">
    <!-- Announcement Bar -->
    <div class="announcement-bar">
        FREE SHIPPING ON ORDERS OVER $50 🔥
    </div>

    <!-- Hero Section -->
    <section class="yy-hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-eyebrow">TWO MOVES, ZERO EFFORT</div>
                <h1 class="hero-title">SHRIMPLY<br><span class="highlight-red">SPICY</span></h1>
                <p class="hero-desc">The ultimate umami bomb for your meals. Packed with real shrimp, garlic, and secret spices.</p>
                
                <div class="hero-ctas">
                    <a href="/shop" class="yy-btn btn-red">GET YOURS NOW <span class="price-tag">$10</span></a>
                    <a href="/stockists" class="yy-btn btn-outline">FIND IN STORES</a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="product-badge tilted-badge yellow-badge">CHEF-MADE</div>
                <div class="product-badge tilted-badge red-badge right-badge">EXTRA LEVEL 4 🔥</div>
                <div class="hero-image-container">
                    <!-- Rotating sunburst background -->
                    <div class="sunburst"></div>
                    <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Jojo Little Kitchen Shrimp Chilli" class="hero-product-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Infinite Marquee -->
    <div class="infinite-marquee">
        <div class="marquee-track">
            <span>NOW IN STORES ✦ UNDER 20 MINUTES ✦ SHAKE IT ON EVERYTHING ✦ </span>
            <span>NOW IN STORES ✦ UNDER 20 MINUTES ✦ SHAKE IT ON EVERYTHING ✦ </span>
        </div>
    </div>

    <!-- Divider Pattern -->
    <div class="pattern-divider"></div>

    <!-- Products Section -->
    <section class="yy-products container">
        <div class="section-header center">
            <h2>FOUR JARS. <span class="highlight-gold">EVERY CRAVING COVERED.</span></h2>
        </div>
        
        <div class="product-grid-yy">
            <!-- Product 1 -->
            <div class="yy-card card-red">
                <div class="card-badge">BEST SELLER</div>
                <div class="card-img-box">
                    <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Shrimply Spicy">
                </div>
                <div class="card-info">
                    <h3>SHRIMPLY SPICY</h3>
                    <p>The original umami bomb.</p>
                    <div class="card-action">
                        <span class="card-price">$10</span>
                        <button class="yy-btn btn-red btn-small">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!-- Product 2 (Placeholder variants to match style) -->
            <div class="yy-card card-blue">
                <div class="card-img-box">
                    <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Extra Spicy" style="filter: hue-rotate(220deg);">
                </div>
                <div class="card-info">
                    <h3>EXTRA SPICY</h3>
                    <p>For the brave souls.</p>
                    <div class="card-action">
                        <span class="card-price">$10</span>
                        <button class="yy-btn btn-blue btn-small">ADD TO CART</button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="yy-card card-green">
                <div class="card-img-box">
                    <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Garlic Crunch" style="filter: hue-rotate(90deg);">
                </div>
                <div class="card-info">
                    <h3>GARLIC CRUNCH</h3>
                    <p>Crispy, garlicky perfection.</p>
                    <div class="card-action">
                        <span class="card-price">$12</span>
                        <button class="yy-btn btn-green btn-small">ADD TO CART</button>
                    </div>
                </div>
            </div>
            
            <!-- Product 4 -->
            <div class="yy-card card-gold">
                <div class="card-badge">NEW</div>
                <div class="card-img-box">
                    <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Vegan Umami" style="filter: grayscale(0.5) sepia(1) hue-rotate(10deg) saturate(3);">
                </div>
                <div class="card-info">
                    <h3>VEGAN MUSHROOM</h3>
                    <p>Plant-based umami punch.</p>
                    <div class="card-action">
                        <span class="card-price">$12</span>
                        <button class="yy-btn btn-gold btn-small">ADD TO CART</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Split Feature Section -->
    <section class="yy-split-section">
        <div class="split-left">
            <h2 class="split-title">WHY JOJO?</h2>
            <div class="step-item">
                <div class="step-number">01</div>
                <div>
                    <h3>REAL INGREDIENTS</h3>
                    <p>No preservatives, no artificial colors. Just dried chilli, shallot, garlic, oil, salt, and seasoning.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">02</div>
                <div>
                    <h3>HANDCRAFTED</h3>
                    <p>Made in small batches to guarantee the perfect crunch and flavor balance.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">03</div>
                <div>
                    <h3>VERSATILE</h3>
                    <p>Use it on noodles, rice, eggs, or as a dipping sauce. It elevates everything.</p>
                </div>
            </div>
        </div>
        <div class="split-divider">
            <div class="vs-badge">VS</div>
        </div>
        <div class="split-right">
            <img src="{{ asset('images/shrimp_chilli.png') }}" alt="Jojo Chilli" class="split-img">
        </div>
    </section>
</main>

<style>
    .announcement-bar {
        background-color: var(--yy-red);
        color: white;
        text-align: center;
        padding: 0.5rem;
        font-family: var(--font-display);
        font-size: 1.25rem;
        letter-spacing: 1px;
        border-bottom: 2px solid var(--yy-black);
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Brutalist Buttons */
    .yy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        border-radius: 20px;
        font-family: var(--font-display);
        font-size: 1.5rem;
        text-decoration: none;
        border: 2px solid var(--yy-black);
        box-shadow: 4px 4px 0px var(--yy-black);
        cursor: pointer;
        transition: all 0.15s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .yy-btn:active {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px var(--yy-black);
    }

    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 1.2rem;
    }

    .btn-red { background-color: var(--yy-red); color: white; }
    .btn-red:hover { background-color: #C0291F; }

    .btn-outline { background-color: var(--yy-bg); color: var(--yy-black); }
    .btn-outline:hover { background-color: white; }

    .btn-blue { background-color: #1E5B94; color: white; }
    .btn-green { background-color: #2E6B27; color: white; }
    .btn-gold { background-color: #D99B00; color: white; }

    .price-tag {
        background: var(--yy-gold);
        color: var(--yy-black);
        padding: 0.1rem 0.5rem;
        border-radius: 20px;
        margin-left: 0.75rem;
        border: 2px solid var(--yy-black);
    }

    /* Hero Section */
    .yy-hero {
        padding: 6rem 2rem;
        border-bottom: 2px solid var(--yy-black);
        overflow: hidden;
    }

    .hero-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .hero-eyebrow {
        font-weight: 800;
        letter-spacing: 2px;
        color: var(--yy-red);
        margin-bottom: 1rem;
    }

    .hero-title {
        font-family: var(--font-display);
        font-size: clamp(4rem, 8vw, 8rem);
        line-height: 0.9;
        margin: 0 0 2rem 0;
        text-transform: uppercase;
        color: var(--yy-black);
        text-shadow: 2px 2px 0px rgba(0,0,0,0.1);
    }

    .highlight-red {
        color: var(--yy-red);
        display: block;
    }
    
    .highlight-gold {
        color: var(--yy-gold);
    }

    .hero-desc {
        font-size: 1.25rem;
        font-weight: 600;
        max-width: 500px;
        margin-bottom: 3rem;
        line-height: 1.5;
    }

    .hero-ctas {
        display: flex;
        gap: 1.5rem;
    }

    .hero-visual {
        position: relative;
        display: flex;
        justify-content: center;
    }

    .hero-image-container {
        position: relative;
        width: 100%;
        max-width: 500px;
        aspect-ratio: 1;
    }

    .sunburst {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        height: 120%;
        background: repeating-conic-gradient(
            var(--yy-gold) 0 10deg,
            var(--yy-bg) 10deg 20deg
        );
        border-radius: 20px;
        z-index: -1;
        animation: spin 40s linear infinite;
        opacity: 0.6;
        mask-image: radial-gradient(circle, black 40%, transparent 70%);
        -webkit-mask-image: radial-gradient(circle, black 40%, transparent 70%);
    }

    @keyframes spin { 100% { transform: translate(-50%, -50%) rotate(360deg); } }

    .hero-product-img {
        width: 100%;
        height: auto;
        position: relative;
        z-index: 2;
        filter: drop-shadow(10px 15px 15px rgba(0,0,0,0.4));
        transform: rotate(5deg);
        transition: transform 0.5s;
    }
    
    .hero-product-img:hover {
        transform: rotate(0deg) scale(1.05);
    }

    .tilted-badge {
        position: absolute;
        z-index: 10;
        font-family: var(--font-display);
        font-size: 1.5rem;
        padding: 0.5rem 1.5rem;
        border: 2px solid var(--yy-black);
        border-radius: 20px;
        box-shadow: 3px 3px 0px var(--yy-black);
    }

    .yellow-badge {
        background: var(--yy-gold);
        color: var(--yy-black);
        top: 10%;
        left: 0;
        transform: rotate(-10deg);
    }

    .red-badge {
        background: var(--yy-red);
        color: white;
        bottom: 10%;
        right: 0;
        transform: rotate(8deg);
    }

    /* Infinite Marquee */
    .infinite-marquee {
        background-color: var(--yy-black);
        color: white;
        font-family: var(--font-display);
        font-size: 2rem;
        padding: 1rem 0;
        overflow: hidden;
        white-space: nowrap;
        border-bottom: 2px solid var(--yy-black);
    }

    .marquee-track {
        display: inline-block;
        animation: marquee 15s linear infinite;
    }

    .marquee-track span {
        margin-right: 1rem;
    }

    /* Products Section */
    .yy-products {
        padding: 6rem 2rem;
    }

    .section-header.center {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-header h2 {
        font-family: var(--font-display);
        font-size: 4rem;
        margin: 0;
        letter-spacing: 1px;
    }

    .product-grid-yy {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .yy-card {
        border: 2px solid var(--yy-black);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        box-shadow: 6px 6px 0px var(--yy-black);
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }

    .yy-card:hover {
        transform: translate(-2px, -2px);
        box-shadow: 8px 8px 0px var(--yy-black);
    }

    .card-red { background-color: #F9E4DE; }
    .card-blue { background-color: #DCEAF4; }
    .card-green { background-color: #DCEDD9; }
    .card-gold { background-color: #F7EECD; }

    .card-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--yy-gold);
        color: var(--yy-black);
        font-family: var(--font-display);
        padding: 0.25rem 0.75rem;
        border: 2px solid var(--yy-black);
        border-radius: 20px;
        z-index: 2;
        transform: rotate(-3deg);
    }

    .card-img-box {
        padding: 2rem;
        display: flex;
        justify-content: center;
        border-bottom: 2px solid var(--yy-black);
        background: rgba(255,255,255,0.3);
    }

    .card-img-box img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.2));
        transition: transform 0.3s;
    }

    .yy-card:hover .card-img-box img {
        transform: scale(1.1) rotate(5deg);
    }

    .card-info {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-info h3 {
        font-family: var(--font-display);
        font-size: 2rem;
        margin: 0 0 0.5rem 0;
        line-height: 1;
    }

    .card-info p {
        font-weight: 600;
        margin: 0 0 1.5rem 0;
    }

    .card-action {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-price {
        font-family: var(--font-display);
        font-size: 2rem;
    }

    /* Split Section */
    .yy-split-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-top: 2px solid var(--yy-black);
        border-bottom: 2px solid var(--yy-black);
        position: relative;
    }

    .split-left {
        background-color: var(--yy-red);
        color: white;
        padding: 6rem 4rem;
    }

    .split-title {
        font-family: var(--font-display);
        font-size: 4rem;
        margin-top: 0;
        margin-bottom: 3rem;
    }

    .step-item {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .step-number {
        font-family: var(--font-display);
        font-size: 3rem;
        color: var(--yy-gold);
        text-shadow: 2px 2px 0px var(--yy-black);
        line-height: 1;
    }

    .step-item h3 {
        font-family: var(--font-display);
        font-size: 1.8rem;
        margin: 0 0 0.5rem 0;
    }

    .step-item p {
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
        line-height: 1.5;
    }

    .split-right {
        background-color: #DCEAF4;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem;
    }

    .split-img {
        max-width: 80%;
        height: auto;
        filter: drop-shadow(15px 15px 0px rgba(0,0,0,0.1));
    }

    .split-divider {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background-color: var(--yy-black);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vs-badge {
        background-color: var(--yy-gold);
        color: var(--yy-black);
        width: 80px;
        height: 80px;
        border-radius: 20px;
        border: 2px solid var(--yy-black);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 2.5rem;
        transform: translateX(-1px);
        box-shadow: 4px 4px 0px var(--yy-black);
    }

    @media (max-width: 900px) {
        .hero-container {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2rem;
        }
        .hero-desc { margin: 0 auto 3rem auto; }
        .hero-ctas { justify-content: center; }
        .hero-title { font-size: 4rem; }
        .yy-split-section { grid-template-columns: 1fr; }
        .split-divider {
            width: 100%;
            height: 2px;
            top: auto;
            bottom: auto;
            left: 0;
            right: 0;
        }
        .vs-badge { transform: translateY(-50%); }
    }
</style>
@endsection
