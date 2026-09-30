@extends('frontend.layouts.master')
@section('meta')
    <title>{{ $product->name }} | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content detail-bg">
    
    <div class="container detail-container reveal">
        <!-- Left: Product Image -->
        <div class="detail-left">
            <div class="product-gallery">
                <div class="main-image">
                    @if($product->sale_price)
                        <div class="product-badge sale">SALE</div>
                    @elseif($product->is_best_seller)
                        <div class="product-badge best-seller">BEST SELLER</div>
                    @endif
                    <img src="{{ asset('images/product_hero.png') }}" alt="{{ $product->name }}" id="featured-img">
                </div>
                <div class="thumbnail-list">
                    <!-- Placeholder thumbnails -->
                    <div class="thumb-item active"><img src="{{ asset('images/product_hero.png') }}" alt="thumb1"></div>
                    <div class="thumb-item"><img src="{{ asset('images/product_hero.png') }}" alt="thumb2"></div>
                </div>
            </div>
        </div>

        <!-- Right: Product Info -->
        <div class="detail-right">
            <div class="product-vendor">{{ $product->category->name ?? 'Spices & Seasonings' }}</div>
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <div class="product-price">
                @if($product->sale_price)
                    <span class="price-current">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="price-compare">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <div class="product-description">
                <p>{{ $product->description }}</p>
            </div>

            <div class="cart-action-group">
                <div class="quantity-selector">
                    <button type="button" class="qty-btn minus">-</button>
                    <input type="number" value="1" min="1" max="10" class="qty-input" id="detail-qty">
                    <button type="button" class="qty-btn plus">+</button>
                </div>
                <button class="add-to-cart-btn large-btn" 
                    data-product-id="{{ $product->id }}" 
                    data-name="{{ $product->name }}" 
                    data-price="{{ $product->sale_price ?? $product->price }}">
                    ADD TO CART
                </button>
            </div>

            <!-- Accordions -->
            <div class="product-accordion">
                <details class="accordion-item" open>
                    <summary class="accordion-header">INGREDIENTS</summary>
                    <div class="accordion-content">
                        <p>100% Natural, non-GMO spices. No artificial colors or preservatives. Made in a facility that also processes peanuts.</p>
                    </div>
                </details>
                <details class="accordion-item">
                    <summary class="accordion-header">HOW TO USE</summary>
                    <div class="accordion-content">
                        <p>Sprinkle generously on meat, poultry, or vegetables before cooking. Can also be used as a finishing salt.</p>
                    </div>
                </details>
                <details class="accordion-item">
                    <summary class="accordion-header">SHIPPING & RETURNS</summary>
                    <div class="accordion-content">
                        <p>Free standard shipping on orders over $50. Returns accepted within 30 days of purchase for unopened items.</p>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="container related-container reveal">
        <h2 class="section-heading">YOU MIGHT ALSO LIKE</h2>
        <div class="yum-grid">
            @foreach($relatedProducts as $related)
            <div class="product-card" style="border: 3px solid var(--spice-text); border-radius: 12px; overflow: hidden; background: white; box-shadow: 6px 6px 0px var(--spice-text); display: flex; flex-direction: column; transition: transform 0.2s;">
                <a href="{{ route('page.product', $related->slug) }}" class="product-img-wrapper" style="padding: 2rem; display: flex; justify-content: center; border-bottom: 3px solid var(--spice-text); background-color: #F8F3EA;">
                    <img src="{{ asset('images/product_hero.png') }}" alt="{{ $related->name }}" style="max-height: 200px; object-fit: contain;">
                </a>
                <div class="product-details" style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                    <a href="{{ route('page.product', $related->slug) }}" class="product-title" style="font-family: var(--font-heading); font-size: 1.5rem; text-decoration: none; color: var(--spice-text); margin-bottom: 0.5rem;">{{ $related->name }}</a>
                    <div class="product-price" style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem;">
                        @if($related->sale_price)
                            <span class="price-current" style="color: var(--spice-text);">${{ number_format($related->sale_price, 2) }}</span>
                            <span class="price-compare" style="color: #999; text-decoration: line-through; font-size: 1rem;">${{ number_format($related->price, 2) }}</span>
                        @else
                            ${{ number_format($related->price, 2) }}
                        @endif
                    </div>
                    <button class="add-to-cart-btn" style="background: var(--spice-primary); color: white; border: 2px solid var(--spice-text); padding: 0.5rem 1rem; border-radius: 20px; font-weight: 800; cursor: pointer; text-transform: uppercase;" data-product-id="{{ $related->id }}" data-name="{{ $related->name }}" data-price="{{ $related->sale_price ?? $related->price }}">Add to Cart</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</main>

