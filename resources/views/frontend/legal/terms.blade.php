@extends('frontend.layouts.master')

@section('meta')
<title>Terms of Service | Dried Chili - Fair, Transparent & Customer First</title>
<meta name="description" content="Read Dried Chili's terms of service. Clear, friendly policies on AUD pricing inclusive of GST, Australian Consumer Law guarantees, food safety, and customer care.">
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
    @if($pageLayoutValue('page_layout_terms_show_hero') === '1')
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
    @endif

    <!-- Document Section -->
    @if($pageLayoutValue('page_layout_terms_show_content') === '1')
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
                            <h4>{{ $pageLayoutValue('page_layout_terms_terms_content_01') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_terms_terms_content_02') }}</p>
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
                            <h4>{{ $pageLayoutValue('page_layout_terms_terms_content_03') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_terms_terms_content_04') }}</p>
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
                            <h4>{{ $pageLayoutValue('page_layout_terms_terms_content_05') }}</h4>
                            <p>{{ $pageLayoutValue('page_layout_terms_terms_content_06') }}</p>
                        </div>
                    </div>
                </div>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_07') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_08') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_09') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_10') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_11') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_12') }}</p>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_13') }} <a href="{{ route('page.privacy') }}">{{ $pageLayoutValue('page_layout_terms_terms_content_14') }}</a> {{ $pageLayoutValue('page_layout_terms_terms_content_15') }} <a href="{{ route('page.shipping') }}">{{ $pageLayoutValue('page_layout_terms_terms_content_16') }}</a>{{ $pageLayoutValue('page_layout_terms_terms_content_17') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_18') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_19') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_20') }}</strong>{{ $pageLayoutValue('page_layout_terms_terms_content_21') }}</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_22') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_23') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_24') }}</li>
                </ul>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_25') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_26') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_27') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_28') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_29') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_30') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_31') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_32') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_33') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_34') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_35') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_36') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_37') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_38') }}</strong>:</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_39') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_40') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_41') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_42') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_43') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_44') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_45') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_46') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_47') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_48') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_49') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_50') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_51') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_52') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_53') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_54') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_55') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_56') }} <strong>{{ $pageLayoutValue('page_layout_terms_terms_content_57') }}</strong>{{ $pageLayoutValue('page_layout_terms_terms_content_58') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_59') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_60') }}</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_61') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_62') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_63') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_64') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_65') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_66') }}</p>
                <ul>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_67') }}</li>
                    <li>{{ $pageLayoutValue('page_layout_terms_terms_content_68') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_69') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_70') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_71') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_72') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_73') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_74') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_75') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_76') }}</li>
                </ul>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_77') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_78') }}</p>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_79') }}</p>

                <h2>{{ $pageLayoutValue('page_layout_terms_terms_content_80') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_terms_terms_content_81') }}</p>
                <ul>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_82') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_83') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_84') }}</strong> <a href="mailto:{{ $pageLayoutValue('page_layout_terms_contact_email') }}">{{ $pageLayoutValue('page_layout_terms_contact_email') }}</a></li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_85') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_86') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_87') }}</strong> {{ $pageLayoutValue('page_layout_terms_terms_content_88') }}</li>
                    <li><strong>{{ $pageLayoutValue('page_layout_terms_terms_content_89') }}</strong> <a href="{{ route('contact.page') }}">{{ $pageLayoutValue('page_layout_terms_terms_content_90') }}</a></li>
                </ul>

            </div>
        </div>
    </section>
    @endif
@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'Terms of Service'])
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
