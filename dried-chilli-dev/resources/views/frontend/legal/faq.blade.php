@extends('frontend.layouts.master')

@section('meta')
    <title>Frequently Asked Questions | Dried Chili</title>
@endsection

@section('full-content')
<main class="page-content legal-page bg-cream">
    <!-- Hero Section: Standardized Hero Banner -->
    <section class="about-hero-section legal-hero">
        <div class="container about-hero-container">
            <div class="about-hero-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                <span>HELP CENTER · FREQUENTLY ASKED QUESTIONS</span>
            </div>
            
            <h1 class="about-hero-title">
                Questions & Answers<br>
                <span class="highlight-gold">Everything You Need To Know</span>
            </h1>
            
            <p class="about-hero-desc">
                From Scoville heat ratings and allergen profiles to proper airtight storage, delivery times, and returns — find clear answers below.
            </p>

            <!-- 3 Brighter Highlight Clusters -->
            <div class="hero-stats-clusters">
                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Heat Guide</strong>
                        <span>Scoville Profiles</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>Nationwide</strong>
                        <span>Tracked Dispatch</span>
                    </div>
                </div>

                <div class="hero-cluster-item">
                    <div class="cluster-icon-box">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <div class="cluster-text">
                        <strong>30-Day Policy</strong>
                        <span>100% Risk Free</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Accordion Section -->
    <section class="legal-document">
        <div class="container reveal">
            <div class="document-wrapper shadow-lg">
                <!-- Category Highlights Bar -->
                <div class="faq-categories">
                    <button type="button" class="faq-cat-btn active" data-filter="all">All Questions</button>
                    <button type="button" class="faq-cat-btn" data-filter="product">Products & Heat</button>
                    <button type="button" class="faq-cat-btn" data-filter="shipping">Shipping & Orders</button>
                    <button type="button" class="faq-cat-btn" data-filter="storage">Quality</button>
                </div>

                <!-- FAQ List -->
                <div class="faq-list-container">
                    @forelse($faqs as $index => $faq)
                    @php
                        // Assign categories based on keywords
                        $qLower = strtolower($faq->question);
                        $category = 'product';
                        if (str_contains($qLower, 'ship') || str_contains($qLower, 'order') || str_contains($qLower, 'return') || str_contains($qLower, 'refund') || str_contains($qLower, 'wholesale')) {
                            $category = 'shipping';
                        } elseif (str_contains($qLower, 'store') || str_contains($qLower, 'shelf') || str_contains($qLower, 'fresh') || str_contains($qLower, 'source')) {
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
                    @empty
                    <!-- Fallback Comprehensive FAQs if database is empty -->
                    <details class="faq-accordion-item" data-category="product" open>
                        <summary class="faq-header">
                            <span class="faq-question">How spicy are Dried Chili products?</span>
                            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="faq-content">
                            <p>Our heat levels range from mild and aromatic (like our Ancho Chili flakes at 1,000–2,000 SHU) to intensely fiery (our Ghost Pepper and Carolina Reaper blends at 800,000+ SHU). Every product displays a clear 1-to-5 flame heat rating on the label so you always pick the perfect heat for your palate.</p>
                        </div>
                    </details>
                    <details class="faq-accordion-item" data-category="product">
                        <summary class="faq-header">
                            <span class="faq-question">Are your products 100% natural, vegan, and gluten-free?</span>
                            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="faq-content">
                            <p>Yes! The majority of our whole dried peppers, flakes, and seasoning powders contain pure, single-origin chilis with zero preservatives, zero MSG, and no artificial coloring. All our single-origin pepper lines are 100% vegan and gluten-free.</p>
                        </div>
                    </details>
                    <details class="faq-accordion-item" data-category="shipping">
                        <summary class="faq-header">
                            <span class="faq-question">How fast do you process and ship orders?</span>
                            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="faq-content">
                            <p>Orders placed Monday through Friday before 2:00 PM are processed and dispatched within 24 to 48 hours. Standard domestic delivery typically takes 3 to 5 business days, and Express Priority delivery arrives in 1 to 2 business days. Tracking links are emailed immediately once your package is on its way.</p>
                        </div>
                    </details>
                    <details class="faq-accordion-item" data-category="shipping">
                        <summary class="faq-header">
                            <span class="faq-question">Do you offer free shipping?</span>
                            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="faq-content">
                            <p>Yes! We offer free standard domestic shipping on all orders over $50. For orders under $50, flat-rate standard shipping is $4.99.</p>
                        </div>
                    </details>
                    <details class="faq-accordion-item" data-category="storage">
                        <summary class="faq-header">
                            <span class="faq-question">How should I store dried chilies to preserve maximum freshness?</span>
                            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="faq-content">
                            <p>Keep your chili jars and pouches sealed tightly in a cool, dark, and dry pantry away from direct sunlight, stove heat, and moisture. Stored properly, whole dried pods and flakes stay vibrant and potent for up to 18 to 24 months.</p>
                        </div>
                    </details>
                    @endforelse
                </div>

                <!-- Still Have Questions Help Box -->
                <div class="faq-help-box">
                    <div class="help-box-content">
                        <h3>Still have questions?</h3>
                        <p>Can't find the answer you're looking for? Please reach out to our dedicated spice support team.</p>
                    </div>
                    <div class="help-box-actions">
                        <a href="{{ route('contact.page') }}" class="help-btn primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Contact Support
                        </a>
                        <a href="tel:180024454" class="help-btn outline">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
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
.bg-cream { background-color: var(--spice-bg); }

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

/* Category Filter Buttons */
.faq-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 2.5rem;
    justify-content: center;
}
.faq-cat-btn {
    background: rgba(40, 18, 11, 0.04);
    border: 1px solid rgba(40, 18, 11, 0.08);
    border-radius: 20px;
    padding: 0.6rem 1.4rem;
    font-family: var(--font-body);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--spice-text);
    cursor: pointer;
    transition: all 0.25s ease;
}
.faq-cat-btn:hover {
    background: rgba(228, 93, 62, 0.1);
    color: var(--spice-primary);
    border-color: rgba(228, 93, 62, 0.25);
}
.faq-cat-btn.active {
    background: var(--spice-primary);
    color: #FFFFFF;
    border-color: var(--spice-primary);
    box-shadow: 0 4px 12px rgba(228, 93, 62, 0.3);
}

