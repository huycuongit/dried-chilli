@extends('frontend.layouts.master')

@section('meta')
<meta name="description" content="Dried Chili - Premium quality spices, chillies, and organic seasonings.">
<title>Dried Chili</title>
@endsection

@section('full-content')
<main class="spice-main">
    <!-- Hero Slider Section -->
    <section class="spice-hero-slider">
        <div class="slider-container" id="heroSlider">
            <!-- Slide 1 (Content Left, Image Right) -->
            <div class="slide active">
                <div class="slide-split container">
                    <!-- Left: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">THE ORIGINAL FLAVOR</span>
                        <h1 class="hero-title">SHRIMPLY<br>EXTRA SPICY</h1>
                        <p class="hero-desc">The ultimate umami bomb. Handcrafted with authentic shrimp and our
                            signature spice blend.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">
                                <span>Shop Now</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">

                        <!-- Floating Pills -->
                        <span class="hero-sticker sticker-1">Chef-made</span>
                        <span class="hero-sticker sticker-2"><span>150,000+</span> jars sold</span>
                    </div>
                </div>
            </div>

            <!-- Slide 2 (Image Left, Content Right) -->
            <div class="slide">
                <div class="slide-split container">
                    <!-- Left: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-red"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">New Recipe</span>
                        <span class="hero-sticker sticker-2"><span>Extra</span> Crunchy</span>
                    </div>

                    <!-- Right: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">NEW ARRIVAL RECIPE</span>
                        <h1 class="hero-title">EXTRA<br>GARLIC CRUNCH</h1>
                        <p class="hero-desc">Take your daily meals to the next level with our extra garlicky, crunchy
                            chilli crisp.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">
                                <span>Discover</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 (Content Left, Image Right) -->
            <div class="slide">
                <div class="slide-split container">
                    <!-- Left: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">LIMITED SPICE EDITION</span>
                        <h1 class="hero-title">SMOKY<br>FIRE ROASTED</h1>
                        <p class="hero-desc">Experience the deep smoky flavor of premium chillies roasted slowly over an
                            open flame.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">
                                <span>Shop Limited</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-yellow"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">Smoky</span>
                        <span class="hero-sticker sticker-2"><span>Award</span> Winning</span>
                    </div>
                </div>
            </div>

            <!-- Slide 4 (Image Left, Content Right) -->
            <div class="slide">
                <div class="slide-split container">
                    <!-- Left: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-red"></div>
                        <img class="hero-can" src="{{ asset('images/product_hero.png') }}" alt="Dried Chili Product">
                        <span class="hero-sticker sticker-1">Plant Based</span>
                        <span class="hero-sticker sticker-2"><span>No</span> MSG</span>
                    </div>

                    <!-- Right: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">ORGANIC VEGAN BLEND</span>
                        <h1 class="hero-title">ORGANIC<br>PLANT POWER</h1>
                        <p class="hero-desc">All the umami, none of the seafood. Our vegan recipe delivers the same
                            intense punch.</p>
                        <div class="hero-actions">
                            <a href="/shop" class="btn-primary">
                                <span>Try Vegan</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
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

    <!-- Features Banner (180px Height & Centered Stacked Layout) -->
    <section class="spice-features-banner">
        <div class="container">
            <div class="features-banner-grid">
                <div class="feature-col">
                    <div class="feature-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h3 class="feature-title">100% Authentic</h3>
                        <p class="feature-desc">Pure ingredients, no artificial additives</p>
                    </div>
                </div>
                <div class="feature-col">
                    <div class="feature-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h3 class="feature-title">Sourced Globally</h3>
                        <p class="feature-desc">Direct from premier spice farms</p>
                    </div>
                </div>
                <div class="feature-col">
                    <div class="feature-icon-wrap">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                            <path d="M15 18H9" />
                            <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                            <circle cx="17" cy="18" r="2" />
                            <circle cx="7" cy="18" r="2" />
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h3 class="feature-title">Fast Delivery</h3>
                        <p class="feature-desc">Freshness delivered to your doorstep</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
    /* ĐỒNG BỘ TOÀN BỘ TEXT TIÊU ĐỀ TRANG CHỦ FONT-WEIGHT: 800 */
    .hero-title,
    .feature-title,
    .serif-title,
    .social-feed h2,
    .story-content h2,
    .bundle-title,
    .testi-heading,
    .spice-main h1,
    .spice-main h2,
    .spice-main h3,
    .spice-main h4 {
        font-weight: 800 !important;
    }

    .spice-features-banner {
        background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-accent) 55%, #8A1504 100%);
        color: #ffffff;
        min-height: 180px;
        display: flex;
        align-items: center;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        padding: 1.5rem 0;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .spice-features-banner .container {
        width: 100%;
    }

    .features-banner-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        align-items: center;
    }

    .feature-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 0.65rem;
        padding: 0.5rem 1.5rem;
    }

    .feature-col:not(:last-child) {
        border-right: 1px solid rgba(255, 255, 255, 0.22);
    }

    .feature-icon-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.14);
        flex-shrink: 0;
        color: #ffffff;
    }

    .feature-text {
        text-align: center;
    }

    .feature-title {
        font-family: var(--font-heading);
        font-size: 18px;
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: 0.3px;
        margin: 0;
        color: #ffffff;
    }

    .feature-desc {
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        margin: 0.25rem auto 0 auto;
        max-width: 260px;
        color: rgba(255, 255, 255, 0.9);
    }

    @media (max-width: 991px) {
        .feature-col {
            padding: 0.5rem 0.75rem;
        }

        .feature-title {
            font-size: 0.95rem;
        }

        .feature-desc {
            font-size: 0.8rem;
        }

        .feature-icon-wrap {
            width: 42px;
            height: 42px;
        }

        .feature-icon-wrap svg {
            width: 20px;
            height: 20px;
        }
    }

    @media (max-width: 768px) {
        .spice-features-banner {
            min-height: auto;
            padding: 2.5rem 0;
        }

        .features-banner-grid {
            grid-template-columns: 1fr;
            gap: 1.75rem;
        }

        .feature-col {
            border-right: none !important;
            max-width: 320px;
            margin: 0 auto;
            width: 100%;
            padding: 0;
        }
    }
    </style>

    <!-- Trending Products -->
    <section class="trending-products reveal">
        <div class="container">
            <div class="section-header rich-header">
                <div class="header-content">
                    <span class="section-subtitle">🔥 HOT RIGHT NOW</span>
                    <h2 class="serif-title">Trending Spices</h2>
                    <p class="section-desc">Hand-picked community favorites. Elevate your everyday meals with our
                        most-loved, top-rated chili blends.</p>
                </div>
                <div class="header-action">
                    <a href="/shop" class="view-all-btn">
                        <span>SHOP ALL SPICES</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="product-carousel">
                @foreach($latestProducts->take(3) as $product)
                <div class="product-card">
                    @if($product->sale_price)
                    <div class="product-badge sale">Sale</div>
                    @else
                    <div class="product-badge hot">Hot</div>
                    @endif
                    <div class="product-img-wrapper">
                        <a href="{{ route('page.product', $product->slug) }}"
                            style="display: block; width: 100%; height: 100%;">
                            <img src="{{ asset('images/product_hero.png') }}" alt="{{ $product->name }}">
                        </a>
                        <button type="button" class="quick-add" data-product-id="{{ $product->id }}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            <span>Quick Add</span>
                        </button>
                    </div>
                    <div class="product-details">
                        <div class="product-vendor">DRIED CHILI</div>
                        <a href="{{ route('page.product', $product->slug) }}"
                            class="product-title">{{ $product->name }}</a>
                        <div class="product-price">
                            @if($product->sale_price)
                            <span class="price-current">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="price-compare">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span class="price-current">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>




    <!-- Social Videos Section (Inspired by Nafu Services) -->
    <section class="social-feed">
        <div class="wrap container">
            <div class="sec-head reveal in" style="margin-bottom:clamp(22px,3vw,36px)">
                <span class="label">Straight off the feed</span>
                <h2>The wok never stops.</h2>
            </div>
        </div>
        <div class="feed-track" id="feedTrack" aria-label="Social videos">
            <div class="feed-marquee">
                <div class="feed-half">
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/e14dc2cc87cc489c86fb9d08f59b0ce7.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/43e35e54bd8548b8a407a31527c5091b.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/1a93967f093d48399118f58f8c2da686.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/409babbdc3204efc9380fbac89c833af.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/3167fa95aa5642a8b1d90db9ba3f2a1b.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/1e91aa473a284eb191ec595e2d9d8703.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/f138f17e76914bd1a163b936cf8d33a1.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/e14cdc798d7f48b4a1677003f757141a.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/63e262bcf23748ceb1e9d5d35ed79ee3.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                </div>
                <div class="feed-half">
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/e14dc2cc87cc489c86fb9d08f59b0ce7.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/43e35e54bd8548b8a407a31527c5091b.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/1a93967f093d48399118f58f8c2da686.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/409babbdc3204efc9380fbac89c833af.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/3167fa95aa5642a8b1d90db9ba3f2a1b.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/1e91aa473a284eb191ec595e2d9d8703.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/f138f17e76914bd1a163b936cf8d33a1.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/e14cdc798d7f48b4a1677003f757141a.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                    <div class="feed-card"><video
                            data-src="https://cdn.shopify.com/videos/c/o/v/63e262bcf23748ceb1e9d5d35ed79ee3.mp4"
                            crossorigin="anonymous" preload="none" muted loop playsinline></video><span
                            class="feed-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>@yumyum.au</span></div>
                </div>
            </div>
        </div>
        <div class="wrap container" style="text-align:center;margin-top:26px">
            <a class="btn-ghost" href="https://instagram.com/yumyum.au" target="_blank" rel="noopener">Follow
                @yumyum.au</a>
            <a class="btn-ghost" href="https://www.tiktok.com/@dimsimlim" target="_blank" rel="noopener">TikTok
                @dimsimlim</a>
        </div>
    </section>

    <!-- Image with Text -->
    <section class="spice-story reveal">
        <div class="container">
            <div class="story-grid">
                <div class="story-image">
                    <img src="{{ asset('images/story_spices.jpg') }}" alt="Spices on market">
                </div>
                <div class="story-content">
                    <span class="subheading">OUR STORY</span>
                    <h2>Passionate About Flavor</h2>
                    <p>We believe that every dish tells a story, and the spices you use are its vocabulary. Our journey
                        began in the vibrant spice markets of Asia, bringing authentic, sun-dried chillies and
                        hand-ground spices to home chefs who demand the best.</p>
                    <a href="/about" class="btn-primary">
                        <span>Learn More</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Compact Testimonials -->
    <section class="spice-compact-testimonials reveal">
        <div class="container">
            <div class="testi-header-flex">
                <h2 class="testi-heading">Clients are saying</h2>
                <div class="testi-rating-overall">
                    <span class="stars">★★★★★</span>
                    <span class="rating-text">4.9/5 from 10,000+ reviews</span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="testi-grid-container">
                <div class="compact-testimonial-item premium-card">
                    <div class="card-top">
                        <div class="stars">★★★★★</div>
                        <svg class="quote-icon" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="var(--spice-primary)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" opacity="0.4" aria-hidden="true">
                            <path
                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                            <path
                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                        </svg>
                    </div>
                    <p>"This chili powder brings the perfect fiery kick to my daily cooking. Absolutely obsessed!"</p>
                    <div class="testi-footer">
                        <div class="author-initials">MT</div>
                        <div class="author-info">
                            <strong class="author-name">Minh Tran</strong>
                            <span class="author-sub">Home Chef • Verified Buyer</span>
                        </div>
                    </div>
                </div>

                <div class="compact-testimonial-item premium-card">
                    <div class="card-top">
                        <div class="stars">★★★★★</div>
                        <svg class="quote-icon" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="var(--spice-primary)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" opacity="0.4" aria-hidden="true">
                            <path
                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                            <path
                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                        </svg>
                    </div>
                    <p>"The curry blend is incredibly authentic. It transformed my weekend dinners into a masterpiece."
                    </p>
                    <div class="testi-footer">
                        <div class="author-initials">SW</div>
                        <div class="author-info">
                            <strong class="author-name">Sarah Woods</strong>
                            <span class="author-sub">Weekend Cook • Verified Buyer</span>
                        </div>
                    </div>
                </div>

                <div class="compact-testimonial-item premium-card">
                    <div class="card-top">
                        <div class="stars">★★★★★</div>
                        <svg class="quote-icon" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="var(--spice-primary)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" opacity="0.4" aria-hidden="true">
                            <path
                                d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                            <path
                                d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z" />
                        </svg>
                    </div>
                    <p>"I've never tasted spices this fresh and aromatic before. The heat level is just perfect."</p>
                    <div class="testi-footer">
                        <div class="author-initials">DL</div>
                        <div class="author-info">
                            <strong class="author-name">David Lee</strong>
                            <span class="author-sub">Culinary Student • Verified Buyer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Social Feed Section */
