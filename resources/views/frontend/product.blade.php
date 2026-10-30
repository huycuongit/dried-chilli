@extends('frontend.layouts.master')

@section('title', $product->name . ' | Dried Chili')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?: 'Shop ' . $product->name . ' at Dried Chili. Handcrafted premium spicy seasonings, 100% natural and freshly packaged.'), 155))
@section('og_image', $product->image_url)
@section('og_type', 'product')

@section('schema_json')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Product",
      "name": "{{ addslashes($product->name) }}",
      "image": ["{{ $product->image_url }}"],
      "description": "{{ addslashes(strip_tags($product->description ?: $product->name)) }}",
      "sku": "DC-{{ $product->id }}",
      "brand": {
        "@type": "Brand",
        "name": "Dried Chili"
      },
      "category": "{{ addslashes($product->category->name ?? 'Spices & Seasonings') }}",
      "offers": {
        "@type": "Offer",
        "url": "{{ request()->url() }}",
        "priceCurrency": "USD",
        "price": "{{ number_format((float)($product->sale_price ?? $product->price), 2, '.', '') }}",
        "priceValidUntil": "{{ date('Y-12-31') }}",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "Dried Chili"
        }
      }
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ url('/') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Shop",
          "item": "{{ url('/shop') }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ addslashes($product->name) }}",
          "item": "{{ request()->url() }}"
        }
      ]
    }
  ]
}
</script>
@endsection
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
<main class="page-content detail-bg">
    
    <div class="container detail-container reveal">
        <!-- Left: Product Image -->
        <div class="detail-left">
            <div class="product-gallery">
                <div class="main-image">
                    @if($product->sale_price)
                        <div class="product-badge sale">{{ $pageLayoutValue('page_layout_product_product_details_01') }}</div>
                    @elseif($product->is_best_seller)
                        <div class="product-badge best-seller">{{ $pageLayoutValue('page_layout_product_product_details_02') }}</div>
                    @endif
                    <img src="{{ $product->gallery_images[0] ?? $product->image_url }}" alt="{{ $product->name }}" id="featured-img">
                </div>
                @if(count($product->gallery_images) > 1)
                    <div class="thumbnail-list">
                        @foreach($product->gallery_images as $index => $imgUrl)
                            <div class="thumb-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }} thumb {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif
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

            <div class="product-stock" style="margin-bottom: 1.25rem;">
                @if($product->inventory && $product->inventory->quantity > 0)
                    <span class="stock-badge in-stock">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                        {{ $pageLayoutValue('page_layout_product_product_details_03') }}
                    </span>
                @else
                    <span class="stock-badge out-of-stock">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        {{ $pageLayoutValue('page_layout_product_product_details_04') }}
                    </span>
                @endif
            </div>

            <div class="cart-action-group">
                <div class="quantity-selector">
                    <button type="button" class="qty-btn minus" aria-label="Decrease quantity">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <input type="number" value="1" min="1" max="{{ max(1, min(10, $product->inventory->quantity ?? 1)) }}" class="qty-input" id="detail-qty" aria-label="Quantity">
                    <button type="button" class="qty-btn plus" aria-label="Increase quantity">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                </div>
                <button class="add-to-cart-btn large-btn" 
                    data-product-id="{{ $product->id }}" 
                    data-name="{{ $product->name }}" 
                    data-price="{{ $product->sale_price ?? $product->price }}"
                    @if(!$product->inventory || $product->inventory->quantity <= 0) disabled style="opacity: 0.5; cursor: not-allowed; pointer-events: none;" @endif>
                    <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    {{ (!$product->inventory || $product->inventory->quantity <= 0) ? $pageLayoutValue('page_layout_product_unavailable') : $pageLayoutValue('page_layout_product_add_to_cart') }}
                </button>
            </div>

            <!-- Accordions -->
            <div class="product-accordion">
                <details class="accordion-item" open>
                    <summary class="accordion-header">
                        <span>{{ $pageLayoutValue('page_layout_product_product_details_05') }}</span>
                        <svg class="accordion-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="accordion-content">
                        <p>{{ $pageLayoutValue('page_layout_product_product_details_06') }}</p>
                    </div>
                </details>
                <details class="accordion-item">
                    <summary class="accordion-header">
                        <span>{{ $pageLayoutValue('page_layout_product_product_details_07') }}</span>
                        <svg class="accordion-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="accordion-content">
                        <p>{{ $pageLayoutValue('page_layout_product_product_details_08') }}</p>
                    </div>
                </details>
                <details class="accordion-item">
                    <summary class="accordion-header">
                        <span>{{ $pageLayoutValue('page_layout_product_product_details_09') }}</span>
                        <svg class="accordion-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="accordion-content">
                        <p>{{ $pageLayoutValue('page_layout_product_shipping_text') }}</p>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="container related-container reveal">
        <h2 class="section-heading">{{ $pageLayoutValue('page_layout_product_product_details_10') }}</h2>
        <div class="yum-grid">
            @foreach($relatedProducts as $related)
            <div class="product-card">
                <a href="{{ route('page.product', $related->slug) }}" class="product-img-wrapper">
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" loading="lazy">
                </a>
                <div class="product-details">
                    <div class="product-vendor">{{ $related->category->name ?? 'Dried Chili' }}</div>
                    <a href="{{ route('page.product', $related->slug) }}" class="product-card-title">{{ $related->name }}</a>
                    <div class="product-price">
                        @if($related->sale_price)
                            <span class="price-current">${{ number_format($related->sale_price, 2) }}</span>
                            <span class="price-compare">${{ number_format($related->price, 2) }}</span>
                        @else
                            <span class="price-current">${{ number_format($related->price, 2) }}</span>
                        @endif
                    </div>
                    <div class="product-stock">
                        @if($related->inventory && $related->inventory->quantity > 0)
                            <span class="stock-badge in-stock">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                {{ $pageLayoutValue('page_layout_product_product_details_11') }}
                            </span>
                        @else
                            <span class="stock-badge out-of-stock">{{ $pageLayoutValue('page_layout_product_product_details_12') }}</span>
                        @endif
                    </div>
                    <button class="add-to-cart-btn" data-product-id="{{ $related->id }}" data-name="{{ $related->name }}" data-price="{{ $related->sale_price ?? $related->price }}">
                        <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        {{ $pageLayoutValue('page_layout_product_product_details_13') }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'Product Details'])
