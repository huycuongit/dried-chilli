@extends('frontend.layouts.master')
@section('meta')
    <title>Shop All | Dried Chili</title>
@endsection
@section('full-content')
@php
    $queryParams = request()->query();
    
    // In Stock toggle URL
    $inStockParams = $queryParams;
    if (request('in_stock')) {
        unset($inStockParams['in_stock']);
    } else {
        $inStockParams['in_stock'] = 1;
    }
    unset($inStockParams['page']);
    $inStockUrl = route('page.shop', $inStockParams);

    // Best Seller toggle URL
    $bestSellerParams = $queryParams;
    if (request('best_seller')) {
        unset($bestSellerParams['best_seller']);
    } else {
        $bestSellerParams['best_seller'] = 1;
    }
    unset($bestSellerParams['page']);
    $bestSellerUrl = route('page.shop', $bestSellerParams);

    // On Sale toggle URL
    $onSaleParams = $queryParams;
    if (request('on_sale')) {
        unset($onSaleParams['on_sale']);
    } else {
        $onSaleParams['on_sale'] = 1;
    }
    unset($onSaleParams['page']);
    $onSaleUrl = route('page.shop', $onSaleParams);

    // Active filters count
    $activeFilterCount = 0;
    if (request('in_stock')) $activeFilterCount++;
    if (request('best_seller')) $activeFilterCount++;
    if (request('on_sale')) $activeFilterCount++;
    if (request('min_price') || request('max_price')) $activeFilterCount++;
    if (request('sort') && request('sort') !== 'featured') $activeFilterCount++;

    $currentSort = $sort ?? 'featured';
    $sortLabels = [
        'featured' => 'Featured',
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'name_asc' => 'Name: A to Z',
        'name_desc' => 'Name: Z to A',
    ];
    $currentSortLabel = $sortLabels[$currentSort] ?? 'Featured';
