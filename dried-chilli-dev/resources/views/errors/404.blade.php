@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260919-1">
<link rel="stylesheet" href="{{ asset('assets/css/nafu-404.css') }}?v=20260919-1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush

@section('meta')
<title>{{ $homeContent('page_404_text_1') }}</title>
<meta name="description" content="{{ $homeContent('page_404_seo_5') }}">
<meta name="robots" content="noindex, follow">
@endsection

@section('full-content')
<main class="nafu-error-page">
    <section class="nafu-error" aria-labelledby="error-title">
        <div class="nafu-error__content">
            <p class="nafu-error__code" aria-hidden="true">404</p>
            <h1 id="error-title">{{ $homeContent('page_404_text_2') }}</h1>
            <p class="nafu-error__description">{{ $homeContent('page_404_text_3') }}</p>
            <div class="nafu-error__action">
                <a href="{{ page_route('home') }}" class="btn-block dark-btn w-inline-block">
                    <span class="btn-text">{{ $homeContent('page_404_text_4') }}</span>
                    <span class="btn-overlay bg-skin"></span>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection