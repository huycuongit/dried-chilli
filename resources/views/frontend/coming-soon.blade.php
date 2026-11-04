@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-home.css') }}?v=20260919-1">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-404.css') }}?v=20260919-1">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-coming-soon.css') }}?v=20261104-1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush

@section('meta')
<title>Coming Soon | Dried Chili</title>
<meta name="description" content="Something new is on the way from Dried Chili. Check back soon.">
<meta name="robots" content="noindex, follow">
@endsection

@section('full-content')
<main class="nafu-error-page">
    <section class="nafu-error nafu-coming-soon" aria-labelledby="coming-soon-title">
        <div class="nafu-error__content">
            <p class="nafu-coming-soon__badge">
                <span class="nafu-coming-soon__dot" aria-hidden="true"></span>
                In the works
            </p>
            <p class="nafu-error__code nafu-coming-soon__word" aria-hidden="true">Soon</p>
            <h1 id="coming-soon-title">Something hot is coming</h1>
            <p class="nafu-error__description">We're putting the finishing touches on this page. In the meantime, explore our range of dried chilli in the shop.</p>
            <div class="nafu-error__action nafu-coming-soon__actions">
                <a href="{{ page_route('page.shop') }}" class="btn-block dark-btn w-inline-block">
                    <span class="btn-text">Shop now</span>
                    <span class="btn-overlay bg-skin"></span>
                </a>
                <a href="{{ page_route('home') }}" class="nafu-coming-soon__link">Back to home</a>
            </div>
        </div>
    </section>
</main>
@endsection
