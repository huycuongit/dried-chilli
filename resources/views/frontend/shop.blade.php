@extends('frontend.layouts.master')
@section('meta')
    <title>Shop All | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content shop-bg">
    <!-- Shop Header -->
    <header class="shop-header">
        <h1 class="reveal">SHOP ALL</h1>
        <p class="reveal">Every fiery flavor, one place. From mild to wild.</p>
    </header>

    <div class="shop-container reveal">
        <!-- Filters Sidebar -->
        <aside class="shop-filters">
            <!-- Search -->
            <div class="filter-group">
                <div class="search-box">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Search products..." class="search-input">
                </div>
            </div>

            <!-- Sort By -->
            <div class="filter-group">
                <h3>Sort By</h3>
                <div class="custom-dropdown" id="sortDropdown">
                    <div class="dropdown-selected">
                        <span>Featured</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div class="dropdown-options">
                        <div class="dropdown-option active">Featured</div>
                        <div class="dropdown-option">Price: Low to High</div>
                        <div class="dropdown-option">Price: High to Low</div>
                        <div class="dropdown-option">Best Sellers</div>
                        <div class="dropdown-option">Newest Arrivals</div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="filter-group">
                <h3>Category</h3>
                <ul class="filter-list">
                    <li><a href="#" class="active">All Products</a></li>
                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $category)
                            <li><a href="#">{{ $category->name }}</a></li>
                        @endforeach
                    @else
                        <li><a href="#">Mild Heat</a></li>
                        <li><a href="#">Extreme Heat</a></li>
                        <li><a href="#">Bundles & Gifts</a></li>
                    @endif
                </ul>
            </div>

            <!-- Price Range -->
            <div class="filter-group">
                <h3>Price Range</h3>
                <div class="price-range">
                    <input type="number" placeholder="Min" class="price-input">
                    <span class="price-sep">-</span>
                    <input type="number" placeholder="Max" class="price-input">
                    <button class="price-btn">Go</button>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="filter-group">
                <h3>Quick Filters</h3>
                <label class="filter-checkbox">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                    In Stock
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    Best Sellers
                </label>
                <label class="filter-checkbox">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    On Sale
                </label>
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="shop-grid">
            @forelse($products as $product)
                <div class="product-card">
                    @if($product->sale_price)
                        <div class="product-badge sale">SALE</div>
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
                        <button class="add-to-cart-btn" data-product-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->sale_price ?? $product->price }}">Add to Cart</button>
                    </div>
                </div>
            @empty
                <p>No products available at the moment.</p>
            @endforelse
        </section>
    </div>
</main>

