@extends('frontend.layouts.master')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-home.css') }}?v=20260918-2">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-blog.css') }}?v=20260918-1">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-services.css') }}?v=20260918-2">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush
@section('meta')
<title>{{ $homeContent('page_services_text_1') }}</title>
<meta name="description" content="{{ $homeContent('page_services_seo_11') }}">
<meta property="og:title" content="{{ $homeContent('page_services_seo_12') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ page_route('services.index') }}">
<link rel="canonical" href="{{ page_route('services.index') }}">
@endsection
@section('full-content')
<main id="top">
<section class="pagetitle-section" aria-labelledby="services-page-title">
<div class="container w-container"><div class="pagetitle-inner">
<div class="pagetitle-grid">
<div class="pagetitle-heading-block"><h1 class="pagetitle-heading" id="services-page-title">{{ $homeContent('page_services_text_2') }}</h1></div>
<div class="pagetitle-image-block"><img class="pagetitle-image" src="{{ asset($homeContent('page_services_image_13')) }}" width="320" height="320" alt="" fetchpriority="high"></div>
</div>
<div class="pagetitle-desc-wrapper"><div class="pagetitle-right-desc-box">
<div class="page-pretitle">{{ $homeContent('page_services_text_3') }}</div>
<p class="pagetitle-desc-text">{{ $homeContent('page_services_text_4') }}</p>
<a class="pagetitle-link-block" href="#Section-Block" aria-label="Browse our services"><svg class="pagetitle-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18m-6-6 6 6 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
</div></div></div></div>
</section>
<section id="Section-Block" class="service-2-section section-padding" aria-label="Nafu services">
<div class="container w-container"><div class="service-2-section-inner">
@foreach($services as $service)
<article class="service-2-wrap {{ $loop->even ? 'bg-skin-2' : '' }}" id="{{ $service['slug'] }}" data-service="{{ $service['slug'] }}">
<div class="service-item-grid {{ $loop->even ? 'grid-2' : '' }}">
<div class="service-content-block {{ $loop->even ? 'right-content-block' : '' }}">
<h2 class="service-item-title">{{ $service['name'] }}</h2>
<p class="service-desc">{{ $service['description'] }}</p>
<div class="service-list-1 w-richtext"><ul>@foreach($service['items'] as $item)<li>{{ $item }}</li>@endforeach</ul></div>
<div class="service-btn-block"><a href="{{ page_route('services.show', $service['slug']) }}" class="btn-block dark-btn w-inline-block"><div class="btn-text">{{ $homeContent('page_services_text_5') }}</div><div class="btn-overlay bg-skin"></div></a></div>
</div>
<div class="service-image-block"><img src="{{ $service['image_url'] }}" alt="{{ $service['name'] }}" class="service-image" loading="lazy" decoding="async"></div>
</div></article>
@endforeach
</div></div></section>
<section class="cta-section section-padding-80">
<div class="container w-container"><div class="cta-section-grid">
<div class="cta-list-block">
<div class="cta-desc-block"><a href="{{ page_route('home') }}#about" class="cta-round-btn-block" aria-label="Meet Nafu"><img src="{{ asset($homeContent('page_services_image_14')) }}" class="cta-round-text-image" alt="" loading="lazy"><span class="nafu-cta-play" aria-hidden="true">↗</span></a></div>
<p class="cta-desc">{{ $homeContent('page_services_text_6') }}</p>
<div class="cta-btn-block"><a href="{{ page_route('home') }}#contact-modal" class="btn-block border-white w-inline-block"><div class="btn-text">{{ $homeContent('page_services_text_7') }}</div><div class="btn-overlay bg-skin"></div></a></div>
</div>
<div class="cta-content-box"><div class="cta-flex-box">
<div class="cta-image-block"><img src="{{ asset($homeContent('page_services_image_15')) }}" loading="lazy" alt="Handyman ready to help" class="cta-image"><div class="cta-bg-overlay"></div></div>
<div class="cta-contact-block">
<div class="cta-contact-box"><div class="cta-contact-icon"><img src="{{ asset('assets/dried-chilli/683ae87fcb9ea083f2cefef5_email -white.svg') }}" class="cta-contact-icon-image" alt=""></div><a href="mailto:admin@nafuservices.com" class="cta-contact-link">admin@nafuservices.com</a></div>
<div class="cta-contact-box"><div class="cta-contact-icon"><img src="{{ asset('assets/dried-chilli/683ae87f774ed8e134537a42_phone-call -white.svg') }}" class="cta-contact-icon-image" alt=""></div><a href="tel:+61481818836" class="cta-contact-link">{{ $homeContent('page_services_text_8') }}</a></div>
</div></div>
<div class="cta-section-title"><h2 class="cta-section-heading">{{ $homeContent('page_services_text_9') }}</h2></div>
</div></div></div></section>
<section class="marquee-section" aria-label="Reliable, renos, repairs"><div class="marquee-wrapper">@for($i = 0; $i < 2; $i++)<div class="nafu-service-marquee" @if($i) aria-hidden="true" @endif>{{ $homeContent('page_services_text_10') }}</div>@endfor</div></section>
</main>
@endsection
@push('scripts')
<script src="{{ asset('assets/dried-chilli/nafu-services.js') }}?v=20260918-2" defer></script>
@endpush
