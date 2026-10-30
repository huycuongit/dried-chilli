@extends('frontend.layouts.master')

@section('meta')
<title>Privacy Policy | Dried Chili - Plain English & Transparent Data Care</title>
<meta name="description"
    content="Read Dried Chili's privacy policy. Written in plain English: how we protect your personal information, handle secure payments, and respect your privacy under Australian standards.">
@endsection

@php
    $pageLayoutGroups = json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR);
    $pageLayoutFields = collect($pageLayoutGroups)->collapse()->all();
    $pageLayoutValue = static fn (string $key) => \App\Support\AboutPageContent::value($key, $pageLayoutFields, $systemSettings);
    $pageLayoutLink = static function (string $key) use ($pageLayoutValue) {
        $link = trim($pageLayoutValue($key));
        return preg_match('~^(?:/(?!/)|https?://|#)~i', $link) ? $link : '#';
    };
@endphp

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
    @if($pageLayoutValue('page_layout_privacy_show_hero') === '1')
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
    @endif

    <!-- Document Section -->
    @if($pageLayoutValue('page_layout_privacy_show_content') === '1')
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
                            <h4>{{ $pageLayoutValue('page_layout_privacy_policy_content_01') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_02') }}</p>
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
                            <h4>{{ $pageLayoutValue('page_layout_privacy_policy_content_03') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_04') }}</p>
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
                            <h4>{{ $pageLayoutValue('page_layout_privacy_policy_content_05') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_06') }}</p>
                        </div>
                    </div>
                </div>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_07') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_08') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_09') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_10') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_11') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_12') }}</p>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_13') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_14') }}</strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_15') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_16') }}</strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_17') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_18') }}</strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_19') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_20') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_21') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_22') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_23') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_24') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_25') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_26') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_27') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_28') }}</strong></li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_29') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_30') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_31') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_32') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_33') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_34') }}</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_35') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_36') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_37') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_38') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_39') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_40') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_41') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_42') }}</strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_43') }}</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_44') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_45') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_46') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_47') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_48') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_49') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_privacy_policy_content_50') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_51') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_52') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_53') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_54') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_55') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_56') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_57') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_58') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_59') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_60') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_61') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_62') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_63') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_64') }} <a
                            href="{{ route('account.dashboard') }}">{{ $pageLayoutValue('page_layout_privacy_policy_content_65') }}</a> {{ $pageLayoutValue('page_layout_privacy_policy_content_66') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_67') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_68') }} <a href="mailto:{{ $pageLayoutValue('page_layout_privacy_contact_email') }}">{{ $pageLayoutValue('page_layout_privacy_contact_email') }}</a>{{ $pageLayoutValue('page_layout_privacy_policy_content_69') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_privacy_policy_content_70') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_71') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_72') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_73') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_74') }}</strong> <a href="mailto:{{ $pageLayoutValue('page_layout_privacy_contact_email') }}">{{ $pageLayoutValue('page_layout_privacy_contact_email') }}</a></li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_75') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_76') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_77') }}</strong> <a href="{{ route('contact.page') }}">{{ $pageLayoutValue('page_layout_privacy_policy_content_78') }}</a>
                    </li>
                </ul>
                <p>{{ $pageLayoutValue('page_layout_privacy_policy_content_79') }} <strong>{{ $pageLayoutValue('page_layout_privacy_policy_content_80') }}</strong> {{ $pageLayoutValue('page_layout_privacy_policy_content_81') }} <a href="https://www.oaic.gov.au" target="_blank" rel="noopener noreferrer">{{ $pageLayoutValue('page_layout_privacy_policy_content_82') }}</a> {{ $pageLayoutValue('page_layout_privacy_policy_content_83') }}</p>


            </div>
        </div>
    </section>
    @endif
@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'Privacy Policy'])
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