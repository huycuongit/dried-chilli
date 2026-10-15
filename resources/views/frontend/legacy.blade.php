@extends('frontend.layouts.master')
@section('meta')
    <title>Our Legacy | Dried Chili</title>
@endsection
@section('full-content')
<main class="page-content about-page">
    
    <!-- Hero Section -->
    <section class="about-hero legacy-hero-bg" style="position: relative; background-image: url('https://images.unsplash.com/photo-1506456121405-b0404c05711b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
        <!-- Dark overlay -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(42, 8, 0, 0.8) 0%, rgba(58, 27, 20, 0.6) 100%); z-index: 1;"></div>
        
        <div class="container text-center reveal" style="position: relative; z-index: 2;">
            <h1 class="text-white mt-3" style="color: var(--spice-secondary) !important; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">ROOTS & TRADITION</h1>
            <p class="hero-subtitle text-white mt-3 mx-auto" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); max-width: 650px; opacity: 0.9; font-size: 1.15rem; line-height: 1.6; margin-left: auto !important; margin-right: auto !important;">
                For generations, our family has cultivated the soil, respecting the rhythm of nature. A story of passion, fire, and unyielding dedication to flavor.
            </p>
        </div>
    </section>

    <!-- Legacy Story Section using Smart Layout (about-grid) -->
    <section class="about-section bg-cream">
        <div class="container">
            <div class="about-grid reveal">
                <div class="about-text">
                    <h2>THE JOURNEY BEGINS</h2>
                    <p>
                        It all started over a century ago in a small, sun-drenched valley where the soil was rich and the days were long. Our great-grandfather planted the first chili seeds with a simple philosophy: never rush what nature takes time to perfect.
                    </p>
                    <p>
                        We don't just grow peppers; we preserve a legacy. Our farming methods rely on sun-drying techniques passed down through centuries, completely avoiding artificial dehydrators. This slow, deliberate process allows the complex sugars to caramelize naturally, developing the deep, smoky umami flavor that has become our signature. When you taste Dried Chili, you aren't just tasting a spice—you are tasting history.
                    </p>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1588123190131-1c3fac394f4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Vintage Chili Farming">
                </div>
            </div>
        </div>
    </section>
    


    <!-- The Heritage Section using Smart Layout (reverse) -->
    <section class="about-section bg-chai">
        <div class="container">
            <div class="about-grid reverse reveal">
                <div class="about-text">
                    <h2 style="color: var(--spice-primary);">FROM SEED TO SPICE</h2>
                    <p>
                        Every chili pod is hand-selected at the peak of ripeness. We believe that true quality cannot be manufactured—it must be nurtured. Our master blenders carefully inspect every harvest, ensuring that only the most robust and vibrant peppers make it into our batches.
                    </p>
                    <blockquote class="blockquote mt-5 border-start border-4 ps-4 py-2" style="border-color: var(--spice-accent) !important; background: rgba(228, 93, 62, 0.05); border-radius: 0 20px 20px 0;">
                        <p class="mb-2 fst-italic" style="color: var(--spice-bg-dark); font-size: 1.2rem; font-weight: 500;">
                            "Nature dictates our schedule. We simply listen and craft the finest spices the earth can offer."
                        </p>
                        <footer class="blockquote-footer mt-2" style="color: var(--spice-primary); font-weight: 700;">The Founder</footer>
                    </blockquote>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Our Heritage Farm">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="about-section bg-moss text-white">
        <div class="container text-center reveal">
            <h2 class="mb-5" style="color: var(--spice-secondary); font-size: clamp(30px, 3vw, 40px); letter-spacing: 2px;">A CENTURY OF SPICE</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>1920</h3>
                    <p>Farm Established</p>
                    <div class="stat-divider"></div>
                    <span class="stat-desc">The year our first heirloom seeds took root.</span>
                </div>
                <div class="stat-card">
                    <h3>3rd</h3>
                    <p>Generation Farmers</p>
                    <div class="stat-divider"></div>
                    <span class="stat-desc">Family-owned and operated for over 100 years.</span>
                </div>
                <div class="stat-card">
                    <h3>100%</h3>
                    <p>Sun-dried Pure</p>
                    <div class="stat-divider"></div>
                    <span class="stat-desc">No artificial heat. Just patience and sunshine.</span>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Utilities */
