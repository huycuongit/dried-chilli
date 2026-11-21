@extends('frontend.layouts.master')
@section('title', 'Exclusive Sale & Deals | Dried Chili')
@section('meta_description', 'Discover limited-time promotions and special offers on premium dried chillies and shrimp seasonings.')
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
<main class="page-content shop-bg">
    
    <div class="container sale-container">
        @if($bigSaleActive)
        <!-- BIG SALE Section -->
        <div class="sale-tier reveal" id="big-sale">
            @if($bigSaleBanner)
            <div class="sale-banner-wrapper" style="margin-bottom: 3rem; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.06); height: 650px;">
                <img src="{{ str_starts_with($bigSaleBanner, 'http') ? $bigSaleBanner : asset(str_starts_with(ltrim($bigSaleBanner, '/'), 'storage/') ? ltrim($bigSaleBanner, '/') : 'storage/' . ltrim($bigSaleBanner, '/')) }}" alt="{{ $bigSaleTitle }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
            </div>
            @endif
            
            <h2 class="tier-title">{{ $bigSaleTitle }}</h2>
            <div class="yum-grid">
                @forelse($bigSaleProducts as $product)
                    <div class="yum-card">
                        <div class="yum-card-top">
                            @if($product->is_best_seller)
                                <div class="yum-badge badge-red">{{ $pageLayoutValue('page_layout_sale_sale_page_01') }}</div>
                            @else
                                <div class="yum-badge badge-black">{{ $pageLayoutValue('page_layout_sale_sale_page_02') }}</div>
                            @endif
                            @if($product->price > $product->sale_price)
                                <div class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
                            @endif
                            <a href="{{ route('page.product', $product->slug) }}">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="yum-card-bottom">
                            <div class="yum-meta">{{ $product->category->name ?? 'Spices & Seasonings' }}</div>
                            <h3 class="yum-title"><a href="{{ route('page.product', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ $product->name }}</a></h3>
                            <p class="yum-desc">{{ Str::limit($product->description ?: 'Artisanal sun-dried chili blend infused with slow-roasted garlic and rich umami crunch.', 120) }}</p>
                            <div class="yum-action">
                                <div class="price-wrapper">
                                    <span class="price-original">${{ number_format($product->price, 2) }}</span>
                                    <span class="yum-price">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                                <button class="yum-btn" data-product-id="{{ $product->id }}">{{ $pageLayoutValue('page_layout_sale_add_to_cart') }}</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 1.5rem; color: var(--spice-text); text-align: center; grid-column: 1/-1;">{{ $pageLayoutValue('page_layout_sale_sale_page_03') }}</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- FLASH SALE Section -->
        <div class="sale-tier reveal" id="flash-sale">
            <h2 class="tier-title"><span style="font-weight: 800; letter-spacing: 0.1em; margin-right: 5px">{{ $pageLayoutValue('page_layout_sale_sale_page_04') }}</span>{{ $pageLayoutValue('page_layout_sale_sale_page_05') }}</h2>
            <div class="yum-grid">
                @forelse($flashSaleProducts as $product)
                    <div class="yum-card flash-card">
                        <div class="yum-card-top">
                            <div class="yum-badge badge-red flash-badge">
                                {{ $pageLayoutValue('page_layout_sale_sale_page_06') }}
                            </div>
                            @if($product->price > $product->sale_price)
                                <div class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
                            @endif
                            <a href="{{ route('page.product', $product->slug) }}">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </a>
                            <!-- COUNTDOWN TIMER -->
                            <div class="countdown-timer" data-end="{{ \Carbon\Carbon::parse($product->sale_end_date)->format('Y-m-d\TH:i:s') }}">
                                <span class="cd-item"><b class="cd-h">00</b><small>{{ $pageLayoutValue('page_layout_sale_sale_page_07') }}</small></span>:
                                <span class="cd-item"><b class="cd-m">00</b><small>{{ $pageLayoutValue('page_layout_sale_sale_page_08') }}</small></span>:
                                <span class="cd-item"><b class="cd-s">00</b><small>{{ $pageLayoutValue('page_layout_sale_sale_page_09') }}</small></span>
                            </div>
                        </div>
                        <div class="yum-card-bottom">
                            <div class="yum-meta">{{ $product->category->name ?? 'Spices & Seasonings' }}</div>
                            <h3 class="yum-title"><a href="{{ route('page.product', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ $product->name }}</a></h3>
                            <p class="yum-desc">{{ Str::limit($product->description ?: 'Artisanal sun-dried chili blend infused with slow-roasted garlic and rich umami crunch.', 120) }}</p>
                            <div class="yum-action">
                                <div class="price-wrapper">
                                    <span class="price-original">${{ number_format($product->price, 2) }}</span>
                                    <span class="yum-price">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                                <button class="yum-btn" data-product-id="{{ $product->id }}">{{ $pageLayoutValue('page_layout_sale_add_to_cart') }}</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 1.5rem; color: var(--spice-text); text-align: center; grid-column: 1/-1;">{{ $pageLayoutValue('page_layout_sale_sale_page_10') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'Sale'])
