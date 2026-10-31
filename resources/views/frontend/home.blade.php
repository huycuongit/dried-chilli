@extends('frontend.layouts.master')

@section('title', 'Dried Chili — Handcrafted Premium Spices & Organic Seasonings')
@section('meta_description', 'Dried Chili specializes in artisanal shrimp chilli paste, premium dried chillies, and organic culinary seasonings crafted with 100% natural ingredients.')

@php
    $pageLayoutGroups = json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR);
    $pageLayoutFields = collect($pageLayoutGroups)->collapse()->all();
    $pageLayoutValue = static fn (string $key) => \App\Support\AboutPageContent::value($key, $pageLayoutFields, $systemSettings);
    $heroSrcset = \App\Support\ResponsivePageImages::srcset($pageLayoutValue('page_layout_home_image_slide_1'));
    $heroSizes = '(max-width: 768px) 210px, 410px';
    $pageLayoutLink = static function (string $key) use ($pageLayoutValue) {
        $link = trim($pageLayoutValue($key));
        return preg_match('~^(?:/(?!/)|https?://|#)~i', $link) ? $link : '#';
    };
@endphp

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
                        <span class="hero-subtitle">{{ $pageLayoutValue('page_layout_home_slide_1_01') }}</span>
                        <h1 class="hero-title">{{ $pageLayoutValue('page_layout_home_slide_1_02') }}<br>{{ $pageLayoutValue('page_layout_home_slide_1_03') }}</h1>
                        <p class="hero-desc">{{ $pageLayoutValue('page_layout_home_slide_1_04') }}</p>
                        <div class="hero-actions">
                            <a href="{{ $pageLayoutLink('page_layout_home_link_slide_1') }}" class="btn-primary">
                                <span>{{ $pageLayoutValue('page_layout_home_slide_1_05') }}</span>
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
                        @if($pageLayoutValue('page_layout_home_image_slide_1') !== '')<img class="hero-can" src="{{ asset($pageLayoutValue('page_layout_home_image_slide_1')) }}" alt="{{ $pageLayoutValue('page_layout_home_image_alt_1') }}" width="409" height="610" @if($heroSrcset !== '') srcset="{{ $heroSrcset }}" sizes="{{ $heroSizes }}" @endif fetchpriority="high">@endif

                        <!-- Floating Pills -->
                        <span class="hero-sticker sticker-1">{{ $pageLayoutValue('page_layout_home_slide_1_06') }}</span>
                        <span class="hero-sticker sticker-2"><span>{{ $pageLayoutValue('page_layout_home_slide_1_08') }}</span> {{ $pageLayoutValue('page_layout_home_slide_1_07') }}</span>
                    </div>
                </div>
            </div>

            <!-- Slide 2 (Image Left, Content Right) -->
            <div class="slide">
                <div class="slide-split container">
                    <!-- Left: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-red"></div>
                        @if($pageLayoutValue('page_layout_home_image_slide_2') !== '')<img class="hero-can" src="{{ asset($pageLayoutValue('page_layout_home_image_slide_2')) }}" alt="{{ $pageLayoutValue('page_layout_home_image_alt_2') }}" width="500" height="500" loading="lazy">@endif
                        <span class="hero-sticker sticker-1">{{ $pageLayoutValue('page_layout_home_slide_2_01') }}</span>
                        <span class="hero-sticker sticker-2"><span>{{ $pageLayoutValue('page_layout_home_slide_2_02') }}</span> {{ $pageLayoutValue('page_layout_home_slide_2_03') }}</span>
                    </div>

                    <!-- Right: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">{{ $pageLayoutValue('page_layout_home_slide_2_04') }}</span>
                        <p class="hero-title">{{ $pageLayoutValue('page_layout_home_slide_2_05') }}<br>{{ $pageLayoutValue('page_layout_home_slide_2_06') }}</p>
                        <p class="hero-desc">{{ $pageLayoutValue('page_layout_home_slide_2_07') }}</p>
                        <div class="hero-actions">
                            <a href="{{ $pageLayoutLink('page_layout_home_link_slide_2') }}" class="btn-primary">
                                <span>{{ $pageLayoutValue('page_layout_home_slide_2_08') }}</span>
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
                        <span class="hero-subtitle">{{ $pageLayoutValue('page_layout_home_slide_3_01') }}</span>
                        <p class="hero-title">{{ $pageLayoutValue('page_layout_home_slide_3_02') }}<br>{{ $pageLayoutValue('page_layout_home_slide_3_03') }}</p>
                        <p class="hero-desc">{{ $pageLayoutValue('page_layout_home_slide_3_04') }}</p>
                        <div class="hero-actions">
                            <a href="{{ $pageLayoutLink('page_layout_home_link_slide_3') }}" class="btn-primary">
                                <span>{{ $pageLayoutValue('page_layout_home_slide_3_05') }}</span>
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
                        @if($pageLayoutValue('page_layout_home_image_slide_3') !== '')<img class="hero-can" src="{{ asset($pageLayoutValue('page_layout_home_image_slide_3')) }}" alt="{{ $pageLayoutValue('page_layout_home_image_alt_3') }}" width="500" height="500" loading="lazy">@endif
                        <span class="hero-sticker sticker-1">{{ $pageLayoutValue('page_layout_home_slide_3_06') }}</span>
                        <span class="hero-sticker sticker-2"><span>{{ $pageLayoutValue('page_layout_home_slide_3_07') }}</span> {{ $pageLayoutValue('page_layout_home_slide_3_08') }}</span>
                    </div>
                </div>
            </div>

            <!-- Slide 4 (Image Left, Content Right) -->
            <div class="slide">
                <div class="slide-split container">
                    <!-- Left: Image with Burst & Pills -->
                    <div class="hero-stage" aria-hidden="true">
                        <div class="hero-burst burst-red"></div>
                        @if($pageLayoutValue('page_layout_home_image_slide_4') !== '')<img class="hero-can" src="{{ asset($pageLayoutValue('page_layout_home_image_slide_4')) }}" alt="{{ $pageLayoutValue('page_layout_home_image_alt_4') }}" width="500" height="500" loading="lazy">@endif
                        <span class="hero-sticker sticker-1">{{ $pageLayoutValue('page_layout_home_slide_4_01') }}</span>
                        <span class="hero-sticker sticker-2"><span>{{ $pageLayoutValue('page_layout_home_slide_4_02') }}</span> {{ $pageLayoutValue('page_layout_home_slide_4_03') }}</span>
                    </div>

                    <!-- Right: Text Content -->
                    <div class="hero-content">
                        <span class="hero-subtitle">{{ $pageLayoutValue('page_layout_home_slide_4_04') }}</span>
                        <p class="hero-title">{{ $pageLayoutValue('page_layout_home_slide_4_05') }}<br>{{ $pageLayoutValue('page_layout_home_slide_4_06') }}</p>
                        <p class="hero-desc">{{ $pageLayoutValue('page_layout_home_slide_4_07') }}</p>
                        <div class="hero-actions">
                            <a href="{{ $pageLayoutLink('page_layout_home_link_slide_4') }}" class="btn-primary">
                                <span>{{ $pageLayoutValue('page_layout_home_slide_4_08') }}</span>
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
                        <p class="feature-title">100% Authentic</p>
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
                        <p class="feature-title">Sourced Globally</p>
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
                        <p class="feature-title">Fast Delivery</p>
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
            padding: 0.75rem 0;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .features-banner-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.25rem;
            align-items: center;
        }

        .feature-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 0.3rem;
            padding: 0.2rem 0.35rem;
            border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
            max-width: none;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .feature-col:last-child {
            border-right: none !important;
        }

        .feature-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.16);
        }

        .feature-icon-wrap svg {
            width: 16px;
            height: 16px;
        }

        .feature-title {
            font-size: 11px !important;
            line-height: 1.25 !important;
            font-weight: 800 !important;
            letter-spacing: 0.2px !important;
            margin: 0 !important;
        }

        .feature-desc {
            display: none !important;
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
                    <p class="section-desc">Hand-picked community favorites crafted for true heat lovers. Elevate your everyday home dining with our most-loved, small-batch artisanal chili blends and savory crisps.</p>
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
                @foreach($latestProducts->take(6) as $product)
                <div class="product-card">
                    @if($product->sale_price)
                    <div class="product-badge sale">Sale</div>
                    @else
                    <div class="product-badge hot">Hot</div>
                    @endif
                    <div class="product-img-wrapper">
                        <a href="{{ route('page.product', $product->slug) }}"
                            aria-label="{{ $product->name }}"
                            style="display: block; width: 100%; height: 100%;">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="300" height="300" loading="lazy">
                        </a>
                        <!-- Desktop Hover Quick Add Button -->
                        <button type="button" class="quick-add desktop-quick-add" data-product-id="{{ $product->id }}" aria-label="Quick Add {{ $product->name }}">
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
                        <!-- Mobile Quick Add Button (Visible <= 768px below price) -->
                        <button type="button" class="quick-add mobile-quick-add" data-product-id="{{ $product->id }}" aria-label="Quick Add {{ $product->name }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            <span>Quick Add</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>




    <!-- Social Videos Section (Inspired by Nafu Services) -->
    <!-- <section class="social-feed">
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
                    
                </div>
            </div>
        </div>
        <div class="wrap container" style="text-align:center;margin-top:26px">
            <a class="btn-ghost" href="https://instagram.com/yumyum.au" target="_blank" rel="noopener">Follow
                @yumyum.au</a>
            <a class="btn-ghost" href="https://www.tiktok.com/@dimsimlim" target="_blank" rel="noopener">TikTok
                @dimsimlim</a>
        </div>
    </section> -->

    <!-- Image with Text -->
    <section class="spice-story reveal">
        <div class="container">
            <div class="story-grid">
                <div class="story-image">
                    <img src="{{ asset('images/story_spices-optimized.webp') }}" srcset="{{ asset('images/story_spices-560.webp') }} 560w, {{ asset('images/story_spices-optimized.webp') }} 1024w" sizes="(max-width: 768px) 280px, 512px" alt="Spices on market" width="1024" height="1024" loading="lazy" decoding="async">
                </div>
                <div class="story-content">
                    <span class="subheading">OUR STORY</span>
                    <h2>Passionate About Flavor</h2>
                    <p>We believe that every dish tells an unforgettable culinary story, and the spices you choose define its authentic voice. Our journey began across the vibrant heritage spice markets of Asia, curating prime sun-dried chillies and slow-roasting hand-ground aromatics to empower passionate home chefs who demand uncompromising heat, crunch, and umami depth.</p>
                    <a href="{{ route('page.about') }}" class="btn-primary" aria-label="Learn More About Our Story">
                        <span>Learn More About Our Story</span>
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
                    <p>This crispy shrimp chili brings the exact fiery kick and rich aromatic depth my wok cooking needed. The crunchy garlic texture stays crisp on hot jasmine rice and noodles. Absolutely obsessed with this blend!</p>
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
                    <p>The chili crunch is incredibly authentic, layered with toasted sesame and slow-roasted chili pods. It instantly elevated our weekend family dinners into restaurant-worthy feasts. A permanent pantry staple!</p>
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
                    <p>I have never experienced store-bought spices this intensely fresh and fragrant before. The balanced heat profile and satisfying garlic crunch elevate everything from sunny-side-up eggs to late-night ramen.</p>
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
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
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
    gap: 48px;
    height: 100%;
    max-width: 1200px !important;
    margin: 0 auto;
    padding: 0 2rem;
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
    margin: 0 0 1rem 0;
    color: #2A0800;
    word-wrap: break-word;
    overflow-wrap: break-word;
    display: block;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.hero-desc {
    font-family: var(--font-body);
    color: #5C4B41;
    font-size: 1.15rem;
    line-height: 1.6;
    margin: 0 0 1.6rem 0;
    max-width: 440px;
    text-align: left;
    text-wrap: pretty;
    hyphens: none;
    -webkit-hyphens: none;
    font-weight: 450;
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

.slide:first-child.active .hero-content,
.slide:first-child.active .hero-stage {
    transition: none;
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
    filter: drop-shadow(0 20px 30px rgba(43, 29, 20, 0.28)) drop-shadow(0 6px 14px rgba(0, 0, 0, 0.12));
    transition: filter 0.3s ease;
}

.slide:first-child.active .hero-can {
    animation: none !important;
}

.hero-can:hover {
    filter: drop-shadow(0 26px 36px rgba(43, 29, 20, 0.35)) drop-shadow(0 8px 16px rgba(0, 0, 0, 0.16));
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
       Phối màu chuẩn: Tông Màu Nóng Đồng Bộ Thương Hiệu (Spicy Amber, Fire Coral, Roast Gold)
       ========================================================================== */

/* --- SLIDE 1 (Original Flavor): 1 Nóng (Chili Coral) + 1 Nóng (Warm Curry Gold) --- */
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
    border: 2px solid #FFB300;
    background: rgba(48, 20, 8, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(255, 179, 0, 0.35);
    animation: floatDream2 7.0s ease-in-out 0.6s infinite alternate;
}

.slide:nth-child(1) .sticker-2 span {
    color: #FCD34D;
}

/* --- SLIDE 2 (Garlic Crunch): 1 Nóng (Spicy Tangerine) + 1 Nóng (Garlic Amber) --- */
.slide:nth-child(2) .sticker-1 {
    top: 12%;
    left: 2%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #FF7A1A;
    background: rgba(46, 14, 10, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(255, 122, 26, 0.35);
    animation: floatDream3 6.2s ease-in-out 0.2s infinite alternate;
}

.slide:nth-child(2) .sticker-1 span {
    color: #FFA066;
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

/* --- SLIDE 3 (Fire Roasted): 1 Nóng (Smoky Crimson) + 1 Nóng (Honey Roast Amber) --- */
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
    border: 2px solid #E59528;
    background: rgba(45, 18, 6, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 22px rgba(229, 149, 40, 0.35);
    animation: floatDream6 8.2s ease-in-out 0.3s infinite alternate;
}

.slide:nth-child(3) .sticker-2 span {
    color: #FDE047;
}

/* --- SLIDE 4 (Plant Power): 1 Nóng (Coral Chili Red) + 1 Nóng (Warm Tangerine) --- */
.slide:nth-child(4) .sticker-1 {
    top: 6%;
    left: 4%;
    right: auto;
    bottom: auto;
    color: #FFFFFF;
    border: 2px solid #E45D3E;
    background: rgba(48, 15, 12, 0.95);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35), 0 0 20px rgba(228, 93, 62, 0.35);
    animation: floatDream7 6.4s ease-in-out 0.5s infinite alternate;
}

.slide:nth-child(4) .sticker-1 span {
    color: #FF8A65;
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
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
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

.mobile-quick-add {
    display: none !important;
}

.product-img-wrapper > a {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    display: block;
    z-index: 2;
}

.desktop-quick-add {
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
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 10;
    border: none;
    pointer-events: none;
}

.product-card:hover .desktop-quick-add {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
    pointer-events: auto;
}

.desktop-quick-add:hover {
    background: var(--spice-primary);
    box-shadow: 0 4px 15px rgba(228, 93, 62, 0.4);
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
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
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
    text-align-last: center;
    -webkit-hyphens: auto;
    hyphens: auto;
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

/* ==========================================================================
   TABLET RESPONSIVE SUITE (iPad / Tablets 769px to 1024px)
   Layout 2 cột cân đối, hiển thị đầy đủ hình ảnh và nội dung ở tỷ lệ phù hợp
   ========================================================================== */
@media (min-width: 769px) and (max-width: 1024px) {
    .spice-hero-slider {
        height: 560px;
        min-height: 560px;
    }

    .slide-split {
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        padding: 2rem 1.5rem;
        max-width: 960px;
    }

    .hero-title {
        font-size: clamp(32px, 3.8vw, 44px);
    }

    .hero-can {
        height: 340px;
        width: auto;
        max-width: 220px;
    }

    .hero-burst {
        width: 480px;
        height: 480px;
    }

    .hero-stage {
        min-height: 400px;
    }

    .product-carousel {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1.5rem;
    }

    .props-grid,
    .story-grid {
        grid-template-columns: 1fr;
    }

    .story-content {
        padding: 3rem 1.5rem;
    }
}

/* ==========================================================================
   MOBILE-FIRST NATIVE RESPONSIVE SUITE (Phones <= 768px, 375x667, 390x844)
   ========================================================================== */
@media (max-width: 768px) {
    /* 1. Global Container Spacing */
    .container {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }

    /* 2. Hero Slider (Refined Mobile Redesign: 480px, Proportional, Balanced) */
    .spice-hero-slider {
        height: 480px !important;
        min-height: 480px !important;
        max-height: 480px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        position: relative !important;
    }

    .slider-container {
        width: 100% !important;
        height: 100% !important;
        position: relative !important;
    }

    .slide {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }

    .slide-split {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        gap: 8px !important;
        padding: 16px 1rem 36px 1rem !important;
        width: 100% !important;
        max-width: 420px !important;
        height: 100% !important;
        margin: 0 auto !important;
        box-sizing: border-box !important;
        position: relative !important;
    }

    /* Product Jar Stage cleanly placed on TOP (order 1) */
    .hero-stage {
        order: 1 !important;
        min-height: 175px !important;
        height: 175px !important;
        max-height: 175px !important;
        width: 100% !important;
        max-width: 330px !important;
        position: relative !important;
        margin: 0 auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transform: none !important;
        padding: 0 !important;
        opacity: 1 !important;
    }

    /* Radiant Burst effect behind the jar - Thu nhỏ & định vị tinh tế không đè lên text */
    .hero-burst {
        display: block !important;
        position: absolute !important;
        top: 44% !important;
        left: 50% !important;
        width: 250px !important;
        height: 250px !important;
        border-radius: 50% !important;
        z-index: 1 !important;
        pointer-events: none !important;
        mask-image: radial-gradient(circle at center, black 25%, transparent 64%) !important;
        -webkit-mask-image: radial-gradient(circle at center, black 25%, transparent 64%) !important;
        animation: spinBurstMobile 36s linear infinite !important;
    }

    .slide.active .hero-burst {
        opacity: 0.85 !important;
        visibility: visible !important;
    }

    .slide:not(.active):not(.fading-out) .hero-burst {
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    @keyframes spinBurstMobile {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .hero-can {
        height: 155px !important;
        width: auto !important;
        max-width: 120px !important;
        object-fit: contain !important;
        animation: floatImgMobile 4s ease-in-out infinite alternate !important;
        transform: none !important;
        filter: drop-shadow(0 8px 18px rgba(43, 29, 20, 0.28)) !important;
        position: relative !important;
        z-index: 5 !important;
        margin: 0 auto !important;
    }

    /* Floating Pill Badges around the jar - Định vị rộng ra hai bên không đè lên thân hũ */
    .hero-sticker {
        display: inline-flex !important;
        align-items: center !important;
        gap: 3px !important;
        position: absolute !important;
        z-index: 7 !important;
        border-radius: 20px !important;
        padding: 3.5px 8px !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #FFFFFF !important;
        white-space: nowrap !important;
        pointer-events: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5) !important;
        will-change: transform;
    }

    .hero-sticker.sticker-1 {
        left: 0 !important;
        top: 18% !important;
        right: auto !important;
        bottom: auto !important;
        transform: rotate(-4deg) !important;
        background: rgba(45, 12, 10, 0.94) !important;
        border: 1.5px solid #FF5722 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(255, 87, 34, 0.4) !important;
    }

    .hero-sticker.sticker-1 span {
        color: #FFA066 !important;
        font-weight: 800 !important;
    }

    .hero-sticker.sticker-2 {
        right: 0 !important;
        bottom: 20% !important;
        left: auto !important;
        top: auto !important;
        transform: rotate(4deg) !important;
        background: rgba(48, 20, 8, 0.94) !important;
        border: 1.5px solid #FFB300 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(255, 179, 0, 0.4) !important;
    }

    .hero-sticker.sticker-2 span {
        color: #FCD34D !important;
        font-weight: 800 !important;
    }

    /* Tông màu nóng theo từng slide trên mobile */
    .slide:nth-child(2) .sticker-1 {
        border-color: #FF7A1A !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(255, 122, 26, 0.4) !important;
    }
    .slide:nth-child(2) .sticker-2 {
        border-color: #F59E0B !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(245, 158, 11, 0.35) !important;
    }

    .slide:nth-child(3) .sticker-1 {
        border-color: #EF4444 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(239, 68, 68, 0.4) !important;
    }
    .slide:nth-child(3) .sticker-2 {
        border-color: #E59528 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(229, 149, 40, 0.35) !important;
    }

    .slide:nth-child(4) .sticker-1 {
        border-color: #E45D3E !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(228, 93, 62, 0.4) !important;
    }
    .slide:nth-child(4) .sticker-2 {
        border-color: #FB923C !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35), 0 0 12px rgba(251, 146, 60, 0.35) !important;
    }

    /* Content below the jar (order 2) */
    .hero-content {
        order: 2 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        padding: 0 !important;
        margin: 0 !important;
        transform: none !important;
        gap: 5px !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 10 !important;
    }

    .hero-subtitle {
        display: inline-flex !important;
        align-items: center !important;
        width: fit-content !important;
        font-size: 10.5px !important;
        letter-spacing: 1.2px !important;
        text-transform: uppercase !important;
        color: var(--spice-fire) !important;
        font-weight: 800 !important;
        border: 1.5px solid var(--spice-fire) !important;
        padding: 2.5px 10px !important;
        border-radius: 20px !important;
        line-height: 1.2 !important;
        margin: 0 0 3px 0 !important;
        background: rgba(228, 93, 62, 0.06) !important;
    }

    .hero-title br {
        display: inline !important;
        content: ' ' !important;
    }

    .hero-title {
        font-family: var(--font-heading) !important;
        font-size: clamp(21px, 5.8vw, 25px) !important;
        font-weight: 800 !important;
        line-height: 1.15 !important;
        margin: 0 0 4px 0 !important;
        text-align: center !important;
        justify-content: center !important;
        display: block !important;
        color: #2A0800 !important;
        letter-spacing: -0.2px !important;
        text-transform: uppercase !important;
        white-space: normal !important;
    }

    .hero-desc {
        display: block !important;
        font-family: var(--font-body) !important;
        font-size: 13.5px !important;
        line-height: 1.5 !important;
        color: #5C4B41 !important;
        margin: 0 auto 12px auto !important;
        max-width: 330px !important;
        text-align: center !important;
        hyphens: none !important;
        -webkit-hyphens: none !important;
        text-wrap: pretty !important;
    }

    .hero-actions {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin: 0 !important;
    }

    .hero-actions .btn-primary {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: auto !important;
        min-width: 155px !important;
        max-width: 220px !important;
        padding: 0.58rem 1.65rem !important;
        font-size: 13.5px !important;
        font-weight: 700 !important;
        border-radius: 24px !important;
        background: var(--spice-primary) !important;
        color: #FFFFFF !important;
        box-shadow: 0 5px 16px rgba(228, 93, 62, 0.38) !important;
        gap: 6px !important;
        text-decoration: none !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .hero-actions .btn-primary:active {
        transform: scale(0.97) !important;
    }

    .slider-controls {
        bottom: 12px !important;
        position: absolute !important;
        left: 0 !important;
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        z-index: 10 !important;
    }

    .slider-dots .dot {
        width: 8px !important;
        height: 8px !important;
        margin: 0 4px !important;
        background: rgba(42, 8, 0, 0.2) !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
    }

    .slider-dots .dot.active {
        width: 22px !important;
        border-radius: 10px !important;
        background: var(--spice-primary) !important;
    }

    @keyframes floatImgMobile {
        0% { transform: translateY(0); }
        100% { transform: translateY(-7px); }
    }

    /* 3. Section Titles & Spacing */
    .serif-title,
    .social-feed h2,
    .story-content h2,
    .testi-heading,
    .bundle-title {
        font-size: 20px !important;
        line-height: 1.2 !important;
    }

    /* 4. Trending Products - Clean, Airy 2-Column Grid */
    .trending-products {
        padding: 1.75rem 0 !important;
    }

    .rich-header {
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 0.85rem !important;
        padding-bottom: 0.65rem !important;
        border-bottom: 1px solid rgba(59, 42, 32, 0.08) !important;
        gap: 0.5rem !important;
    }

    .trending-products .section-subtitle,
    .trending-products .section-desc,
    .product-vendor {
        display: none !important;
    }

    .header-action {
        width: auto !important;
    }

    .view-all-btn {
        width: auto !important;
        padding: 0.35rem 0.75rem !important;
        font-size: 0.72rem !important;
        border-radius: 12px !important;
        white-space: nowrap !important;
    }

    .product-carousel {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
        margin-top: 0.5rem !important;
    }

    .product-card {
        background: #FFFFFF !important;
        border-radius: 14px !important;
        border: 1px solid rgba(43, 29, 20, 0.08) !important;
        box-shadow: 0 3px 12px rgba(43, 29, 20, 0.05) !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        transition: none !important;
        position: relative !important;
    }

    .product-badge {
        position: absolute !important;
        top: 6px !important;
        left: 6px !important;
        transform: none !important;
        width: auto !important;
        padding: 2px 7px !important;
        font-size: 0.62rem !important;
        border-radius: 6px !important;
        letter-spacing: 0.5px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15) !important;
        z-index: 10 !important;
    }

    .product-img-wrapper {
        padding-top: 86% !important;
        background: #FAF7F2 !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .product-img-wrapper a {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
    }

    .product-img-wrapper img {
        position: absolute !important;
        top: 8% !important;
        left: 10% !important;
        width: 80% !important;
        height: 80% !important;
        object-fit: contain !important;
    }

    .desktop-quick-add {
        display: none !important;
    }

    .mobile-quick-add {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        width: 100% !important;
        padding: 0.52rem 0.5rem !important;
        margin-top: 0.55rem !important;
        font-size: 0.76rem !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
        background: linear-gradient(135deg, #E45D3E 0%, #D3381C 100%) !important;
        color: #FFFFFF !important;
        border: none !important;
        cursor: pointer !important;
        box-shadow: 0 3px 10px rgba(211, 56, 28, 0.25) !important;
        transition: transform 0.2s, background 0.2s !important;
        position: static !important;
        transform: none !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .mobile-quick-add:active {
        transform: scale(0.97) !important;
    }

    .product-details {
        padding: 0.6rem 0.5rem 0.65rem 0.5rem !important;
        text-align: center !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        flex: 1 !important;
    }

    .product-title {
        font-size: 13px !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
        height: 34px !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        margin-bottom: 0.2rem !important;
    }

    .product-price {
        margin: 0.15rem 0 0 0 !important;
        gap: 5px !important;
        justify-content: center !important;
    }

    .price-current {
        font-size: 14.5px !important;
        font-weight: 800 !important;
    }

    .price-compare {
        font-size: 11.5px !important;
    }

    /* 5. Social Feed on Mobile - Clean & Airy */
    .social-feed {
        padding: 1.75rem 0 !important;
    }

    .social-feed .sec-head .label {
        display: none !important;
    }

    .feed-track {
        padding: 0.5rem 0 !important;
        border: none !important;
        margin-top: 0.75rem !important;
    }

    .feed-card {
        width: 125px !important;
        border-radius: 12px !important;
    }

    .feed-badge {
        font-size: 0.65rem !important;
        padding: 0.2rem 0.45rem !important;
        bottom: 0.4rem !important;
        left: 0.4rem !important;
    }

    .btn-ghost {
        padding: 0.45rem 0.9rem !important;
        font-size: 0.75rem !important;
        margin: 0.2rem !important;
    }

    /* 6. Brand Story on Mobile - Airy & Concise */
    .spice-story {
        padding: 1.75rem 0 !important;
    }

    .story-content .subheading {
        display: none !important;
    }

    .story-grid {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.85rem !important;
    }

    .story-image img {
        max-height: 160px !important;
        width: 100% !important;
        object-fit: cover !important;
        border-radius: 14px !important;
    }

    .story-content {
        padding: 0 !important;
        text-align: center !important;
        align-items: center !important;
    }

    .story-content h2 {
        font-size: 20px !important;
        margin-bottom: 0.35rem !important;
    }

    .story-content p {
        font-size: 13px !important;
        line-height: 1.5 !important;
        margin-bottom: 0.85rem !important;
        text-align: justify !important;
        text-justify: inter-word !important;
        text-align-last: left !important;
        -webkit-hyphens: auto !important;
        hyphens: auto !important;
        color: #5C4B41 !important;
    }

    .story-content .btn-primary {
        padding: 0.55rem 1.5rem !important;
        font-size: 13px !important;
        border-radius: 20px !important;
    }

    /* 7. Testimonials on Mobile - Horizontal Swipe Track */
    .spice-compact-testimonials {
        padding: 1.75rem 0 2.5rem 0 !important;
    }

    .quote-icon {
        display: none !important;
    }

    .testi-header-flex {
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 0.85rem !important;
        gap: 0.5rem !important;
    }

    .testi-rating-overall {
        align-items: flex-end !important;
    }

    .testi-rating-overall .stars {
        font-size: 1rem !important;
    }

    .testi-rating-overall .rating-text {
        font-size: 0.75rem !important;
    }

    .testi-grid-container {
        display: flex !important;
        flex-direction: row !important;
        overflow-x: auto !important;
        scroll-snap-type: x mandatory !important;
        gap: 10px !important;
        padding: 0.25rem 1rem 0.6rem 1rem !important;
        margin: 0 -1rem !important;
        -webkit-overflow-scrolling: touch !important;
    }

    .testi-grid-container::-webkit-scrollbar {
        display: none;
    }

    .compact-testimonial-item.premium-card {
        flex: 0 0 82vw !important;
        max-width: 300px !important;
        scroll-snap-align: center !important;
        padding: 1rem !important;
        border-radius: 14px !important;
        margin: 0 !important;
        box-sizing: border-box !important;
    }

    .compact-testimonial-item.premium-card p {
        font-size: 13px !important;
        line-height: 1.45 !important;
        margin-bottom: 0.75rem !important;
        text-align: justify !important;
        text-justify: inter-word !important;
        text-align-last: left !important;
        -webkit-hyphens: auto !important;
        hyphens: auto !important;
    }

    .testi-footer {
        padding-top: 0.5rem !important;
        gap: 0.65rem !important;
    }

    .author-initials {
        width: 34px !important;
        height: 34px !important;
        font-size: 0.85rem !important;
        border-radius: 10px !important;
    }

    .author-name {
        font-size: 0.88rem !important;
    }

    .author-sub {
        font-size: 0.7rem !important;
    }
}

@media (max-width: 380px) {
    .spice-hero-slider {
        height: 440px !important;
        min-height: 440px !important;
        max-height: 440px !important;
    }
    .slide-split {
        padding: 12px 0.75rem 28px 0.75rem !important;
        gap: 6px !important;
    }
    .hero-stage {
        min-height: 155px !important;
        height: 155px !important;
        max-height: 155px !important;
    }
    .hero-can {
        height: 140px !important;
        max-width: 110px !important;
    }
    .hero-burst {
        width: 220px !important;
        height: 220px !important;
    }
    .hero-sticker {
        font-size: 10px !important;
        padding: 3px 8px !important;
    }
    .hero-title {
        font-size: 19px !important;
    }
    .hero-desc {
        font-size: 12px !important;
        line-height: 1.4 !important;
        max-width: 290px !important;
        margin-bottom: 8px !important;
    }
    .hero-actions .btn-primary {
        padding: 0.5rem 1.4rem !important;
        font-size: 13px !important;
        min-width: 140px !important;
    }
    .product-carousel {
        gap: 8px !important;
    }
    .product-title {
        font-size: 12px !important;
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
        slideInterval = setInterval(nextSlide, 12000);
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
