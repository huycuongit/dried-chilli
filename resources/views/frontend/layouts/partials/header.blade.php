<header class="spice-header">
    <div class="header-container">
        <!-- Left Navigation -->
        <div class="header-left header-nav">
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
        </div>
        
        <!-- Center Logo -->
        <div class="header-center brand-logo-wrapper">
            <a class="brand-logo" href="{{ page_route('home') }}">
                <img src="{{ asset('images/logo_dried.png') }}" alt="Dried Chili Logo" class="logo-img">
            </a>
        </div>
        
        <!-- Right Navigation & Cart -->
        <div class="header-right header-nav">
            <a href="{{ route('page.legacy') }}" class="nav-link {{ request()->routeIs('page.legacy') ? 'active' : '' }}">OUR LEGACY</a>
            <a href="{{ route('contact.page') }}" class="nav-link {{ request()->routeIs('contact.page') ? 'active' : '' }}">CONTACT</a>
            <div class="cart-wrapper" style="position: relative;">
                <a href="/cart" class="cart-btn {{ request()->is('cart') ? 'active' : '' }}" style="text-decoration: none;">
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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap');

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
        /* --- QUY TẮC 60-30-10 (FIERY SPICY THEME) --- */
        
        /* 60%: MÀU NỀN & CHỮ (Base & Text) */
        --spice-bg: #FDF9F1; /* Trắng ngà ánh vàng (Warm Cream) */
        --spice-bg-alt: #F0E6DD; /* Be đậm ấm cúng (Chai Latte Beige) cho trang phụ */
        --spice-bg-dark: #2A0800; /* Nâu Đỏ Rực Sâu (Hero/Header) */
        --spice-bg-bundle: #3A1B14; /* Nâu Ca-cao Đậm (Dark Cocoa) - Hợp tone ấm thay vì xanh */
        --spice-text: #28120B; /* Nâu than ấm cho text */
        
        /* 30%: MÀU PHỤ (Secondary) */
        --spice-text-light: #F4DFD4; /* Cam sữa nhạt cho chữ trên nền tối */
        --spice-secondary: #FFB300; /* Vàng Cà-ri (Curry Gold) - Thêm độ nóng */
        
        /* 10%: MÀU NHẤN CHÍNH (CTA / Accent) - Màu Sếp chọn */
        --spice-primary: #E45D3E; /* Cam San Hô rực rỡ (Coral Red) - Rất cay nóng */
        --spice-accent: #C73B1B; /* Đỏ Ớt Đậm (Hover state) */
        
        /* BỘ MÀU HỖ TRỢ MỞ RỘNG (EXTENDED PALETTE TỪ STUDIO & LIFESTYLE) */
        --spice-fire: #C4141E;       /* Đỏ ớt tươi studio - High Heat & Flash Sale */
        --spice-tangerine: #FF7A1A;  /* Cam vỏ ớt bão hòa - Vibe trẻ trung, tươi mới */
        --spice-honey: #E59528;      /* Vàng mật ong hổ phách - Artisan & Sốt sánh */
        --spice-herb: #4E7837;       /* Xanh thảo mộc - Organic & Thành phần tươi */
        --spice-mint: #7FD2BD;       /* Xanh mint tương phản - Complementary Pop */
        --spice-steel: #B5BAC2;      /* Bạc kim loại bếp ăn - Subtle Borders & Dividers */
        
        /* CHUẨN HÓA BORDER-RADIUS TOÀN BỘ WEBSITE = 20PX */
        --spice-radius: 20px;
        
        --font-heading: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* GLOBAL RULE: TẤT CẢ PHẦN TỬ CÓ BORDER-RADIUS ĐỀU ĐỒNG BỘ 20PX */
    button:not(.btn-circle):not(.pin-marker):not(.cart-btn):not([class*="carousel"]):not(.slick-arrow):not(.swiper-button),
    .btn:not(.btn-circle),
    .btn-primary,
    .btn-outline,
    .btn-ghost,
    .btn-open-map,
    .submit-btn,
    input:not([type="checkbox"]):not([type="radio"]):not([type="color"]),
    select,
    textarea,
    .spice-form input,
    .spice-form select,
    .spice-form textarea,
    .card:not(.card-circle),
    .product-card,
    .feed-card,
    .contact-item,
    .contact-form-wrapper,
    .spice-dropdown,
    .hero-sticker,
    .hero-subtitle,
    .search-box,
    .dropdown-selected,
    .dropdown-options,
    .price-input,
    .price-btn,
    .cart-item,
    .cart-summary,
    .faq-card,
    .alert {
        border-radius: var(--spice-radius, 20px) !important;
    }

    /* Dropdown Menu CSS */
    .spice-dropdown-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .spice-dropdown {
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
        text-align: center;
    }
    
    .spice-dropdown::before {
        content: '';
        position: absolute;
        top: -12px;
        left: 0;
        right: 0;
        height: 12px;
    }
    
    .spice-dropdown-wrapper:hover .spice-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
    
    .spice-dropdown a {
        display: block;
        padding: 0.6rem 1.5rem;
        color: var(--spice-text);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .spice-dropdown a:hover {
        color: var(--spice-primary);
    }

    body {
        margin: 0;
        font-family: var(--font-body);
        background-color: var(--spice-bg);
        color: var(--spice-text);
        -webkit-font-smoothing: antialiased;
        overflow-x: visible; 
        width: 100%;
        box-sizing: border-box;
    }
    
    main {
        display: flow-root;
    }
    
    *, *::before, *::after {
        box-sizing: inherit;
    }

    /* CHUẨN HÓA CĂN ĐỀU HAI BÊN (JUSTIFY) CHO TẤT CẢ NỘI DUNG MÔ TẢ */
    .content-desc,
    .section-desc,
    .hero-desc,
    .product-description,
    .story-content p,
    .about-text p,
    .editor-content p,
    .editor-content,
    .legal-document p,
    .document-wrapper p,
    .faq-card p {
        text-align: justify;
        text-justify: inter-word;
        text-rendering: optimizeLegibility;
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
        background: var(--spice-bg);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 999;
        padding: 0.8rem 0;
    }

    .header-container {
        max-width: 1430px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left, .header-center, .header-right {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .header-left {
        justify-content: flex-start;
        gap: clamp(1.5rem, 2.2vw, 2.25rem);
    }
    
    .header-center {
        justify-content: center;
    }
    
    .header-right {
        justify-content: flex-end;
        gap: clamp(1.5rem, 2.2vw, 2.25rem);
    }

    .brand-logo {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-img {
        height: 65px;
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
        color: var(--spice-bg-dark);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-weight: 800;
        position: relative;
        padding: 0.35rem 0;
        transition: color 0.2s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .sale-link {
        color: var(--spice-primary);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: var(--spice-primary); /* Coral underline */
        transition: width 0.3s ease;
    }

    .nav-link:hover::after, .nav-link.active::after {
        width: 100%;
    }

    .nav-link.active, .nav-link:hover {
        color: var(--spice-primary);
        text-decoration: none;
    }

    .cart-btn {
        background: none;
        border: none;
        color: var(--spice-bg-dark);
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 0.35rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--font-body);
        font-size: 0.95rem;
        font-weight: 800;
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
        border-radius: 20px;
        display: inline-block;
        transition: transform 0.2s ease;
    }

    /* CHUẨN HÓA BỘ ICON LUCIDE (Outline, Stroke 1.75 - 2px) */
    .header-nav svg,
    .cart-btn svg,
    .header-icon {
        width: 22px; /* Dải 20-24px */
        height: 22px;
        stroke: currentColor;
        stroke-width: 2px; /* Dải 1.75-2px */
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: inline-block;
        flex-shrink: 0;
    }
    .spice-dropdown-wrapper .nav-link svg {
        width: 20px;
        height: 20px;
    }

    /* Icon trong các loại nút bấm (Button Icon: 16-20px, Stroke 2px) */
    button svg,
    .btn svg,
    .btn-primary svg,
    .btn-outline svg,
    .btn-ghost svg,
    .quick-add svg,
    .bundle-add-btn svg,
    .view-all-btn svg {
        width: 18px; /* Dải 16-20px */
        height: 18px;
        stroke: currentColor;
        stroke-width: 2px; /* Dải 1.75-2px */
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
    }

    @media (max-width: 900px) {
        .header-nav { display: none; }
        .logo-img { height: 50px; }
    }
</style>