@endphp
<main class="page-content shop-bg">
    <!-- Shop Header: Standardized Hero Banner -->
    <header class="about-hero-section shop-header">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span>ARTISANAL PANTRY · ALL NATURAL CRAFT</span>
            </div>
            
            <h1 class="about-hero-title">
                Every Fiery Flavor<br>
                <span class="highlight-gold">From Mild Heat To Wild Crunch</span>
            </h1>
            
            <p class="about-hero-desc">
                Explore our handcrafted small-batch pantry — sun-dried chillies, golden crispy garlic, and slow-simmered umami oils created to elevate your home table.
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Free Shipping</strong>
                        <span>Orders Over $50</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Small Batches</strong>
                        <span>Under 200 Jars</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>100% Artisan</strong>
                        <span>Freshness Verified</span>
                    </div>
                </div>
            </div>
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

        <!-- Mobile Filter Bar (Visible only on <= 768px) -->
        <div class="mobile-filter-bar">
            <!-- Search & Filter Trigger Row -->
            <div class="mobile-filter-top-row">
                <form class="mobile-search-form" action="{{ route('page.shop') }}" method="GET">
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    @if(request('in_stock')) <input type="hidden" name="in_stock" value="{{ request('in_stock') }}"> @endif
                    @if(request('best_seller')) <input type="hidden" name="best_seller" value="{{ request('best_seller') }}"> @endif
                    @if(request('on_sale')) <input type="hidden" name="on_sale" value="{{ request('on_sale') }}"> @endif
                    
                    <div class="mobile-search-input-wrap">
                        <svg class="mobile-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="mobile-search-input">
                        @if(request('search'))
                            @php
                                $clearSearch = $queryParams;
                                unset($clearSearch['search'], $clearSearch['page']);
                            @endphp
                            <a href="{{ route('page.shop', $clearSearch) }}" class="mobile-search-clear" aria-label="Clear search">✕</a>
                        @endif
                    </div>
                </form>
                
                <button type="button" class="mobile-filter-trigger {{ $activeFilterCount > 0 ? 'has-active' : '' }}" id="mobileFilterOpenBtn" aria-label="Open filter and sort drawer">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    <span>Filters</span>
                    @if($activeFilterCount > 0)
                        <span class="mobile-filter-badge">{{ $activeFilterCount }}</span>
                    @endif
                </button>
            </div>

            <!-- Horizontal Scrollable Quick Chips -->
            <div class="mobile-quick-chips">
                <button type="button" class="mobile-chip filter-drawer-chip {{ $activeFilterCount > 0 ? 'active' : '' }}" id="mobileChipOpenDrawer">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m3 16 4 4 4-4"/><path d="M7 20V4"/><path d="m21 8-4-4-4 4"/><path d="M17 4v16"/></svg>
                    <span>{{ $currentSortLabel }}</span>
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <a href="{{ $inStockUrl }}" class="mobile-chip {{ request('in_stock') ? 'active' : '' }}">
                    @if(request('in_stock'))
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    @endif
                    In Stock
                </a>

                <a href="{{ $bestSellerUrl }}" class="mobile-chip {{ request('best_seller') ? 'active' : '' }}">
                    @if(request('best_seller'))
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    @else
                        <span class="chip-emoji">🔥</span>
                    @endif
                    Best Sellers
                </a>

                <a href="{{ $onSaleUrl }}" class="mobile-chip {{ request('on_sale') ? 'active' : '' }}">
                    @if(request('on_sale'))
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    @else
                        <span class="chip-emoji">🏷️</span>
                    @endif
                    On Sale
                </a>

                @if(request('min_price') || request('max_price'))
                    @php
                        $clearPrice = $queryParams;
                        unset($clearPrice['min_price'], $clearPrice['max_price'], $clearPrice['page']);
                    @endphp
                    <a href="{{ route('page.shop', $clearPrice) }}" class="mobile-chip active-dismiss" title="Remove price filter">
                        ${{ request('min_price', 0) }} - ${{ request('max_price', 'Any') }}
                        <span class="chip-remove">✕</span>
                    </a>
                @endif

                @if($activeFilterCount > 0 || request('search'))
                    <a href="{{ route('page.shop') }}" class="mobile-chip clear-all-chip">
                        Reset All ✕
                    </a>
                @endif
            </div>
        </div>

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
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
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

    <!-- Mobile Filter Bottom Sheet Drawer (Visible only <= 768px when opened) -->
    <div id="mobileFilterDrawer" class="mobile-filter-drawer" aria-hidden="true">
        <div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop"></div>
        <div class="mobile-drawer-sheet">
            <div class="drawer-handle-bar">
                <span class="drawer-handle"></span>
            </div>
            
            <div class="drawer-header">
                <div class="drawer-title-box">
                    <h3 class="drawer-title">Filter & Sort</h3>
                    @if($activeFilterCount > 0)
                        <span class="drawer-badge-count">{{ $activeFilterCount }} active</span>
                    @endif
                </div>
                <div class="drawer-actions">
                    @if($activeFilterCount > 0 || request('search'))
                        <a href="{{ route('page.shop') }}" class="drawer-clear-text">Reset All</a>
                    @endif
                    <button type="button" class="drawer-close-btn" id="mobileDrawerCloseBtn" aria-label="Close drawer">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <form id="mobileDrawerFilterForm" action="{{ route('page.shop') }}" method="GET" class="drawer-body-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Sort By -->
                <div class="drawer-group">
                    <h4 class="drawer-group-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m3 16 4 4 4-4"/><path d="M7 20V4"/><path d="m21 8-4-4-4 4"/><path d="M17 4v16"/></svg>
                        Sort By
                    </h4>
                    <div class="drawer-sort-grid">
                        <label class="drawer-sort-pill {{ ($sort ?? 'featured') == 'featured' ? 'selected' : '' }}">
                            <input type="radio" name="sort" value="featured" {{ ($sort ?? 'featured') == 'featured' ? 'checked' : '' }}>
                            <span>Featured</span>
                        </label>
                        <label class="drawer-sort-pill {{ ($sort ?? '') == 'price_asc' ? 'selected' : '' }}">
                            <input type="radio" name="sort" value="price_asc" {{ ($sort ?? '') == 'price_asc' ? 'checked' : '' }}>
                            <span>Price: Low to High</span>
                        </label>
                        <label class="drawer-sort-pill {{ ($sort ?? '') == 'price_desc' ? 'selected' : '' }}">
                            <input type="radio" name="sort" value="price_desc" {{ ($sort ?? '') == 'price_desc' ? 'checked' : '' }}>
                            <span>Price: High to Low</span>
                        </label>
                        <label class="drawer-sort-pill {{ ($sort ?? '') == 'name_asc' ? 'selected' : '' }}">
                            <input type="radio" name="sort" value="name_asc" {{ ($sort ?? '') == 'name_asc' ? 'checked' : '' }}>
                            <span>Name: A to Z</span>
                        </label>
                        <label class="drawer-sort-pill {{ ($sort ?? '') == 'name_desc' ? 'selected' : '' }}">
                            <input type="radio" name="sort" value="name_desc" {{ ($sort ?? '') == 'name_desc' ? 'checked' : '' }}>
                            <span>Name: Z to A</span>
                        </label>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="drawer-group">
                    <h4 class="drawer-group-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Price Range
                    </h4>
                    <div class="drawer-price-row">
                        <div class="drawer-price-box">
                            <span class="price-unit">$</span>
                            <input type="number" name="min_price" id="drawerMinPrice" placeholder="Min" value="{{ request('min_price') }}" min="0" step="1" class="drawer-price-input">
                        </div>
                        <span class="price-dash">—</span>
                        <div class="drawer-price-box">
                            <span class="price-unit">$</span>
                            <input type="number" name="max_price" id="drawerMaxPrice" placeholder="Max" value="{{ request('max_price') }}" min="0" step="1" class="drawer-price-input">
                        </div>
                    </div>
                </div>

                <!-- Quick Filters -->
                <div class="drawer-group">
                    <h4 class="drawer-group-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Availability & Specials
                    </h4>
                    <div class="drawer-check-list">
                        <label class="drawer-check-item {{ request('in_stock') == '1' ? 'checked' : '' }}">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }}>
                            <span class="check-box-indicator"></span>
                            <div class="check-text-wrap">
                                <span class="check-title">In Stock Only</span>
                                <span class="check-desc">Ready to ship right away</span>
                            </div>
                        </label>
                        <label class="drawer-check-item {{ request('best_seller') == '1' ? 'checked' : '' }}">
                            <input type="checkbox" name="best_seller" value="1" {{ request('best_seller') == '1' ? 'checked' : '' }}>
                            <span class="check-box-indicator"></span>
                            <div class="check-text-wrap">
                                <span class="check-title">Best Sellers 🔥</span>
                                <span class="check-desc">Our most popular artisanal items</span>
                            </div>
                        </label>
                        <label class="drawer-check-item {{ request('on_sale') == '1' ? 'checked' : '' }}">
                            <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') == '1' ? 'checked' : '' }}>
                            <span class="check-box-indicator"></span>
                            <div class="check-text-wrap">
                                <span class="check-title">On Sale 🏷️</span>
                                <span class="check-desc">Discounted chili oils and flakes</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Sticky Footer -->
                <div class="drawer-footer">
                    <button type="button" class="drawer-reset-btn" id="drawerResetAllFields">Clear</button>
                    <button type="submit" class="drawer-apply-btn">
                        <span>Apply Filters</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<style>