.bg-cream { background-color: var(--spice-bg); }
.bg-moss { background-color: var(--spice-bg-bundle); }
.bg-chai { background-color: var(--spice-bg-alt); }

/* Hero */
.about-hero {
    padding: 0;
    height: 650px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: var(--spice-bg);
}
.legacy-hero-bg {
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}
.hero-badge {
    display: inline-block;
    background: var(--spice-primary);
    color: #fff;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 2rem;
    font-size: 0.9rem;
}
.about-hero h1 {
    font-family: var(--font-heading);
    font-size: clamp(48px, 4.5vw, 64px);
    font-weight: 800;
    margin: 0 0 1rem 0;
    line-height: 1.08;
    text-transform: uppercase;
}
.about-hero .hero-subtitle,
.hero-subtitle {
    font-family: var(--font-body);
    font-size: 1.15rem;
    line-height: 1.6;
    font-weight: 400;
    max-width: 650px;
    margin-left: auto !important;
    margin-right: auto !important;
    text-align: center;
    opacity: 0.9;
}

/* Sections */
.about-section {
    padding: 8rem 0;
    overflow: hidden;
}

/* Smart Layout: About Grid */
.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6rem;
    align-items: center;
}
.about-grid.reverse {
    grid-template-columns: 1fr 1.2fr;
}
.about-grid.reverse .about-text {
    order: 2;
}
.about-grid.reverse .about-image {
    order: 1;
}
.about-image img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    aspect-ratio: 4/5;
    object-fit: cover;
}
.about-text h2 {
    font-family: var(--font-heading);
    font-size: clamp(30px, 3vw, 40px);
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.15;
    color: var(--spice-bg-dark);
}
.about-text p {
    font-family: var(--font-body);
    font-size: 16px;
    line-height: 1.65;
    margin-bottom: 1.5rem;
    color: #5C4B41;
    text-align: justify;
    text-justify: inter-word;
}

/* Stats */
.stats-grid { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 3rem; 
    max-width: 1100px;
    margin: 0 auto;
}
.stat-card { 
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 3rem 2rem; 
    border-radius: 20px; 
    transition: transform 0.3s ease, background 0.3s ease;
    backdrop-filter: blur(10px);
}
.stat-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.08);
}
.stat-card h3 { 
    font-family: var(--font-heading); 
    font-size: 3.5rem; 
    margin: 0; 
    color: var(--spice-secondary); 
    font-weight: 800;
}
.stat-card p { 
    font-weight: 700; 
    font-size: 1.2rem;
    margin-top: 0.5rem; 
    margin-bottom: 1rem; 
    color: #fff; 
    text-transform: uppercase;
    letter-spacing: 1px;
}
.stat-divider {
    height: 3px;
    width: 40px;
    background: var(--spice-primary);
    margin: 1.5rem auto;
    border-radius: 20px;
}
.stat-desc {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Typography elements */
h2 {
    font-family: var(--font-heading);
    font-weight: 800;
    line-height: 1.1;
}

@media (max-width: 991px) {
    .about-grid, .about-grid.reverse {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    .about-grid.reverse .about-text {
        order: 1 !important;
    }
    .about-grid.reverse .about-image {
        order: 2 !important;
    }
    .stats-grid { 
        grid-template-columns: 1fr; 
        gap: 2rem;
    }
    .about-section { 
        padding: 5rem 0; 
    }
    .about-hero {
        padding: 8rem 0 6rem;
    }
}

@media (max-width: 768px) {
    .about-hero h1 {
        font-size: clamp(34px, 7vw, 42px) !important;
    }
    h2, .about-text h2 {
        font-size: clamp(26px, 5vw, 32px) !important;
    }
}
</style>
@endsection
