<!doctype html>
<html lang="{{ app()->getLocale() }}">
@include('frontend.layouts.partials.head')

<body class="{{ request()->routeIs('home') ? 'home-page' : '' }}">
    <div class="spice-marquee" style="cursor: pointer;"
        onclick="document.getElementById('newsletter-modal').classList.add('active'); document.getElementById('voucher-popup').classList.remove('show');">
        <div class="marquee-track">
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
            <span>🔥 SALE: BUY 2 GET 1 FREE ON ALL SHRIMP CHILLI JARS ✦ FREE SHIPPING OVER $50 ✦</span>
        </div>
    </div>
    <style>
    /* Marquee */
    .spice-marquee {
        background-color: var(--spice-primary);
        color: white;
        padding: 3px 0;
        font-size: 0.75rem;
        overflow: hidden;
        white-space: nowrap;
        font-family: var(--font-heading, 'Manrope', sans-serif);
        font-weight: 800;
        letter-spacing: 1px;
        position: relative;
        z-index: 1000;
        transition: background-color 0.3s;
        display: flex;
        align-items: center;
    }

    .spice-marquee:hover {
        background-color: var(--spice-accent);
    }

    .marquee-track {
        display: inline-block;
        animation: scrollMarquee 25s linear infinite;
    }

    .marquee-track span {
        margin-right: 3rem;
    }

    @keyframes scrollMarquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }
    </style>
    @include('frontend.layouts.partials.header')





    @hasSection('full-content')
    @yield('full-content')
    @else
    <main>@yield('content')</main>
    @endif

    @include('frontend.layouts.partials.voucher-popup')
    @include('frontend.layouts.partials.footer')

    <!-- Floating Hotline Button -->
    <a href="tel:+1234567890" class="floating-hotline" aria-label="Hotline">
        <div class="hotline-pulse"></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
            </path>
        </svg>
    </a>

    <!-- Modern Mobile Bottom Navigation Dock (App-like UX) -->
    <nav class="mobile-bottom-nav" id="mobileBottomNav" aria-label="Mobile Navigation">
        <a href="{{ page_route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}"
            aria-label="Home">
            <div class="bottom-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>
            </div>
            <span>Home</span>
        </a>
        <a href="/shop" class="bottom-nav-item {{ request()->is('shop') ? 'active' : '' }}" aria-label="Shop">
            <div class="bottom-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 8h14l1 13H4L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
            </div>
            <span>Shop</span>
        </a>
        <a href="/cart" class="bottom-nav-item {{ request()->is('cart') ? 'active' : '' }}" aria-label="Cart">
            <div class="bottom-nav-icon bottom-nav-cart-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M2 2h2l2.5 12.4a2 2 0 0 0 2 1.6H19a2 2 0 0 0 2-1.6L22 7H5"/></svg>
                <span class="bottom-nav-cart-badge cart-count">0</span>
            </div>
            <span>Cart</span>
        </a>
    </nav>

    <style>
    .floating-hotline {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background-color: var(--spice-primary);
        color: white;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(228, 93, 62, 0.4);
        z-index: 9999;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .floating-hotline:hover {
        transform: scale(1.1);
        color: white;
    }

    .hotline-pulse {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--spice-primary);
        border-radius: 50% !important;
        z-index: -1;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    /* Mobile Bottom Nav Styles */
    .mobile-bottom-nav {
        display: none;
    }

    @media (max-width: 768px) {
        body {
            padding-bottom: 84px;
        }

        .mobile-bottom-nav {
            display: flex;
            position: fixed;
            bottom: 10px;
            left: 10px;
            right: 10px;
            width: calc(100% - 20px);
            max-width: 480px;
            margin: 0 auto;
            height: 64px;
            background: rgba(253, 249, 241, 0.96);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(43, 29, 20, 0.12);
            border-radius: 20px;
            align-items: center;
            justify-content: space-around;
            z-index: 9998;
            box-shadow: 0 6px 24px rgba(43, 29, 20, 0.14);
            box-sizing: border-box;
            padding: 4px 0.5rem;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #5C4B41;
            text-decoration: none;
            font-family: var(--font-heading);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            padding: 3px 0.5rem;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: color 0.2s, transform 0.15s;
            flex: 1;
            max-width: 80px;
        }

        .bottom-nav-item:hover,
        .bottom-nav-item.active {
            color: var(--spice-primary);
        }

        .bottom-nav-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 28px;
            margin: 0;
            border-radius: 14px;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .bottom-nav-item.active .bottom-nav-icon {
            background: rgba(228, 93, 62, 0.12);
        }

        .bottom-nav-item i,
        .bottom-nav-item svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2px;
            display: inline-block;
            flex-shrink: 0;
        }

        .bottom-nav-cart-badge {
            position: absolute;
            top: -4px;
            right: -7px;
            background: var(--spice-primary);
            color: #FFFFFF;
            font-family: var(--font-heading);
            font-size: 0.62rem;
            font-weight: 800;
            min-width: 16px;
            height: 16px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            box-sizing: border-box;
            box-shadow: 0 2px 6px rgba(228, 93, 62, 0.4);
        }

        .promo-dot-indicator {
            position: absolute;
            top: -1px;
            right: -2px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--spice-fire);
            box-shadow: 0 0 6px rgba(196, 20, 30, 0.8);
            animation: pulseDot 1.5s infinite;
        }

        @keyframes pulseDot {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.4);
                opacity: 0.6;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Hide floating hotline on mobile to keep viewport clean and airy - accessible via menu drawer & footer */
        .floating-hotline {
            display: none !important;
        }
    }
    </style>


    <script>
    (() => {
        document.documentElement.lang = 'en';
        document.querySelectorAll('[data-en][data-vi]').forEach((element) => {
            element.innerHTML = element.dataset.en;
        });
        document.querySelectorAll('[data-language-content]').forEach((element) => {
            element.hidden = element.dataset.languageContent !== 'en';
        });
    })();
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        });
        reveals.forEach(reveal => revealObserver.observe(reveal));

        // Fallback page transition if View Transitions API is not supported
        if (!document.startViewTransition) {
            document.body.classList.add('page-transition-enter');

            // Remove class after animation finishes to prevent containing block bug which breaks position: fixed/sticky
            setTimeout(() => {
                document.body.classList.remove('page-transition-enter');
            }, 450);

            document.querySelectorAll('a').forEach(link => {
                if (link.hostname === window.location.hostname && !link.hash && link.target !==
                    '_blank' && !link.getAttribute('href').startsWith('#')) {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        const target = link.href;
                        document.body.classList.remove('page-transition-enter');
                        document.body.classList.add('page-transition-leave');
                        setTimeout(() => {
                            window.location = target;
                        }, 300);
                    });
                }
            });
        }
    });
    </script>
    @stack('scripts')
</body>

</html>
