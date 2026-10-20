@extends('frontend.layouts.master')

@section('meta')
<title>Privacy Policy | Dried Chili</title>
@endsection

@section('full-content')
<main class="page-content legal-page bg-cream">
    <!-- Hero Section: Standardized Hero Banner -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>DATA PROTECTION · YOUR PRIVACY MATTERS</span>
            </div>
            
            <h1 class="about-hero-title">
                Privacy Policy<br>
                <span class="highlight-gold">Transparency & Safe Data Care</span>
            </h1>
            
            <p class="about-hero-desc">
                Your personal details, order records, and checkout information are safeguarded with bank-grade security. We never sell your personal data.
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>256-Bit SSL</strong>
                        <span>Bank-Grade Safety</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Zero Selling</strong>
                        <span>Never Shared</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Full Control</strong>
                        <span>Manage Your Data</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Document Section -->
    <section class="legal-document">
        <div class="container reveal">
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
                            <h4>100% Data Protection</h4>
                            <p>Rigorous security standards and encryption protecting your order data.</p>
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
                            <h4>No Third-Party Selling</h4>
                            <p>We never sell, rent, or trade your personal details to outside advertisers.</p>
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
                            <h4>Full User Control</h4>
                            <p>Request data access, profile updates, or total erasure at any time.</p>
                        </div>
                    </div>
                </div>

                <h2>1. Introduction</h2>
                <p>Welcome to <strong>Dried Chili</strong>. We deeply value your trust and are committed to safeguarding
                    your personal data. This privacy policy explains how we collect, handle, store, and protect your
                    information when you visit our website, explore our culinary spices, or place an order, as well as
                    detailing your privacy rights and the legal protections available to you under applicable data
                    privacy laws.</p>

                <h2>2. Data We Collect</h2>
                <p>We may collect, use, store, and transfer different categories of personal information about you,
                    which we have organized as follows:</p>
                <ul>
                    <li><strong>Identity Data:</strong> Includes first name, last name, username or customer account
                        identifier.</li>
                    <li><strong>Contact Data:</strong> Includes billing address, delivery address, email address, and
                        telephone contact numbers.</li>
                    <li><strong>Financial & Payment Data:</strong> Includes payment transaction tokens. Please note that
                        all card details are encrypted and securely processed by certified third-party payment gateways
                        (e.g., Stripe, PayPal); Dried Chili never stores full credit card numbers on our local servers.
                    </li>
                    <li><strong>Transaction Data:</strong> Includes historical details about your spice orders,
                        payments, invoice receipts, and delivery tracking.</li>
                    <li><strong>Technical Data:</strong> Includes internet protocol (IP) address, login credentials,
                        browser type and version, time zone setting, operating system, and platform.</li>
                </ul>

                <h2>3. How We Use Your Data</h2>
                <p>We will only utilize your personal data when permitted by law. Most commonly, we process your
                    information in the following circumstances:</p>
                <ul>
                    <li><strong>Order Fulfillment:</strong> To prepare, package, and ship your spice orders, process
                        payments, and provide live delivery notifications.</li>
                    <li><strong>Customer Support:</strong> To communicate with you regarding order queries, returns,
                        refunds, or product inquiries.</li>
                    <li><strong>Legitimate Interests:</strong> To improve our spice recipes, optimize website usability,
                        and detect fraudulent transactions.</li>
                    <li><strong>Legal Compliance:</strong> To comply with mandatory statutory, tax, or legal reporting
                        obligations.</li>
                </ul>

                <h2>4. Data Security</h2>
                <p>We have instituted robust administrative, technical, and physical security measures to prevent your
                    personal data from being accidentally lost, unauthorizedly accessed, altered, or disclosed. Access
                    to your personal information is strictly restricted to employees, logistics partners, and agents who
                    have an immediate business necessity. They process your data under strict contractual
                    confidentiality obligations.</p>

                <h2>5. Data Retention</h2>
                <p>We retain your personal information only for as long as reasonably necessary to fulfill the purposes
                    for which it was originally collected, including satisfying legal, accounting, tax, or regulatory
                    compliance requirements.</p>

                <h2>6. Your Legal Rights</h2>
                <p>Under global data protection standards (including GDPR and CCPA where applicable), you have rights
                    regarding your personal data, including the right to:</p>
                <ul>
                    <li>Request access to a copy of the personal data we hold about you.</li>
                    <li>Request correction of any incomplete or inaccurate data.</li>
                    <li>Request erasure of your personal data when there is no legitimate reason for us continuing to
                        process it.</li>
                    <li>Object to or restrict the processing of your personal data for direct marketing purposes.</li>
                </ul>
                <p>To exercise any of these privacy rights, please reach out directly to our privacy officer at <a
                        href="mailto:privacy@driedchili.com">privacy@driedchili.com</a>.</p>

                <h2>7. Cookie Policy</h2>
                <p>We utilize cookies and similar tracking technologies to enhance your shopping experience, remember
                    your cart items across sessions, and understand how visitors interact with our artisanal spice
                    catalog. You can instruct your browser to refuse all or certain cookies. However, disabling
                    essential cookies may impact checkout functionality and interactive store features.</p>

                <!-- Help Box -->
                <div class="privacy-help-box">
                    <div class="help-box-content">
                        <h3>Questions about your privacy or data?</h3>
                        <p>Our dedicated compliance specialists are ready to assist with any data access, update, or
                            deletion requests.</p>
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
                        <a href="mailto:privacy@driedchili.com" class="help-btn outline">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            Email Privacy Team
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
    font-size: clamp(30px, 3vw, 40px);
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