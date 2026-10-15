@extends('frontend.layouts.master')

@section('meta')
    <title>Contact Us | Dried Chili</title>
@endsection

@section('full-content')
<main class="page-content about-page">
    <!-- Hero Section -->
    <section class="about-hero" style="background: var(--spice-bg-dark);">
        <div class="container text-center reveal">
            <h1 class="text-white mt-3" style="color: var(--spice-secondary) !important;">CONTACT US</h1>
            <p class="hero-subtitle text-white mt-3 mx-auto" style="max-width: 650px; opacity: 0.9; font-size: 1.15rem; line-height: 1.6; margin-left: auto !important; margin-right: auto !important;">
                Have questions about our spices, need help with an order, or want to inquire about wholesale opportunities? Our team is always here to assist you.
            </p>
        </div>
    </section>

    <!-- Contact Form & Details Section -->
    <section class="about-section bg-cream">
        <div class="container">
            <div class="about-grid reveal">
                <!-- Contact Info -->
                <div class="about-text">
                    <span class="contact-eyebrow">COMMUNICATION DESK</span>
                    <h2>Our Contact Information</h2>
                    <p>
                        Whether you are a home chef looking for the perfect seasoning or a restaurant seeking bulk orders, our advisory team is here to assist you.
                    </p>
                    
                    <div class="contact-info-list mt-4">
                        <div class="contact-item">
                            <div class="icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="details">
                                <h4>Visit Atelier</h4>
                                <p>123 Spice Market, Culinary District<br>Flavor Town, FL 33139, USA</p>
                                <span class="contact-meta">Flagship Atelier & Tasting Room</span>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                            <div class="details">
                                <h4>Email Inquiries</h4>
                                <p><a href="mailto:hello@driedchili.com">hello@driedchili.com</a></p>
                                <span class="contact-meta">Response commitment within 24 business hours</span>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="details">
                                <h4>Phone Support</h4>
                                <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
                                <span class="contact-meta">Monday – Friday: 8:00 AM – 6:00 PM EST</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert alert-success border-0" role="alert" style="background-color: #d4edda; color: #155724; border-radius: 20px; padding: 1rem; margin-bottom: 1.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0" role="alert" style="background-color: #f8d7da; color: #721c24; border-radius: 20px; padding: 1rem; margin-bottom: 1.5rem;">
                            Please check the form for errors.
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="spice-form">
                        @csrf
                        <input type="hidden" name="source" value="contact-page">
                        
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" placeholder="John Doe" value="{{ old('full_name') }}" required>
                            @error('full_name')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group half">
                                <label>Email Address *</label>
                                <input type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
                                @error('email')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group half">
                                <label>Phone Number</label>
                                <div class="phone-input">
                                    <select name="phone_country">
                                        <option value="+1" @selected(old('phone_country') === '+1')>+1</option>
                                        <option value="+61" @selected(old('phone_country') === '+61')>+61</option>
                                        <option value="+84" @selected(old('phone_country') === '+84')>+84</option>
                                    </select>
                                    <input type="tel" name="phone" placeholder="123 456 7890" value="{{ old('phone') }}">
                                </div>
                                @error('phone')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                                @error('phone_country')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Inquiry Type *</label>
                            <select name="project_type" required>
                                <option value="">Select an option</option>
                                <option value="wholesale" @selected(old('project_type') === 'wholesale')>Wholesale & Bulk Orders</option>
                                <option value="retail" @selected(old('project_type') === 'retail')>Retail & Personal Orders</option>
                                <option value="support" @selected(old('project_type') === 'support')>Customer Support</option>
                                <option value="other" @selected(old('project_type') === 'other')>Other Inquiries</option>
                            </select>
                            @error('project_type')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Your Message *</label>
                            <textarea name="message" rows="5" placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                            @error('message')<small class="text-danger mt-1">{{ $message }}</small>@enderror
                        </div>
                        
                        <button type="submit" class="submit-btn">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section class="contact-map-section">
        <div class="map-wrapper">
            <iframe 
                class="contact-map-iframe"
                src="https://maps.google.com/maps?q=-37.8105,144.9665&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Dried Chili Headquarters & Atelier Map">
            </iframe>
            
            <!-- Open in Maps Button (Top Left) -->
            <a href="https://maps.google.com/?q=-37.8105,144.9665" target="_blank" rel="noopener noreferrer" class="btn-open-map">
                Open in Maps
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
            </a>

            <!-- Central Location Marker Pin -->
            <div class="map-center-pin" title="Dried Chili Atelier & Flagship Store">
                <div class="pin-marker">
                    <svg width="28" height="36" viewBox="0 0 24 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0C5.37 0 0 5.37 0 12C0 20.25 12 30 12 30C12 30 24 20.25 24 12C24 5.37 18.63 0 12 0Z" fill="#8B2218"/>
                        <circle cx="12" cy="11" r="4" fill="#FFFFFF"/>
                    </svg>
                    <div class="pin-pulse"></div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Utilities */
