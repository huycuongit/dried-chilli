@extends('frontend.layouts.master')

@section('meta')
<title>Shipping & Refunds | Dried Chili</title>
@endsection

@section('full-content')
<main class="page-content legal-page bg-cream">
    <!-- Hero Section -->
    <section class="legal-hero">
        <div class="container text-center reveal">
            <h1 class="text-white mt-3" style="color: var(--spice-secondary) !important;">SHIPPING &
                REFUNDS</h1>
            <p class="hero-subtitle text-white mt-3 mx-auto"
                style="max-width: 650px; opacity: 0.9; font-size: 1.15rem; line-height: 1.6; margin-left: auto !important; margin-right: auto !important;">
                Fast, reliable delivery straight to your kitchen, backed by our 100% 30-Day
                Freshness & Satisfaction Guarantee.
            </p>
        </div>
    </section>

    <!-- Document Section -->
    <section class="legal-document">
        <div class="container reveal">
            <div class="document-wrapper shadow-lg">
                <!-- Highlight Highlights Bar -->
                <div class="shipping-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                <path d="M15 18H9" />
                                <path
                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                <circle cx="17" cy="18" r="2" />
                                <circle cx="7" cy="18" r="2" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Free Shipping Over $50</h4>
                            <p>Fast standard delivery across the nationwide network.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Dispatched in 24–48 Hours</h4>
                            <p>Freshly packed and tracked straight from our spice house.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>30-Day Guarantee</h4>
                            <p>Zero-hassle replacement or 100% full refund on orders.</p>
                        </div>
                    </div>
                </div>

                <h2>1. Order Processing Times</h2>
                <p>We work tirelessly to ensure your dried chilis arrive at your doorstep in peak
                    culinary condition. Orders placed Monday through Friday before <strong>2:00
                        PM</strong> are processed and dispatched within <strong>24 to 48
                        hours</strong>. Orders placed over the weekend or on public holidays are
                    fulfilled on the next business day.</p>
                <p>As soon as your package leaves our fulfillment kitchen, you will receive an
                    automated shipping confirmation email containing your live tracking number and
                    delivery portal link.</p>

                <h2>2. Domestic Shipping Rates & Estimated Delivery</h2>
                <div class="table-responsive">
                    <table class="shipping-table">
                        <thead>
                            <tr>
                                <th>Shipping Method</th>
                                <th>Delivery Estimate</th>
                                <th>Order Value</th>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Standard Shipping</strong></td>
                                <td>3–5 business days</td>
                                <td>Orders $50.00 and above</td>
                                <td><span class="badge-free">FREE</span></td>
                            </tr>
                            <tr>
                                <td><strong>Standard Shipping</strong></td>
                                <td>3–5 business days</td>
                                <td>Orders under $50.00</td>
                                <td>$4.99 flat rate</td>
                            </tr>
                            <tr>
                                <td><strong>Express Priority Shipping</strong></td>
                                <td>1–2 business days</td>
                                <td>All order values</td>
                                <td>$9.99</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>3. International Shipping</h2>
                <p>We are proud to share our fiery heat worldwide! We currently ship to over
                    <strong>50 countries</strong> across Europe, Asia-Pacific, North America, and
                    Australia. International shipments are typically delivered within <strong>7 to
                        14 business days</strong> depending on local customs processing.
                </p>
                <ul>
                    <li>Real-time carrier rates from DHL Express, FedEx, and USPS International are
                        dynamically calculated at checkout.</li>
                    <li><strong>Customs & Duties:</strong> Depending on your country's customs
                        regulations, import duties, taxes, and brokerage fees may be assessed upon
                        arrival. These charges are the recipient's responsibility.</li>
                </ul>

                <h2>4. Package Tracking & Delivery</h2>
                <p>Every single order includes complete door-to-door tracking. You can check the
                    progress of your spice shipment anytime by clicking the tracking link in your
                    confirmation email, or by logging into your account under <a
                        href="{{ route('account.orders') }}">Order History</a>.</p>
                <p>If you have specific delivery instructions (such as gate codes or apartment
                    drop-offs), please include them in the order notes during checkout.</p>

                <h2>5. 30-Day Satisfaction & Refund Policy</h2>
                <p>At <strong>Dried Chili</strong>, we stand behind the exceptional quality, aroma,
                    and fiery flavor of every batch we produce. If you are not 100% satisfied with
                    your purchase, we want to make it right:</p>
                <ul>
                    <li><strong>Unopened Items:</strong> You may return any unopened, factory-sealed
                        chili jars or spice pouches within <strong>30 days</strong> of delivery for
                        a full refund of the product purchase price.</li>
                    <li><strong>Damaged or Incorrect Items:</strong> If your shipment arrives
                        damaged in transit, leaking, or containing an incorrect item, please notify
                        us immediately. You do not need to ship the damaged goods back—simply email
                        us a photo at <a href="mailto:support@driedchili.com">support@driedchili.com</a>, and we
                        will issue an instant replacement or 100% refund.</li>
                </ul>

                <h2>6. How to Initiate a Return</h2>
                <p>Returning an item with Dried Chili is simple and hassle-free:</p>
                <ol class="shipping-steps">
                    <li><strong>Contact Our Team:</strong> Send an email to <a
                            href="mailto:support@driedchili.com">support@driedchili.com</a> with
                        your order number and the item(s) you wish to return.</li>
                    <li><strong>Receive Your Prepaid Label:</strong> Our customer support team will
                        review your request within 24 hours and provide you with return instructions
                        and a prepaid return shipping label.</li>
                    <li><strong>Drop Off Package:</strong> Affix the return label to the original
                        packaging and drop it off at any authorized carrier drop-off location.</li>
                    <li><strong>Refund Issued:</strong> Once your return is received and inspected,
                        your refund will be processed back to your original payment method within
                        <strong>3 to 5 business days</strong>.
                    </li>
                </ol>

                <h2>7. Damaged, Lost, or Stolen Packages</h2>
                <p>While carrier delays and delivery mishaps are rare, we provide full customer
                    protection. If your tracking indicates that your package was delivered but you
                    cannot locate it, please check with household members and neighbors first. If it
                    remains missing after 24 hours, contact us immediately and we will launch an
                    investigation with the carrier and reship your spices promptly.</p>

                <!-- Help Box -->
                <div class="shipping-help-box">
                    <div class="help-box-content">
                        <h3>Need help with a shipment or return?</h3>
                        <p>Our spice specialists are available Monday through Saturday to assist you
                            with any questions.</p>
                    </div>
                    <div class="help-box-actions">
                        <a href="{{ route('contact.page') }}" class="help-btn primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            Contact Support
                        </a>
                        <a href="tel:180024454" class="help-btn outline">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            Call 1800-CHILI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    /* Utilities */
    .bg-cream {
        background-color: var(--spice-bg);
    }

    /* Hero */
    .legal-hero {
        background: var(--spice-bg-dark);
        padding: 0;
        height: 650px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: var(--spice-bg);
    }

    .legal-hero h1 {
        font-family: var(--font-heading);
        font-size: clamp(48px, 4.5vw, 64px);
        font-weight: 800;
        margin: 0 0 1rem 0;
        line-height: 1.08;
        text-transform: uppercase;
    }

    .legal-hero .hero-subtitle {
        max-width: 650px;
        margin-left: auto !important;
        margin-right: auto !important;
        text-align: center;
    }

    /* Document */
    .legal-document {
        padding: 4rem 0 8rem;
    }

    .document-wrapper {
        background: #FFFFFF;
        border-radius: 20px;
        padding: 3.5rem 4rem;
        max-width: 950px;
        margin: 0 auto;
        color: var(--spice-text);
        margin-top: -3.5rem;
        position: relative;
        z-index: 10;
        border: 1px solid rgba(40, 18, 11, 0.08);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.06);
    }

    /* Shipping Highlights */
    .shipping-highlights {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 3.5rem;
        padding-bottom: 3rem;
        border-bottom: 1px solid rgba(40, 18, 11, 0.08);
    }

    .highlight-item {
        background: rgba(240, 230, 221, 0.35);
        border: 1px solid rgba(40, 18, 11, 0.06);
        border-radius: 20px;
        padding: 1.75rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.85rem;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .highlight-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border-color: rgba(228, 93, 62, 0.25);
    }

    .highlight-icon {
        width: 52px;
        height: 52px;
        border-radius: 20px;
        background: rgba(228, 93, 62, 0.1);
        color: var(--spice-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .highlight-text h4 {
        font-family: var(--font-heading);
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--spice-bg-dark);
        margin: 0 0 0.35rem 0;
    }

    .highlight-text p {
        font-family: var(--font-body);
        font-size: 0.88rem;
        color: #6C5A4E;
        margin: 0;
        line-height: 1.5;
    }

    /* Typography in Document */
    .document-wrapper h2 {
        font-family: var(--font-heading);
        color: var(--spice-bg-dark);
        font-size: clamp(30px, 3vw, 40px);
        font-weight: 800;
        margin-top: 3.5rem;
        margin-bottom: 1.25rem;
        letter-spacing: -0.3px;
    }

    .document-wrapper h2:first-of-type {
        margin-top: 0;
    }

    .document-wrapper p,
    .document-wrapper ul,
    .document-wrapper ol {
        font-family: var(--font-body);
        font-size: 15px;
        line-height: 1.65;
        color: #4A3B32;
        margin-bottom: 1.5rem;
        text-align: justify;
        text-justify: inter-word;
        line-height: 1.7;
    }

    .document-wrapper ul,
    .document-wrapper ol {
        padding-left: 2rem;
    }

    .document-wrapper li {
        margin-bottom: 0.75rem;
        line-height: 1.65;
    }

    .document-wrapper a {
        color: var(--spice-primary);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1.5px solid transparent;
        transition: border-color 0.2s ease;
    }

    .document-wrapper a:hover {
        border-color: var(--spice-primary);
    }

    /* Shipping Table */
    .table-responsive {
        overflow-x: auto;
        margin: 1.5rem 0 2.5rem;
        border-radius: 20px;
        border: 1px solid rgba(40, 18, 11, 0.08);
    }

    .shipping-table {
        width: 100%;
        border-collapse: collapse;
        background: #FFFFFF;
        font-family: var(--font-body);
        font-size: 0.95rem;
    }

    .shipping-table th {
        background: rgba(40, 18, 11, 0.04);
        color: var(--spice-bg-dark);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid rgba(40, 18, 11, 0.08);
    }

    .shipping-table td {
        padding: 1.15rem 1.5rem;
        color: #4A3B32;
        border-bottom: 1px solid rgba(40, 18, 11, 0.06);
    }

    .shipping-table tr:last-child td {
        border-bottom: none;
    }

    .badge-free {
        background: rgba(46, 125, 50, 0.12);
        color: #2E7D32;
        font-weight: 700;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    /* Ordered Steps */
    .shipping-steps {
        padding-left: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .shipping-steps li {
        margin-bottom: 1rem;
        padding-left: 0.5rem;
    }

    /* Help Box */
    .shipping-help-box {
        margin-top: 4rem;
        background: rgba(240, 230, 221, 0.5);
        border: 1px solid rgba(40, 18, 11, 0.08);
        border-radius: 20px;
        padding: 2.25rem 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .help-box-content h3 {
        font-family: var(--font-heading);
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--spice-bg-dark);
        margin: 0 0 0.5rem 0;
    }

    .help-box-content p {
        font-family: var(--font-body);
        font-size: 0.95rem;
        color: #5C4B41;
        margin: 0;
        line-height: 1.5;
    }

    .help-box-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .help-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.4rem;
        border-radius: 20px;
        font-family: var(--font-body);
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .help-btn.primary {
        background: var(--spice-primary);
        color: #FFFFFF;
        box-shadow: 0 6px 18px rgba(228, 93, 62, 0.3);
    }

    .help-btn.primary:hover {
        background: var(--spice-accent);
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(199, 59, 27, 0.35);
    }

    .help-btn.outline {
        background: #FFFFFF;
        color: var(--spice-bg-dark);
        border: 1px solid rgba(40, 18, 11, 0.15);
    }

    .help-btn.outline:hover {
        border-color: var(--spice-primary);
        color: var(--spice-primary);
        transform: translateY(-2px);
    }

    @media (max-width: 900px) {
        .shipping-highlights {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .legal-hero h1 {
            font-size: clamp(34px, 7vw, 42px) !important;
        }

        .document-wrapper {
            padding: 2.5rem 1.5rem;
            margin-top: -2rem;
        }

        .shipping-help-box {
            flex-direction: column;
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .help-box-actions {
            flex-direction: column;
            width: 100%;
        }

        .help-btn {
            justify-content: center;
            width: 100%;
        }
    }
</style>
@endsection