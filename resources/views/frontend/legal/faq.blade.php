@extends('frontend.layouts.master')

@section('meta')
    <title>Frequently Asked Questions | Dried Chili - Plain English Answers & Customer Care</title>
    <meta name="description" content="Find clear, friendly answers to common questions about Dried Chili spices, heat levels, allergens, shipping, Australian Consumer Law guarantees, and GST.">
@endsection

@section('full-content')
@php
    $sys = app(\App\Support\SystemSettings::class);
    $heroBadge = $sys->get('nafu_home_page_faq_badge', 'HELP CENTER · COMMONLY ASKED QUESTIONS');
    $heroTitle = $sys->get('nafu_home_page_faq_title', 'Frequently Asked Questions');
    $heroSubtitle = $sys->get('nafu_home_page_faq_subtitle', 'Clear Answers for Every Spice Lover');
    $heroDesc = $sys->get('nafu_home_page_faq_desc', 'From spice heat levels and allergen safety to delivery times, fair returns, and all-inclusive AUD pricing — here are clear answers to the questions our customers ask most.');
    $stat1Title = $sys->get('nafu_home_page_faq_stat1_title', 'Protected Shopping');
    $stat1Desc = $sys->get('nafu_home_page_faq_stat1_desc', 'Australian Consumer Law');
    $stat2Title = $sys->get('nafu_home_page_faq_stat2_title', 'All-Inclusive AUD');
    $stat2Desc = $sys->get('nafu_home_page_faq_stat2_desc', '10% GST Included');
    $stat3Title = $sys->get('nafu_home_page_faq_stat3_title', 'Honest Ingredients');
    $stat3Desc = $sys->get('nafu_home_page_faq_stat3_desc', 'Food Standards & Origin');

    $customIntro = $sys->get('nafu_home_page_faq_intro');
@endphp

