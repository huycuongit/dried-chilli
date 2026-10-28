@extends('frontend.layouts.master')

@section('meta')
<title>Terms of Service | Dried Chili - Fair, Transparent & Customer First</title>
<meta name="description" content="Read Dried Chili's terms of service. Clear, friendly policies on AUD pricing inclusive of GST, Australian Consumer Law guarantees, food safety, and customer care.">
@endsection

@section('full-content')
@php
    $sys = app(\App\Support\SystemSettings::class);
    $heroBadge = $sys->get('nafu_home_page_terms_badge', 'SHOPPING WITH US · FAIR & TRANSPARENT TERMS');
    $heroTitle = $sys->get('nafu_home_page_terms_title', 'Terms of Service');
    $heroSubtitle = $sys->get('nafu_home_page_terms_subtitle', 'Clear, Friendly & Built on Trust');
    $heroDesc = $sys->get('nafu_home_page_terms_desc', 'We believe buying gourmet spices should be straightforward and enjoyable. Here are our plain-English terms covering all-inclusive AUD pricing, Australian Consumer Law protections, food safety, and customer care.');
    $stat1Title = $sys->get('nafu_home_page_terms_stat1_title', 'Consumer Rights');
    $stat1Desc = $sys->get('nafu_home_page_terms_stat1_desc', 'ACL Protected');
    $stat2Title = $sys->get('nafu_home_page_terms_stat2_title', 'All-Inclusive AUD');
    $stat2Desc = $sys->get('nafu_home_page_terms_stat2_desc', '10% Tax Included');
    $stat3Title = $sys->get('nafu_home_page_terms_stat3_title', 'Kitchen Certified');
    $stat3Desc = $sys->get('nafu_home_page_terms_stat3_desc', 'Food Standards Assured');

    $card1Title = $sys->get('nafu_home_page_terms_card1_title', 'No Hidden Surcharges');
    $card1Text = $sys->get('nafu_home_page_terms_card1_text', 'All prices are in Australian Dollars with 10% GST included. What you see is what you pay.');
    $card2Title = $sys->get('nafu_home_page_terms_card2_title', 'Australian Consumer Law');
    $card2Text = $sys->get('nafu_home_page_terms_card2_text', 'Our products come with non-excludable statutory guarantees under the Australian Consumer Law.');
    $card3Title = $sys->get('nafu_home_page_terms_card3_title', 'Safe, Certified Kitchen');
    $card3Text = $sys->get('nafu_home_page_terms_card3_text', 'Prepared under Australia New Zealand Food Standards Code and State Food Acts.');

    $customContent = $sys->get('nafu_home_page_terms_content');
@endphp

