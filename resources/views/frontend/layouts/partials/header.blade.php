<header class="site-header nafu-header">
    <a class="brand" href="{{ page_route('home') }}" aria-label="Nafu Home Care home">
        <img class="nafu-logo-image" src="{{ asset($companySetting('logo', 'assets/nafu/nafu-logo.png')) }}" alt="{{ $companySetting('name', 'Nafu Services') }}" width="612" height="408">
    </a>
    <span class="nafu-tagline">{{ $companySetting('tagline', 'Trusted care for every home') }}</span>
    <nav aria-label="Main navigation">
        <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ page_route('home') }}">HOME</a>
        <a class="{{ request()->routeIs('projects.*') ? 'is-active' : '' }}" href="{{ page_route('projects.index') }}">PROJECTS</a>
        <a class="{{ request()->routeIs('services.*') ? 'is-active' : '' }}" href="/services">SERVICES</a>
        <a class="{{ request()->routeIs('news.*') ? 'is-active' : '' }}" href="{{ page_route('news.index') }}">BLOG</a>
        <a class="{{ request()->routeIs('contact.page') ? 'is-active' : '' }}" href="{{ route('contact.page') }}">CONTACT</a>
        <a class="talk-button" href="{{ route('contact.page') }}#contact-form">CONTACT US</a>
    </nav>
</header>

