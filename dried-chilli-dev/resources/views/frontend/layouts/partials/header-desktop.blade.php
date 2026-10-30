<!-- Desktop Header Navigation (Screens > 900px) -->
<header class="spice-header desktop-header">
    <div class="header-container">
        <!-- Left Section: Desktop Navigation Links -->
        <div class="header-left">
            <nav class="desktop-nav" aria-label="Desktop Navigation Left">
                <a href="/sale" class="nav-link sale-link {{ request()->is('sale') ? 'active' : '' }}">SALE</a>
                <a href="/shop" class="nav-link {{ request()->is('shop') ? 'active' : '' }}">SHOP</a>
                <div class="spice-dropdown-wrapper">
                    <a href="/about-us" class="nav-link {{ request()->is('about-us') || request()->routeIs('page.privacy') || request()->routeIs('page.terms') || request()->routeIs('page.faq') || request()->routeIs('page.shipping') ? 'active' : '' }}">
                        ABOUT US
                        <svg class="header-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    <div class="spice-dropdown">
                        <a href="{{ route('page.privacy') }}">Privacy Policy</a>
                        <a href="{{ route('page.terms') }}">Term and Conditions</a>
                        <a href="{{ route('page.faq') }}">FAQ</a>
                        <a href="{{ route('page.shipping') }}">Shipping & Refunds</a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Center Section: Brand Logo -->
        <div class="header-center brand-logo-wrapper">
            <a class="brand-logo" href="{{ page_route('home') }}" aria-label="Dried Chili Home">
                <img src="{{ asset('images/logo_dried.png') }}" alt="Dried Chili Logo" class="logo-img">
            </a>
        </div>
        
        <!-- Right Section: Desktop Navigation & Cart -->
        <div class="header-right">
            <nav class="desktop-nav" aria-label="Desktop Navigation Right">
                <a href="{{ route('page.legacy') }}" class="nav-link {{ request()->routeIs('page.legacy') ? 'active' : '' }}">OUR LEGACY</a>
                <a href="{{ route('contact.page') }}" class="nav-link {{ request()->routeIs('contact.page') ? 'active' : '' }}">CONTACT</a>
            </nav>
            <div class="cart-wrapper" style="position: relative;">
                <a href="/cart" class="cart-btn {{ request()->is('cart') ? 'active' : '' }}" style="text-decoration: none;" aria-label="Cart">
                    <svg class="header-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <span class="cart-text">CART</span>
                    <span class="cart-count">0</span>
                </a>
                @include('frontend.layouts.partials.cart-drawer')
            </div>
        </div>
    </div>
</header>

<style>
    /* DESKTOP HEADER STYLES */
    @media (min-width: 901px) {
        .desktop-header {
            display: block !important;
            background: var(--spice-bg);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 0.8rem 0;
            width: 100%;
        }

        .desktop-header .header-container {
            max-width: 1430px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .desktop-header .header-left,
        .desktop-header .header-center,
        .desktop-header .header-right {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .desktop-header .header-left {
            justify-content: flex-start;
        }

        .desktop-header .header-center {
            justify-content: center;
        }

        .desktop-header .header-right {
            justify-content: flex-end;
            gap: clamp(1.5rem, 2.2vw, 2.5rem);
        }

        /* Fix chính: Dàn ngang hàng các menu items */
        .desktop-header .desktop-nav {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: clamp(1.25rem, 2vw, 2.25rem);
            margin: 0;
            padding: 0;
        }

        .desktop-header .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .desktop-header .logo-img {
            height: 65px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .desktop-header .brand-logo:hover .logo-img {
            transform: scale(1.05);
        }

        .desktop-header .nav-link {
            font-family: var(--font-body);
            font-size: 0.9rem;
            text-decoration: none;
            color: var(--spice-bg-dark);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 800;
            position: relative;
            padding: 0.35rem 0;
            transition: color 0.2s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .desktop-header .sale-link {
            color: var(--spice-primary);
        }

        .desktop-header .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--spice-primary);
            transition: width 0.3s ease;
        }

        .desktop-header .nav-link:hover::after,
        .desktop-header .nav-link.active::after {
            width: 100%;
        }

        .desktop-header .nav-link.active,
        .desktop-header .nav-link:hover {
            color: var(--spice-primary);
            text-decoration: none;
        }

        .desktop-header .cart-btn {
            background: none;
            border: none;
            color: var(--spice-bg-dark);
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 0.35rem 0;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-body);
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .desktop-header .cart-btn:hover {
            color: var(--spice-primary);
        }

        .desktop-header .cart-count {
            background-color: var(--spice-primary);
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .desktop-header .spice-dropdown-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .desktop-header .spice-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #FFFFFF;
            min-width: 200px;
            box-shadow: 0 10px 30px rgba(43, 29, 20, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(43, 29, 20, 0.05);
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1000;
        }

        .desktop-header .spice-dropdown::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: transparent;
        }

        .desktop-header .spice-dropdown-wrapper:hover .spice-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .desktop-header .spice-dropdown a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--spice-bg-dark);
            text-decoration: none;
            font-size: 0.9rem;
            font-family: var(--font-body);
            font-weight: 600;
            transition: all 0.2s ease;
            text-align: left;
        }

        .desktop-header .spice-dropdown a:hover {
            background-color: rgba(228, 93, 62, 0.06);
            color: var(--spice-primary);
            padding-left: 1.75rem;
        }
    }

    /* Ẩn Desktop Header hoàn toàn khi màn hình <= 900px */
    @media (max-width: 900px) {
        .desktop-header {
            display: none !important;
        }
    }
</style>