<style>
.detail-bg { background: #FFF9F0; min-height: 100vh; padding-bottom: 4rem; }

/* Detail Layout */
.detail-container { 
    max-width: 1200px; 
    margin: 0 auto;
    padding: 3rem 1rem 0 1rem; 
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

/* Left: Gallery */
.product-gallery {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.main-image {
    border: 4px solid var(--spice-text);
    border-radius: 12px;
    background: white;
    padding: 2rem;
    position: relative;
    box-shadow: 8px 8px 0px var(--spice-text);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}
.main-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}
.product-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.4rem 0.8rem;
    font-size: 0.75rem;
    font-weight: 800;
    color: white;
    text-transform: uppercase;
    border-radius: 20px;
    z-index: 10;
    letter-spacing: 0.5px;
}
.product-badge.sale { background: var(--spice-primary); }
.product-badge.best-seller { background: var(--spice-text); }

.thumbnail-list {
    display: flex;
    gap: 1rem;
}
.thumb-item {
    border: 3px solid var(--spice-text);
    border-radius: 8px;
    background: white;
    width: 80px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
    opacity: 0.6;
}
.thumb-item img {
    max-width: 80%;
    max-height: 80%;
}
.thumb-item.active, .thumb-item:hover {
    opacity: 1;
    box-shadow: 4px 4px 0px var(--spice-text);
    transform: translateY(-2px);
}

/* Right: Product Info */
.product-vendor {
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #666;
    margin-bottom: 0.5rem;
    letter-spacing: 1px;
}
.product-title {
    font-family: var(--font-heading);
    font-size: 3rem;
    color: var(--spice-text);
    margin: 0 0 1rem 0;
    line-height: 1.1;
    text-transform: uppercase;
}
.product-price {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.price-current { color: var(--spice-text); }
.price-compare { color: #999; text-decoration: line-through; font-size: 1.5rem; }

.product-description {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 2.5rem;
    color: #444;
}

/* Cart Actions */
.cart-action-group {
    display: flex;
    gap: 1rem;
    margin-bottom: 3rem;
    border-bottom: 3px solid var(--spice-text);
    padding-bottom: 3rem;
}
.quantity-selector {
    display: flex;
    border: 3px solid var(--spice-text);
    border-radius: 30px;
    background: white;
    overflow: hidden;
    height: 60px;
    box-shadow: 4px 4px 0px var(--spice-text);
}
.qty-btn {
    background: none;
    border: none;
    width: 50px;
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.qty-btn:hover { background: #f0f0f0; }
.qty-input {
    width: 60px;
    text-align: center;
    border: none;
    border-left: 2px solid var(--spice-text);
    border-right: 2px solid var(--spice-text);
    font-size: 1.2rem;
    font-weight: bold;
    font-family: var(--font-body);
    -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.large-btn {
    flex: 1;
    background: var(--spice-primary);
    color: white;
    border: 3px solid var(--spice-text);
    border-radius: 30px;
    font-weight: 800;
    font-size: 1.1rem;
    text-transform: uppercase;
    cursor: pointer;
    box-shadow: 6px 6px 0px var(--spice-text);
    transition: all 0.1s;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.large-btn:hover {
    background: #e33b3b;
}
.large-btn:active {
    transform: translate(3px, 3px);
    box-shadow: 3px 3px 0px var(--spice-text);
}

/* Accordions */
.product-accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.accordion-item {
    border: 3px solid var(--spice-text);
    border-radius: 8px;
    background: white;
    overflow: hidden;
    box-shadow: 4px 4px 0px var(--spice-text);
}
.accordion-header {
    padding: 1rem 1.5rem;
    font-weight: 800;
    font-size: 1.1rem;
    cursor: pointer;
    user-select: none;
    text-transform: uppercase;
    background: var(--spice-bg);
}
.accordion-header::-webkit-details-marker { display: none; }
.accordion-header::after {
    content: '+';
    float: right;
    font-size: 1.5rem;
    line-height: 1;
}
details[open] .accordion-header::after { content: '-'; }
.accordion-content {
    padding: 1.5rem;
    border-top: 3px solid var(--spice-text);
    line-height: 1.5;
}

/* Related Products */
.related-container { margin-top: 5rem; }
.section-heading {
    font-family: var(--font-heading);
    font-size: 2.5rem;
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 3rem;
}

.yum-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

@media (max-width: 1024px) {
    .yum-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .detail-container { grid-template-columns: 1fr; gap: 2rem; }
    .main-image { min-height: 350px; }
    .product-title { font-size: 2.5rem; }
    .yum-grid { grid-template-columns: 1fr; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thumbnails logic
    const mainImg = document.getElementById('featured-img');
    const thumbs = document.querySelectorAll('.thumb-item');
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            mainImg.src = this.querySelector('img').src;
        });
    });

    // Quantity selector logic
    const qtyInput = document.getElementById('detail-qty');
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');

    minusBtn.addEventListener('click', () => {
        let val = parseInt(qtyInput.value);
        if (val > 1) qtyInput.value = val - 1;
    });
    plusBtn.addEventListener('click', () => {
        let val = parseInt(qtyInput.value);
        if (val < parseInt(qtyInput.max)) qtyInput.value = val + 1;
    });

    // Handle add to cart with quantity
    const addBtn = document.querySelector('.detail-right .add-to-cart-btn');
    if (addBtn) {
        addBtn.addEventListener('click', function(e) {
            const id = this.dataset.productId;
            const qty = parseInt(qtyInput.value);
            
            if (window.addToCart) {
                window._lastClickedBtn = this; // for toast animation
                window.addToCart(id, qty);
            } else {
                console.error("Cart script not loaded");
            }
        });
    }
});
</script>
@endsection