</main>

<style>
.detail-bg { background: var(--spice-bg-alt); min-height: 100vh; padding-bottom: 5rem; }

/* Detail Layout */
.detail-container { 
    max-width: 1200px; 
    margin: 0 auto;
    padding: 3.5rem 1.5rem 0 1.5rem; 
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

/* Left: Gallery */
.product-gallery {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.main-image {
    border: 1px solid rgba(40, 18, 11, 0.08);
    border-radius: 20px;
    background: #FFFFFF;
    padding: 2.5rem;
    position: relative;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
    overflow: hidden;
    isolation: isolate;
    transition: box-shadow 0.3s ease;
}
.main-image:hover {
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.07);
}
.main-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    transition: transform 0.4s ease;
}
.main-image:hover img {
    transform: scale(1.04);
}

/* Corner Ribbon Badge */
.product-badge {
    position: absolute;
    top: 24px;
    left: -38px;
    width: 155px;
    text-align: center;
    padding: 0.4rem 0;
    color: #FFFFFF;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    white-space: nowrap;
    z-index: 10;
    transform: rotate(-45deg);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
    pointer-events: none;
    line-height: 1.2;
    text-shadow: 0 1px 2px rgba(0,0,0,0.25);
}
.product-badge.sale { 
    background: linear-gradient(135deg, var(--spice-accent) 0%, var(--spice-primary) 100%);
    color: #FFFFFF;
}
.product-badge.best-seller { 
    background: linear-gradient(135deg, #FFB300 0%, #FF8F00 100%);
    color: #28120B;
    text-shadow: none;
    box-shadow: 0 4px 10px rgba(255, 179, 0, 0.3);
}

/* Product Stock Clean Badge */
.product-stock {
    margin-bottom: 1.25rem;
}
.product-stock .stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
}
.product-stock .stock-badge.in-stock {
    color: #2E7D32; /* Chữ màu xanh lá */
    font-weight: 600;
}
.product-stock .stock-badge.out-of-stock {
    color: #C73B1B;
    font-weight: 600;
}

