@extends('frontend.layouts.master')

@section('meta')
<title>Shipping & Refunds | Dried Chili - Fast Tracked Delivery & Full Guarantee</title>
<meta name="description" content="Dried Chili shipping and refund policy. Fast tracked delivery across Australia, all-inclusive AUD rates with GST, and our worry-free replacement guarantee.">
@endsection

@section('full-content')
@php
    $sys = app(\App\Support\SystemSettings::class);
    $heroBadge = $sys->get('nafu_home_page_shipping_badge', 'AUSTRALIAN DELIVERY & REFUNDS · 100% RISK-FREE');
    $heroTitle = $sys->get('nafu_home_page_shipping_title', 'Fast Tracked Shipping');
    $heroSubtitle = $sys->get('nafu_home_page_shipping_subtitle', 'Carefully Packed & 100% Guaranteed');
    $heroDesc = $sys->get('nafu_home_page_shipping_desc', 'Every jar of Dried Chili is wrapped with protective cushioning and airtight tamper-evident seals. Dispatched across Australia with transparent AUD pricing, GST included, and backed by Australian Consumer Law protections.');
    $stat1Title = $sys->get('nafu_home_page_shipping_stat1_title', 'Free Over $50 AUD');
    $stat1Desc = $sys->get('nafu_home_page_shipping_stat1_desc', 'Australia-Wide');
    $stat2Title = $sys->get('nafu_home_page_shipping_stat2_title', '24–48h Dispatch');
    $stat2Desc = $sys->get('nafu_home_page_shipping_stat2_desc', 'Tracked Transit');
    $stat3Title = $sys->get('nafu_home_page_shipping_stat3_title', 'Free Replacement');
    $stat3Desc = $sys->get('nafu_home_page_shipping_stat3_desc', 'If Damaged in Transit');

    $card1Title = $sys->get('nafu_home_page_shipping_card1_title', 'Tracked Australia Post & Couriers');
    $card1Text = $sys->get('nafu_home_page_shipping_card1_text', 'Every parcel includes full tracking and email updates from door to door.');
    $card2Title = $sys->get('nafu_home_page_shipping_card2_title', '100% Transit Guarantee');
    $card2Text = $sys->get('nafu_home_page_shipping_card2_text', 'If glass arrives broken or compromised, we replace or refund immediately.');
    $card3Title = $sys->get('nafu_home_page_shipping_card3_title', 'All-Inclusive Shipping Rates');
    $card3Text = $sys->get('nafu_home_page_shipping_card3_text', 'All delivery charges include 10% GST with zero surprise handling fees at checkout.');

    $customContent = $sys->get('nafu_home_page_shipping_content');
@endphp

