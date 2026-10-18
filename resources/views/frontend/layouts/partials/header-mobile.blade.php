<!-- Mobile Header & Navigation Drawer (Screens <= 900px) -->
<header class="spice-header mobile-header">
    <div class="header-container">
        <!-- Left Section: Mobile Menu Toggle Button -->
        <div class="header-left">
            <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Open Navigation Menu">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
        
        <!-- Center Section: Brand Logo -->
        <div class="header-center brand-logo-wrapper">
            <a class="brand-logo" href="{{ page_route('home') }}" aria-label="Dried Chili Home">
                <img src="{{ asset('images/logo_dried.png') }}" alt="Dried Chili Logo" class="mobile-logo-img">
            </a>
        </div>
        
        <!-- Right Section: Empty spacer to keep logo centered -->
        <div class="header-right" aria-hidden="true"></div>
    </div>
</header>

<!-- Mobile Navigation Drawer Backdrop -->
<div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>

<!-- Mobile Navigation Off-canvas Drawer -->
<aside class="mobile-nav-drawer" id="mobileNavDrawer" aria-label="Mobile Navigation">
    <div class="mobile-nav-header">
        <a class="brand-logo" href="{{ page_route('home') }}">
            <img src="{{ asset('images/logo_dried.png') }}" alt="Dried Chili Logo" style="height: 38px; width: auto; object-fit: contain;">
        </a>

    </div>

    <div class="mobile-nav-body">
        <ul class="mobile-menu-list">
            <li>
                <a href="/sale" class="mobile-menu-link sale-link {{ request()->is('sale') ? 'active' : '' }}">
                    <span>🔥 SALE</span>
                    <span class="mobile-badge-sale">HOT</span>
                </a>
            </li>
            <li>
                <a href="/shop" class="mobile-menu-link {{ request()->is('shop') ? 'active' : '' }}">
                    <span>SHOP ALL SPICES</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </li>
            <li>
                <a href="{{ route('page.legacy') }}" class="mobile-menu-link {{ request()->routeIs('page.legacy') ? 'active' : '' }}">
                    <span>OUR LEGACY</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </li>
            <li class="mobile-menu-item-accordion">
                <button type="button" class="mobile-menu-accordion-btn" id="mobileAboutAccordion">
                    <span>ABOUT US</span>
                    <svg class="accordion-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <ul class="mobile-submenu" id="mobileAboutSubmenu">
                    <li><a href="/about-us">Brand Story</a></li>
                    <li><a href="{{ route('page.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('page.shipping') }}">Shipping & Refunds</a></li>
                    <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('page.terms') }}">Terms & Conditions</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('contact.page') }}" class="mobile-menu-link {{ request()->routeIs('contact.page') ? 'active' : '' }}">
                    <span>CONTACT</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </li>
        </ul>
    </div>

    <div class="mobile-nav-footer">
        <a href="tel:+1234567890" class="mobile-footer-contact">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>Hotline: +1 (234) 567-890</span>
        </a>
        <p class="mobile-footer-copy">&copy; {{ date('Y') }} Dried Chili. All rights reserved.</p>
    </div>
</aside>