.thumbnail-list {
    display: flex;
    gap: 1rem;
}
.thumb-item {
    border: 1.5px solid rgba(40, 18, 11, 0.12);
    border-radius: 20px;
    background: #FFFFFF;
    width: 80px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.25s ease;
    opacity: 0.7;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}
.thumb-item img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
}
.thumb-item.active, .thumb-item:hover {
    opacity: 1;
    border-color: var(--spice-primary);
    box-shadow: 0 6px 16px rgba(228, 93, 62, 0.25);
    transform: translateY(-2px);
}

/* Right: Product Info */
.product-vendor {
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #9C8F85;
    margin-bottom: 0.5rem;
    letter-spacing: 1.2px;
}
.product-title {
    font-family: var(--font-heading);
    font-size: clamp(48px, 4.2vw, 64px);
    font-weight: 800;
    color: var(--spice-bg-dark);
    margin: 0 0 1rem 0;
    line-height: 1.1;
    text-transform: uppercase;
    letter-spacing: -0.5px;
}
.product-price {
    font-family: var(--font-body);
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: baseline;
    gap: 1rem;
}
.price-current { color: var(--spice-bg-dark); font-size: 24px; font-weight: 800; }
.price-compare { color: #9C8F85; text-decoration: line-through; font-size: 16px; font-weight: 400; }

.product-description {
    font-family: var(--font-body);
    font-size: 15px;
    line-height: 1.65;
    margin-bottom: 2rem;
    color: #4A3B32;
    text-align: left;
}
.product-description p {
    margin: 0;
    line-height: inherit;
    text-align: left;
}

/* Cart Actions */
.cart-action-group {
    display: flex;
    gap: 1rem;
    margin-bottom: 2.5rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.1);
    padding-bottom: 2.5rem;
}
.quantity-selector {
    display: flex;
    align-items: center;
    border: 1.5px solid rgba(40, 18, 11, 0.15);
    border-radius: 20px;
    background: #FFFFFF;
    overflow: hidden;
    height: 56px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
    transition: border-color 0.2s;
}
.quantity-selector:focus-within {
    border-color: var(--spice-primary);
}
.qty-btn {
    background: transparent;
    border: none;
    width: 48px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--spice-bg-dark);
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.qty-btn:hover { 
    background: rgba(228, 93, 62, 0.08); 
    color: var(--spice-primary);
}
.qty-input {
    width: 50px;
    height: 100%;
    text-align: center;
    border: none;
    font-size: 1.15rem;
    font-weight: 700;
    font-family: var(--font-body);
    color: var(--spice-bg-dark);
    background: transparent;
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
    color: #FFFFFF;
    border: none;
    border-radius: 20px;
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 1.05rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(228, 93, 62, 0.35);
    transition: all 0.25s ease;
    height: 56px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 0.65rem;
}
.large-btn:hover {
    background: var(--spice-accent);
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(199, 59, 27, 0.4);
}
.large-btn:active {
    transform: translateY(0);
    box-shadow: 0 6px 16px rgba(199, 59, 27, 0.3);
}
.large-btn .btn-icon {
    width: 20px;
    height: 20px;
    stroke-width: 2px;
}