<main class="page-content legal-page bg-cream">
    <!-- Hero Section -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                <span>{{ $heroBadge }}</span>
            </div>
            
            <h1 class="about-hero-title">
                {{ $heroTitle }}<br>
                <span class="highlight-gold">{{ $heroSubtitle }}</span>
            </h1>
            
            <p class="about-hero-desc">
                {{ $heroDesc }}
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat1Title }}</strong>
                        <span>{{ $stat1Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat2Title }}</strong>
                        <span>{{ $stat2Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat3Title }}</strong>
                        <span>{{ $stat3Desc }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Document Section -->
    <section class="legal-document">
        <div class="container">
            <div class="document-wrapper shadow-lg">
                <!-- Highlight Bar -->
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
                            <h4>Tracked Nationwide</h4>
                            <p>Fast, reliable dispatch via Australia Post with live door-to-door tracking links.</p>
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
                            <h4>All Taxes Included</h4>
                            <p>Prices in AUD with 10% GST included. Official tax invoice sent upon purchase.</p>
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
                            <h4>Full Transit Protection</h4>
                            <p>Arrived cracked or leaking? We will replace it immediately free of charge.</p>
                        </div>
                    </div>
                </div>

                <!-- Statutory Notice Box -->
                <div class="statutory-notice-box">
                    <div class="statutory-notice-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                    <div class="statutory-notice-body">
                        <h4>Australian Consumer Guarantee</h4>
                        <p><strong>Our goods come with guarantees that cannot be excluded under the Australian Consumer Law.</strong> You are entitled to a replacement or refund for a Major Failure and compensation for any other reasonably foreseeable loss or damage. You are also entitled to have the goods repaired or replaced if the goods fail to be of acceptable quality and the failure does not amount to a Major Failure (Minor Failure).</p>
                    </div>
                </div>

                <h2>1. How We Pack & Dispatch Your Order</h2>
                <p>We take pride in making sure your artisanal dried chilis reach you fresh, fragrant, and intact:</p>
                <ul>
                    <li><strong>Dispatch Time:</strong> Orders placed Monday through Friday before <strong>2:00 PM AEST</strong> are packed and handed to our couriers within <strong>24 to 48 hours</strong>. Orders placed over the weekend or on public holidays are dispatched the next business day.</li>
                    <li><strong>Protective Packaging:</strong> Glass jars are individually cushioned in shock-absorbing wrapping and sealed with airtight, tamper-evident security bands to keep aroma locked in and prevent transit damage.</li>
                    <li><strong>Live Tracking:</strong> As soon as your order leaves our kitchen, you'll receive an automated email with your Australia Post tracking link so you can follow its journey.</li>
                </ul>

                <h2>2. Domestic Australian Delivery Rates (AUD, GST Included)</h2>
                <p>In accordance with the <strong>GST Act 1999</strong>, all shipping rates are quoted in Australian Dollars (AUD) and include 10% Australian GST:</p>
                <div class="table-responsive">
                    <table class="shipping-table">
                        <thead>
                            <tr>
                                <th>Delivery Option</th>
                                <th>Estimated Delivery Time</th>
                                <th>Order Value</th>
                                <th>Shipping Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Standard Australia Post</strong></td>
                                <td>3–5 business days (Metro)<br>4–7 business days (Regional)</td>
                                <td>Orders $50.00 AUD and above</td>
                                <td><span class="badge-free">FREE</span></td>
                            </tr>
                            <tr>
                                <td><strong>Standard Australia Post</strong></td>
                                <td>3–5 business days (Metro)<br>4–7 business days (Regional)</td>
                                <td>Orders under $50.00 AUD</td>
                                <td>$4.99 AUD</td>
                            </tr>
                            <tr>
                                <td><strong>Express Priority Delivery</strong></td>
                                <td>1–2 business days (National network)</td>
                                <td>All order values</td>
                                <td>$9.99 AUD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>3. Worldwide Shipping</h2>
                <p>We love sending our spicy blends to heat lovers across the globe! We ship to over 50 countries via DHL Express and FedEx International:</p>
                <ul>
                    <li>Delivery times typically range between <strong>7 to 14 business days</strong> depending on destination customs clearance.</li>
                    <li><strong>Tax-Free Export:</strong> Australian GST is automatically deducted at checkout once your overseas delivery address is confirmed. Any local import duties or customs tariffs in your destination country are the responsibility of the recipient.</li>
                </ul>

                <h2>4. What If a Jar Arrives Damaged, Leaking, or Broken?</h2>
                <p>While postal accidents are rare, you are completely protected. If your parcel arrives damaged in transit, with broken glass, or with a broken seal:</p>
                <ul>
                    <li><strong>No need to return broken glass:</strong> For your safety, please do not mail sharp or broken glass back to us.</li>
                    <li><strong>Quick resolution:</strong> Take a clear photo of the damaged jar and email it to <a href="mailto:support@driedchili.com">support@driedchili.com</a> with your order number.</li>
                    <li><strong>Your choice of remedy:</strong> We will dispatch an immediate replacement via express post at no extra cost, or issue an instant 100% full refund (including any delivery fees paid).</li>
                </ul>

                <h2>5. 30-Day Change-of-Mind Policy</h2>
                <p>We want you to be confident in your purchase:</p>
                <ul>
                    <li><strong>Unopened Jars:</strong> If you change your mind, you can return any unopened jar or spice pouch with the factory tamper seal intact within <strong>30 days</strong> of delivery for a full refund of the product purchase price.</li>
                    <li><strong>Food Hygiene Safety:</strong> In line with the <strong>Australia New Zealand Food Standards Code</strong> and state food safety hygiene regulations, we cannot accept returns on jars that have already been opened, unsealed, or tasted. This rule never affects your consumer rights if the item arrived damaged or spoiled.</li>
                </ul>

                <h2>6. How to Request a Return or Replacement</h2>
                <ol class="shipping-steps">
                    <li><strong>Contact Our Team:</strong> Send a quick email to <a href="mailto:support@driedchili.com">support@driedchili.com</a> with your order number and photo (if an item arrived damaged).</li>
                    <li><strong>Fast Assessment:</strong> Our Australian customer support team will reply within <strong>24 business hours</strong> with confirmation and return instructions.</li>
                    <li><strong>Replacement or Refund:</strong> Your replacement will be dispatched immediately, or your refund will be returned to your original payment method (card, Stripe, or PayPal) within <strong>3 to 5 business days</strong>.</li>
                </ol>

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
    background: #1F0701;
}

