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

        <!-- Zhen Hero Section -->
    <section class="zhen-hero">
        <div class="zhen-hero-content container">
            <div class="zhen-text-side">
                <div class="zhen-badge">
                    <span class="fire-icon">🔥</span> Bold Flavors, Infinite Spice
                </div>
                <h1 class="zhen-title">Simply<br><span class="highlight-yellow">Asian</span>, Truly<br>Exceptional</h1>
                <p class="zhen-desc">Discover the vibrant streets of Asia through our signature bowls and authentic street-food favorites.</p>
                <div class="zhen-actions">
                    <a href="/shop" class="btn-primary-zhen">Get Started &rarr;</a>
                    <a href="/about" class="btn-outline-zhen">Our Features</a>
                </div>
            </div>
            <div class="zhen-image-side">
                <img src="{{ asset('images/product_khong_nen.png') }}" alt="Asian Bento Box" class="zhen-hero-img">
            </div>
        </div>

        <div class="zhen-features container">
            <div class="zhen-feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Farm to Table Organic</h3>
                <p>We source our ingredients daily from local sustainable farms.</p>
            </div>
            <div class="zhen-feature-card">
                <div class="feature-icon">👨‍🍳</div>
                <h3>Master Chefs</h3>
                <p>Our dishes are prepared by expert chefs trained in traditional Asian techniques.</p>
            </div>
            <div class="zhen-feature-card">
                <div class="feature-icon">⏱️</div>
                <h3>Always Fresh</h3>
                <p>No pre-cooked meals. Every dish is prepared fresh the moment you order.</p>
            </div>
        </div>
    </section>

    <!-- Trending Products -->
    <section class="trending-products reveal">
        <div class="container">
            <div class="section-header">
                <h2>Trending Spices</h2>
                <a href="/shop" class="view-all">View all products &rarr;</a>
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

    

    /* Header color overrides for home page dark background */
    .spice-header .nav-link,
    .spice-header .cart-btn,
    .spice-header .cart-text {
        color: #F6F1EA !important;
    }
    .spice-header .nav-link:hover,
    .spice-header .nav-link.active,
    .spice-header .cart-btn:hover,
    .spice-header .cart-btn:hover .cart-text {
        color: #E0A83A !important;
    }
    .spice-header .nav-link::after {
        background-color: #E0A83A !important;
    }
    .spice-header {
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    }

    /* Zhen Hero Styles */
    .spice-header {
        position: absolute;
        top: 0; left: 0; right: 0;
        background: transparent !important;
        border-bottom: none !important;
        z-index: 100;
    }
    .spice-marquee {
        display: none; /* Hide marquee to make header flush top */
    }
    .zhen-hero {
        background-color: #3B2A20; 
        background: linear-gradient(135deg, #3B2A20 0%, #2A1D15 100%);
        min-height: 100vh;
        padding-top: 120px; 
        padding-bottom: 4rem;
        color: #F6F1EA;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }
    .zhen-hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        flex: 1;
    }
    .zhen-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 99px;
        font-family: var(--font-body, sans-serif);
        font-size: 0.9rem;
        margin-bottom: 2rem;
        color: #D7CBBC;
    }
    .zhen-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3rem, 5vw, 5.5rem);
        line-height: 1.1;
        margin: 0 0 1.5rem 0;
        color: #F6F1EA;
        font-weight: 700;
    }
    .zhen-title .highlight-yellow {
        color: #E0A83A;
    }
    .zhen-desc {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #D7CBBC;
        max-width: 450px;
        margin-bottom: 2.5rem;
    }
    .zhen-actions {
        display: flex;
        gap: 1rem;
    }
    .btn-primary-zhen {
        background-color: #E0A83A;
        color: #3B2A20;
        border: none;
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }
    .btn-primary-zhen:hover {
        background-color: #DB7B52;
        color: #F6F1EA;
        transform: translateY(-2px);
    }
    .btn-outline-zhen {
        background-color: rgba(255,255,255,0.1);
        color: #F6F1EA;
        border: none;
        padding: 1rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }
    .btn-outline-zhen:hover {
        background-color: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    .zhen-image-side {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .zhen-hero-img {
        max-width: 90%;
        height: auto;
        border-radius: 20px;
        transform: rotate(2deg) scale(0.9);
        box-shadow: 20px 20px 60px rgba(0,0,0,0.5);
        transition: transform 0.3s ease;
    }
    .zhen-hero-img:hover {
        transform: rotate(0deg) scale(0.95);
    }
    .zhen-features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 4rem;
    }
    .zhen-feature-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: background 0.3s ease;
    }
    .zhen-feature-card:hover {
        background: rgba(255,255,255,0.1);
    }
    .feature-icon {
        font-size: 1.5rem;
        color: #E0A83A;
        margin-bottom: 1rem;
        display: inline-flex;
        width: 48px; height: 48px;
        background: rgba(224, 168, 58, 0.2);
        border-radius: 12px;
        align-items: center;
        justify-content: center;
    }
    .zhen-feature-card h3 {
        color: #F6F1EA;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .zhen-feature-card p {
        color: #D7CBBC;
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0;
    }
    
    @media (max-width: 992px) {
        .zhen-hero-content {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .zhen-actions {
            justify-content: center;
        }
        .zhen-features {
            grid-template-columns: 1fr;
        }
        .zhen-hero-img {
            max-width: 90%;
            transform: none;
        }
        .zhen-hero-img:hover {
            transform: none;
        }
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

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    .product-card {
        background: var(--spice-bg);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-img-wrapper {
        position: relative;
        display: block;
        padding-top: 100%;
        overflow: hidden;
        background: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
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
        border-top: 1px solid rgba(0,0,0,0.05);
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
        .props-grid, .story-grid { grid-template-columns: 1fr; }
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