.social-feed {
    padding: 5rem 0;
    background-color: var(--spice-bg);
    overflow: hidden;
}

.social-feed .label {
    display: block;
    font-family: var(--font-body);
    color: var(--spice-primary);
    text-transform: uppercase;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.social-feed h2 {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    color: var(--spice-bg-dark);
    font-weight: 800;
    margin: 0;
    line-height: 1.15;
}

.feed-track {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-top: 4px solid var(--spice-bg-dark);
    border-bottom: 4px solid var(--spice-bg-dark);
    padding: 2rem 0;
    margin-top: 2rem;
}

.feed-marquee {
    display: flex;
    width: max-content;
    animation: feedScroll 40s linear infinite;
    will-change: transform;
    transform: translate3d(0, 0, 0);
}

.feed-marquee:hover {
    animation-play-state: paused;
}

.feed-half {
    display: flex;
    gap: 1.5rem;
    padding-right: 1.5rem;
}

.feed-card {
    position: relative;
    width: 260px;
    aspect-ratio: 9/16;
    border-radius: 20px;
    overflow: hidden;
    background: #111;
    flex-shrink: 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    contain: layout paint;
    backface-visibility: hidden;
    transform: translateZ(0);
}

.feed-card:hover {
    transform: scale(1.02);
}

.feed-card video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.9;
    display: block;
    pointer-events: none;
    background: #111;
}