<main class="page-content legal-page bg-cream">
    <!-- Hero Section -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat1Title }}</strong>
                        <span>{{ $stat1Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat2Title }}</strong>
                        <span>{{ $stat2Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
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
                <!-- Terms Highlights Bar -->
                <div class="terms-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>No Hidden Surcharges</h4>
                            <p>All prices are in Australian Dollars with 10% GST included. What you see is what you pay.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Automatic Quality Guarantees</h4>
                            <p>Full statutory protections under the Australian Consumer Law if anything goes wrong.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="8" r="7" />
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Small-Batch Food Safety</h4>
                            <p>Crafted in licensed kitchens with clear allergen declarations and airtight tamper seals.</p>
                        </div>
                    </div>
                </div>

                <h2>1. Welcome to Dried Chili</h2>
                <p>Welcome to <strong>Dried Chili</strong> (operated by <strong>Jojo Little Kitchen</strong> in Australia). These Terms of Service outline how our store operates and what you can expect when ordering our small-batch culinary spices.</p>
                <p>By exploring our website, setting up an account, or purchasing from our store, you agree to these friendly, straightforward terms, alongside our <a href="{{ route('page.privacy') }}">Privacy Policy</a> and <a href="{{ route('page.shipping') }}">Shipping & Refund Policy</a>. These terms are governed by the laws of New South Wales and the Commonwealth of Australia.</p>

                <h2>2. Your Automatic Rights Under Australian Consumer Law</h2>
                <p>Your satisfaction and peace of mind come first. Under the <strong>Australian Consumer Law (ACL)</strong>, all products you purchase from Dried Chili come with statutory consumer guarantees that cannot be excluded:</p>
                <ul>
                    <li>Our products must be of acceptable quality, safe for consumption, and free from defects.</li>
                    <li>They must accurately match the descriptions and photos on our store.</li>
                    <li>They must be fit for their intended culinary purpose.</li>
                </ul>
                <p>Nothing in these terms limits, removes, or weakens your statutory consumer rights. If a jar arrives broken, unsealed, spoiled, or defective, we will make it right with an immediate replacement or full refund.</p>

                <h2>3. Clear Pricing: Australian Dollars (AUD) & 10% GST Included</h2>
                <p>We believe in 100% price transparency with zero surprise fees in accordance with the <strong>A New Tax System (Goods and Services Tax) Act 1999</strong> and Section 48 of the Australian Consumer Law:</p>
                <ul>
                    <li><strong>Australian Dollars (AUD):</strong> Every product price and shipping rate is displayed in AUD.</li>
                    <li><strong>GST Included:</strong> All prices already include the 10% Australian Goods and Services Tax (GST). What you see on the product page is exactly what you pay at checkout.</li>
                    <li><strong>Tax Invoice Provided:</strong> As soon as your order is confirmed, an official Australian Tax Invoice showing our Australian Business Number (ABN) and the exact GST component is emailed to you.</li>
                </ul>

                <h2>4. Net Weight & Easy Value Comparison (Unit Pricing Code)</h2>
                <p>We want you to know exactly what you are getting, adhering to Australia's <strong>Unit Pricing Code</strong>:</p>
                <ul>
                    <li>Every spice product clearly states its certified net weight (such as 100g, 180g, or 250g) in metric units, strictly excluding the weight of the glass jar or pouch.</li>
                    <li>We display the standard <strong>Unit price (price per 100 grams)</strong> right next to the product price, making it easy to compare value across our range.</li>
                </ul>

                <h2>5. Small-Batch Food Safety & Clear Allergen Notices</h2>
                <p>As passionate food artisans, food hygiene, safety, and allergen honesty are paramount. We strictly follow the <strong>Australia New Zealand Food Standards Code</strong> and state health regulations:</p>
                <ul>
                    <li><strong>Clear Allergen Warnings:</strong> We prominently declare any allergens on product listings and physical labels. For instance, our signature <strong>Shrimp Chilli</strong> contains dried seafood (crustacea) and sesame seeds. Our pure single-origin dried chili flakes and whole pods are vegan, gluten-free, and prepared without artificial colorings or preservatives.</li>
                    <li><strong>Freshness & Shelf Life:</strong> Every jar features a clearly printed "Best Before" date and lot number. When stored sealed in a cool, dry pantry, our spices maintain peak aroma and crispness for up to 18 to 24 months.</li>
                    <li><strong>Licensed Kitchens:</strong> Our chili recipes are crafted in registered commercial food premises overseen by certified Food Safety Supervisors.</li>
                </ul>

                <h2>6. Honest Country of Origin Labelling</h2>
                <p>In accordance with Australia's <strong>Country of Origin Food Labelling Information Standard 2016</strong>, our products state clearly where their ingredients are sourced. Where specialty imported peppers (such as Ghost Pepper, Bird's Eye, or Habanero) are blended with fresh Australian garlic, shallots, and cold-pressed Australian oils, our packaging openly shows the percentage of Australian ingredients.</p>

                <h2>7. Ordering, Delivery & Safe Payments</h2>
                <p>Shopping on our store is secure and simple:</p>
                <ul>
                    <li>You can checkout quickly using major credit cards, Stripe, Apple Pay, or PayPal. All transactions are securely encrypted.</li>
                    <li>Orders are typically dispatched from our fulfillment kitchen within 24 to 48 hours (Monday to Friday).</li>
                    <li>You will receive a live Australia Post tracking number as soon as your box is scanned into the postal network.</li>
                    <li>In the rare event of an unexpected inventory stockout, we will notify you right away and issue a prompt 100% refund.</li>
                </ul>

                <h2>8. Enjoying Hot Spices Responsibly</h2>
                <p>Our chili products range from gentle, smoky table seasonings to extreme Scoville heats (including Carolina Reaper and Ghost Pepper):</p>
                <ul>
                    <li>Please taste test in small quantities if you are trying a fiery blend for the first time.</li>
                    <li>Always wash your hands thoroughly after handling potent dried peppers, and keep extremely spicy jars out of reach of young children and pets.</li>
                </ul>

                <h2>9. Returns, Replacements & Hygiene Rules</h2>
                <p>Our returns process is fair and customer-friendly:</p>
                <ul>
                    <li><strong>Damaged or Defective Jars:</strong> If Australia Post mishandles your box and a jar arrives cracked, leaking, or with a broken seal, take a quick photo and email us. We will dispatch an immediate replacement or issue a full refund right away.</li>
                    <li><strong>30-Day Change of Mind:</strong> We gladly accept returns on unopened jars with original factory safety seals intact within 30 days of delivery.</li>
                    <li><strong>Food Hygiene Exclusion:</strong> Because food safety matters to everyone, state food health regulations mean we cannot accept returns on jars that have already been opened or tasted. This rule never affects your legal rights if the product arrives damaged or defective.</li>
                </ul>

                <h2>10. Respectful Communications & Intellectual Property</h2>
                <p>Our recipes, culinary stories, graphics, and photos are the creative work of Dried Chili / Jojo Little Kitchen. Please don't copy or use them for commercial purposes without our permission.</p>
                <p>When you subscribe to our newsletter, you can leave anytime with one click. We never send unsolicited spam.</p>

                <h2>11. Getting in Touch & Friendly Customer Care</h2>
                <p>If you have any questions about an order, need culinary recipe advice, or want to discuss your purchase, our friendly Australian team is here to help:</p>
                <ul>
                    <li><strong>Company:</strong> Dried Chili / Jojo Little Kitchen Pty Ltd</li>
                    <li><strong>Email:</strong> <a href="mailto:support@driedchili.com">support@driedchili.com</a></li>
                    <li><strong>Phone:</strong> 1800 244 547 (Mon–Fri, 9:00 AM – 5:00 PM AEST)</li>
                    <li><strong>Postal Address:</strong> Dried Chili Customer Care, PO Box 412, Sydney NSW 2000, Australia</li>
                    <li><strong>Online Help:</strong> <a href="{{ route('contact.page') }}">Online Contact Form</a></li>
                </ul>

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

/* Terms Highlights */
.terms-highlights {
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

/* Help Box */
.terms-help-box {
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
    .terms-highlights {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .document-wrapper {
        padding: 2.5rem 1.5rem;
        margin-top: -2rem;
    }

    .terms-help-box {
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
