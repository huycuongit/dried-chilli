@extends('frontend.layouts.master')
@section('meta')
    <title>Sale | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content shop-bg">
    
    <div class="container sale-container">
        <!-- SALE Section -->
        <div class="sale-tier reveal" id="sale-active">
            <h2 class="tier-title"><span>HOT</span> FLASH SALE</h2>
            <div class="yum-grid">
                @forelse($saleProducts as $product)
                    <div class="yum-card">
                        <div class="yum-card-top" style="background-color: {{ $loop->iteration % 2 == 0 ? '#FAF4E6' : '#F8F3EA' }};">
                            @if($product->is_best_seller)
                                <div class="yum-badge badge-red">★ BEST SELLER ★</div>
                            @else
                                <div class="yum-badge badge-black">LIMITED OFFER</div>
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
                                <span class="yum-price">${{ number_format($product->sale_price, 2) }}</span>
                                <button class="yum-btn" data-product-id="{{ $product->id }}">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="font-size: 1.5rem; color: var(--spice-text);">No items currently on sale. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

<style>
.shop-bg { background: #FFF9F0; min-height: 100vh; padding-bottom: 4rem; }



/* Sale Container */
.sale-container { max-width: 1300px; margin: 0 auto 4rem auto; padding: 10px 1rem 0 1rem; }
.sale-tier { margin-bottom: 5rem; }
.tier-title {
    font-family: var(--font-heading);
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: var(--spice-text);
    border-bottom: 4px solid var(--spice-text);
    padding-bottom: 1rem;
    text-transform: uppercase;
}
.tier-title span { color: #D92525; }

/* Grid Layout */
.yum-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

/* YumYum Custom Card Style */
.yum-card {
    border: 3px solid var(--spice-text);
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 6px 6px 0px var(--spice-text);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s;
}
.yum-card:hover {
    transform: translateY(-5px);
}
.yum-card-top {
    position: relative;
    padding: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-bottom: 3px solid var(--spice-text);
    min-height: 280px;
}
.yum-card-top img {
    max-height: 220px;
    object-fit: contain;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.yum-card:hover .yum-card-top img {
    transform: scale(1.1);
}
.yum-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    color: white;
    border-radius: 20px;
    z-index: 2;
    letter-spacing: 0.5px;
}
.badge-red { background: #D92525; }
.badge-black { background: var(--spice-text); }

.yum-card-bottom {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.yum-meta {
    font-size: 0.85rem;
    font-weight: 700;
    color: #555;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}
.yum-title {
    font-family: var(--font-heading);
    font-size: 1.8rem;
    margin: 0 0 0.5rem 0;
    text-transform: uppercase;
    line-height: 1.1;
    color: var(--spice-text);
}
.yum-desc {
    font-size: 1.05rem;
    margin: 0 0 1.5rem 0;
    color: #2B1D14;
    flex: 1;
    line-height: 1.4;
}
.yum-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}
.yum-price {
    font-family: var(--font-heading);
    font-size: 1.8rem;
    font-weight: 800;
}
.yum-btn {
    background: #D92525;
    color: white;
    border: 2px solid var(--spice-text);
    padding: 0.6rem 1.2rem;
    border-radius: 20px;
    font-weight: 800;
    text-transform: uppercase;
    cursor: pointer;
    box-shadow: 3px 3px 0px var(--spice-text);
    transition: all 0.1s;
    font-size: 0.9rem;
}
.yum-btn:hover {
    background: #e33b3b;
}
.yum-btn:active {
    transform: translate(3px, 3px);
    box-shadow: 0px 0px 0px var(--spice-text);
}

@media (max-width: 1024px) {
    .yum-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
    .yum-grid { grid-template-columns: 1fr; }
    .tier-title { font-size: 2rem; }
    .banner-text h1 { font-size: 3rem; }
}
</style>
@endsection
