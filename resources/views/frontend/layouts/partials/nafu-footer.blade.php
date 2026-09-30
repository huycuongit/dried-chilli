<footer class="spice-footer">
    <div class="footer-top">
        <div class="container">
            <div class="newsletter-wrapper">
                <h3>Join Our Spice Club</h3>
                <p>Subscribe to receive recipes, exclusive offers, and spice pairing tips.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email address">
                    <button type="button">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="footer-main">
        <div class="container footer-grid">
            <div class="footer-col brand-col">
                <span class="footer-brand">DRIED CHILI</span>
                <p class="brand-desc">Sourcing the world's finest, most authentic spices and dried chillies to bring vibrant flavors to your kitchen.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                    <a href="#" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                    <a href="#" aria-label="Twitter"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Shop</h4>
                <a href="#">Dried Chillies</a>
                <a href="#">Spice Blends</a>
                <a href="#">Herbs</a>
                <a href="#">New Arrivals</a>
            </div>
            
            <div class="footer-col">
                <h4>Information</h4>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Shipping Policy</a>
                <a href="#">Refund Policy</a>
            </div>
            
            <div class="footer-col">
                <h4>Customer Support</h4>
                <p>Email: hello@driedchili.com</p>
                <p>Phone: +1 (555) 123-4567</p>
                <p>Hours: Mon - Fri, 9am - 5pm</p>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; {{ date('Y') }} Dried Chili. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    .spice-footer {
        background-color: var(--spice-bg-alt);
        color: var(--spice-text);
        margin-top: 5rem;
    }

    .footer-top {
        border-bottom: 1px solid rgba(43, 29, 20, 0.1);
        padding: 4rem 0;
        text-align: center;
    }

    .newsletter-wrapper h3 {
        font-family: var(--font-heading);
        font-size: 2rem;
        color: var(--spice-primary);
        margin: 0 0 0.5rem 0;
    }

    .newsletter-wrapper p {
        margin: 0 0 2rem 0;
        color: var(--spice-text);
        opacity: 0.8;
    }

    .newsletter-form {
        display: flex;
        max-width: 500px;
        margin: 0 auto;
        gap: 0.5rem;
    }

    .newsletter-form input {
        flex: 1;
        padding: 1rem 1.5rem;
        border: 1px solid rgba(43, 29, 20, 0.2);
        background: var(--spice-bg);
        font-family: var(--font-body);
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s;
    }
    
    .newsletter-form input:focus {
        border-color: var(--spice-primary);
    }

    .newsletter-form button {
        padding: 1rem 2rem;
        background-color: var(--spice-text);
        color: white;
        border: none;
        font-family: var(--font-body);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .newsletter-form button:hover {
        background-color: var(--spice-primary);
    }

    .footer-main {
        padding: 4rem 0;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 4rem;
    }

    .footer-brand {
        font-family: var(--font-heading);
        font-size: 1.8rem;
        color: var(--spice-primary);
        font-weight: 700;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 1rem;
    }

    .brand-desc {
        opacity: 0.8;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(43, 29, 20, 0.05);
        color: var(--spice-text);
        transition: all 0.3s;
    }

    .social-links a:hover {
        background-color: var(--spice-primary);
        color: white;
        transform: translateY(-2px);
    }

    .footer-col h4 {
        font-family: var(--font-heading);
        font-size: 1.25rem;
        margin: 0 0 1.5rem 0;
        color: var(--spice-text);
    }

    .footer-col a, .footer-col p {
        display: block;
        color: var(--spice-text);
        text-decoration: none;
        margin-bottom: 0.75rem;
        opacity: 0.8;
        transition: opacity 0.3s, color 0.3s;
    }

    .footer-col a:hover {
        opacity: 1;
        color: var(--spice-primary);
    }

    .footer-bottom {
        padding: 1.5rem 0;
        border-top: 1px solid rgba(43, 29, 20, 0.1);
        text-align: center;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    @media (max-width: 900px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .brand-col {
            grid-column: 1 / -1;
        }
    }
    
    @media (max-width: 600px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }
        .newsletter-form {
            flex-direction: column;
        }
    }
</style>