</main>

<style>
.shop-bg { background: var(--jojo-cream, #fff8ee); min-height: 100vh; padding-bottom: 6rem; padding-top: 2rem; }

/* Sale Container */
.sale-container { max-width: 1460px; margin: 0 auto; padding: 0 1.5rem; }
.sale-tier { margin-bottom: 5rem; }
.tier-title {
    font-family: Georgia, 'Times New Roman', serif;
    font-size: clamp(30px, 3.2vw, 40px);
    margin-bottom: 3rem;
    color: var(--jojo-ink, #401b1b);
    text-align: center;
    font-weight: 700;
    letter-spacing: -0.02em;
}
.tier-title span { 
    color: var(--jojo-red, #a4000b); 
    font-style: normal;
}

/* Grid Layout */
.yum-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2.5rem;
}

/* Elegant Card Style */
.yum-card {
    border-radius: 20px;
    overflow: hidden;
    background: #fffaf2;
    box-shadow: 0 6px 18px rgba(95, 30, 20, 0.08);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #ead8c9;
}
.yum-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(95, 30, 20, 0.12);
}
.yum-card-top {
    position: relative;
    padding: 2.5rem 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 260px;
    background: var(--jojo-gold, #f2c455);
    border-radius: 20px 20px 0 0;
}
.yum-card-top img {
    max-height: 200px;
    object-fit: contain;
    transition: transform 0.4s ease;
}
.yum-card:hover .yum-card-top img {
    transform: scale(1.05);
}
.yum-badge {
    position: absolute;
    top: 25px;
    left: -45px;
    width: 170px;
    padding: 0.4rem 0;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    color: white;
    z-index: 2;
    letter-spacing: 1px;
    transform: rotate(-45deg);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.badge-red { 
    background: var(--jojo-red, #a4000b); 
    box-shadow: 0 4px 12px rgba(164, 0, 11, 0.3);
}
.badge-black { 
    background: #401b1b; 
    color: var(--jojo-gold, #f2c455);
    box-shadow: 0 4px 12px rgba(40, 18, 11, 0.2);
}
.discount-badge {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    background: var(--jojo-gold, #f2c455);
    color: #401b1b;
    font-weight: 800;
    font-size: 0.85rem;
    padding: 0.35rem 0.8rem;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(242, 196, 85, 0.35);
    z-index: 2;
}

.yum-card-bottom {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: #fffaf2;
}
.yum-meta {
    font-size: 0.8rem;
    font-weight: 700;
    color: #8a5a40;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    letter-spacing: 1px;
}
.yum-title {
    font-family: Georgia, 'Times New Roman', serif;
    font-size: 1.25rem;
    margin: 0 0 0.75rem 0;
    font-weight: 700;
    line-height: 1.35;
    color: #420d16;
}
.yum-desc {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    margin: 0 0 1.5rem 0;
    color: #5a2e1d;
    flex: 1;
    line-height: 1.6;
    text-align: left;
}
.yum-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    border-top: 1px solid #ead8c9;
    padding-top: 1.25rem;
}
.price-wrapper {
    display: flex;
    flex-direction: column;
}
.price-original {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 15px;
    color: #73615b;
    text-decoration: line-through;
    font-weight: 500;
    margin-bottom: -0.2rem;
}
.yum-price {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--jojo-red, #a4000b);
}
.yum-btn {
    background: var(--jojo-red, #a4000b);
    color: #FDFBF7;
    border: none;
    padding: 0.65rem 1.25rem;
    border-radius: 20px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 700;
    font-size: 0.88rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(164, 0, 11, 0.25);
    transition: all 0.25s ease;
}
.yum-btn:hover {
    background: #710007;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(164, 0, 11, 0.35);
}
.yum-btn:active {
    transform: translateY(0);
}

@media (max-width: 1200px) {
    .yum-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
    .yum-grid { grid-template-columns: repeat(2, 1fr); }
    .tier-title { font-size: 2.5rem; }
}
@media (max-width: 600px) {
    .sale-banner-wrapper { height: 180px !important; margin-bottom: 2rem !important; }
    .yum-grid { grid-template-columns: 1fr; }
    .yum-card-top { min-height: 220px; }
    .yum-card-top img { max-height: 160px; }
}
/* Countdown Timer Styles */
.countdown-timer {
    position: absolute;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255,255,255,0.95);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    font-weight: 700;
    color: var(--spice-bg-dark);
    z-index: 2;
    white-space: nowrap;
}
.cd-item b {
    font-size: 1.1rem;
    color: var(--spice-primary);
}
.cd-item small {
    font-size: 0.7rem;
    color: #888;
    margin-left: 2px;
}

@media (max-width: 768px) {
    .sale-banner-wrapper {
        height: clamp(220px, 50vw, 320px) !important;
        margin-bottom: 2rem !important;
        border-radius: 20px !important;
    }
    .tier-title {
        font-size: 24px !important;
        margin-bottom: 1.5rem !important;
    }
    .yum-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
    .yum-card {
        border-radius: 20px !important;
    }
    .yum-card-bottom {
        padding: 0.75rem 0.6rem !important;
    }
    .yum-title {
        font-size: 13.5px !important;
        height: 35px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .yum-desc {
        display: none !important;
    }
    .yum-action {
        flex-direction: column !important;
        gap: 0.5rem !important;
        align-items: stretch !important;
    }
    .yum-btn {
        width: 100% !important;
        padding: 0.5rem 0 !important;
        font-size: 0.75rem !important;
        border-radius: 20px !important;
    }
    .countdown-timer {
        font-size: 0.68rem !important;
        padding: 0.25rem 0.5rem !important;
        bottom: 8px !important;
    }
}
@media (max-width: 480px) {
    .yum-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const timers = document.querySelectorAll('.countdown-timer');
    
    timers.forEach(timer => {
        const endTimeStr = timer.getAttribute('data-end');
        if(!endTimeStr) return;
        // Parse date string carefully to support Safari (replacing - with / is sometimes needed but we used ISO format Y-m-dTH:i:s)
        const endTime = new Date(endTimeStr).getTime();
        
        const hEl = timer.querySelector('.cd-h');
        const mEl = timer.querySelector('.cd-m');
        const sEl = timer.querySelector('.cd-s');

        const interval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(interval);
                hEl.textContent = "00";
                mEl.textContent = "00";
                sEl.textContent = "00";
                return;
            }

            // Calculate hours properly including days
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            hEl.textContent = hours.toString().padStart(2, '0');
            mEl.textContent = minutes.toString().padStart(2, '0');
            sEl.textContent = seconds.toString().padStart(2, '0');
        }, 1000);
    });
});
</script>
@endsection
