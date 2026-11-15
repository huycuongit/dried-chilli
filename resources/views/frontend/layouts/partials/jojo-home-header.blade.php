<header class="jojo-site-header">
    <div class="jojo-header-inner jojo-container">
        <a class="jojo-brand" href="{{ route('home') }}" aria-label="Jojo Little Kitchen home"><img src="{{ asset('images/jojo-logo-pdf.svg') }}" alt="Jojo Little Kitchen" width="72" height="72"></a>
        <nav class="jojo-desktop-nav" aria-label="Main navigation">
            <a href="{{ route('page.shop') }}">Shop</a>
            <a href="{{ route('page.about') }}">About Us</a>
            <a href="{{ route('home') }}#recipes">Recipes</a>
            <a href="{{ route('page.legacy') }}">Our Legacy</a>
            <a href="{{ route('contact.page') }}">Contact</a>
        </nav>
        <div class="jojo-header-actions">
            <button class="jojo-icon-button jojo-search-toggle" type="button" aria-label="Search products" aria-controls="jojo-search" aria-expanded="false"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg></button>
            <div class="jojo-cart-wrap">
                <a class="cart-btn jojo-cart-link" href="{{ route('page.cart') }}" aria-label="Open cart"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 3h2l2.2 12h12.5L21 7H5"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg><span class="jojo-cart-label">Cart (<span class="cart-count">0</span>)</span><span class="jojo-cart-count-mobile cart-count" aria-hidden="true">0</span></a>
                @include('frontend.layouts.partials.cart-drawer')
            </div>
            <button class="jojo-icon-button jojo-menu-toggle" type="button" aria-label="Open menu" aria-controls="jojo-mobile-nav" aria-expanded="false"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button>
        </div>
    </div>
    <form class="jojo-header-search jojo-container" id="jojo-search" action="{{ route('page.shop') }}" method="get" hidden>
        <label for="jojo-search-input">Search products</label><input id="jojo-search-input" name="search" type="search" placeholder="Search Jojo products"><button type="submit">Search</button>
    </form>
    <nav class="jojo-mobile-nav" id="jojo-mobile-nav" aria-label="Mobile navigation" hidden>
        <a href="{{ route('page.shop') }}">Shop</a><a href="{{ route('page.about') }}">About Us</a><a href="{{ route('home') }}#recipes">Recipes</a><a href="{{ route('page.legacy') }}">Our Legacy</a><a href="{{ route('contact.page') }}">Contact</a><a href="{{ route('page.cart') }}">Cart</a><a href="{{ route('auth.login') }}">Login / Account</a>
    </nav>
</header>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.jojo-site-header');
    if (!header) return;
    const menuButton = header.querySelector('.jojo-menu-toggle');
    const searchButton = header.querySelector('.jojo-search-toggle');
    const menu = document.getElementById('jojo-mobile-nav');
    const search = document.getElementById('jojo-search');
    function closePanels() {
        menu.hidden = true; search.hidden = true;
        menuButton.setAttribute('aria-expanded', 'false');
        searchButton.setAttribute('aria-expanded', 'false');
    }
    menuButton.addEventListener('click', function () { const open = menu.hidden; closePanels(); menu.hidden = !open; menuButton.setAttribute('aria-expanded', String(open)); if (open) menu.querySelector('a')?.focus(); });
    searchButton.addEventListener('click', function () { const open = search.hidden; closePanels(); search.hidden = !open; searchButton.setAttribute('aria-expanded', String(open)); if (open) search.querySelector('input')?.focus(); });
    document.addEventListener('keydown', function (event) { if (event.key === 'Escape') closePanels(); });
    menu.querySelectorAll('a').forEach(function (link) { link.addEventListener('click', closePanels); });
});
</script>
