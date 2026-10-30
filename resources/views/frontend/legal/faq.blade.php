@extends('frontend.layouts.master')

@section('meta')
    <title>Frequently Asked Questions | Dried Chili - Plain English Answers & Customer Care</title>
    <meta name="description" content="Find clear, friendly answers to common questions about Dried Chili spices, heat levels, allergens, shipping, Australian Consumer Law guarantees, and GST.">
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
    @if($pageLayoutValue('page_layout_faq_show_hero') === '1')
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
    @endif
    
    <!-- FAQ Accordion Section -->
    @if($pageLayoutValue('page_layout_faq_show_content') === '1')
    <section class="legal-document">
        <div class="container">
            <div class="document-wrapper shadow-lg">
                <!-- Category Highlights Bar -->
                <div class="faq-categories">
                    <button type="button" class="faq-cat-btn active" data-filter="all">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_01') }}</button>
                    <button type="button" class="faq-cat-btn" data-filter="compliance">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_02') }}</button>
                    <button type="button" class="faq-cat-btn" data-filter="product">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_03') }}</button>
                    <button type="button" class="faq-cat-btn" data-filter="shipping">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_04') }}</button>
                    <button type="button" class="faq-cat-btn" data-filter="privacy">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_05') }}</button>
                    <button type="button" class="faq-cat-btn" data-filter="storage">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_06') }}</button>
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
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_07') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_01') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="compliance">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_11') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_02') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="compliance">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_13') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_03') }}</p>
                            </div>
                        </details>

                        <!-- 2. Food Standards & Allergens (FSANZ, PEAL, Origin) -->
                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_17') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_04') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_23') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_05') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="product">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_27') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_06') }}</p>
                            </div>
                        </details>

                        <!-- 3. Shipping & Refunds (ACL Remedies, Delivery Times) -->
                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_29') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_07') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_30') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_08') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="shipping">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_32') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_09') }}</p>
                            </div>
                        </details>

                        <!-- 4. Privacy & Email (Privacy Act 1988, Spam Act 2003) -->
                        <details class="faq-accordion-item" data-category="privacy">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_35') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_10') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="privacy">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_41') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_11') }}</p>
                            </div>
                        </details>

                        <!-- 5. Food Safety & Storage (FSANZ & State Food Acts) -->
                        <details class="faq-accordion-item" data-category="storage">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_47') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_12') }}</p>
                            </div>
                        </details>

                        <details class="faq-accordion-item" data-category="storage">
                            <summary class="faq-header">
                                <span class="faq-question">{{ $pageLayoutValue('page_layout_faq_questions_and_answers_49') }}</span>
                                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="faq-content">
                                <p>{{ $pageLayoutValue('page_layout_faq_default_answer_13') }}</p>
                            </div>
                        </details>
                    @endif
                </div>

            </div>
        </div>
    </section>
    @endif
<section class="legal-document" aria-label="Customer support">
    <div class="container"><div class="document-wrapper shadow-lg">
        <h2>{{ $pageLayoutValue('page_layout_faq_support_title') }}</h2>
        <p>{{ $pageLayoutValue('page_layout_faq_support_desc') }}</p>
        <div class="d-flex" style="display:flex;flex-wrap:wrap;gap:1rem">
            <a href="{{ $pageLayoutLink('page_layout_faq_support_contact_link') }}" class="help-btn">{{ $pageLayoutValue('page_layout_faq_support_contact_text') }}</a>
            <a href="mailto:{{ $pageLayoutValue('page_layout_faq_support_email') }}" class="help-btn outline">{{ $pageLayoutValue('page_layout_faq_support_email_text') }}</a>
        </div>
    </div></div>
</section>
@include('frontend.layouts.partials.custom-page-sections', ['customPageName' => 'FAQ'])
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