<main class="page-content legal-page bg-cream">
    <!-- Hero Section -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat3Title }}</strong>
                        <span>{{ $stat3Desc }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Accordion Section -->
    <section class="legal-document">
        <div class="container">
            <div class="document-wrapper shadow-lg">
                <!-- Category Highlights Bar -->
                <div class="faq-categories">
                    <button type="button" class="faq-cat-btn active" data-filter="all">All Questions</button>
                    <button type="button" class="faq-cat-btn" data-filter="compliance">Ordering & Consumer Law</button>
                    <button type="button" class="faq-cat-btn" data-filter="product">Food Standards & Allergens</button>
                    <button type="button" class="faq-cat-btn" data-filter="shipping">Shipping & Refunds</button>
                    <button type="button" class="faq-cat-btn" data-filter="privacy">Privacy & Email</button>
                    <button type="button" class="faq-cat-btn" data-filter="storage">Storage & Freshness</button>
                </div>

                <!-- FAQ List -->
                <div class="faq-list-container">
                    @if(isset($faqs) && $faqs->count() > 0)
                        @foreach($faqs as $index => $faq)
                        @php
                            $qLower = strtolower($faq->question);
                            $category = 'product';
                            if (str_contains($qLower, 'acl') || str_contains($qLower, 'law') || str_contains($qLower, 'gst') || str_contains($qLower, 'tax') || str_contains($qLower, 'unit price')) {
                                $category = 'compliance';
                            } elseif (str_contains($qLower, 'ship') || str_contains($qLower, 'order') || str_contains($qLower, 'return') || str_contains($qLower, 'refund') || str_contains($qLower, 'delivery')) {
                                $category = 'shipping';
                            } elseif (str_contains($qLower, 'privacy') || str_contains($qLower, 'spam') || str_contains($qLower, 'email') || str_contains($qLower, 'unsubscribe') || str_contains($qLower, 'data')) {
                                $category = 'privacy';
                            } elseif (str_contains($qLower, 'store') || str_contains($qLower, 'shelf') || str_contains($qLower, 'safety') || str_contains($qLower, 'best before')) {
                                $category = 'storage';
                            }
                        @endphp
                        <details class="faq-accordion-item" data-category="{{ $category }}" {{ $index == 0 ? 'open' : '' }}>
                            <summary class="faq-header">
                                <span class="faq-question">{{ $faq->question }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </details>
                        @endforeach
                    @else
                        <!-- Comprehensive Plain-English Customer FAQs -->
                        
                        <!-- 1. Consumer Law & Pricing (ACL, GST, Unit Pricing) -->
                        <details class="faq-accordion-item" data-category="compliance" open>
                            <summary class="faq-header">
                                <span class="faq-question">What guarantees protect my purchase under the Australian Consumer Law?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>As an Australian shopper, you are fully protected by the <strong>Australian Consumer Law</strong>. All our spices and chili blends come with automatic guarantees that cannot be excluded. You are entitled to products that are safe, of premium culinary quality, and accurately described. If your order ever arrives damaged, leaking, unsealed, or not as described, you have the right to an immediate replacement or a full refund.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="compliance">
                            <summary class="faq-header">
                                <span class="faq-question">Are all prices in Australian Dollars (AUD) and do they include GST?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>Yes! All prices across our Australian store are displayed in Australian Dollars (AUD) with 10% Goods and Services Tax (GST) already included. What you see on our product pages is exactly what you pay at checkout with zero surprise surcharges. An official Australian Tax Invoice showing our ABN and the GST amount is emailed automatically with every order.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="compliance">
                            <summary class="faq-header">
                                <span class="faq-question">How does Unit Pricing work on your store?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>To help you easily compare value across different jar sizes and blends, we follow the Australian <strong>Unit Pricing Code</strong>. Every product listing displays both the total package price and the standard unit price (such as price per 100 grams), alongside certified metric net weights (strictly excluding the glass jar weight).</p>
                            </div>
                        </details>

                        <!-- 2. Food Standards & Allergens (FSANZ, PEAL, Origin) -->
                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">Are your chili products allergen-safe, vegan, or gluten-free?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>We take food safety and allergen transparency very seriously under the <strong>Australia New Zealand Food Standards Code</strong>. All ingredients and allergens are clearly declared in plain English on both our website and product labels. For example, our signature <strong>Shrimp Chilli</strong> clearly highlights dried shrimp (crustacea) and sesame. Meanwhile, our pure chili flakes and whole dried pods are 100% plant-based, gluten-free, and prepared with zero artificial colors or preservatives.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">Where are your ingredients sourced and grown?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>In accordance with Australia's <strong>Country of Origin Food Labelling</strong> rules, every jar and pouch displays clear origin information. For our handcrafted blends combining specialty imported peppers (such as Ghost Pepper, Bird's Eye, and Habanero) with fresh Australian garlic, shallots, and cold-pressed Australian oils, our packaging openly shows the percentage of Australian ingredients.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">How spicy are Dried Chili blends, and how is heat measured?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>Our collection spans from mild, fruity, and aromatic (such as Ancho chili at 1,000–2,000 Scoville Heat Units) to scorching heat (like our Ghost Pepper and Carolina Reaper blends exceeding 800,000 SHU). Every product displays an easy-to-read 1-to-5 flame rating and Scoville estimate so you know exactly what level of heat you are getting into.</p>
                            </div>
                        </details>

                        <!-- 3. Shipping & Refunds (ACL Remedies, Delivery Times) -->
                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">What are your shipping times and delivery rates across Australia?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>Orders placed Monday to Friday before 2:00 PM AEST are packed and dispatched within 24 to 48 hours. Standard Australia Post delivery takes 3 to 5 business days for metro areas (4 to 7 for regional), and Express Priority arrives in 1 to 2 business days. We provide Free Standard Shipping on all Australian orders of $50.00 AUD or more ($4.99 AUD under $50, or $9.99 AUD for Express).</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">Can I return an opened jar of chili if I change my mind?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>We offer a 30-day return policy on any unopened jar or spice pouch with the factory tamper seal intact for a full product refund. Under Australian food safety laws and state food hygiene regulations (such as the NSW Food Act), we cannot accept returns on jars once opened, unsealed, or tasted, due to health and safety risks. However, this hygiene rule never affects your statutory rights: if a jar arrives broken, damaged, or defective, we will gladly replace it or issue a full refund immediately.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">What if a jar arrives cracked, leaking, or broken in the mail?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>You are completely protected by our damage replacement guarantee. For your safety, do not mail broken glass back to us. Simply take a quick photo of the damaged package and email it to <a href="mailto:support@driedchili.com">support@driedchili.com</a> with your order number. We will dispatch a brand-new replacement via express post right away or give you a full 100% refund.</p>
                            </div>
                        </details>

                        <!-- 4. Privacy & Email (Privacy Act 1988, Spam Act 2003) -->
                        <details class="faq-accordion-item" data-category="privacy">
                            <summary class="faq-header">
                                <span class="faq-question">How is my personal information protected under the Privacy Act 1988?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>We respect your personal details under the <strong>Privacy Act 1988</strong> and the <strong>Australian Privacy Principles</strong>. We only collect the necessary information to deliver your orders and manage your account. We never sell, rent, or trade your personal data to advertisers. Online payments are processed through secure, bank-level encrypted checkout partners (Stripe and PayPal), so your card numbers are never stored on our website.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="privacy">
                            <summary class="faq-header">
                                <span class="faq-question">Will I receive spam emails, and how do I unsubscribe under the Spam Act 2003?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>We hate spam as much as you do. Under Australia's <strong>Spam Act 2003</strong>, we only send newsletters or special recipe discounts if you explicitly chose to opt in. Every marketing email includes a quick <strong>1-click Unsubscribe link</strong> at the bottom, and you can opt out instantly anytime at no cost.</p>
                            </div>
                        </details>

                        <!-- 5. Food Safety & Storage (FSANZ & State Food Acts) -->
                        <details class="faq-accordion-item" data-category="storage">
                            <summary class="faq-header">
                                <span class="faq-question">How are your chili products prepared and kept food-safe?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>All our chili blends and sauces are produced in registered commercial food premises overseen by state food authorities and certified Food Safety Supervisors. We maintain strict hygiene protocols, routine temperature monitoring, and dedicated allergen separation to ensure every jar is clean, fresh, and safe.</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="storage">
                            <summary class="faq-header">
                                <span class="faq-question">How should I store dried chilies to preserve peak aroma and shelf life?</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>Store your chili jars tightly sealed in a cool, dark, and dry pantry away from direct sunlight, stovetop heat, and humidity. Always use a clean, dry spoon to avoid introducing moisture into chili crisp jars. Sealed jars have an optimal Best Before shelf life of up to 18 to 24 months from the production date printed on the base.</p>
                            </div>
                        </details>
                    @endif
                </div>

            </div>
        </div>
    </section>
</main>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            Contact Support
                        </a>
                        <a href="mailto:support@driedchili.com" class="help-btn outline">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            Email Customer Care
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

/* Category Filter Bar */
.faq-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.08);
}

.faq-cat-btn {
    padding: 0.65rem 1.25rem;
    border-radius: 30px;
    border: 1px solid rgba(40, 18, 11, 0.15);
    background: #FFFFFF;
    color: var(--spice-bg-dark);
    font-family: var(--font-body);
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}

.faq-cat-btn:hover {
    border-color: var(--spice-primary);
    color: var(--spice-primary);
    transform: translateY(-2px);
}

.faq-cat-btn.active {
    background: var(--spice-primary);
    color: #FFFFFF;
    border-color: var(--spice-primary);
    box-shadow: 0 4px 12px rgba(228, 93, 62, 0.25);
}

/* Accordion Item */
.faq-accordion-item {
    border: 1px solid rgba(40, 18, 11, 0.1);
    border-radius: 14px;
    margin-bottom: 1rem;
    background: #FFFFFF;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
}

.faq-accordion-item[open] {
    border-color: var(--spice-primary);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
}

.faq-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    cursor: pointer;
    user-select: none;
    background: rgba(240, 230, 221, 0.15);
    transition: background 0.2s ease;
}

.faq-header:hover {
    background: rgba(240, 230, 221, 0.35);
}

.faq-question {
    font-family: var(--font-heading);
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--spice-bg-dark);
    margin: 0;
    line-height: 1.45;
}

.faq-chevron {
    color: var(--spice-primary);
    transition: transform 0.25s ease;
    flex-shrink: 0;
    margin-left: 1rem;
}

.faq-accordion-item[open] .faq-chevron {
    transform: rotate(180deg);
}

.faq-content {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid rgba(40, 18, 11, 0.06);
    background: #FFFFFF;
}

.faq-content p {
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: #4A3B32;
    line-height: 1.7;
    margin: 0 0 0.85rem 0;
    text-align: justify;
    text-justify: inter-word;
    text-align-last: left;
}

.faq-content p:last-child {
    margin-bottom: 0;
}

.faq-content a {
    color: var(--spice-primary);
    font-weight: 600;
    text-decoration: underline;
}

/* Help Box */
.faq-help-box {
    margin-top: 3.5rem;
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

@media (max-width: 768px) {
    .document-wrapper {
        padding: 2.5rem 1.5rem;
        margin-top: -2rem;
    }
    .faq-categories {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.75rem;
    }
    .faq-cat-btn {
        flex-shrink: 0;
    }
    .faq-help-box {
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.faq-cat-btn');
    const faqItems = document.querySelectorAll('.faq-accordion-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            faqItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
