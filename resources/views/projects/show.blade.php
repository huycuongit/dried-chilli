@extends('frontend.layouts.master')

@php
    $heroImage = $project->avatar ? $project->image_url : asset($homeContent('page_project_details_image_29'));
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-project-detail.css') }}?v=20260919-4">
@endpush

@section('meta')
    <title>{{ $project->title }} | {{ $companySetting('name', 'Nafu Services') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($project->description), 155) }}">
    <meta property="og:title" content="{{ $project->title }} | {{ $companySetting('name', 'Nafu Services') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($project->description), 155) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ page_route('projects.show', $project->slug) }}">
    <meta property="og:image" content="{{ $heroImage }}">
    <link rel="canonical" href="{{ page_route('projects.show', $project->slug) }}">
@endsection

@section('full-content')
    <main id="top" class="nafu-work-detail">
        <section class="pagetitle-section" aria-labelledby="project-title">
            <div class="w-layout-blockcontainer container w-container">
                <div class="pagetitle-inner">
                    <div class="pagetitle-grid">
                        <div class="pagetitle-heading-block">
                            <h1 id="project-title" class="pagetitle-heading">{{ $project->title }}</h1>
                        </div>
                        <div class="pagetitle-image-block">
                            <img src="{{ asset($homeContent('page_project_details_image_29')) }}" alt="" aria-hidden="true" class="pagetitle-image">
                        </div>
                    </div>
                    <div class="pagetitle-desc-wrapper">
                        <div class="pagetitle-right-desc-box">
                            <div class="page-pretitle">{{ $homeContent('page_project_details_text_5') }}</div>
                            <p class="pagetitle-desc-text">{{ $project->description }}</p>
                            <a href="#work-details" class="pagetitle-link-block w-inline-block" aria-label="Read project details">
                                <svg width="22" height="25" viewBox="0 0 22 25" fill="none" aria-hidden="true"><path d="M11 1v21M2 14l9 9 9-9" stroke="white" stroke-width="1.8"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="work-details" class="project-single-section section-padding">
            <div class="w-layout-blockcontainer container container-2 w-container">
                <div class="project-single-grid">
                    <div class="project-single-wrap">
                        <img src="{{ $heroImage }}" alt="{{ $project->title }}" fetchpriority="high" class="project-single-page-image">
                        <h2 class="project-single-title">{{ $homeContent('page_project_details_text_6') }}</h2>
                        <p>{{ $project->description }}</p>
                    </div>
                    <div class="project-rich-text w-richtext ql-content">
                        {!! $project->content !!}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
