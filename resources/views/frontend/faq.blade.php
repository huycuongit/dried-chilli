@extends('frontend.layouts.master')
@section('title', 'Frequently Asked Questions | Dried Chili')
@section('meta_description', 'Find answers to common questions about Dried Chili, our artisan spicy sauces, order tracking, Australian Consumer Law guarantees, and shipping policies.')
@section('full-content')
<main class="page-content faq-bg">
    <div class="faq-header">
        <h1>Spicy Questions?</h1>
        <p>Everything you need to know about our products, Australian Consumer Law guarantees, food standards, and shipping policies.</p>
    </div>

    <div class="container faq-grid reveal">
        <div class="faq-visual-col">
            <img src="{{ asset('images/faq_illustration.jpg') }}" alt="FAQ Illustration" class="faq-img">
        </div>
        <div class="faq-accordion">
            <div class="faq-card">
                <h3>How spicy are your products?</h3>
                <p>Our heat levels range from mild (like our Ancho chili flakes at 1,000–2,000 SHU) to face-melting (our Ghost Pepper and Carolina Reaper blends exceeding 800,000 SHU). Every product displays a clear 1-to-5 flame heat rating and Scoville profile on the label.</p>
            </div>

            <div class="faq-card">
                <h3>Are prices in AUD and do they include GST?</h3>
                <p>Yes! In accordance with the <em>GST Act 1999</em> and the <em>Australian Consumer Law</em>, all prices on our Australian storefront are displayed in Australian Dollars (AUD) and are inclusive of 10% GST. An official tax invoice with our ABN is provided with every order.</p>
            </div>

            <div class="faq-card">
                <h3>Do you ship across Australia and internationally?</h3>
                <p>Yes! We offer tracked delivery across Australia via Australia Post, with Free Standard Shipping on domestic orders over $50 AUD ($4.99 AUD under $50, $9.99 AUD Express). We also ship to over 50 countries worldwide (GST-free for overseas exports).</p>
            </div>

            <div class="faq-card">
                <h3>Are your products vegan, gluten-free, and FSANZ compliant?</h3>
                <p>All single-origin dried chili pods and flakes are 100% vegan, gluten-free, and free of artificial additives. In accordance with the Australia New Zealand Food Standards Code (Plain English Allergen Labelling), any allergens—such as crustacea in our signature <em>Shrimp Chilli</em>—are prominently declared.</p>
            </div>

            <div class="faq-card">
                <h3>What is your refund policy under the Australian Consumer Law (ACL)?</h3>
                <p>Our goods come with automatic guarantees under the Australian Consumer Law that cannot be excluded. If your order arrives damaged, leaking, or defective, you are entitled to a full replacement or refund. For change of mind, we accept returns on unopened, sealed jars within 30 days (opened food cannot be returned due to state food hygiene laws).</p>
            </div>
        </div>
    </div>
</main>

<style>
.faq-bg {
    background: #EFE4D3;
    min-height: 100vh;
    padding-bottom: 4rem;
}

.faq-header {
    background: var(--spice-accent);
    color: white;
    padding: 4rem 1rem;
    text-align: center;
    border-bottom: 4px solid var(--spice-text);
}

.faq-header h1 {
    font-family: var(--font-heading);
    font-size: clamp(2.5rem, 6vw, 4rem);
    margin: 0;
    text-transform: uppercase;
}

.faq-header p {
    font-size: 1.25rem;
    font-weight: bold;
    max-width: 600px;
    margin: 1rem auto;
}

.faq-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 4rem;
    margin-top: 4rem;
}

.faq-img {
    width: 100%;
    border: 4px solid var(--spice-text);
    box-shadow: 8px 8px 0px var(--spice-text);
    border-radius: 20px;
    position: sticky;
    top: 2rem;
}

.faq-card {
    background: white;
    border: 2px solid var(--spice-text);
    border-radius: 20px;
    margin-bottom: 1rem;
    box-shadow: 4px 4px 0px var(--spice-text);
    padding: 1.5rem;
}

.faq-card h3 {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    margin: 0 0 1rem 0;
    color: var(--spice-primary);
}

.faq-card p {
    margin: 0;
    line-height: 1.6;
    text-align: justify;
    text-justify: inter-word;
    text-align-last: left;
    -webkit-hyphens: auto;
    hyphens: auto;
}

@media (max-width: 900px) {
    .faq-grid {
        grid-template-columns: 1fr;
    }

    .faq-img {
        position: relative;
        top: 0;
        max-width: 400px;
        margin: 0 auto;
        display: block;
    }

    .faq-card p {
        text-align: justify;
        text-justify: inter-word;
        text-align-last: left;
    }
}
</style>
@endsection