.feed-card:hover video {
    opacity: 1;
}

.feed-badge {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    padding: 0.5rem 0.9rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    backdrop-filter: blur(4px);
}

.btn-ghost {
    display: inline-block;
    border: 2px solid var(--spice-bg-dark);
    color: var(--spice-bg-dark);
    padding: 0.8rem 1.8rem;
    border-radius: 20px;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.3s;
    margin: 0.5rem;
}

.btn-ghost:hover {
    background: var(--spice-bg-dark);
    color: #FDF9F1;
}

@keyframes feedScroll {
    to {
        transform: translate3d(-50%, 0, 0);
    }
}

@media (max-width: 768px) {
    .feed-card {
        width: 200px;
    }
}

/* Compact Testimonials Section */
.spice-compact-testimonials {
    padding: 6rem 0;
    background-color: var(--spice-bg);
    overflow: hidden;
}

.testi-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.testi-heading {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    font-weight: 800;
    color: var(--spice-bg-dark);
    margin: 0;
    line-height: 1.15;
}

.testi-rating-overall {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.testi-rating-overall .stars {
    color: var(--spice-honey);
    font-size: 1.5rem;
    letter-spacing: 2px;
}

.testi-rating-overall .rating-text {
    font-size: 1rem;
    color: #5C4B41;
    font-weight: 600;
}

.testi-grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 1rem;
}

.compact-testimonial-item.premium-card {
    width: 100%;
    background-color: var(--spice-bg-dark);
    border-radius: 20px;
    padding: 2.5rem;
    border: 1px solid rgba(181, 186, 194, 0.15);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.compact-testimonial-item.premium-card:hover {
    transform: translateY(-5px);
}

.card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.card-top .stars {
    color: var(--spice-honey);
    font-size: 1.25rem;
    letter-spacing: 2px;
}

.compact-testimonial-item.premium-card p {
    font-family: var(--font-body);
    font-size: 16px;
    color: #FDF9F1;
    line-height: 1.65;
    margin-bottom: 2.5rem;
    flex-grow: 1;
    font-weight: 400;
    text-align: justify;
    text-justify: inter-word;
}

.testi-footer {
    display: flex;
    align-items: center;
    gap: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 1.5rem;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.author-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #FDF9F1;
}

.author-sub {
    font-size: 0.85rem;
    color: rgba(253, 249, 241, 0.6);
}

.author-initials {
    background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-tangerine) 100%);
    color: #fff;
    font-weight: 800;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    font-size: 1.1rem;
    box-shadow: 0 4px 10px rgba(196, 20, 30, 0.35);
}

@media (max-width: 1024px) {
    .testi-grid-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .testi-header-flex {
        flex-direction: column;
        align-items: flex-start;
    }

    .testi-rating-overall {
        align-items: flex-start;
    }

    .testi-grid-container {
        grid-template-columns: 1fr;
    }

    .compact-testimonial-item.premium-card {
        padding: 2rem;
    }
}

/* Buttons - Elegant Style */
.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    background: linear-gradient(135deg, var(--spice-primary) 0%, var(--spice-tangerine) 100%);
    color: #FDFBF7;
    padding: 0.95rem 2.2rem;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    text-decoration: none;
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(228, 93, 62, 0.3);
    /* Coral Shadow */
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(196, 20, 30, 0.45);
    background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-accent) 100%);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    background-color: transparent;
    color: var(--spice-text);
    padding: 0.95rem 2.2rem;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    text-decoration: none;
    border: 2px solid var(--spice-text);
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background-color: var(--spice-text);
    color: #FDFBF7;
    transform: translateY(-3px);
}








/* Hero Slider */
.spice-hero-slider {
    position: relative;
    background-color: #EFE4D3;
    /* Soft earthy background */
    overflow: hidden;
    height: 650px;
    min-height: 650px;
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
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.6s cubic-bezier(0.2, 0.8, 0.2, 1), visibility 0.6s;
    display: flex;
    align-items: center;
    pointer-events: none;
    z-index: 1;
}

.slide.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    z-index: 3;
}

/* Lớp fading-out: từ từ ẩn đi êm ái trước khi slide mới xuất hiện */
.slide.fading-out {
    opacity: 0;
    visibility: visible;
    transition: opacity 0.35s ease-out;
    pointer-events: none;
    z-index: 2;
}

.slide:not(.active):not(.fading-out) .hero-sticker {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.2s ease, visibility 0.2s ease;
}

.slide-split {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    align-items: center;
    gap: 100px;
    /* Giãn cách hero-content và hero-stage cách xa nhau 100px */
    height: 100%;
    max-width: 1430px;
    margin: 0 auto;
    padding: 0 1.5rem;
    box-sizing: border-box;
}

.hero-content {
    position: relative;
    z-index: 5;
    /* Đảm bảo nội dung chữ luôn ở tầng trên cùng */
    width: 100%;
    height: 100%;
    min-width: 0;
    color: var(--spice-text);
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-sizing: border-box;
    opacity: 0;
    transform: translateY(14px);
    transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.1s, transform 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.1s;
}

.slide.active .hero-content {
    opacity: 1;
    transform: translateY(0);
}

.hero-subtitle {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    font-size: 0.85rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--spice-fire);
    font-weight: 700;
    margin-bottom: 0.75rem;
    /* Giảm margin dưới để nội dung không bị đội lên */
    border: 2px solid var(--spice-fire);
    padding: 0.35rem 1.1rem;
    border-radius: 20px;
    line-height: 1;
}

.hero-title {
    font-family: var(--font-heading);
    font-size: clamp(48px, 4.2vw, 64px);
    line-height: 1.08;
    margin: 0 0 0.85rem 0;
    /* Giảm margin dưới */
    color: #2A0800;
    word-wrap: break-word;
    overflow-wrap: break-word;
    display: flex;
    align-items: flex-start;
    font-weight: 800;
}

