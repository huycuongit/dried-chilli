<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('frontend.layouts.partials.head')
    <body class="{{ request()->routeIs('home') ? 'home-page' : (request()->routeIs('news.*') ? 'nafu-blog-page' : (request()->routeIs('services.*') ? 'nafu-blog-page nafu-services-page' : (request()->routeIs('contact.page') ? 'nafu-blog-page nafu-contact-page' : (request()->routeIs('projects.*') ? 'nafu-blog-page nafu-project-page' : '')))) }}">
        @include('frontend.layouts.partials.header')

        @hasSection('full-content')
            @yield('full-content')
        @else
            <main>@yield('content')</main>
        @endif

        @include('frontend.layouts.partials.footer')

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