<style>
    /* Ẩn Mobile Header trên Desktop (Màn hình > 900px) */
    @media (min-width: 901px) {
        .mobile-header,
        .mobile-nav-backdrop,
        .mobile-nav-drawer {
            display: none !important;
        }
    }

    /* Kích hoạt Mobile Header trên Màn hình <= 900px */
    @media (max-width: 900px) {
        .mobile-header {
            display: block !important;
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(253, 249, 241, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(43, 29, 20, 0.08);
            padding: 0.45rem 0;
            box-shadow: 0 2px 10px rgba(43, 29, 20, 0.04);
            width: 100%;
        }

        .mobile-header .header-container {
            padding: 0 1rem;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-header .header-left,
        .mobile-header .header-right {
            flex: 0 0 44px;
            display: flex;
            align-items: center;
        }

        .mobile-header .header-left {
            justify-content: flex-start;
        }

        .mobile-header .header-right {
            justify-content: flex-end;
        }

        .mobile-header .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mobile-menu-toggle {
            display: inline-flex;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            padding: 0;
            color: var(--spice-bg-dark);
            cursor: pointer;
            border-radius: 10px !important;
            transition: background-color 0.2s;
        }

        .mobile-menu-toggle:hover {
            background-color: rgba(43, 29, 20, 0.06);
        }

        .mobile-logo-img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .mobile-cart-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: var(--spice-bg-dark);
            text-decoration: none;
            position: relative;
            background: transparent;
            border-radius: 10px !important;
            transition: background-color 0.2s;
        }

        .mobile-cart-btn:hover {
            background-color: rgba(43, 29, 20, 0.06);
            color: var(--spice-primary);
        }

        .mobile-cart-count {
            position: absolute;
            top: 4px;
            right: 2px;
            background-color: var(--spice-primary);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 1px 5px;
            min-width: 17px;
            height: 17px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FDF9F1;
        }

        /* Backdrop */
        .mobile-nav-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(43, 29, 20, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 10001;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
        }
        .mobile-nav-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* Drawer Panel */
        .mobile-nav-drawer {
            position: fixed;
            top: 0;
            left: 0;
            width: 320px;
            max-width: 85vw;
            height: 100vh;
            height: 100dvh;
            background-color: #FDF9F1;
            box-shadow: 10px 0 35px rgba(43, 29, 20, 0.25);
            z-index: 10002;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .mobile-nav-drawer.active {
            transform: translateX(0);
        }

        .mobile-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(43, 29, 20, 0.08);
            background: #FDF9F1;
        }

    

        .mobile-nav-body {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .mobile-menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .mobile-menu-list li {
            width: 100%;
        }

        .mobile-menu-link,
        .mobile-menu-accordion-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.85rem 1rem;
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 800;
            color: var(--spice-bg-dark);
            text-decoration: none;
            border-radius: 14px !important;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-sizing: border-box;
        }
        .mobile-menu-link:hover,
        .mobile-menu-accordion-btn:hover {
            background-color: rgba(43, 29, 20, 0.05);
            color: var(--spice-primary);
        }
        .mobile-menu-link.active {
            background-color: rgba(228, 93, 62, 0.1);
            color: var(--spice-primary);
        }
        .mobile-menu-link.sale-link {
            color: var(--spice-fire);
        }
        .mobile-badge-sale {
            background: var(--spice-fire);
            color: #FFFFFF;
            font-size: 0.7rem;
            padding: 0.2rem 0.55rem;
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .mobile-menu-item-accordion {
            display: flex;
            flex-direction: column;
        }
        .accordion-arrow {
            transition: transform 0.3s ease;
        }
        .mobile-menu-item-accordion.open .accordion-arrow {
            transform: rotate(180deg);
        }
        .mobile-submenu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
            flex-direction: column;
            gap: 0.25rem;
            overflow: hidden;
        }
        .mobile-menu-item-accordion.open .mobile-submenu {
            display: flex;
            padding: 0.35rem 0 0.5rem 1rem;
        }
        .mobile-submenu a {
            display: block;
            padding: 0.6rem 0.85rem;
            font-family: var(--font-body);
            font-size: 0.92rem;
            font-weight: 600;
            color: #6C5F57;
            text-decoration: none;
            border-radius: 10px !important;
            transition: color 0.2s, background-color 0.2s;
        }
        .mobile-submenu a:hover {
            color: var(--spice-primary);
            background-color: rgba(43, 29, 20, 0.04);
        }

        .mobile-drawer-promo {
            margin-top: auto;
            padding: 0.5rem 0;
        }
        .mobile-promo-btn {
            width: 100%;
            background: linear-gradient(135deg, #FFF0E6 0%, #FFE5D9 100%);
            border: 2px dashed var(--spice-primary);
            border-radius: 16px !important;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            color: var(--spice-bg-dark);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .mobile-promo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(228, 93, 62, 0.2);
        }
        .mobile-promo-btn .promo-tag {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--spice-primary);
            text-transform: uppercase;
        }
        .mobile-promo-btn strong {
            font-size: 1rem;
            color: var(--spice-fire);
        }
        .mobile-promo-btn small {
            font-size: 0.8rem;
            color: #6C5F57;
        }

        .mobile-nav-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(43, 29, 20, 0.08);
            background: #FDF9F1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .mobile-footer-contact {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--spice-bg-dark);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .mobile-footer-copy {
            margin: 0;
            font-size: 0.75rem;
            color: #8C827A;
        }
    }

    /* Tinh chỉnh cho điện thoại nhỏ <= 576px */
    @media (max-width: 576px) {
        .mobile-header {
            padding: 0.35rem 0;
        }
        .mobile-header .header-container {
            padding: 0 0.75rem;
            min-height: 46px;
        }
        .mobile-logo-img {
            height: 36px;
        }
        .mobile-cart-btn svg {
            width: 22px;
            height: 22px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileDrawer = document.getElementById('mobileNavDrawer');
    const mobileBackdrop = document.getElementById('mobileNavBackdrop');
    const mobileClose = document.getElementById('mobileNavClose');
    const accordionBtn = document.getElementById('mobileAboutAccordion');
    const accordionItem = accordionBtn ? accordionBtn.closest('.mobile-menu-item-accordion') : null;

    function openMobileDrawer() {
        if (mobileDrawer && mobileBackdrop) {
            mobileDrawer.classList.add('active');
            mobileBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
        }
    }

    function closeMobileDrawer() {
        if (mobileDrawer && mobileBackdrop) {
            mobileDrawer.classList.remove('active');
            mobileBackdrop.classList.remove('active');
            document.body.style.overflow = '';
            if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
        }
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openMobileDrawer);
    if (mobileClose) mobileClose.addEventListener('click', closeMobileDrawer);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileDrawer);

    if (accordionBtn && accordionItem) {
        accordionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            accordionItem.classList.toggle('open');
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDrawer && mobileDrawer.classList.contains('active')) {
            closeMobileDrawer();
        }
    });
});
</script>
