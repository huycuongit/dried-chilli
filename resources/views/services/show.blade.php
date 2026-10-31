@extends('frontend.layouts.master')
@php
    $cover = $service['image_url'];
    $quoteUrl = page_route('home', ['service' => $slug]) . '#contact-modal';
@endphp
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-service-content.css') }}?v=20260919-1">
<link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-home.css') }}?v=20260918-2">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-blog.css') }}?v=20260918-1">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-services.css') }}?v=20260918-2">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush
@section('meta')
<title>{{ $service['seo_title'] ?: $service['name'] . ' | ' . $companySetting('name', 'Nafu Services') }}</title>
<meta name="description" content="{{ $service['seo_description'] ?: $service['description'] }}">
@if($service['seo_keywords'])<meta name="keywords" content="{{ $service['seo_keywords'] }}">@endif
<meta property="og:title" content="{{ $service['seo_title'] ?: $service['name'] . ' | ' . $companySetting('name', 'Nafu Services') }}">
<meta property="og:description" content="{{ $service['seo_description'] ?: $service['description'] }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $cover }}">
<meta property="og:url" content="{{ page_route('services.show', $slug) }}">
<link rel="canonical" href="{{ page_route('services.show', $slug) }}">
@endsection
@section('full-content')
<main id="top">
<section class="pagetitle-section" aria-labelledby="service-page-title">
<div class="container w-container"><div class="pagetitle-inner">
<div class="pagetitle-grid">
<div class="pagetitle-heading-block"><h1 class="pagetitle-heading" id="service-page-title">{{ $service['name'] }}</h1></div>
<div class="pagetitle-image-block"><img src="{{ asset($homeContent('page_service_details_image_6')) }}" width="320" height="320" alt="" class="pagetitle-image" fetchpriority="high"></div>
</div>
<div class="pagetitle-desc-wrapper"><div class="pagetitle-right-desc-box">
<div class="page-pretitle">{{ $homeContent('page_service_details_text_1') }}</div>
<p class="pagetitle-desc-text">{{ $service['description'] }}</p>
<a href="#Section-Block" class="pagetitle-link-block" aria-label="Explore this service"><svg class="pagetitle-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18m-6-6 6 6 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
</div></div></div></div>
</section>
<section id="Section-Block" class="service-single-section section-padding">
<div class="container container-2 w-container"><div class="service-single-grid">
<div class="nafu-service-article">
<img src="{{ $cover }}" alt="{{ $service['name'] }}" class="service-single-image" loading="lazy" decoding="async">
<div class="service-single-list w-richtext ql-content">{!! $service['content'] !!}</div>
</div>
<aside aria-label="Service navigation"><div class="sticky-box">
<div class="service-banner"><div class="text-block">{{ $homeContent('page_service_details_text_4') }}</div><div><a href="{{ $quoteUrl }}" class="btn-block skin-btn w-inline-block"><div class="btn-text">{{ $homeContent('page_service_details_text_5') }}</div><div class="btn-overlay bg-dark"></div></a></div></div>
<nav class="service-sidebar-block" aria-label="Our services">
@foreach($allServices as $entry) @php($serviceSlug = $entry['slug'])
<div class="service-list-item"><a href="{{ page_route('services.show', $serviceSlug) }}" class="service-list-item-block w-inline-block {{ $serviceSlug === $slug ? 'w--current' : '' }}" @if($serviceSlug === $slug) aria-current="page" @endif><div>{{ $entry['name'] }}</div><svg class="service-list-item-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 12h18m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.5"/></svg></a></div>
@endforeach
</nav></div></aside>
</div></div></section>
</main>
@endsection
