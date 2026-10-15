<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('frontend.layouts.partials.head')
    <body class="{{ request()->routeIs('home') ? 'home-page' : (request()->routeIs('news.*') ? 'nafu-blog-page' : (request()->routeIs('services.*') ? 'nafu-blog-page nafu-services-page' : (request()->routeIs('contact.page') ? 'nafu-blog-page nafu-contact-page' : (request()->routeIs('projects.*') ? 'nafu-blog-page nafu-project-page' : '')))) }}">
        <div class="spice-marquee" style="cursor: pointer;" onclick="document.getElementById('newsletter-modal').classList.add('active'); document.getElementById('voucher-popup').classList.remove('show');">
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
                font-family: var(--font-body, 'Outfit', sans-serif);
                font-weight: 800;
                letter-spacing: 1px;
                position: relative;
                z-index: 1000;
                transition: background-color 0.3s;
                display: flex;
                align-items: center;
            }
            .spice-marquee:hover { background-color: var(--spice-accent); }
            .marquee-track {
                display: inline-block;
                animation: scrollMarquee 25s linear infinite;
            }
            .marquee-track span { margin-right: 3rem; }
            @keyframes scrollMarquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
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
        <a href="tel:+1234567890" class="floating-hotline">
            <div class="hotline-pulse"></div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </a>
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
                0% { transform: scale(1); opacity: 0.8; }
                100% { transform: scale(1.6); opacity: 0; }
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
                }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });
                reveals.forEach(reveal => revealObserver.observe(reveal));
                
                // Fallback page transition if View Transitions API is not supported
                if (!document.startViewTransition) {
                    document.body.classList.add('page-transition-enter');
                    
                    // Remove class after animation finishes to prevent containing block bug which breaks position: fixed/sticky
                    setTimeout(() => {
                        document.body.classList.remove('page-transition-enter');
                    }, 450);
                    
                    document.querySelectorAll('a').forEach(link => {
                        if (link.hostname === window.location.hostname && !link.hash && link.target !== '_blank' && !link.getAttribute('href').startsWith('#')) {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const target = link.href;
                                document.body.classList.remove('page-transition-enter');
                                document.body.classList.add('page-transition-leave');
                                setTimeout(() => { window.location = target; }, 300);
                            });
                        }
                    });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
