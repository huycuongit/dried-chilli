<footer class="spice-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo-wrap" aria-label="Dried Chili Home">
                    <img src="{{ asset('images/logo_dried.png') }}" alt="Dried Chili Logo" class="footer-logo" width="150">
                </a>
                <p>Bringing authentic Asian flavors to your kitchen. Handcrafted with passion, shipped globally.</p>
            </div>
            
            <div class="footer-links">
                <h4>Shop</h4>
                <ul class="footer-link-list">
                    <li><a href="{{ route('page.shop') }}">Shop All Spices</a></li>
                    <li><a href="{{ route('page.sale') }}">Hot Deals & Bundles</a></li>
                    <li><a href="{{ route('page.product', 'extra-garlic-crunch-5') }}">Extra Garlic Crunch</a></li>
                    <li><a href="{{ route('page.product', 'ghost-pepper-flakes-2') }}">Ghost Pepper Flakes</a></li>
                    <li><a href="{{ route('page.product', 'smoked-paprika-blend-3') }}">Smoked Paprika</a></li>
                    <li><a href="{{ route('page.product', 'dried-ancho-chilies-1') }}">Dried Ancho Chilies</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>About</h4>
                <ul class="footer-link-list">
                    <li><a href="{{ route('page.about') }}">About Us</a></li>
                    <li><a href="{{ route('page.legacy') }}">Our Legacy</a></li>
                    <li><a href="{{ route('contact.page') }}">Contact Us</a></li>
                    <li><a href="{{ route('page.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('page.terms') }}">Term and Conditions</a></li>
                </ul>
            </div>

            <div class="footer-newsletter">
                <h4>Stay Spicy</h4>
                <p>Join our newsletter for recipes, new releases, and exclusive offers.</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Dried Chili!');">
                    <input type="email" placeholder="Email address" required aria-label="Email address">
                    <button type="submit" aria-label="Subscribe">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Dried Chili - Jojo Little Kitchen. All rights reserved.</p>
            <div class="footer-bottom-info">
                <span>Handcrafted with passion &bull; Shipped globally</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .spice-footer {
        background-color: var(--spice-bg);
        padding: 5rem 0 2rem 0;
        color: var(--spice-text);
        font-family: var(--font-body);
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1.1fr 1.6fr;
        gap: 3rem;
        align-items: start;
        margin-bottom: 4rem;
    }

    .footer-brand {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .footer-brand p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--spice-text);
        opacity: 0.88;
        max-width: 32ch;
        text-align: justify;
        text-justify: inter-word;
        margin: 0;
    }

    .footer-logo-wrap {
        display: inline-block;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        border-radius: 0 !important;
        text-decoration: none;
        margin-bottom: 1rem;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    .footer-logo-wrap:hover {
        opacity: 0.85;
        transform: translateY(-2px);
    }

    .footer-logo {
        width: 150px;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
    }

    .footer-links h4, .footer-newsletter h4 {
        font-family: var(--font-heading);
        font-size: 1.15rem;
        font-weight: 800 !important;
        margin: 0 0 1.25rem 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--spice-text);
        line-height: 1.2;
    }

    .footer-link-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .footer-link-list li {
        margin: 0;
        padding: 0;
    }

    .footer-link-list a {
        display: inline-flex;
        align-items: center;
        color: var(--spice-text);
        opacity: 0.82;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
        transition: color 0.2s ease, opacity 0.2s ease, transform 0.2s ease;
    }

    .footer-link-list a:hover {
        color: var(--spice-primary);
        opacity: 1;
        transform: translateX(4px);
    }

    .footer-newsletter p {
        font-size: 0.95rem;
        margin-bottom: 1.25rem;
        line-height: 1.6;
        text-align: justify;
        text-justify: inter-word;
    }

    .newsletter-form {
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 2px solid var(--spice-text);
        border-radius: 20px !important;
        padding: 4px 6px 4px 16px;
        box-shadow: 0 4px 14px rgba(43, 29, 20, 0.05);
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .newsletter-form:focus-within {
        border-color: var(--spice-primary);
        box-shadow: 0 4px 16px rgba(228, 93, 62, 0.2);
    }

    .newsletter-form input {
        flex: 1;
        padding: 0.65rem 0.5rem 0.65rem 0;
        border: none;
        outline: none;
        background: transparent;
        color: var(--spice-text);
        font-family: var(--font-body);
        font-size: 0.95rem;
        min-width: 0;
    }

    .newsletter-form input::placeholder {
        color: #8C827A;
        font-size: 0.9rem;
    }

    .newsletter-form button {
        background: var(--spice-primary);
        color: #FFFFFF;
        border: none;
        border-radius: 20px !important;
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background-color 0.25s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .newsletter-form button:hover {
        background: var(--spice-accent);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(228, 93, 62, 0.35);
    }

    .newsletter-form button svg {
        stroke: #FFFFFF;
        stroke-width: 2px;
        transition: transform 0.2s ease;
    }

    .newsletter-form button:hover svg {
        transform: translateX(2px);
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 2px solid var(--spice-text);
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--spice-text);
    }

    .footer-bottom-info span {
        font-weight: 500;
        color: #6C5F57;
    }

    @media (max-width: 992px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2.25rem;
        }
        .footer-brand {
            text-align: center;
            align-items: center;
        }
        .footer-logo-wrap {
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 1rem;
        }
        .footer-logo {
            width: 130px;
            margin: 0 auto;
        }
        .footer-brand p {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .footer-links {
            text-align: center;
        }
        .footer-link-list {
            align-items: center;
        }
        .footer-bottom {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>