.shop-bg { background: var(--spice-bg-alt); min-height: 100vh; padding-bottom: 6rem; }

.shop-header {
    background: #1F0701;
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

/* Desktop vs Mobile Display for Filters */
.mobile-filter-bar {
    display: none;
}
.mobile-filter-drawer {
    display: none;
}

@media (max-width: 1024px) {
    .shop-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .shop-container {
        display: flex;
        flex-direction: column;
        padding: 0 1rem 6rem 1rem;
        gap: 1.25rem;
        margin-top: 1.25rem;
    }
    /* Hide desktop filter sidebar on mobile */
    .shop-filters {
        display: none !important;
    }
    /* Show mobile filter bar on mobile */
    .mobile-filter-bar {
        display: flex !important;
        flex-direction: column;
        gap: 0.65rem;
        width: 100%;
        margin-bottom: 0.25rem;
    }
    .mobile-filter-top-row {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }
    .mobile-search-form {
        flex: 1;
        min-width: 0;
    }
    .mobile-search-input-wrap {
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 1.5px solid rgba(43, 29, 20, 0.1);
        border-radius: 9999px;
        padding: 0 12px;
        height: 44px;
        box-shadow: 0 2px 8px rgba(43, 29, 20, 0.04);
        transition: all 0.2s ease;
    }
    .mobile-search-input-wrap:focus-within {
        border-color: #E45D3E;
        box-shadow: 0 2px 12px rgba(228, 93, 62, 0.15);
    }
    .mobile-search-icon {
        color: #9C8F85;
        flex-shrink: 0;
        margin-right: 8px;
    }
    .mobile-search-input {
        border: none;
        background: transparent;
        outline: none;
        font-family: var(--font-body);
        font-size: 0.88rem;
        font-weight: 500;
        color: #2B1D14;
        width: 100%;
    }
    .mobile-search-input::placeholder {
        color: #9C8F85;
    }
    .mobile-search-clear {
        color: #9C8F85;
        font-size: 14px;
        padding: 4px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mobile-filter-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 44px;
        padding: 0 14px;
        border-radius: 9999px;
        background: #FFFFFF;
        border: 1.5px solid rgba(43, 29, 20, 0.12);
        color: #2B1D14;
        font-family: var(--font-body);
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(43, 29, 20, 0.04);
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .mobile-filter-trigger.has-active {
        background: #E45D3E;
        border-color: #E45D3E;
        color: #FFFFFF;
    }
    .mobile-filter-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #D3381C;
        color: #FFFFFF;
        font-size: 0.72rem;
        font-weight: 800;
        width: 18px;
        height: 18px;
        border-radius: 50%;
    }
    .mobile-filter-trigger.has-active .mobile-filter-badge {
        background: #FFFFFF;
        color: #D3381C;
    }
    .mobile-quick-chips {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .mobile-quick-chips::-webkit-scrollbar {
        display: none;
    }
    .mobile-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 13px;
        border-radius: 9999px;
        background: #FFFFFF;
        border: 1.5px solid rgba(43, 29, 20, 0.1);
        color: #5C4B41;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 1px 4px rgba(43, 29, 20, 0.03);
        transition: all 0.2s ease;
        cursor: pointer;
        font-family: var(--font-body);
    }
    .mobile-chip.active {
        background: #E45D3E;
        border-color: #E45D3E;
        color: #FFFFFF;
    }
    .mobile-chip.active svg {
        stroke: #FFFFFF;
    }
    .mobile-chip.active-dismiss {
        background: #FFF3EE;
        border-color: #E45D3E;
        color: #D3381C;
    }
    .mobile-chip .chip-remove {
        font-size: 11px;
        margin-left: 2px;
        opacity: 0.8;
    }
    .mobile-chip.clear-all-chip {
        background: transparent;
        border-color: transparent;
        color: #9C8F85;
        text-decoration: underline;
        box-shadow: none;
        padding: 6px 6px;
    }
    .chip-emoji {
        font-size: 0.85rem;
        line-height: 1;
    }

    /* Mobile Filter Bottom Sheet Drawer */
    .mobile-filter-drawer {
        display: block !important;
        position: fixed;
        inset: 0;
        z-index: 9999;
        visibility: hidden;
        pointer-events: none;
        transition: visibility 0.3s ease;
    }
    .mobile-filter-drawer.open {
        visibility: visible;
        pointer-events: auto;
    }
    .mobile-drawer-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(18, 11, 7, 0.6);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .mobile-filter-drawer.open .mobile-drawer-backdrop {
        opacity: 1;
    }
    .mobile-drawer-sheet {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        max-height: 85vh;
        background: #FFFFFF;
        border-top-left-radius: 24px;
        border-top-right-radius: 24px;
        box-shadow: 0 -8px 32px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }
    .mobile-filter-drawer.open .mobile-drawer-sheet {
        transform: translateY(0);
    }
    .drawer-handle-bar {
        display: flex;
        justify-content: center;
        padding: 10px 0 4px;
    }
    .drawer-handle {
        width: 40px;
        height: 4px;
        background: #E0D7D0;
        border-radius: 4px;
    }
    .drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1.25rem 0.75rem 1.25rem;
        border-bottom: 1px solid rgba(43, 29, 20, 0.08);
    }
    .drawer-title-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .drawer-title {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        font-weight: 800;
        color: #2B1D14;
        margin: 0;
    }
    .drawer-badge-count {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        background: #FFF0EB;
        color: #D3381C;
    }
    .drawer-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .drawer-clear-text {
        color: #E45D3E;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
    }
    .drawer-close-btn {
        background: #F4EFEB;
        border: none;
        color: #2B1D14;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .drawer-body-form {
        display: flex;
        flex-direction: column;
        flex: 1;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        padding: 1.25rem 1.25rem 2rem 1.25rem;
        gap: 1.5rem;
    }
    .drawer-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .drawer-group-title {
        font-family: var(--font-heading);
        font-size: 0.95rem;
        font-weight: 800;
        color: #2B1D14;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .drawer-group-title svg {
        color: #E45D3E;
    }
    .drawer-sort-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .drawer-sort-pill {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 8px;
        border-radius: 12px;
        background: #FAF7F4;
        border: 1.5px solid rgba(43, 29, 20, 0.08);
        font-size: 0.8rem;
        font-weight: 600;
        color: #5C4B41;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .drawer-sort-pill input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .drawer-sort-pill.selected {
        background: #FFF3EE;
        border-color: #E45D3E;
        color: #D3381C;
        font-weight: 700;
    }
    .drawer-price-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .drawer-price-box {
        flex: 1;
        display: flex;
        align-items: center;
        background: #FAF7F4;
        border: 1.5px solid rgba(43, 29, 20, 0.1);
        border-radius: 12px;
        padding: 0 12px;
        height: 44px;
    }
    .drawer-price-box:focus-within {
        border-color: #E45D3E;
        background: #FFFFFF;
    }
    .price-unit {
        font-weight: 700;
        color: #9C8F85;
        margin-right: 6px;
    }
    .drawer-price-input {
        width: 100%;
        border: none;
        background: transparent;
        outline: none;
        font-family: var(--font-body);
        font-size: 0.95rem;
        font-weight: 700;
        color: #2B1D14;
    }
    .price-dash {
        font-weight: bold;
        color: #9C8F85;
    }
    .drawer-check-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .drawer-check-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #FAF7F4;
        border: 1.5px solid rgba(43, 29, 20, 0.08);
        border-radius: 14px;
        padding: 10px 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .drawer-check-item input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .drawer-check-item.checked {
        background: #FFF3EE;
        border-color: #E45D3E;
    }
    .check-box-indicator {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #C4B5AA;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .drawer-check-item input:checked + .check-box-indicator,
    .drawer-check-item.checked .check-box-indicator {
        background: #E45D3E;
        border-color: #E45D3E;
    }
    .drawer-check-item input:checked + .check-box-indicator::after,
    .drawer-check-item.checked .check-box-indicator::after {
        content: "";
        width: 5px;
        height: 10px;
        border: solid #FFFFFF;
        border-width: 0 2.5px 2.5px 0;
        transform: rotate(45deg);
        margin-bottom: 2px;
    }
    .check-text-wrap {
        display: flex;
        flex-direction: column;
    }
    .check-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #2B1D14;
    }
    .check-desc {
        font-size: 0.74rem;
        color: #7A695E;
    }
    .drawer-footer {
        position: sticky;
        bottom: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 1rem;
        background: #FFFFFF;
        border-top: 1px solid rgba(43, 29, 20, 0.08);
        margin-top: auto;
    }
    .drawer-reset-btn {
        padding: 0.75rem 1.2rem;
        border-radius: 14px;
        background: #FAF7F4;
        border: 1.5px solid rgba(43, 29, 20, 0.1);
        color: #5C4B41;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
    }
    .drawer-apply-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0.85rem 1.5rem;
        border-radius: 14px;
        background: linear-gradient(135deg, #E45D3E 0%, #D3381C 100%);
        border: none;
        color: #FFFFFF;
        font-size: 0.95rem;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(211, 56, 28, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .drawer-apply-btn:active {
        transform: scale(0.98);
    }

    .shop-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
    .product-card {
        border-radius: 16px !important;
    }
    .product-details {
        padding: 0.75rem 0.6rem !important;
    }
    .product-title {
        font-size: 13.5px !important;
        height: 35px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0.25rem;
    }
    .product-price {
        font-size: 15px !important;
        margin-bottom: 0.4rem;
        gap: 4px;
    }
    .price-compare {
        font-size: 12px !important;
    }
    .product-stock {
        margin: 0.1rem 0 0.4rem;
    }
    .product-stock .stock-badge {
        font-size: 0.72rem;
    }
    .add-to-cart-btn {
        padding: 0.55rem 0.5rem;
        font-size: 0.75rem;
    }
    .add-to-cart-btn .btn-icon {
        width: 15px;
        height: 15px;
    }
    .shop-pagination-wrapper {
        grid-column: 1 / -1;
        margin-top: 1.5rem;
    }
}
@media (max-width: 480px) {
    .shop-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
    }
    .product-badge {
        font-size: 0.6rem !important;
        top: 8px !important;
        left: -32px !important;
        width: 110px !important;
    }
    .discount-badge {
        top: 0.5rem !important;
        right: 0.5rem !important;
        font-size: 0.68rem !important;
        padding: 0.2rem 0.5rem !important;
    }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Dropdown toggle logic for desktop
        const dropdown = document.getElementById('sortDropdown');
        if (dropdown) {
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelectorAll('.dropdown-option');
            
            selected?.addEventListener('click', () => {
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

        // Mobile Filter Bottom Sheet Drawer logic
        const drawer = document.getElementById('mobileFilterDrawer');
        const openBtn = document.getElementById('mobileFilterOpenBtn');
        const chipOpenBtn = document.getElementById('mobileChipOpenDrawer');
        const closeBtn = document.getElementById('mobileDrawerCloseBtn');
        const backdrop = document.getElementById('mobileDrawerBackdrop');
        const resetFieldsBtn = document.getElementById('drawerResetAllFields');

        function openMobileDrawer() {
            if (!drawer) return;
            drawer.classList.add('open');
            drawer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileDrawer() {
            if (!drawer) return;
            drawer.classList.remove('open');
            drawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openMobileDrawer);
        chipOpenBtn?.addEventListener('click', openMobileDrawer);
        closeBtn?.addEventListener('click', closeMobileDrawer);
        backdrop?.addEventListener('click', closeMobileDrawer);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
                closeMobileDrawer();
            }
        });

        // Sort Pills Selection
        const sortPills = document.querySelectorAll('.drawer-sort-pill');
        sortPills.forEach(pill => {
            pill.addEventListener('click', () => {
                sortPills.forEach(p => p.classList.remove('selected'));
                pill.classList.add('selected');
                const radio = pill.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            });
        });

        // Checkbox cards styling toggle
        const checkItems = document.querySelectorAll('.drawer-check-item');
        checkItems.forEach(item => {
            const input = item.querySelector('input[type="checkbox"]');
            input?.addEventListener('change', () => {
                item.classList.toggle('checked', input.checked);
            });
        });

        // Drawer Reset Fields Button
        resetFieldsBtn?.addEventListener('click', () => {
            // Reset sort to featured
            sortPills.forEach(p => {
                const radio = p.querySelector('input[type="radio"]');
                if (radio && radio.value === 'featured') {
                    radio.checked = true;
                    p.classList.add('selected');
                } else {
                    p.classList.remove('selected');
                }
            });

            // Clear price inputs
            const minPrice = document.getElementById('drawerMinPrice');
            const maxPrice = document.getElementById('drawerMaxPrice');
            if (minPrice) minPrice.value = '';
            if (maxPrice) maxPrice.value = '';

            // Uncheck all checkboxes
            checkItems.forEach(item => {
                const input = item.querySelector('input[type="checkbox"]');
                if (input) input.checked = false;
                item.classList.remove('checked');
            });
        });
    });
</script>
@endsection

