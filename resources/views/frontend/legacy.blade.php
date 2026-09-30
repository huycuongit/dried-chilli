@extends('frontend.layouts.master')
@section('meta')
    <title>Our Legacy | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content">
    <section class="legacy-hero" style="background-image: url('{{ asset('images/legacy_farm.jpg') }}')">
        <div class="legacy-title-box">
            <h1>{{ renderData($systemSettings ?? [], 'nafu_home_page_legacy_title', 'ROOTS & TRADITION') }}</h1>
        </div>
    </section>
    
    <div class="container legacy-body reveal">
        <p class="legacy-lead">{{ renderData($systemSettings ?? [], 'nafu_home_page_legacy_desc', "For generations, our family has cultivated the soil, respecting the rhythm of nature to grow the world's most expressive chilies.") }}</p>
        <p class="legacy-text">{{ renderData($systemSettings ?? [], 'nafu_home_page_legacy_story_text', "We don't just grow peppers; we preserve a legacy. Our farming methods rely on sun-drying techniques passed down through centuries, avoiding artificial dehydrators to let the natural complex flavors develop fully. When you taste Dried Chili, you are tasting history.") }}</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>1920</h3>
                <p>Farm Established</p>
            </div>
            <div class="stat-card">
                <h3>3rd</h3>
                <p>Generation Farmers</p>
            </div>
            <div class="stat-card">
                <h3>100%</h3>
                <p>Sun-dried Pure</p>
            </div>
        </div>
    </div>
</main>

<style>
.legacy-hero { position: relative; height: 60vh; background-position: center; background-size: cover; background-repeat: no-repeat; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 4rem; border-bottom: 4px solid var(--spice-text); }
.legacy-title-box { background: var(--spice-text); color: var(--spice-bg); padding: 2rem 4rem; text-align: center; border-radius: 12px; border: 4px solid var(--spice-primary); box-shadow: 0px 8px 0px var(--spice-primary); transform: translateY(50%); z-index: 10; margin: 0 1rem; }
.legacy-title-box h1 { font-family: var(--font-heading); font-size: clamp(2rem, 5vw, 3.5rem); margin: 0; }
.legacy-body { max-width: 800px; padding: 6rem 1rem 4rem 1rem; text-align: center; margin: 0 auto; }
.legacy-lead { font-size: 1.5rem; line-height: 1.8; font-weight: bold; color: var(--spice-primary); }
.legacy-text { font-size: 1.1rem; line-height: 1.8; margin-top: 2rem; opacity: 0.9; }
.stats-grid { margin-top: 4rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
.stat-card { border: 2px solid var(--spice-text); padding: 2rem 1rem; border-radius: 8px; box-shadow: 4px 4px 0px var(--spice-text); background: white; }
.stat-card h3 { font-family: var(--font-heading); font-size: 2rem; margin: 0; color: var(--spice-accent); }
.stat-card p { font-weight: bold; margin-top: 0.5rem; margin-bottom: 0; }

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .legacy-title-box { padding: 1.5rem; transform: translateY(30%); }
    .legacy-hero { padding-bottom: 2rem; }
}
</style>
@endsection
