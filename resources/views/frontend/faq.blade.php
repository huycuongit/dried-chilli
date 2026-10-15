@extends('frontend.layouts.master')
@section('meta')
    <title>FAQ | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content faq-bg">
    <div class="faq-header">
        <h1>Spicy Questions?</h1>
        <p>Everything you need to know about our products, shipping, and return policies.</p>
    </div>
    
    <div class="container faq-grid reveal">
        <div class="faq-visual-col">
            <img src="{{ asset('images/faq_illustration.jpg') }}" alt="FAQ Illustration" class="faq-img">
        </div>
        <div class="faq-accordion">
            <div class="faq-card">
                <h3>How spicy are your products?</h3>
                <p>Our heat levels range from mild (like our Ancho powder) to face-melting (our Ghost Pepper flakes). We clearly mark the heat level on every product so you know what you're getting into!</p>
            </div>
            
            <div class="faq-card">
                <h3>Do you ship internationally?</h3>
                <p>Yes! We ship worldwide. Shipping rates and times vary depending on the destination. You can see exact quotes at checkout.</p>
            </div>
            
            <div class="faq-card">
                <h3>Are your products vegan/gluten-free?</h3>
                <p>Most of our pure spice blends and flakes are 100% vegan and gluten-free. However, our signature Shrimp Chilli contains seafood. Please check individual product ingredients.</p>
            </div>
        </div>
    </div>
</main>

<style>
.faq-bg { background: #EFE4D3; min-height: 100vh; padding-bottom: 4rem; }
.faq-header { background: var(--spice-accent); color: white; padding: 4rem 1rem; text-align: center; border-bottom: 4px solid var(--spice-text); }
.faq-header h1 { font-family: var(--font-heading); font-size: clamp(2.5rem, 6vw, 4rem); margin: 0; text-transform: uppercase; }
.faq-header p { font-size: 1.25rem; font-weight: bold; max-width: 600px; margin: 1rem auto; }
.faq-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 4rem; margin-top: 4rem; }
.faq-img { width: 100%; border: 4px solid var(--spice-text); box-shadow: 8px 8px 0px var(--spice-text); border-radius: 20px; position: sticky; top: 2rem; }
.faq-card { background: white; border: 2px solid var(--spice-text); border-radius: 20px; margin-bottom: 1rem; box-shadow: 4px 4px 0px var(--spice-text); padding: 1.5rem; }
.faq-card h3 { font-family: var(--font-heading); font-size: 1.5rem; margin: 0 0 1rem 0; color: var(--spice-primary); }
.faq-card p { margin: 0; line-height: 1.6; text-align: justify; text-justify: inter-word; }

@media (max-width: 900px) {
    .faq-grid { grid-template-columns: 1fr; }
    .faq-img { position: relative; top: 0; max-width: 400px; margin: 0 auto; display: block; }
}
</style>
@endsection
