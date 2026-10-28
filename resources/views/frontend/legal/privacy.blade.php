@extends('frontend.layouts.master')

@section('meta')
<title>Privacy Policy | Dried Chili - Plain English & Transparent Data Care</title>
<meta name="description"
    content="Read Dried Chili's privacy policy. Written in plain English: how we protect your personal information, handle secure payments, and respect your privacy under Australian standards.">
@endsection

@section('full-content')
@php
$sys = app(\App\Support\SystemSettings::class);
$heroBadge = $sys->get('nafu_home_page_privacy_badge', 'CUSTOMER CARE · YOUR PRIVACY MATTERS');
$heroTitle = $sys->get('nafu_home_page_privacy_title', 'Privacy Policy');
$heroSubtitle = $sys->get('nafu_home_page_privacy_subtitle', 'Simple, Transparent & Safe Data Care');
$heroDesc = $sys->get('nafu_home_page_privacy_desc', 'We treat your personal details with the same care and integrity
that goes into our handcrafted spices. Here is plain-English information on what we collect, why we need it, and how
your privacy is safeguarded under the Australian Privacy Act 1988 and Spam Act 2003.');
$stat1Title = $sys->get('nafu_home_page_privacy_stat1_title', 'Safe Checkout');
$stat1Desc = $sys->get('nafu_home_page_privacy_stat1_desc', 'Encrypted & Private');
$stat2Title = $sys->get('nafu_home_page_privacy_stat2_title', 'Zero Spam');
$stat2Desc = $sys->get('nafu_home_page_privacy_stat2_desc', '1-Click Unsubscribe');
$stat3Title = $sys->get('nafu_home_page_privacy_stat3_title', 'Your Data Control');
$stat3Desc = $sys->get('nafu_home_page_privacy_stat3_desc', 'Update or Delete');

$card1Title = $sys->get('nafu_home_page_privacy_card1_title', 'Honest Data Care');
$card1Text = $sys->get('nafu_home_page_privacy_card1_text', 'We only collect the essential details needed to deliver
your delicious chili orders.');
$card2Title = $sys->get('nafu_home_page_privacy_card2_title', 'Never Sold to Advertisers');
$card2Text = $sys->get('nafu_home_page_privacy_card2_text', 'We never sell, rent, or trade your personal information to
outside marketing firms.');
$card3Title = $sys->get('nafu_home_page_privacy_card3_title', 'You Are In Full Control');
$card3Text = $sys->get('nafu_home_page_privacy_card3_text', 'Easily view, edit, or ask us to remove your account details
anytime you wish.');

$customContent = $sys->get('nafu_home_page_privacy_content');
@endphp

<main class="page-content legal-page bg-cream">
    <!-- Hero Section -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat1Title }}</strong>
                        <span>{{ $stat1Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </div>
                    <div class="cluster-text">
                        <strong>{{ $stat2Title }}</strong>
                        <span>{{ $stat2Desc }}</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <polyline points="16 11 18 13 22 9" />
                        </svg>
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
                <!-- Privacy Highlights Bar -->
                <div class="privacy-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Honest Data Care</h4>
                            <p>We only collect the essential details needed to deliver your delicious chili orders.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>Never Sold to Advertisers</h4>
                            <p>We never sell, rent, or trade your personal information to outside marketing firms.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <polyline points="16 11 18 13 22 9" />
                            </svg>
                        </div>
                        <div class="highlight-text">
                            <h4>You Are In Full Control</h4>
                            <p>Easily view, edit, or ask us to remove your account details anytime you wish.</p>
                        </div>
                    </div>
                </div>

                <h2>1. Our Promise to You</h2>
                <p>Welcome to <strong>Dried Chili</strong> (operated by <strong>Jojo Little Kitchen</strong> in
                    Australia). We know that sharing your personal information requires trust, and we take that
                    responsibility seriously.</p>
                <p>This Privacy Policy explains clearly and simply how we collect, use, and protect your information
                    when you visit our website, explore our artisan spices, or place an order. We operate in full
                    compliance with Australia's <strong>Privacy Act 1988 (Cth)</strong>, the <strong>Australian Privacy Principles</strong>, and the <strong>Spam Act 2003</strong>—written here in straightforward words so you can easily understand your rights.</p>

                <h2>2. What Information We Collect & Why</h2>
                <p>We only ask for details that are genuinely needed to give you a smooth, enjoyable shopping
                    experience. This includes:</p>
                <ul>
                    <li><strong>Your Delivery Details:</strong> Your full name, delivery address, phone number, and
                        email address so we can pack your spice order, hand it to Australia Post, and send you live
                        parcel tracking.</li>
                    <li><strong>Order & Purchase History:</strong> What chili products you ordered, when you ordered
                        them, and copies of your official Australian Tax Invoices.</li>
                    <li><strong>Safe Payment Information:</strong> When you purchase online, your card details are
                        processed directly and securely by certified payment services (Stripe or PayPal). <strong>Dried
                            Chili never sees or saves your credit card numbers on our website.</strong></li>
                    <li><strong>Customer Notes & Feedback:</strong> Any special delivery instructions (like gate codes)
                        or questions you send to our support team so we can assist you quickly.</li>
                    <li><strong>Website Cookies:</strong> Small, helpful files that remember what is inside your
                        shopping cart as you browse our blends, keeping your session active.</li>
                </ul>

                <h2>3. How We Use Your Details</h2>
                <p>We use your information exclusively to run our small-batch spice business and serve you well:</p>
                <ul>
                    <li>To prepare, safely pack, and dispatch your chili jars.</li>
                    <li>To email you order confirmations, tracking numbers, and tax invoices.</li>
                    <li>To assist you with questions, recipe tips, replacements, or refunds.</li>
                    <li>To keep our online store secure against payment fraud.</li>
                    <li>In the rare event of a product advisory or recall, to notify you promptly to protect your food
                        safety.</li>
                </ul>

                <h2>4. Honest Email Communications & No Spam</h2>
                <p>We hate unsolicited junk mail just as much as you do. Under Australia's <strong>Spam Act
                        2003</strong>, we maintain a strict policy:</p>
                <ul>
                    <li>We will <strong>only</strong> send you newsletters, special discounts, or new seasonal harvest
                        alerts if you explicitly signed up to receive them.</li>
                    <li>Every promotional email has an instant, free <strong>1-click Unsubscribe link</strong> right at
                        the bottom. Click it anytime, and you will be removed from our marketing list within 5 business
                        days.</li>
                    <li>We will still email you important transactional updates about your active orders (like your
                        receipt and tracking link) even if you unsubscribe from promotional newsletters.</li>
                </ul>

                <h2>5. Who We Share Information With</h2>
                <p>We never sell, rent, or trade your personal details to outside companies for marketing. We only share
                    the minimum necessary information with trusted partners who help us fulfill your order:</p>
                <ul>
                    <li><strong>Postal Carriers:</strong> Australia Post or express delivery couriers so they can drive
                        the package to your front door.</li>
                    <li><strong>Payment Gateways:</strong> Certified payment partners (Stripe, PayPal) to safely approve
                        your payment.</li>
                    <li><strong>Cloud Infrastructure:</strong> Secure, industry-leading hosting systems that keep our
                        website running smoothly 24/7.</li>
                </ul>

                <h2>6. How We Protect Your Data</h2>
                <p>We use modern, bank-standard security safeguards to protect your personal details. All web traffic on
                    Dried Chili is protected with 256-bit SSL encryption (look for the padlock in your browser address
                    bar). Access to order records is strictly restricted to team members who need it to pack your boxes
                    or answer customer care requests.</p>

                <h2>7. Managing Your Account & Your Privacy Rights</h2>
                <p>You have full control over your personal records:</p>
                <ul>
                    <li><strong>Update Your Details:</strong> You can log into your <a
                            href="{{ route('account.dashboard') }}">Account Dashboard</a> anytime to edit your shipping
                        address, name, or password.</li>
                    <li><strong>Request Your Data or Account Deletion:</strong> If you would like a copy of the personal
                        information we hold for you, or if you want us to remove your account and delete your records,
                        simply email our team at <a href="mailto:privacy@driedchili.com">privacy@driedchili.com</a>. We
                        will respond promptly within 30 days.</li>
                </ul>

                <h2>8. Questions, Feedback & Privacy Officer Contact</h2>
                <p>If you have any questions about how your information is handled, or if you feel something wasn't
                    handled properly, please contact our team first so we can make it right:</p>
                <ul>
                    <li><strong>Business:</strong> Dried Chili / Jojo Little Kitchen Pty Ltd</li>
                    <li><strong>Email:</strong> <a href="mailto:privacy@driedchili.com">privacy@driedchili.com</a></li>
                    <li><strong>Mailing Address:</strong> Privacy Care, Dried Chili, PO Box 412, Sydney NSW 2000,
                        Australia</li>
                    <li><strong>Online Support:</strong> <a href="{{ route('contact.page') }}">Contact Support Form</a>
                    </li>
                </ul>
                <p>You also have the right under Australian law to contact the <strong>Office of the Australian Information Commissioner (OAIC)</strong> at <a href="https://www.oaic.gov.au" target="_blank" rel="noopener noreferrer">www.oaic.gov.au</a> or by calling 1300 363 992.</p>


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
    opacity: 1 !important;
    display: block !important;
    visibility: visible !important;
}

/* Privacy Highlights */
.privacy-highlights {
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
.privacy-help-box {
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
    .privacy-highlights {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .document-wrapper {
        padding: 2.5rem 1.5rem;
        margin-top: -2rem;
    }

    .privacy-help-box {
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