.bg-cream { background-color: var(--spice-bg); }
.bg-moss { background-color: var(--spice-bg-bundle); }
.text-white { color: #fff !important; }

/* Hero */
.about-hero {
    padding: 0;
    height: 650px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
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
    padding: 7rem 0;
}
.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6rem;
    align-items: flex-start;
}
.about-text h2 {
    font-family: var(--font-heading);
    font-size: clamp(2.3rem, 4vw, 3.2rem);
    font-weight: 800;
    margin-bottom: 1.25rem;
    line-height: 1.15;
    color: var(--spice-bg-dark);
    letter-spacing: -0.5px;
}
.contact-eyebrow {
    display: inline-block;
    font-family: var(--font-body);
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--spice-primary);
    margin-bottom: 0.75rem;
}
.about-text p {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #5C4B41;
}

/* Contact Info List */
.contact-info-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    padding: 1.25rem 1.5rem;
    background: #FFFFFF;
    border: 1px solid rgba(42, 8, 0, 0.08);
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.contact-item:hover {
    transform: translateY(-2px);
    border-color: rgba(228, 93, 62, 0.35);
    box-shadow: 0 10px 25px rgba(42, 8, 0, 0.06);
}
.contact-item .icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 20px;
    background: var(--spice-bg-dark);
    color: white;
    border: 1px solid rgba(255, 179, 0, 0.25);
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.contact-item:hover .icon {
    background: var(--spice-primary);
    border-color: var(--spice-primary);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(228, 93, 62, 0.3);
}
.contact-item .details h4 {
    font-family: var(--font-heading);
    font-weight: 700;
    font-size: 1.12rem;
    margin: 0 0 0.3rem 0;
    color: var(--spice-bg-dark);
    letter-spacing: 0.2px;
}
.contact-item .details p, .contact-item .details a {
    margin: 0;
    font-size: 0.98rem;
    color: #5C4B41;
    text-decoration: none;
    line-height: 1.5;
    font-weight: 500;
    transition: color 0.2s ease;
}
.contact-item .details a:hover {
    color: var(--spice-primary);
}
.contact-meta {
    display: block;
    font-size: 0.8rem;
    color: #8C786E;
    margin-top: 0.35rem;
    font-weight: 400;
}

/* Form Wrapper */
.contact-form-wrapper {
    background: #fff;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

/* Form Elements */
.spice-form .form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
}
.spice-form .form-row {
    display: flex;
    gap: 1.5rem;
}
.spice-form .form-group.half {
    flex: 1;
}
.spice-form label {
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--spice-text);
    font-size: 0.95rem;
}
.spice-form input, .spice-form select, .spice-form textarea {
    padding: 1rem 1.2rem;
    border-radius: 20px;
    border: 2px solid #EAE5D9;
    background-color: #FCFAf5;
    font-family: var(--font-body);
    font-size: 1rem;
    transition: all 0.3s ease;
    color: var(--spice-text);
}
.spice-form input:focus, .spice-form select:focus, .spice-form textarea:focus {
    outline: none;
    border-color: var(--spice-primary);
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(228, 93, 62, 0.1);
}
.spice-form .phone-input {
    display: flex;
    gap: 0.5rem;
}
.spice-form .phone-input select {
    width: 100px;
    flex-shrink: 0;
}
.spice-form .phone-input input {
    flex-grow: 1;
}
.spice-form .submit-btn {
    background-color: var(--spice-primary);
    color: #fff;
    border: none;
    padding: 1.2rem;
    border-radius: 20px;
    font-weight: 800;
    font-family: var(--font-heading);
    letter-spacing: 1px;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    margin-top: 1rem;
}
.spice-form .submit-btn:hover {
    background-color: var(--spice-accent);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(199, 59, 27, 0.2);
}
.text-danger {
    color: #dc3545;
}

@media (max-width: 900px) {
    .about-grid {
        grid-template-columns: 1fr;
        gap: 4rem;
    }
    .spice-form .form-row {
        flex-direction: column;
        gap: 0;
    }
    .contact-form-wrapper {
        padding: 2rem;
    }
}

/* Map Section */
.contact-map-section {
    position: relative;
    width: 100%;
    height: 480px;
    background: #333636;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    overflow: hidden;
}
.map-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}
.contact-map-iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
    filter: invert(90%) hue-rotate(180deg) contrast(95%) brightness(95%);
    transition: filter 0.3s ease;
}
.btn-open-map {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 10;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #FFFFFF;
    color: #374151;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.18);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.22);
    text-decoration: none;
    transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.btn-open-map:hover {
    background: #F3F4F6;
    color: #111827;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}
.map-center-pin {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -100%);
    pointer-events: none;
    z-index: 5;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.pin-marker {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.5));
}
.pin-pulse {
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 14px;
    height: 6px;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
}
@keyframes pinBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
@keyframes pinShadow {
    0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.5; }
    50% { transform: translateX(-50%) scale(0.7); opacity: 0.25; }
}
@media (max-width: 768px) {
    .about-hero h1 {
        font-size: clamp(34px, 7vw, 42px) !important;
    }
    .contact-map-section {
        height: 380px;
    }
    .btn-open-map {
        top: 16px;
        left: 16px;
        font-size: 0.75rem;
        padding: 0.5rem 0.85rem;
    }
}
</style>
@endsection