/* Document */
.legal-document {
    padding: 4rem 0 8rem;
}

.legal-document .container {
    opacity: 1 !important;
    transform: none !important;
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
    margin-bottom: 2.5rem;
    padding-bottom: 2.5rem;
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

/* Statutory Notice Box */
.statutory-notice-box {
    background: #FFF7ED;
    border: 2px solid #F97316;
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    margin-bottom: 3rem;
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
}

.statutory-notice-icon {
    color: #EA580C;
    flex-shrink: 0;
    margin-top: 0.25rem;
}

.statutory-notice-body h4 {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    font-weight: 800;
    color: #9A3412;
    margin: 0 0 0.5rem 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.statutory-notice-body p {
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: #7C2D12;
    margin: 0;
    line-height: 1.6;
}

/* Typography in Document */
.document-wrapper h2 {
    font-family: var(--font-heading);
    color: var(--spice-bg-dark);
    font-size: clamp(26px, 2.5vw, 34px);
    font-weight: 800;
    margin-top: 3.5rem;
    margin-bottom: 1.25rem;
    letter-spacing: -0.3px;
}

.document-wrapper h2:first-of-type {
    margin-top: 0;
}

.document-wrapper p {
    font-family: var(--font-body);
    font-size: 15px;
    color: #4A3B32;
    margin-bottom: 1.5rem;
    text-align: justify;
    text-justify: inter-word;
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
    line-height: 1.7;
}

.document-wrapper ul,
.document-wrapper ol {
    font-family: var(--font-body);
    font-size: 15px;
    color: #4A3B32;
    margin-bottom: 1.5rem;
    text-align: left;
    line-height: 1.7;
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
    margin: 1.5rem 0 2rem;
}

.shipping-table {
    width: 100%;
    border-collapse: collapse;
    background: #FFFFFF;
    border: 1px solid rgba(40, 18, 11, 0.1);
    border-radius: 12px;
    overflow: hidden;
}

.shipping-table th {
    background: #2D140D;
    color: #FFFFFF;
    font-family: var(--font-heading);
    font-size: 0.95rem;
    font-weight: 700;
    padding: 1rem 1.25rem;
    text-align: left;
}

.shipping-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.08);
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: #4A3B32;
}

.shipping-table tr:last-child td {
    border-bottom: none;
}

.badge-free {
    display: inline-block;
    background: #15803D;
    color: #FFFFFF;
    font-weight: 800;
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

/* Steps */
.shipping-steps {
    counter-reset: custom-step;
    list-style: none;
    padding-left: 0;
}

.shipping-steps li {
    position: relative;
    padding-left: 3.25rem;
    margin-bottom: 1.5rem;
}

.shipping-steps li::before {
    counter-increment: custom-step;
    content: counter(custom-step);
    position: absolute;
    left: 0;
    top: 0;
    width: 2.25rem;
    height: 2.25rem;
    background: rgba(228, 93, 62, 0.12);
    color: var(--spice-primary);
    font-family: var(--font-heading);
    font-weight: 800;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
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