.hero-desc {
    font-family: var(--font-body);
    color: #5C4B41;
    font-size: 16px;
    line-height: 1.65;
    margin: 0 0 1.4rem 0;
    /* Giảm margin dưới */
    max-width: 480px;
    text-align: justify;
    text-justify: inter-word;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.hero-stage {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    min-height: 480px;
    /* Giảm min-height từ 520px về 480px để hạ độ cao, không bị ăn lên phía trên */
    min-width: 0;
    box-sizing: border-box;
    opacity: 0;
    transform: scale(0.96);
    transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.08s, transform 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.08s;
}

.slide.active .hero-stage {
    opacity: 1;
    transform: scale(1);
}

/* Hero Burst 700px x 700px - Cân đối, tỏa sáng dịu mắt */
.hero-burst {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 700px;
    height: 700px;
    border-radius: 50%;
    z-index: 1;
    background: repeating-conic-gradient(#E8A33D 0 12deg, transparent 12deg 24deg);
    opacity: 1;
    animation: spinBurst 40s linear infinite;
    mask-image: radial-gradient(circle, black 32%, transparent 70%);
    -webkit-mask-image: radial-gradient(circle, black 32%, transparent 70%);
    pointer-events: none;
}

.slide:not(.active):not(.fading-out) .hero-burst {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

.burst-yellow {
    background: repeating-conic-gradient(#E8A33D 0 12deg, transparent 12deg 24deg);
}

.burst-orange {
    background: repeating-conic-gradient(#C1440E 0 12deg, transparent 12deg 24deg);
}

.burst-red {
    background: repeating-conic-gradient(#A8320A 0 12deg, transparent 12deg 24deg);
}

@keyframes spinBurst {
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

.hero-can {
    position: relative;
    z-index: 5;
    height: 450px;
    width: 300px;
    object-fit: contain;
    animation: floatImg 6s ease-in-out infinite alternate;
    filter: drop-shadow(10px 10px 0px rgba(43, 29, 20, 1));
    /* Hard retro shadow */
}

@keyframes floatImg {
    0% {
        transform: translateY(0);
    }

    100% {
        transform: translateY(-20px);
    }
}

/* Flat Hero Floating Stickers - Dynamic, Weightless & Organic */
.hero-sticker {
    position: absolute;
    z-index: 10;
    font-family: var(--font-heading);
    font-weight: 700;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    padding: 0.6rem 1.3rem;
    border-radius: 20px;
    font-size: 1rem;
    letter-spacing: 0.5px;
    white-space: nowrap;
    will-change: transform;
    pointer-events: none;
    transition: transform 0.3s ease;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.55);
}

.hero-sticker span {
    background: transparent;
    padding: 0;
    margin-right: 0.25rem;
    font-family: inherit;
    font-weight: 800;
    font-size: inherit;
}

/* ==========================================================================
       STRICTLY CONTAINED STICKER COORDINATES (ZERO TEXT OVERLAP GUARANTEED)
       Phối màu chuẩn: 1 Nóng kèm 1 Lạnh, 1 Lạnh kèm Trá Sáng, Tương phản cao
       ========================================================================== */

/* --- SLIDE 1 (Original Flavor): 1 Nóng (Chili Coral) + 1 Lạnh (Cool Jade Mint) kèm Trá Sáng --- */
.slide:nth-child(1) .sticker-1 {
    top: 8%;
    left: 0%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #FF5722;
    background: rgba(45, 12, 10, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(255, 87, 34, 0.35);
    animation: floatDream1 5.6s ease-in-out infinite alternate;
}

.slide:nth-child(1) .sticker-1 span {
    color: #FF8A65;
}

.slide:nth-child(1) .sticker-2 {
    bottom: 12%;
    right: 4%;
    left: auto;
    top: auto;
    color: #FFFFFF;
    border: 2px solid #5EEAD4;
    background: rgba(10, 36, 32, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(94, 234, 212, 0.35);
    animation: floatDream2 7.0s ease-in-out 0.6s infinite alternate;
}

.slide:nth-child(1) .sticker-2 span {
    color: #5EEAD4;
}

/* --- SLIDE 2 (Garlic Crunch): 1 Lạnh (Arctic Cyan) kèm Trá Sáng + 1 Nóng (Garlic Amber) --- */
.slide:nth-child(2) .sticker-1 {
    top: 12%;
    left: 2%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #38BDF8;
    background: rgba(12, 34, 50, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(56, 189, 248, 0.35);
    animation: floatDream3 6.2s ease-in-out 0.2s infinite alternate;
}

.slide:nth-child(2) .sticker-1 span {
    color: #7DD3FC;
}

.slide:nth-child(2) .sticker-2 {
    bottom: 14%;
    right: 6%;
    left: auto;
    top: auto;
    color: #FFFFFF;
    border: 2px solid #F59E0B;
    background: rgba(48, 22, 6, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(245, 158, 11, 0.35);
    animation: floatDream4 7.6s ease-in-out 1.0s infinite alternate;
}

.slide:nth-child(2) .sticker-2 span {
    color: #FBBF24;
}

/* --- SLIDE 3 (Fire Roasted): 1 Nóng (Smoky Crimson) + 1 Lạnh (Glacier Emerald) kèm Trá Sáng --- */
.slide:nth-child(3) .sticker-1 {
    top: 8%;
    left: 2%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #EF4444;
    background: rgba(50, 10, 10, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 22px rgba(239, 68, 68, 0.4);
    animation: floatDream5 5.0s ease-in-out 0.4s infinite alternate;
}

.slide:nth-child(3) .sticker-1 span {
    color: #FCA5A5;
}

.slide:nth-child(3) .sticker-2 {
    bottom: 12%;
    right: 4%;
    left: auto;
    top: auto;
    color: #FFFFFF;
    border: 2px solid #34D399;
    background: rgba(10, 38, 30, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 22px rgba(52, 211, 153, 0.35);
    animation: floatDream6 8.2s ease-in-out 0.3s infinite alternate;
}

.slide:nth-child(3) .sticker-2 span {
    color: #6EE7B7;
}

/* --- SLIDE 4 (Plant Power): 1 Lạnh (Botanical Green) kèm Trá Sáng + 1 Nóng (Warm Tangerine) --- */
.slide:nth-child(4) .sticker-1 {
    top: 6%;
    left: 4%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #4ADE80;
    background: rgba(12, 38, 20, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(74, 222, 128, 0.35);
    animation: floatDream7 6.4s ease-in-out 0.5s infinite alternate;
}

.slide:nth-child(4) .sticker-1 span {
    color: #86EFAC;
}

.slide:nth-child(4) .sticker-2 {
    bottom: 12%;
    right: 4%;
    left: auto;
    top: auto;
    color: #FFFFFF;
    border: 2px solid #FB923C;
    background: rgba(50, 18, 10, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(251, 146, 60, 0.35);
    animation: floatDream8 6.8s ease-in-out 0.9s infinite alternate;
}

.slide:nth-child(4) .sticker-2 span {
    color: #FACC15;
}

/* ==========================================================================
       INDIVIDUALIZED ORGANIC ZERO-GRAVITY KEYFRAMES (BAY BỔNG & MỀM MẠI)
       ========================================================================== */
@keyframes floatDream1 {
    0% {
        transform: translate3d(0, 0, 0) rotate(-8deg);
    }

    45% {
        transform: translate3d(4px, -15px, 0) rotate(-3deg);
    }

    100% {
        transform: translate3d(2px, -24px, 0) rotate(-6deg);
    }
}

@keyframes floatDream2 {
    0% {
        transform: translate3d(0, 0, 0) rotate(5deg) scale(1);
    }

    50% {
        transform: translate3d(-4px, -18px, 0) rotate(2deg) scale(1.02);
    }

    100% {
        transform: translate3d(-2px, -26px, 0) rotate(4deg) scale(1);
    }
}

@keyframes floatDream3 {
    0% {
        transform: translate3d(0, 0, 0) rotate(8deg);
    }

    40% {
        transform: translate3d(3px, -14px, 0) rotate(4deg);
    }

    100% {
        transform: translate3d(-3px, -22px, 0) rotate(7deg);
    }
}

@keyframes floatDream4 {
    0% {
        transform: translate3d(0, 0, 0) rotate(-10deg) scale(0.99);
    }

    55% {
        transform: translate3d(4px, -16px, 0) rotate(-6deg) scale(1.02);
    }

    100% {
        transform: translate3d(2px, -25px, 0) rotate(-8deg) scale(1);
    }
}

@keyframes floatDream5 {
    0% {
        transform: translate3d(0, 0, 0) rotate(7deg);
    }

    45% {
        transform: translate3d(-4px, -14px, 0) rotate(11deg);
    }

    100% {
        transform: translate3d(-2px, -22px, 0) rotate(8deg);
    }
}

@keyframes floatDream6 {
    0% {
        transform: translate3d(0, 0, 0) rotate(-6deg) scale(1);
    }

    50% {
        transform: translate3d(4px, -18px, 0) rotate(-1deg) scale(1.03);
    }

    100% {
        transform: translate3d(2px, -28px, 0) rotate(-4deg) scale(1);
    }
}

@keyframes floatDream7 {
    0% {
        transform: translate3d(0, 0, 0) rotate(-4deg);
    }

    40% {
        transform: translate3d(-3px, -14px, 0) rotate(1deg);
    }

    100% {
        transform: translate3d(3px, -20px, 0) rotate(-2deg);
    }
}

@keyframes floatDream8 {
    0% {
        transform: translate3d(0, 0, 0) rotate(7deg);
    }

    48% {
        transform: translate3d(-4px, -16px, 0) rotate(3deg);
    }

    100% {
        transform: translate3d(-2px, -24px, 0) rotate(5deg);
    }
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
    border-radius: 20px;
    background-color: rgba(43, 29, 20, 0.3);
    cursor: pointer;
    transition: all 0.3s;
}

.dot.active {
    background-color: var(--spice-primary);
    transform: scale(1.2);
}


.container {
    max-width: 1430px !important;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Section Header */

.section-header {
    margin-bottom: 2.5rem;
}

.rich-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 3.5rem;
    border-bottom: 1px solid rgba(59, 42, 32, 0.1);
    padding-bottom: 2rem;
}

.header-content {
    max-width: 600px;
}

.section-subtitle {
    color: var(--spice-primary);
    font-size: 0.85rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    margin-bottom: 1rem;
}

.serif-title {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    color: #3B2A20;
    margin: 0 0 1rem 0;
    font-weight: 800;
    line-height: 1.15;
}

.section-desc {
    font-family: var(--font-body);
    font-size: 15px;
    color: #5C4B41;
    margin: 0;
    line-height: 1.6;
    text-align: justify;
    text-justify: inter-word;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.8rem;
    border: 2px solid #3B2A20;
    border-radius: 20px;
    color: #3B2A20;
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background-color: #3B2A20;
    color: #FDFBF7;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .rich-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
    }
}

/* Trending Products Fishwife Style */
.trending-products {
    padding: 5rem 0;
    background-color: var(--spice-bg-alt);
}

.product-carousel {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.product-card {
    background: var(--spice-bg);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.product-img-wrapper {
    position: relative;
    display: block;
    padding-top: 100%;
    overflow: hidden;
    background: #FDFBF7;
    border-bottom: none;
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
    font-family: var(--font-body);
    font-size: 18px;
    color: #3B2A20;
    font-weight: 600;
    text-decoration: none;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.quick-add {
    position: absolute;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    opacity: 0;
    background: #3B2A20;
    color: #F6F1EA;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.8rem 0;
    width: 80%;
    border-radius: 20px;
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    border: none;
}

.product-card:hover .quick-add {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

.quick-add:hover {
    background: var(--spice-primary);
}

.product-badge {
    position: absolute;
    top: 22px;
    left: -36px;
    width: 145px;
    text-align: center;
    padding: 0.35rem 0;
    color: #FFFFFF;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    white-space: nowrap;
    z-index: 10;
    transform: rotate(-45deg);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
    line-height: 1.2;
    pointer-events: none;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
}

.product-badge.sale {
    background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-tangerine) 100%);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(196, 20, 30, 0.35);
}

.product-badge.hot {
    background: linear-gradient(135deg, var(--spice-honey) 0%, var(--spice-tangerine) 100%);
    color: #28120B;
    text-shadow: none;
    box-shadow: 0 4px 12px rgba(229, 149, 40, 0.35);
}

.product-img-wrapper img {
    position: absolute;
    top: 15%;
    left: 15%;
    width: 70%;
    height: 70%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.product-card:hover .product-img-wrapper img {
    transform: scale(1.05);
}

.product-vendor {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--spice-primary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.5rem;
}

.product-price {
    font-family: var(--font-body);
    font-weight: 700;
    margin-top: 0.5rem;
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.5rem;
}

.price-current {
    color: var(--spice-primary);
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -0.2px;
}

.price-compare {
    text-decoration: line-through;
    opacity: 0.55;
    color: #5C4B41;
    font-size: 15px;
    font-weight: 400;
}

/* Spice Story */
.spice-story {
    padding: 6rem 0;
    background-color: var(--spice-bg);
}

.story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5rem;
    align-items: center;
}

.story-image img {
    width: 100%;
    height: auto;
    aspect-ratio: 4/5;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.story-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-right: 2rem;
}

.story-content .subheading {
    color: var(--spice-primary);
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 1rem;
    display: block;
}

.story-content h2 {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    color: #3B2A20;
    margin: 0 0 1.5rem 0;
    line-height: 1.15;
    font-weight: 800;
}

.story-content p {
    font-family: var(--font-body);
    font-size: 16px;
    line-height: 1.65;
    color: #5C4B41;
    margin: 0 0 2.5rem 0;
    text-align: justify;
    text-justify: inter-word;
}

/* Bundle Section */
.bundle-section {
    background-color: var(--spice-bg-bundle);
    padding: 6rem 0;
    color: #FDF9F1;
}

.bundle-header {
    text-align: center;
    margin-bottom: 4rem;
}

.bundle-subtitle {
    color: var(--spice-secondary);
    /* Changed from primary to secondary (Gold) */
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    margin-bottom: 1rem;
}

.bundle-title {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    font-weight: 800;
    margin: 0 0 1.5rem 0;
    line-height: 1.15;
    color: #FDFBF7;
}

.bundle-desc {
    font-family: var(--font-body);
    font-size: 16px;
    max-width: 600px;
    margin: 0 auto;
    color: #D7CBBC;
    line-height: 1.65;
    opacity: 0.9;
    text-align: justify;
    text-justify: inter-word;
}

.bundle-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2.5rem;
    align-items: stretch;
}

.bundle-card {
    background-color: var(--spice-bg);
    border-radius: 20px;
    padding: 3rem 2rem 2.5rem 2rem;
    text-align: center;
    color: var(--spice-text);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.02);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.bundle-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
}

.bundle-card.highlight-bundle {
    border: 2px solid var(--spice-honey);
    box-shadow: 0 15px 40px rgba(229, 149, 40, 0.22);
    transform: scale(1.02);
}

.bundle-card.highlight-bundle:hover {
    transform: scale(1.02) translateY(-10px);
    box-shadow: 0 25px 50px rgba(229, 149, 40, 0.35);
}

.best-selling-badge {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-accent) 100%);
    color: #FDFBF7;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    white-space: nowrap;
    text-transform: uppercase;
    box-shadow: 0 10px 20px rgba(196, 20, 30, 0.35);
}

.bundle-img-wrapper {
    margin-bottom: 2rem;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bundle-img-wrapper img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.bundle-card:hover .bundle-img-wrapper img {
    transform: scale(1.05);
}

.bundle-details {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.bundle-name {
    font-family: var(--font-body);
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 0.8rem 0;
    color: var(--spice-text);
    line-height: 1.35;
}

.bundle-info {
    font-family: var(--font-body);
    font-size: 15px;
    color: #5C4B41;
    margin: 0 0 1.5rem 0;
    line-height: 1.6;
    flex: 1;
}

.bundle-per-can {
    background-color: var(--spice-bg-dark);
    /* Dark pill */
    color: var(--spice-bg);
    /* Light text */
    display: inline-block;
    padding: 0.5rem 1.2rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin: 0 auto 2rem auto;
}

.bundle-price-block {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    margin-bottom: 1.5rem;
}

.price-old {
    font-family: var(--font-body);
    text-decoration: line-through;
    color: #999;
    font-size: 16px;
    font-weight: 400;
}

.price-new {
    font-family: var(--font-body);
    color: var(--spice-text);
    /* Dark strong text instead of red */
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.3px;
}

.price-off-pill {
    background-color: var(--spice-honey);
    /* Warm Artisan Gold */
    color: var(--spice-text);
    /* Dark text */
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.3rem 0.6rem;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bundle-add-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--spice-primary) 0%, var(--spice-tangerine) 100%);
    color: #FDFBF7;
    padding: 1.1rem 2.5rem;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(228, 93, 62, 0.3);
    /* Coral shadow */
    transition: all 0.3s ease;
    width: 100%;
    cursor: pointer;
}

.bundle-add-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 25px rgba(196, 20, 30, 0.45);
    background: linear-gradient(135deg, var(--spice-fire) 0%, var(--spice-accent) 100%);
}

@media (max-width: 900px) {

    .props-grid,
    .story-grid {
        grid-template-columns: 1fr;
    }

    .product-carousel,
    .bundle-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .hero-title {
        font-size: clamp(38px, 5vw, 48px);
    }

    .slide-split {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 2rem;
        padding: 3rem 1rem;
    }

    .hero-actions {
        justify-content: center;
    }

    .story-content {
        padding: 4rem 2rem;
    }

    .hero-visual img {
        max-height: 300px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: clamp(34px, 7vw, 42px) !important;
    }

    .serif-title,
    .social-feed h2,
    .story-content h2,
    .testi-heading,
    .bundle-title {
        font-size: clamp(26px, 5vw, 32px) !important;
    }

    .hero-sticker {
        font-size: 0.85rem;
        padding: 0.4rem 0.9rem;
    }

    .slide:nth-child(1) .sticker-1 {
        left: 2%;
        top: 6%;
    }

    .slide:nth-child(1) .sticker-2 {
        right: 2%;
        bottom: 8%;
    }

    .slide:nth-child(2) .sticker-1 {
        left: 2%;
        top: 10%;
    }

    .slide:nth-child(2) .sticker-2 {
        right: 2%;
        bottom: 12%;
    }

    .slide:nth-child(3) .sticker-1 {
        right: 2%;
        top: 6%;
    }

    .slide:nth-child(3) .sticker-2 {
        left: 4%;
        bottom: 8%;
    }

    .slide:nth-child(4) .sticker-1 {
        left: 8%;
        top: 4%;
    }

    .slide:nth-child(4) .sticker-2 {
        left: 2%;
        bottom: 12%;
    }
}

@media (max-width: 600px) {

    .product-carousel,
    .bundle-grid {
        grid-template-columns: 1fr;
    }

    .hero-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Hero Slider Logic - Sequential Soft Fade Transition
document.addEventListener('DOMContentLoaded', function() {
    let currentSlideIdx = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let slideInterval;
    let isTransitioning = false;

    function showSlide(nextIdx) {
        if (isTransitioning || nextIdx === currentSlideIdx || !slides[nextIdx]) return;
        isTransitioning = true;

        const currentSlide = slides[currentSlideIdx];
        const nextSlide = slides[nextIdx];

        // Cập nhật dot ngay lập tức
        dots.forEach(d => d.classList.remove('active'));
        if (dots[nextIdx]) dots[nextIdx].classList.add('active');

        // Bước 1: Cho slide hiện tại từ từ ẩn đi (Fade out êm ái)
        currentSlide.classList.add('fading-out');
        currentSlide.classList.remove('active');

        // Bước 2: Đợi slide cũ tan biến hoàn toàn rồi mới cho slide mới hiện lên (Fade in)
        setTimeout(() => {
            currentSlide.classList.remove('fading-out');
            nextSlide.classList.add('active');
            currentSlideIdx = nextIdx;

            // Mở khóa chuyển slide sau khi animation hoàn tất
            setTimeout(() => {
                isTransitioning = false;
            }, 550);
        }, 350);
    }

    window.goToSlide = function(index) {
        if (index === currentSlideIdx || isTransitioning) return;
        showSlide(index);
        resetInterval();
    };

    function nextSlide() {
        const nextIdx = (currentSlideIdx + 1) % slides.length;
        showSlide(nextIdx);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5500);
    }

    if (slides.length > 0) {
        resetInterval();
    }
    window.scrollTestimonials = function(direction) {
        const slider = document.getElementById('testimonialSlider');
        if (slider) {
            const scrollAmount = slider.offsetWidth;
            slider.scrollBy({
                left: scrollAmount * direction,
                behavior: 'smooth'
            });
        }
    };

    // Social Feed Video Optimization (Lazy loading & Hardware-accelerated decoder management)
    const socialFeed = document.querySelector('.social-feed');
    if (socialFeed) {
        const feedVideos = socialFeed.querySelectorAll('.feed-card video');
        let isFeedVisible = false;
        let checkTimer = null;

        function syncVisibleVideos() {
            if (!isFeedVisible) return;
            const winWidth = window.innerWidth || document.documentElement.clientWidth;
            const buffer = 250;

            feedVideos.forEach(video => {
                const rect = video.getBoundingClientRect();
                const inView = rect.right >= -buffer && rect.left <= (winWidth + buffer);

                if (inView) {
                    if (!video.src && video.dataset.src) {
                        video.src = video.dataset.src;
                    }
                    if (video.paused) {
                        const playPromise = video.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(() => {});
                        }
                    }
                } else {
                    if (!video.paused) {
                        video.pause();
                    }
                }
            });
        }

        if ('IntersectionObserver' in window) {
            const feedObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    isFeedVisible = entry.isIntersecting;
                    if (isFeedVisible) {
                        syncVisibleVideos();
                        if (!checkTimer) {
                            checkTimer = setInterval(syncVisibleVideos, 400);
                        }
                    } else {
                        if (checkTimer) {
                            clearInterval(checkTimer);
                            checkTimer = null;
                        }
                        feedVideos.forEach(video => {
                            if (!video.paused) {
                                video.pause();
                            }
                        });
                    }
                });
            }, {
                rootMargin: '200px 0px 200px 0px',
                threshold: 0.01
            });

            feedObserver.observe(socialFeed);
        } else {
            feedVideos.forEach(video => {
                if (!video.src && video.dataset.src) video.src = video.dataset.src;
                video.play().catch(() => {});
            });
        }
    }
});
</script>
@endsection