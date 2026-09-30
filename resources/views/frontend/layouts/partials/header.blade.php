<header class="spice-header">
    <div class="header-container">
        <!-- Left Logo (Home) -->
        <div class="header-left brand-logo-wrapper">
            <a class="brand-logo" href="{{ page_route('home') }}">
                <img src="{{ asset('images/jojo_logo.png') }}" alt="Dried Chili Logo" class="logo-img">
            </a>
        </div>
        
        <!-- Center Navigation -->
        <div class="header-nav">
            <a href="/sale" class="nav-link sale-link {{ request()->is('sale') ? 'active' : '' }}">SALE</a>
            <a href="/about-us" class="nav-link {{ request()->is('about-us') ? 'active' : '' }}">ABOUT US</a>
            <a href="/shop" class="nav-link {{ request()->is('shop') ? 'active' : '' }}">SHOP</a>
            <a href="{{ route('page.legacy') }}" class="nav-link {{ request()->routeIs('page.legacy') ? 'active' : '' }}">OUR LEGACY</a>
        </div>
        
        <!-- Right Navigation & Cart -->
        <div class="header-right">
            <a href="/cart" class="cart-btn {{ request()->is('cart') ? 'active' : '' }}" style="text-decoration: none;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="cart-text">CART</span>
                <span class="cart-count">0</span>
            </a>
        </div>
    </div>
</header>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700;800&display=swap');

    /* Native View Transitions API */
    @view-transition { navigation: auto; }
    
    ::view-transition-old(root) {
        animation: 0.3s cubic-bezier(0.4, 0, 0.2, 1) both fade-out-up;
    }
    ::view-transition-new(root) {
        animation: 0.4s cubic-bezier(0.4, 0, 0.2, 1) both fade-in-up;
    }
    
    @keyframes fade-out-up {
        to { opacity: 0; transform: translateY(-15px); }
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Fallback Page Transition for unsupported browsers */
    .page-transition-enter {
        opacity: 0;
        animation: fallbackFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    .page-transition-leave {
        opacity: 1;
        animation: fallbackFadeOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    @keyframes fallbackFadeIn { to { opacity: 1; } }
    @keyframes fallbackFadeOut { to { opacity: 0; } }

    :root {
        --spice-primary: #C1440E;
        --spice-secondary: #E8A33D;
        --spice-accent: #A8320A;
        --spice-bg: #FAF3E8;
        --spice-bg-alt: #EDE0D0;
        --spice-text: #2B1D14;
        
        --font-heading: 'Outfit', sans-serif;
        --font-body: 'Outfit', sans-serif;
    }

    body {
        margin: 0;
        font-family: var(--font-body);
        background-color: var(--spice-bg);
        color: var(--spice-text);
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
        width: 100%;
        box-sizing: border-box;
    }
    
    main {
        display: flow-root;
    }
    
    *, *::before, *::after {
        box-sizing: inherit;
    }

    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }
    
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .spice-header {
        background-color: var(--spice-bg);
        border-bottom: 2px solid var(--spice-text); /* Warby Parker crisp grid style */
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0.75rem 0;
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left, .header-nav, .header-right {
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }
    .header-left, .header-right {
        flex: 1;
    }
    .header-nav {
        flex: auto;
        gap: 3.5rem;
    }
    .header-nav {
        justify-content: center;
    }
    .header-left {
        justify-content: flex-start;
    }
    
    .header-right {
        justify-content: flex-end;
    }

    .brand-logo {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-img {
        height: 70px;
        width: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .brand-logo:hover .logo-img {
        transform: scale(1.05);
    }

    .nav-link {
        font-family: var(--font-body);
        font-size: 0.9rem;
        text-decoration: none;
        color: var(--spice-text);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-weight: 700;
        position: relative;
        transition: color 0.2s ease;
    }

    .sale-link {
        color: var(--spice-primary);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--spice-text);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after, .nav-link.active::after {
        width: 100%;
    }

    .nav-link.active {
        color: var(--spice-primary);
    }

    .cart-btn {
        background: none;
        border: none;
        color: var(--spice-text);
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--font-body);
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .cart-btn:hover {
        color: var(--spice-primary);
    }

    .cart-count {
        background-color: var(--spice-primary);
        color: white;
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
    }

    @media (max-width: 900px) {
        .header-nav { display: none; }
        .logo-img { height: 50px; }
    }
</style>
