@php
    $instagramUrl = trim((string) app(\App\Support\SystemSettings::class)->get('link_instagram', ''));
    $facebookUrl = trim((string) app(\App\Support\SystemSettings::class)->get('link_facebook', ''));
    $instagramUrl = preg_match('~^https://~i', $instagramUrl) ? $instagramUrl : '';
    $facebookUrl = preg_match('~^https://~i', $facebookUrl) ? $facebookUrl : '';
@endphp
<footer class="jojo-footer">
    <div class="jojo-container">
        <div class="jojo-footer-top">
            <div class="jojo-footer-brand">
                <a class="jojo-footer-logo" href="{{ route('home') }}" aria-label="Jojo Little Kitchen home">
                    <img src="{{ asset('images/jojo-footer-wordmark.svg') }}" alt="Jojo Little Kitchen" width="142" height="74">
                </a>
                <p>Bringing authentic Asian flavours to your table with quality ingredients, bold taste and a homestyle touch.</p>
            </div>
            <nav class="jojo-footer-links" aria-label="Footer shop links">
                <a href="{{ route('page.shop') }}">Shop</a>
                <a href="{{ route('page.about') }}">About Us</a>
                <a href="{{ route('home') }}#recipes">Recipes</a>
            </nav>
            <nav class="jojo-footer-links" aria-label="Footer company links">
                <a href="{{ route('page.legacy') }}">Our Legacy</a>
                <a href="{{ route('contact.page') }}">Contact</a>
            </nav>
            <div class="jojo-footer-social">
                <strong>Follow Us</strong>
                <div class="jojo-footer-social-icons">
                    @if($instagramUrl !== '')
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Jojo on Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle class="jojo-instagram-dot" cx="17.5" cy="6.5" r="1"/></svg></a>
                    @else
                        <span aria-label="Instagram" role="img"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle class="jojo-instagram-dot" cx="17.5" cy="6.5" r="1"/></svg></span>
                    @endif
                    @if($facebookUrl !== '')
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Jojo on Facebook"><span aria-hidden="true" class="jojo-facebook-mark">f</span></a>
                    @else
                        <span aria-label="Facebook" role="img"><span aria-hidden="true" class="jojo-facebook-mark">f</span></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="jojo-footer-bottom">
            <span>&copy; {{ date('Y') }} Jojo Little Kitchen. All rights reserved.</span>
            <nav aria-label="Legal links">
                <a href="{{ route('page.terms') }}">Terms &amp; Conditions</a>
                <a href="{{ route('page.privacy') }}">Privacy Policy</a>
                <a href="{{ route('page.shipping') }}">Shipping &amp; Returns</a>
            </nav>
        </div>
    </div>
</footer>
