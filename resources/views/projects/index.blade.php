@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/dried-chilli/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dried-chilli-projects.css') }}?v=20260919-2">
@endpush

@section('meta')
<title>{{ $homeContent('page_projects_text_1') }}</title>
<meta name="description" content="{{ $homeContent('page_projects_seo_20') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $homeContent('page_projects_seo_21') }}">
<meta property="og:description" content="{{ $homeContent('page_projects_seo_22') }}">
<meta property="og:url" content="{{ page_route('projects.index') }}">
<link rel="canonical" href="{{ page_route('projects.index') }}">
@endsection

@section('full-content')
<main id="top" class="nafu-projects-page">
    <section class="pagetitle-section" aria-labelledby="projects-title">
        <div class="container w-container">
            <div class="pagetitle-inner">
                <div class="pagetitle-grid">
                    <div class="pagetitle-heading-block">
                        <h1 class="pagetitle-heading" id="projects-title">{{ $homeContent('page_projects_text_3') }}</h1>
                    </div>
                    <div class="pagetitle-image-block">
                        <img src="{{ asset($homeContent('page_projects_image_23')) }}" alt="" class="pagetitle-image" width="320" height="320" fetchpriority="high">
                    </div>
                </div>
                <div class="pagetitle-desc-wrapper">
                    <div class="pagetitle-right-desc-box">
                        <div class="page-pretitle">{{ $homeContent('page_projects_text_4') }}</div>
                        <p class="pagetitle-desc-text">{{ $homeContent('page_projects_text_5') }}</p>
                        <a href="#project-list" class="pagetitle-link-block" aria-label="Browse projects">
                            <svg class="pagetitle-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18m-6-6 6 6 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="project-list" class="section-block-main"></div>
    </section>

    <section class="project-2-section section-padding" aria-label="Completed Nafu projects">
        <div class="container w-container">
            @if($projects->isNotEmpty())
                <div class="project-2-list">
                    @foreach($projects as $project)
                        @php($projectImage = $project->image_url)
                        <article class="project-2-item">
                            <div class="project-item-block project2">
                                <div class="project-thumbnail-wrapper-2">
                                    <a href="{{ page_route('projects.show', $project->slug) }}" class="project-thumbnail-block" aria-label="View {{ $project->title }} details">
                                        <img src="{{ $projectImage }}" alt="{{ $project->title }}" class="project-image" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async">
                                    </a>
                                    <div class="project-item-btn-block">
                                        <a href="{{ page_route('projects.show', $project->slug) }}" class="btn-block skin-btn w-inline-block">
                                            <span class="btn-text">{{ $homeContent('page_projects_text_8') }}</span>
                                            <span class="btn-overlay bg-dark"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="project-content-block project-2">
                                    <a href="{{ page_route('projects.show', $project->slug) }}" class="project-item-title">{{ $project->title }}</a>
                                    <p class="project-desc-text">{{ $project->description }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                @if($projects->hasPages())
                    <nav class="nafu-projects-pagination" aria-label="Project pages">{{ $projects->links() }}</nav>
                @endif
            @else
                <div class="nafu-projects-empty">
                    <h2>{{ $homeContent('page_projects_text_13') }}</h2>
                    <p>{{ $homeContent('page_projects_text_14') }}</p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
