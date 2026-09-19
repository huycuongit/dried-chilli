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

        @include('frontend.layouts.partials.nafu-footer')

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
        @stack('scripts')
    </body>
</html>
