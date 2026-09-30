<footer class="spice-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/" class="footer-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}" alt="Dried Chili Logo" class="footer-logo">
                </a>
                <p>Bringing authentic Asian flavors to your kitchen. Handcrafted with passion, shipped globally.</p>
            </div>
            
            <div class="footer-links">
                <h4>Shop</h4>
                <a href="/collections/dried-chillies">Dried Chillies</a>
                <a href="/collections/powders">Spice Powders</a>
                <a href="/collections/blends">Curry & Blends</a>
                <a href="/collections/all">All Products</a>
            </div>

            <div class="footer-links">
                <h4>About</h4>
                <a href="/our-legacy">Our Legacy</a>
                <a href="/story">Our Story</a>
                <a href="/sustainability">Sustainability</a>
                <a href="/contact">Contact Us</a>
            </div>

            <div class="footer-newsletter">
                <h4>Stay Spicy</h4>
                <p>Join our newsletter for recipes, new releases, and exclusive offers.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Email address" required>
                    <button type="submit">→</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Jojo Little Kitchen. All rights reserved.</p>
            <div class="footer-legal">
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .spice-footer {
        background-color: var(--spice-bg);
        border-top: 2px solid var(--spice-text);
        padding: 5rem 0 2rem 0;
        color: var(--spice-text);
        font-family: var(--font-body);
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 2fr;
        gap: 4rem;
        margin-bottom: 4rem;
    }

    .footer-brand p {
        font-size: 0.95rem;
        line-height: 1.6;
        margin-top: 1rem;
        max-width: 300px;
    }

    .footer-logo-wrap {
        display: inline-block;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: var(--spice-primary);
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid var(--spice-text);
        overflow: hidden;
    }

    .footer-logo {
        width: 80%;
        height: auto;
        object-fit: contain;
    }

    .footer-links h4, .footer-newsletter h4 {
        font-family: var(--font-heading);
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-links a {
        display: block;
        color: var(--spice-text);
        text-decoration: none;
        margin-bottom: 0.75rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .footer-links a:hover {
        color: var(--spice-primary);
    }

    .footer-newsletter p {
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .newsletter-form {
        display: flex;
        border: 2px solid var(--spice-text);
        border-radius: 8px;
        overflow: hidden;
    }

    .newsletter-form input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        outline: none;
        background: transparent;
        color: var(--spice-text);
        font-family: var(--font-body);
        font-size: 1rem;
    }

    .newsletter-form button {
        background: var(--spice-primary);
        color: var(--spice-bg);
        border: none;
        border-left: 2px solid var(--spice-text);
        padding: 0 1.5rem;
        font-size: 1.25rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .newsletter-form button:hover {
        background: var(--spice-accent);
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 2px solid var(--spice-text);
        font-size: 0.85rem;
        font-weight: 700;
    }

    .footer-legal a {
        color: var(--spice-text);
        text-decoration: none;
        margin-left: 1.5rem;
    }

    .footer-legal a:hover {
        color: var(--spice-primary);
    }

    @media (max-width: 992px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    @media (max-width: 576px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .footer-bottom {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>