/* Accordions */
.product-accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.accordion-item {
    border: 1px solid rgba(40, 18, 11, 0.08);
    border-radius: 20px;
    background: #FFFFFF;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.accordion-item[open] {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    border-color: rgba(40, 18, 11, 0.12);
}
.accordion-header {
    padding: 1.15rem 1.5rem;
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    user-select: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #FFFFFF;
    display: flex;
    justify-content: space-between;
    align-items: center;
    list-style: none;
    color: var(--spice-bg-dark);
    transition: color 0.2s;
}
.accordion-header:hover {
    color: var(--spice-primary);
}
.accordion-header::-webkit-details-marker { display: none; }
.accordion-chevron {
    transition: transform 0.3s ease;
    color: var(--spice-bg-dark);
}
details[open] .accordion-chevron {
    transform: rotate(180deg);
    color: var(--spice-primary);
}
.accordion-content {
    padding: 1.25rem 1.5rem 1.5rem;
    border-top: 1px solid rgba(40, 18, 11, 0.06);
    line-height: 1.65;
    font-family: var(--font-body);
    font-size: 14px;
    color: #4A3B32;
    text-align: left;
}
.accordion-content p {
    margin: 0;
    line-height: inherit;
    text-align: left;
}

/* Related Products */
.related-container { margin-top: 5rem; }
.section-heading {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    font-weight: 800;
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 3rem;
    color: var(--spice-bg-dark);
}

.yum-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

/* Related Product Cards */
.related-container .product-card {
    background: #FFFFFF;
    border-radius: 20px;
    border: 1px solid rgba(40, 18, 11, 0.08);
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.related-container .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}
.related-container .product-img-wrapper {
    position: relative;
    display: block;
    padding-top: 100%;
    overflow: hidden;
    background: transparent;
}
.related-container .product-img-wrapper img {
    position: absolute;
    top: 10%;
    left: 10%;
    width: 80%;
    height: 80%;
    object-fit: contain;
    transition: transform 0.4s ease;
}
.related-container .product-card:hover .product-img-wrapper img {
    transform: scale(1.08);
}
.related-container .product-details {
    padding: 1.25rem 1.5rem 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.related-container .product-vendor {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9C8F85;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.related-container .product-card-title {
    font-family: var(--font-body);
    font-size: 18px;
    color: var(--spice-bg-dark);
    text-decoration: none;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    font-weight: 600;
    transition: color 0.2s;
    flex-grow: 1;
}
.related-container .product-card-title:hover {
    color: var(--spice-primary);
}
.related-container .product-price {
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 0.5rem;
    color: var(--spice-bg-dark);
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}
.related-container .product-stock {
    margin: 0.25rem 0 0.75rem;
}
.related-container .product-stock .stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.85rem;
    font-weight: 600;
}
.related-container .product-stock .stock-badge.in-stock {
    color: #2E7D32; /* Green */
    font-weight: 600;
}
.related-container .product-stock .stock-badge.out-of-stock {
    color: #C73B1B;
    font-weight: 600;
}
.related-container .add-to-cart-btn {
    margin-top: auto;
    width: 100%;
    padding: 0.8rem;
    background: var(--spice-bg-dark);
    color: white;
    border: none;
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 20px;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.related-container .add-to-cart-btn:hover {
    background: var(--spice-primary);
}
.related-container .add-to-cart-btn .btn-icon {
    width: 18px;
    height: 18px;
    stroke-width: 2px;
}

@media (max-width: 1024px) {
    .yum-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .detail-container { grid-template-columns: 1fr; gap: 1.5rem; padding: 0 1rem; }
    .main-image { min-height: 280px; height: 280px; }
    .yum-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 10px !important; }
}

@media (max-width: 768px) {
    .product-title {
        font-size: 24px !important;
        line-height: 1.2 !important;
        margin-bottom: 0.5rem !important;
    }
    .product-price {
        font-size: 22px !important;
        margin-bottom: 0.75rem !important;
    }
    .product-description {
        font-size: 14px !important;
        line-height: 1.5 !important;
        margin-bottom: 1rem !important;
    }
    .cart-action-group {
        display: flex;
        gap: 0.5rem;
    }
    /* .quantity-selector {
        width: 100px;
        height: 46px;
    } */
    .add-to-cart-btn.large-btn {
        flex: 1;
        height: 54px;
        padding: 0 1rem;
        font-size: 14px;
    }
    .section-heading {
        font-size: 22px !important;
    }
}

@media (max-width: 480px) {
    .main-image { min-height: 240px; height: 240px; }
    .yum-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 8px !important; }
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
