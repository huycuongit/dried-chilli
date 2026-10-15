@extends('frontend.layouts.master')
@section('meta')
    <title>Shop All | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content shop-bg">
    <!-- Shop Header -->
    <header class="shop-header">
        <div class="container text-center reveal">
            <h1 class="text-white mt-3" style="color: var(--spice-secondary) !important;">SHOP ALL</h1>
            <p class="hero-subtitle text-white mt-3 mx-auto" style="max-width: 650px; opacity: 0.9; font-size: 1.15rem; line-height: 1.6; margin-left: auto !important; margin-right: auto !important;">
                Every fiery flavor, one place. From mild to wild.
            </p>
        </div>
    </header>

    <div class="shop-container">
        <!-- Filters Sidebar -->
        <aside class="shop-filters">
            <!-- Search -->
            <div class="filter-group">
                <form class="search-box" action="{{ route('page.shop') }}" method="GET">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    <input type="text" name="search" placeholder="Search products..." class="search-input" value="{{ request('search') }}">
                    <button type="submit" class="search-btn" aria-label="Search">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Sort By -->
            <div class="filter-group">
                <h3>Sort By</h3>
                <div class="custom-dropdown" id="sortDropdown">
                    <div class="dropdown-selected">
                        <span>
                            @if(($sort ?? 'featured') == 'price_asc') Price: Low to High
                            @elseif(($sort ?? 'featured') == 'price_desc') Price: High to Low
                            @elseif(($sort ?? 'featured') == 'name_asc') Name: A to Z
                            @elseif(($sort ?? 'featured') == 'name_desc') Name: Z to A
                            @else Featured
                            @endif
                        </span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option {{ ($sort ?? 'featured') == 'featured' ? 'active' : '' }}" data-value="featured">Featured</div>
                        <div class="dropdown-option {{ ($sort ?? 'featured') == 'price_asc' ? 'active' : '' }}" data-value="price_asc">Price: Low to High</div>
                        <div class="dropdown-option {{ ($sort ?? 'featured') == 'price_desc' ? 'active' : '' }}" data-value="price_desc">Price: High to Low</div>
                        <div class="dropdown-option {{ ($sort ?? 'featured') == 'name_asc' ? 'active' : '' }}" data-value="name_asc">Name: A to Z</div>
                        <div class="dropdown-option {{ ($sort ?? 'featured') == 'name_desc' ? 'active' : '' }}" data-value="name_desc">Name: Z to A</div>
                    </div>
                </div>
            </div>


            <!-- Price Range -->
            <div class="filter-group">
                <h3>Price Range</h3>
                <form class="price-range" action="{{ route('page.shop') }}" method="GET">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <input type="number" name="min_price" placeholder="Min" class="price-input" value="{{ request('min_price') }}">
                    <span class="price-sep">-</span>
                    <input type="number" name="max_price" placeholder="Max" class="price-input" value="{{ request('max_price') }}">
                    <button type="submit" class="price-btn">Go</button>
                </form>
            </div>

            <!-- Quick Filters -->
            <div class="filter-group">
                <h3>Quick Filters</h3>
                <form id="quick-filters-form" action="{{ route('page.shop') }}" method="GET">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    
                    <label class="filter-checkbox">
                        <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()" {{ request('in_stock') == '1' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        In Stock
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="best_seller" value="1" onchange="this.form.submit()" {{ request('best_seller') == '1' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Best Sellers
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="on_sale" value="1" onchange="this.form.submit()" {{ request('on_sale') == '1' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        On Sale
                    </label>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="shop-grid">
            @forelse($products as $product)
                <div class="product-card">
                    @if($product->sale_price)
                        <div class="product-badge sale">SALE</div>
                        @if($product->price > $product->sale_price)
                            <div class="discount-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</div>
                        @endif
                    @elseif($product->is_best_seller)
                        <div class="product-badge best-seller">BEST SELLER</div>
                    @endif
                    <a href="{{ route('page.product', $product->slug) }}" class="product-img-wrapper">
                        <!-- Use real product image or fallback -->
                        <img src="{{ asset('images/product_hero.png') }}" alt="{{ $product->name }}">
                    </a>
                    <div class="product-details">
                        <div class="product-vendor">{{ $product->category->name ?? 'Dried Chili' }}</div>
                        <a href="{{ route('page.product', $product->slug) }}" class="product-title">{{ $product->name }}</a>
                        <div class="product-price">
                            @if($product->sale_price)
                                <span class="price-current">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="price-compare">${{ number_format($product->price, 2) }}</span>
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </div>
                        <div class="product-stock">
                            @if($product->inventory && $product->inventory->quantity > 0)
                                <span class="stock-badge in-stock">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                    In Stock
                                </span>
                            @else
                                <span class="stock-badge out-of-stock">Out of stock</span>
                            @endif
                        </div>
                        <button class="add-to-cart-btn" data-product-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->sale_price ?? $product->price }}" @if(!$product->inventory || $product->inventory->quantity <= 0) disabled style="opacity: 0.5; cursor: not-allowed; pointer-events: none;" @endif>
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                <p>No products available at the moment.</p>
            @endforelse
        </section>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="shop-pagination-wrapper">
                <div class="shop-pagination">
                    @if ($products->onFirstPage())
                        <span class="page-link disabled" aria-label="Previous"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="page-link" aria-label="Previous"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></a>
                    @endif

                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        @if ($i == $products->currentPage())
                            <span class="page-link active">{{ $i }}</span>
                        @else
                            <a href="{{ $products->url($i) }}" class="page-link">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="page-link" aria-label="Next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else
                        <span class="page-link disabled" aria-label="Next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></span>
                    @endif
                </div>
            </div>
        @endif
        
    </div>
</main>

<style>
.shop-bg { background: var(--spice-bg-alt); min-height: 100vh; padding-bottom: 6rem; }

.shop-header {
    background: var(--spice-bg-dark);
    color: var(--spice-bg);
    padding: 0;
    height: 650px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.shop-header h1 {
    font-family: var(--font-heading);
    font-size: clamp(48px, 4.5vw, 64px);
    margin: 0 0 1rem 0;
    line-height: 1.08;
    color: var(--spice-secondary);
    font-weight: 800;
    text-transform: uppercase;
}
.shop-header .hero-subtitle,
.shop-header p {
    font-family: var(--font-body);
    font-size: 1.15rem;
    line-height: 1.6;
    font-weight: 400;
    max-width: 650px;
    margin-left: auto !important;
    margin-right: auto !important;
    text-align: center;
    opacity: 0.9;
}

.shop-container {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 4rem;
    max-width: 1400px;
    margin: 4rem auto 0 auto;
    padding: 0 2rem;
}

.shop-filters {
    position: sticky;
    top: 120px;
    height: fit-content;
}
.filter-group {
    margin-bottom: 2.5rem;
}
.filter-group h3 {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    font-weight: 800;
    margin-top: 0;
    margin-bottom: 1.25rem;
    color: var(--spice-bg-dark);
}

/* Search Box */
.search-box {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    padding: 0.8rem 1rem;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.search-box:focus-within {
    border-color: var(--spice-primary);
    box-shadow: 0 8px 25px rgba(228, 93, 62, 0.15);
}
.search-btn {
    background: transparent;
    color: #9C8F85;
    border: none;
    padding: 0;
    margin-right: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: color 0.2s;
    flex-shrink: 0;
    order: -1; /* Move icon to the left of the input */
}
.search-btn:hover, .search-box:focus-within .search-btn {
    color: var(--spice-primary);
}
.search-input {
    flex: 1;
    min-width: 0; /* Prevents flex blowout */
    border: none;
    padding: 0;
    font-family: var(--font-body);
    font-size: 0.95rem;
    outline: none;
    background: transparent;
    color: var(--spice-text);
    font-weight: 500;
}
.search-input::placeholder {
    color: #9C8F85;
    font-weight: 500;
}

/* Custom Dropdown */
.custom-dropdown {
    position: relative;
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 600;
}
.dropdown-selected {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 1.2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    cursor: pointer;
    user-select: none;
    color: var(--spice-text);
}
.dropdown-selected svg {
    transition: transform 0.2s;
    opacity: 0.5;
}
.dropdown-options {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    width: 100%;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s;
    overflow: hidden;
}
.custom-dropdown.open .dropdown-options {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.custom-dropdown.open .dropdown-selected svg {
    transform: rotate(180deg);
}
.dropdown-option {
    padding: 0.75rem 1.2rem;
    cursor: pointer;
    transition: all 0.2s;
    color: #5C4B41;
}
.dropdown-option:hover { 
    background: rgba(228, 93, 62, 0.05);
    color: var(--spice-primary);
}
.dropdown-option.active {
    background: var(--spice-primary);
    color: white;
}

/* Price Range */
.price-range {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.price-input {
    width: 100%;
    padding: 0.8rem;
    border: none;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    font-family: var(--font-body);
    font-size: 0.95rem;
    outline: none;
    font-weight: 600;
}
.price-sep { font-weight: bold; color: var(--spice-text); opacity: 0.5; }
.price-btn {
    padding: 0.8rem 1.2rem;
    background: var(--spice-primary);
    color: white;
    border: none;
    border-radius: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.price-btn:hover {
    background: #c94b2f;
}

/* Checkboxes */
.filter-checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    cursor: pointer;
    font-weight: 500;
    font-size: 1rem;
    position: relative;
    user-select: none;
    color: #5C4B41;
}
.filter-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}
.checkmark {
    height: 20px;
    width: 20px;
    background-color: white;
    border: 2px solid var(--spice-primary);
    border-radius: 20px;
    margin-right: 12px;
    position: relative;
    transition: background 0.2s;
}
.filter-checkbox:hover input ~ .checkmark {
    background-color: rgba(228, 93, 62, 0.1);
}
.filter-checkbox input:checked ~ .checkmark {
    background-color: var(--spice-primary);
}
.filter-checkbox input:checked ~ .checkmark:after {
    content: "";
    position: absolute;
    display: block;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Filter List */
.filter-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.filter-list li {
    margin-bottom: 0.75rem;
}
.filter-list a {
    text-decoration: none;
    color: #5C4B41;
    font-size: 1.05rem;
    font-weight: 500;
    transition: color 0.2s;
    display: flex;
    align-items: center;
}
.filter-list a::before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    background: transparent;
    border: 2px solid var(--spice-primary);
    border-radius: 20px;
    margin-right: 12px;
    transition: background 0.2s;
}
.filter-list a:hover { color: var(--spice-primary); }
.filter-list a.active { color: var(--spice-primary); font-weight: 700; }
.filter-list a.active::before { background: var(--spice-primary); }

/* Grid & Cards */
.shop-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2.5rem;
    align-items: start;
}

.product-card {
    background: white;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    height: 100%; /* Force uniform height */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    isolation: isolate;
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

/* Corner Ribbon Badge on Top-Left */
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
    z-index: 5;
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

.discount-badge {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    background: var(--spice-secondary);
    color: var(--spice-bg-dark);
    font-weight: 800;
    font-size: 0.82rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(255, 179, 0, 0.3);
    z-index: 4;
    letter-spacing: 0.5px;
}

.product-img-wrapper {
    position: relative;
    display: block;
    padding-top: 100%;
    overflow: hidden;
    background: transparent;
}
.product-img-wrapper img {
    position: absolute;
    top: 10%;
    left: 10%;
    width: 80%;
    height: 80%;
    object-fit: contain;
    transition: transform 0.4s ease;
}
.product-card:hover .product-img-wrapper img {
    transform: scale(1.08);
}

.product-details {
    padding: 1.25rem 1.5rem 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Allow details to fill remaining space */
}
.product-vendor {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9C8F85;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.product-title {
    font-family: var(--font-body);
    font-size: 18px;
    color: var(--spice-bg-dark);
    text-decoration: none;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    font-weight: 600;
    transition: color 0.2s;
    flex-grow: 1; /* Push content below it down */
}
.product-title:hover {
    color: var(--spice-primary);
}
.product-price {
    font-family: var(--font-body);
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 0.5rem;
    color: var(--spice-bg-dark);
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}
.price-compare {
    text-decoration: line-through;
    color: #9C8F85;
    font-size: 15px;
    font-weight: 400;
}
/* Product Stock Clean Badge */
.product-stock {
    margin: 0.25rem 0 0.75rem;
}
.product-stock .stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.85rem;
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

.add-to-cart-btn {
    margin-top: auto; /* Always align button to the bottom */
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
.add-to-cart-btn:hover {
    background: var(--spice-primary);
}
.add-to-cart-btn .btn-icon {
    width: 18px;
    height: 18px;
    stroke-width: 2px;
}

/* Pagination */
.shop-pagination-wrapper {
    grid-column: 2 / 3;
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}
.shop-pagination {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.shop-pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: white;
    color: var(--spice-bg-dark);
    font-weight: 700;
    text-decoration: none;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.2s;
    border: 2px solid transparent;
}
.shop-pagination .page-link:hover:not(.disabled) {
    border-color: var(--spice-primary);
    color: var(--spice-primary);
    transform: translateY(-2px);
}
.shop-pagination .page-link.active {
    background: var(--spice-primary);
    color: white;
    box-shadow: 0 8px 20px rgba(228, 93, 62, 0.3);
}
.shop-pagination .page-link.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    box-shadow: none;
}

@media (max-width: 1024px) {
    .shop-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .shop-header h1 {
        font-size: clamp(34px, 7vw, 42px) !important;
    }
    .shop-container { grid-template-columns: 1fr; padding: 0 1.5rem; }
    .shop-filters { position: relative; top: 0; margin-bottom: 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
    .filter-group { margin-bottom: 0; }
    .filter-list { display: flex; flex-wrap: wrap; gap: 1rem; }
    .filter-list li { margin-bottom: 0; }
}
@media (max-width: 480px) {
    .shop-filters { grid-template-columns: 1fr; gap: 1.5rem; }
    .shop-grid { grid-template-columns: 1fr; }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Dropdown toggle logic
        const dropdown = document.getElementById('sortDropdown');
        if (dropdown) {
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelectorAll('.dropdown-option');
            
            selected.addEventListener('click', () => {
                dropdown.classList.toggle('open');
            });
            
            options.forEach(opt => {
                opt.addEventListener('click', () => {
                    const val = opt.getAttribute('data-value');
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', val);
                    window.location.href = url.toString();
                });
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        }
    });
</script>
@endsection

