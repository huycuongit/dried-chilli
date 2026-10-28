<footer class="spice-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo-wrap" aria-label="Dried Chili Home">
                    <img src="{{ asset('images/logo_dried.webp') }}" alt="Dried Chili Logo" class="footer-logo" width="150" height="61" loading="lazy">
                </a>
                <p>Bringing authentic Asian chili craftsmanship directly to your kitchen. Handcrafted in small batches with premium sun-dried peppers, aromatic crispy garlic, and shipped fresh to heat lovers globally.</p>
            </div>
            
            <div class="footer-links">
                <h4>Shop</h4>
                <ul class="footer-link-list">
                    <li><a href="{{ route('page.shop') }}">Shop All Spices</a></li>
                    <li><a href="{{ route('page.sale') }}">Hot Deals & Bundles</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>About</h4>
                <ul class="footer-link-list">
                    <li><a href="{{ route('page.about') }}">About Us</a></li>
                    <li><a href="{{ route('page.legacy') }}">Our Legacy</a></li>
                    <li><a href="{{ route('contact.page') }}">Contact Us</a></li>
                    <li><a href="{{ route('page.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('page.shipping') }}">Shipping & Refunds</a></li>
                    <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('page.terms') }}">Terms and Conditions</a></li>
                </ul>
            </div>

            <div class="footer-newsletter">
                <h4>Stay Spicy</h4>
                <p>Subscribe to our spice dispatch for secret family recipes, limited small-batch releases and exclusive culinary offers delivered straight to your inbox.</p>
                <form class="newsletter-form" id="footer-newsletter-form">
                    <input type="email" id="footer-newsletter-email" placeholder="Email address" required aria-label="Email address">
                    <button type="submit" id="footer-newsletter-btn" aria-label="Subscribe">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>
                <div id="footer-newsletter-feedback" style="display: none; font-size: 0.85rem; margin-top: 8px;"></div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Dried Chili - Jojo Little Kitchen. All rights reserved.</p>
            <div class="footer-bottom-info">
                <span>Designed and developed by FEB Digi.</span>
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
        line-height: 1.68;
        color: var(--spice-text);
        opacity: 0.95;
        max-width: 38ch;
        text-align: justify;
        text-justify: inter-word;
        text-align-last: left;
        -webkit-hyphens: auto;
        hyphens: auto;
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
        opacity: 0.95;
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
        line-height: 1.68;
        max-width: 44ch;
        text-align: justify;
        text-justify: inter-word;
        text-align-last: left;
        -webkit-hyphens: auto;
        hyphens: auto;
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

    /* Responsive: Tablet (768px - 992px) */
    @media (min-width: 769px) and (max-width: 992px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
        }
        .footer-newsletter {
            grid-column: span 2;
            max-width: 500px;
        }
    }
    
    /* Responsive: Mobile Phone (768px and below) */
    @media (max-width: 768px) {
        .spice-footer {
            padding: 2.5rem 0 5.5rem 0;
        }
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem 1rem;
            margin-bottom: 2rem;
        }
        .footer-brand {
            grid-column: span 2;
            text-align: center;
            align-items: center;
        }
        .footer-logo-wrap {
            margin: 0 auto 0.5rem auto;
        }
        .footer-logo {
            width: 120px;
        }
        .footer-brand p {
            margin: 0 auto;
            text-align: center;
            font-size: 0.88rem;
            max-width: 290px;
        }
        .footer-links {
            text-align: left;
            padding: 0 0.5rem;
        }
        .footer-links h4 {
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }
        .footer-link-list {
            gap: 0.45rem;
        }
        .footer-link-list a {
            font-size: 0.85rem;
        }
        .footer-newsletter {
            grid-column: span 2;
            text-align: center;
            margin-top: 0.5rem;
        }
        .footer-newsletter h4 {
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
        }
        .footer-newsletter p {
            text-align: center;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .newsletter-form {
            max-width: 320px;
            margin: 0 auto;
            padding: 3px 5px 3px 14px;
        }
        .footer-bottom {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
            font-size: 0.78rem;
            padding-top: 1.25rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const footerForm = document.getElementById('footer-newsletter-form');
    const footerEmail = document.getElementById('footer-newsletter-email');
    const footerBtn = document.getElementById('footer-newsletter-btn');
    const footerFeedback = document.getElementById('footer-newsletter-feedback');

    if (footerForm) {
        footerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = footerEmail.value.trim();
            if (!email) return;

            footerBtn.disabled = true;
            footerFeedback.style.display = 'block';
            footerFeedback.style.color = '#BDBDBD';
            footerFeedback.textContent = 'Sending...';

            fetch('/api/coupon/claim-voucher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => res.json())
            .then(data => {
                footerBtn.disabled = false;
                if (data.success) {
                    footerFeedback.style.color = '#81C784';
                    footerFeedback.textContent = 'Your 15% code: ' + data.code + ' (Sent to your email!)';
                    footerEmail.value = '';
                } else {
                    footerFeedback.style.color = '#E57373';
                    footerFeedback.textContent = data.message || 'Error sending voucher.';
                }
            })
            .catch(() => {
                footerBtn.disabled = false;
                footerFeedback.style.color = '#E57373';
                footerFeedback.textContent = 'Connection error. Please try again.';
            });
        });
    }
});
</script>