<style>
.shop-bg { background: #FFF9F0; min-height: 100vh; padding-bottom: 4rem; }

.shop-header {
    background: var(--spice-primary);
    color: white;
    padding: 6rem 1rem 4rem 1rem;
    text-align: center;
    border-bottom: 4px solid var(--spice-text);
}
.shop-header h1 {
    font-family: var(--font-heading);
    font-size: clamp(3rem, 8vw, 6rem);
    margin: 0;
    text-transform: uppercase;
    line-height: 1;
    text-shadow: 4px 4px 0px var(--spice-text);
}
.shop-header p {
    font-size: 1.25rem;
    font-weight: 700;
    margin-top: 1rem;
}

.shop-container {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 3rem;
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
    font-size: 1.5rem;
    margin-top: 0;
    margin-bottom: 1.25rem;
    border-bottom: 2px solid var(--spice-text);
    padding-bottom: 0.5rem;
}

/* Search Box */
.search-box {
    display: flex;
    align-items: center;
    border: 2px solid var(--spice-text);
    border-radius: 8px;
    overflow: hidden;
    background: white;
    box-shadow: 4px 4px 0px var(--spice-text);
    padding: 0 0.75rem;
}
.search-icon {
    color: var(--spice-text);
    opacity: 0.5;
}
.search-input {
    flex: 1;
    border: none;
    padding: 0.75rem 0.5rem;
    font-family: var(--font-body);
    font-size: 1rem;
    outline: none;
    background: transparent;
}

/* Custom Dropdown */
.custom-dropdown {
    position: relative;
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 700;
}
.dropdown-selected {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    border: 2px solid var(--spice-text);
    border-radius: 8px;
    background: white;
    box-shadow: 4px 4px 0px var(--spice-text);
    cursor: pointer;
    user-select: none;
    transition: transform 0.1s, box-shadow 0.1s;
}
.dropdown-selected:active {
    transform: translate(2px, 2px);
    box-shadow: 2px 2px 0px var(--spice-text);
}
.dropdown-selected svg {
    transition: transform 0.2s;
}
.dropdown-options {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    width: 100%;
    background: white;
    border: 2px solid var(--spice-text);
    border-radius: 8px;
    box-shadow: 4px 4px 0px var(--spice-text);
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s;
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
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background 0.1s;
    border-bottom: 1px solid #eee;
}
.dropdown-option:last-child { border-bottom: none; }
.dropdown-option:hover { background: #f1e9df; }
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
    padding: 0.6rem;
    border: 2px solid var(--spice-text);
    border-radius: 6px;
    font-family: var(--font-body);
    font-size: 1rem;
    outline: none;
    font-weight: 600;
}
.price-sep { font-weight: bold; }
.price-btn {
    padding: 0.6rem 1rem;
    background: var(--spice-primary);
    color: white;
    border: 2px solid var(--spice-text);
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 3px 3px 0px var(--spice-text);
    transition: transform 0.1s;
}
.price-btn:active {
    transform: translate(2px, 2px);
    box-shadow: 1px 1px 0px var(--spice-text);
}

/* Checkboxes */
.filter-checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    cursor: pointer;
    font-weight: 600;
    font-size: 1.1rem;
    position: relative;
    user-select: none;
}
.filter-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}
.checkmark {
    height: 22px;
    width: 22px;
    background-color: white;
    border: 2px solid var(--spice-text);
    border-radius: 4px;
    margin-right: 12px;
    position: relative;
    box-shadow: 2px 2px 0px var(--spice-text);
    transition: background 0.1s;
}
.filter-checkbox:hover input ~ .checkmark {
    background-color: #f1e9df;
}
.filter-checkbox input:checked ~ .checkmark {
    background-color: var(--spice-primary);
}
.filter-checkbox input:checked ~ .checkmark:after {
    content: "";
    position: absolute;
    display: block;
    left: 6px;
    top: 2px;
    width: 4px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
}
.filter-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.filter-list li {
    margin-bottom: 1rem;
}
.filter-list a {
    text-decoration: none;
    color: var(--spice-text);
    font-size: 1.1rem;
    font-weight: 600;
    transition: color 0.2s;
    display: flex;
    align-items: center;
}
.filter-list a::before {
    content: '';
    display: inline-block;
    width: 12px;
    height: 12px;
    border: 2px solid var(--spice-text);
    border-radius: 50%;
    margin-right: 10px;
    transition: background 0.2s;
}
.filter-list a:hover { color: var(--spice-primary); }
.filter-list a.active::before { background: var(--spice-primary); }

.shop-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2.5rem;
}

/* Product Card - YumYum / Graza Style */
.product-card {
    background: white;
    border: 3px solid var(--spice-text);
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    box-shadow: 6px 6px 0px var(--spice-text);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
    transform: translate(2px, 2px);
    box-shadow: 4px 4px 0px var(--spice-text);
}

.product-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.25rem 0.75rem;
    color: white;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    z-index: 2;
    border: 2px solid var(--spice-text);
    border-radius: 20px;
}
.product-badge.sale { background-color: var(--spice-accent); }
.product-badge.best-seller { background-color: var(--spice-secondary); color: var(--spice-text); }

.product-img-wrapper {
    position: relative;
    display: block;
    padding-top: 100%;
    overflow: hidden;
    background: var(--spice-bg);
    border-bottom: 3px solid var(--spice-text);
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
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.product-vendor {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.7;
    font-weight: 700;
    margin-bottom: 0.25rem;
}
.product-title {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    color: var(--spice-text);
    text-decoration: none;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}
.product-price {
    font-weight: 800;
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
}
.price-compare {
    text-decoration: line-through;
    opacity: 0.5;
    margin-left: 0.5rem;
    font-size: 1rem;
}

.add-to-cart-btn {
    margin-top: auto;
    width: 100%;
    padding: 0.75rem;
    background: var(--spice-secondary);
    border: 2px solid var(--spice-text);
    color: var(--spice-text);
    font-family: var(--font-body);
    font-weight: 800;
    font-size: 1rem;
    text-transform: uppercase;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 3px 3px 0px var(--spice-text);
    transition: all 0.1s;
}
.add-to-cart-btn:hover {
    background: #f7b44d;
}
.add-to-cart-btn:active {
    transform: translate(3px, 3px);
    box-shadow: 0px 0px 0px var(--spice-text);
}

@media (max-width: 1024px) {
    .shop-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .shop-container { grid-template-columns: 1fr; padding: 0 1rem; }
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
                    selected.querySelector('span').textContent = opt.textContent;
                    options.forEach(o => o.classList.remove('active'));
                    opt.classList.add('active');
                    dropdown.classList.remove('open');
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

