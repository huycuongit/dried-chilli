@extends('frontend.layouts.master')
@section('meta')
    <title>About Us | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content">
    <section class="story-grid reveal">
        <div class="story-image">
            <img src="{{ asset('images/about_founders.jpg') }}" alt="Our Founders">
        </div>
        <div class="story-content about-content">
            <span class="subheading badge">{{ renderData($systemSettings ?? [], 'nafu_home_page_about_mission_title', 'OUR STORY') }}</span>
            <h2>{{ renderData($systemSettings ?? [], 'nafu_home_page_about_title', 'Born from the Heat') }}</h2>
            <p>{{ renderData($systemSettings ?? [], 'nafu_home_page_about_desc', "Started in 2021 by three spice enthusiasts (Chris, Maria, and Ben) who were tired of bland, mass-produced chili flakes. We embarked on a journey to source the world's most vibrant, sun-dried chilies.") }}</p>
            <p>{{ renderData($systemSettings ?? [], 'nafu_home_page_about_mission_text', "We work directly with farmers to ensure every jar packs the authentic heat and flavor you deserve. Pure ingredients, no artificial junk, just unapologetic spice.") }}</p>
        </div>
    </section>
</main>

<style>
.story-grid { display: grid; grid-template-columns: 1fr 1fr; border-bottom: 2px solid var(--spice-text); }
.story-image img { width: 100%; height: 100%; object-fit: cover; min-height: 500px; border-right: 2px solid var(--spice-text); }
.about-content { background: var(--spice-primary); color: white; padding: 6rem 4rem; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; }
.about-content h2 { font-family: var(--font-heading); font-size: 3rem; margin: 0 0 1.5rem 0; color: white; }
.about-content p { font-size: 1.1rem; line-height: 1.8; margin: 0 0 1.5rem 0; opacity: 0.9; }
.badge { color: var(--spice-secondary); font-weight: bold; font-size: 1.2rem; display: block; margin-bottom: 1rem; border: 2px solid; padding: 0.2rem 1rem; border-radius: 20px; }

@media (max-width: 900px) {
    .story-grid { grid-template-columns: 1fr; }
    .story-image img { border-right: none; border-bottom: 2px solid var(--spice-text); min-height: 300px; }
    .about-content { padding: 3rem 1.5rem; }
}
</style>
@endsection