/* FAQ Accordion List */
.faq-list-container {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.faq-accordion-item {
    background: #FFFFFF;
    border: 1px solid rgba(40, 18, 11, 0.08);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
}
.faq-accordion-item:hover {
    border-color: rgba(228, 93, 62, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
}
.faq-accordion-item[open] {
    border-color: rgba(228, 93, 62, 0.4);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
}

.faq-header {
    padding: 1.25rem 1.75rem;
    cursor: pointer;
    user-select: none;
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    background: #FFFFFF;
    transition: background 0.2s ease;
}
.faq-header::-webkit-details-marker { display: none; }
.faq-header:hover .faq-question {
    color: var(--spice-primary);
}

.faq-question {
    font-family: var(--font-body);
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--spice-bg-dark);
    line-height: 1.4;
    transition: color 0.2s ease;
}

.faq-chevron {
    flex-shrink: 0;
    color: var(--spice-bg-dark);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s ease;
}
.faq-accordion-item[open] .faq-chevron {
    transform: rotate(180deg);
    color: var(--spice-primary);
}

.faq-content {
    padding: 1.25rem 1.75rem 1.75rem;
    border-top: 1px solid rgba(40, 18, 11, 0.06);
    background: #FDFBF8;
}
.faq-content p {
    font-family: var(--font-body);
    font-size: 15px;
    line-height: 1.65;
    color: #4A3B32;
    margin: 0;
    text-align: justify;
    text-justify: inter-word;
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
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
