@extends('frontend.layouts.master')
@section('meta')
    <title>Sale | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content shop-bg">
    
    <div class="container sale-container">
        @if($bigSaleActive)
        <!-- BIG SALE Section -->
        <div class="sale-tier reveal" id="big-sale">
            @if($bigSaleBanner)
            <div class="sale-banner-wrapper" style="margin-bottom: 3rem; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.06); height: 650px;">
                <img src="{{ str_starts_with($bigSaleBanner, 'http') ? $bigSaleBanner : asset('storage/' . $bigSaleBanner) }}" alt="{{ $bigSaleTitle }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
            </div>
            @endif
            
            <h2 class="tier-title">{{ $bigSaleTitle }}</h2>
            <div class="yum-grid">
                @forelse($bigSaleProducts as $product)
                    <div class="yum-card">
                        <div class="yum-card-top">
                            @if($product->is_best_seller)
                                <div class="yum-badge badge-red">★ BEST SELLER ★</div>
                            @else
                                <div class="yum-badge badge-black">LIMITED OFFER</div>
                            @endif
                            @if($product->price > $product->sale_price)
                                <div class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
                            @endif
                            <a href="{{ route('page.product', $product->slug) }}">
                                <img src="{{ asset('images/product_hero.png') }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="yum-card-bottom">
                            <div class="yum-meta">{{ $product->category->name ?? 'Spices & Seasonings' }}</div>
                            <h3 class="yum-title"><a href="{{ route('page.product', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ $product->name }}</a></h3>
                            <p class="yum-desc">{{ Str::limit($product->description, 60) }}</p>
                            <div class="yum-action">
                                <div class="price-wrapper">
                                    <span class="price-original">${{ number_format($product->price, 2) }}</span>
                                    <span class="yum-price">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                                <button class="yum-btn" data-product-id="{{ $product->id }}">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 1.5rem; color: var(--spice-text); text-align: center; grid-column: 1/-1;">No items in Big Sale.</p>
                @endforelse
            </div>
        </div>
        @endif

        <!-- FLASH SALE Section -->
        <div class="sale-tier reveal" id="flash-sale">
            <h2 class="tier-title"><span style="font-weight: 800; letter-spacing: 0.1em; margin-right: 5px">SPICIEST</span>DEALS</h2>
            <div class="yum-grid">
                @forelse($flashSaleProducts as $product)
                    <div class="yum-card flash-card">
                        <div class="yum-card-top">
                            <div class="yum-badge badge-red flash-badge">
                                FLASH SALE
                            </div>
                            @if($product->price > $product->sale_price)
                                <div class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
                            @endif
                            <a href="{{ route('page.product', $product->slug) }}">
                                <img src="{{ asset('images/product_hero.png') }}" alt="{{ $product->name }}">
                            </a>
                            <!-- COUNTDOWN TIMER -->
                            <div class="countdown-timer" data-end="{{ \Carbon\Carbon::parse($product->sale_end_date)->format('Y-m-d\TH:i:s') }}">
                                <span class="cd-item"><b class="cd-h">00</b><small>h</small></span>:
                                <span class="cd-item"><b class="cd-m">00</b><small>m</small></span>:
                                <span class="cd-item"><b class="cd-s">00</b><small>s</small></span>
                            </div>
                        </div>
                        <div class="yum-card-bottom">
                            <div class="yum-meta">{{ $product->category->name ?? 'Spices & Seasonings' }}</div>
                            <h3 class="yum-title"><a href="{{ route('page.product', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ $product->name }}</a></h3>
                            <p class="yum-desc">{{ Str::limit($product->description, 60) }}</p>
                            <div class="yum-action">
                                <div class="price-wrapper">
                                    <span class="price-original">${{ number_format($product->price, 2) }}</span>
                                    <span class="yum-price">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                                <button class="yum-btn" data-product-id="{{ $product->id }}">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 1.5rem; color: var(--spice-text); text-align: center; grid-column: 1/-1;">No flash sale items available today.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

<style>
.shop-bg { background: var(--spice-bg-alt); min-height: 100vh; padding-bottom: 6rem; padding-top: 2rem; }

/* Sale Container */
.sale-container { max-width: 1300px; margin: 0 auto; padding: 0 1.5rem; }
.sale-tier { margin-bottom: 5rem; }
.tier-title {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3.2vw, 40px);
    margin-bottom: 3rem;
    color: var(--spice-bg-dark);
    text-align: center;
    font-weight: 600;
    letter-spacing: 0.05em;
}
.tier-title span { 
    color: var(--spice-primary); 
    font-style: italic;
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
    background: #FFFFFF;
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03);
}
.yum-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.12);
}
.yum-card-top {
    position: relative;
    padding: 3rem 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 280px;
    background: radial-gradient(circle at center, rgba(0,0,0,0.02) 0%, transparent 70%);
}
.yum-card-top img {
    max-height: 200px;
    object-fit: contain;
    transition: transform 0.5s ease;
}
.yum-card:hover .yum-card-top img {
    transform: scale(1.08) rotate(2deg);
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
    background: var(--spice-primary); 
    box-shadow: 0 6px 15px rgba(228, 93, 62, 0.3);
}
.badge-black { 
    background: var(--spice-bg-dark); 
    color: var(--spice-secondary);
    box-shadow: 0 6px 15px rgba(42, 8, 0, 0.2);
}
.discount-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: var(--spice-secondary);
    color: var(--spice-bg-dark);
    font-weight: 800;
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(255, 179, 0, 0.3);
    z-index: 2;
}

.yum-card-bottom {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    background: white;
}
.yum-meta {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--spice-secondary);
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    letter-spacing: 1.5px;
}
.yum-title {
    font-family: var(--font-body);
    font-size: 18px;
    margin: 0 0 1rem 0;
    font-weight: 600;
    line-height: 1.35;
    color: var(--spice-text);
}
.yum-desc {
    font-family: var(--font-body);
    font-size: 14px;
    margin: 0 0 2rem 0;
    color: #6C5D53;
    flex: 1;
    line-height: 1.6;
    text-align: justify;
    text-justify: inter-word;
}
.yum-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    border-top: 1px solid rgba(0,0,0,0.06);
    padding-top: 1.5rem;
}
.price-wrapper {
    display: flex;
    flex-direction: column;
}
.price-original {
    font-family: var(--font-body);
    font-size: 15px;
    color: #9C8F85;
    text-decoration: line-through;
    font-weight: 500;
    margin-bottom: -0.2rem;
}
.yum-price {
    font-family: var(--font-body);
    font-size: 22px;
    font-weight: 700;
    color: var(--spice-bg-dark);
}
.yum-btn {
    background: var(--spice-primary);
    color: #FDFBF7;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(228, 93, 62, 0.3);
    transition: all 0.3s;
    font-size: 0.85rem;
}
.yum-btn:hover {
    background: var(--spice-accent);
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(228, 93, 62, 0.4);
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
    .tier-title {
        font-size: clamp(26px, 5vw, 32px) !important;
    }
    .yum-grid {
        grid-template-columns: 1fr;
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
