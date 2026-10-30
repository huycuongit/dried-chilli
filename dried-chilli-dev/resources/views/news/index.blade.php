@extends('frontend.layouts.master')

@php
    $blogTitle = $homeContent('news_heading');
    $blogDescription = $homeContent('news_description');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260918-2">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-blog.css') }}?v=20260918-1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush

@section('meta')
    <title>{{ $homeContent('news_title') }} | Nafu Home Care</title>
    <meta name="description" content="{{ $blogDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $homeContent('news_title') }} | Nafu Home Care">
    <meta property="og:description" content="{{ $blogDescription }}">
    <meta property="og:url" content="{{ page_route('news.index') }}">
    <link rel="canonical" href="{{ page_route('news.index') }}">
@endsection

@section('full-content')
    <main id="top">
        <section class="pagetitle-section" aria-labelledby="blog-page-title">
            <div class="container w-container"><div class="pagetitle-inner">
                <div class="pagetitle-grid">
                    <div class="pagetitle-heading-block"><h1 class="pagetitle-heading" id="blog-page-title">{{ $blogTitle }}</h1></div>
                    <div class="pagetitle-image-block"><img class="pagetitle-image" src="{{ asset($homeContent('page_news_image_4')) }}" width="320" height="320" alt="" decoding="async" fetchpriority="high"></div>
                </div>
                <div class="pagetitle-desc-wrapper"><div class="pagetitle-right-desc-box">
                    <div class="page-pretitle">{{ $homeContent('news_title') }}</div>
                    <p class="pagetitle-desc-text">{{ $blogDescription }}</p>
                    <a class="pagetitle-link-block" href="#Section-Block" aria-label="Browse articles"><svg class="pagetitle-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18m-6-6 6 6 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div></div>
            </div></div>
        </section>

        <section id="Section-Block" class="blog-1-section section-padding" aria-label="Latest articles">
            <div class="container w-container"><div class="blog-1-grid">
                @forelse ($articles as $article)
                    @php
                        $articleTitle = $article->name;
                        $articleCategory = $article->category_name ?: 'Home care';
                        $cover = $article->avatar ? (str_starts_with($article->avatar, 'assets/') ? asset($article->avatar) : Storage::url($article->avatar)) : asset($homeContent('page_news_image_5'));
                        $publishedAt = $article->publish_time ?: ($article->created_at ? \Carbon\Carbon::parse($article->created_at) : null);
                    @endphp
                    <article class="blog-1-item-block"><a class="nafu-blog-card-link" href="{{ page_route('news.show', $article->localizedSlug()) }}" aria-labelledby="blog-title-{{ $article->id }}">
                        <div class="blog-1-thumbnail-block"><img class="blog-1-image" src="{{ $cover }}" alt="" loading="lazy" decoding="async"></div>
                        <div class="blog-1-content-block">
                            <div><span class="blog-category-text">{{ $articleCategory }}</span></div>
                            <div class="blog-bottom-content">
                                @if($publishedAt)<time class="blog-1-post-date" datetime="{{ $publishedAt->toDateString() }}">{{ $publishedAt->format('F j, Y') }}</time>@endif
                                <h2 class="blog-1-item-title" id="blog-title-{{ $article->id }}">{{ $articleTitle }}</h2>
                            </div>
                        </div>
                        <span class="blog-1-btn-block" aria-hidden="true"><span class="btn-block skin-btn"><span class="btn-text">{{ $homeContent('news_details_button') }}</span><span class="btn-overlay bg-dark"></span></span></span>
                    </a></article>
                @empty
                    <div class="nafu-blog-empty"><h2>{{ $homeContent('news_empty_heading') }}</h2><p>{{ $homeContent('news_empty_description') }}</p><a class="btn-block dark-btn" href="mailto:admin@nafuservices.com">Contact Nafu</a></div>
                @endforelse
            </div>
            @if($articles->hasPages())
                <nav class="nafu-blog-pagination" aria-label="Article pages">
                    @if(!$articles->onFirstPage())<a href="{{ $articles->previousPageUrl() }}" rel="prev">← Previous</a>@endif
                    @foreach($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" @if($page === $articles->currentPage()) aria-current="page" @endif>{{ $page }}</a>
                    @endforeach
                    @if($articles->hasMorePages())<a href="{{ $articles->nextPageUrl() }}" rel="next">Next →</a>@endif
                </nav>
            @endif
            </div>
        </section>
    </main>
@endsection
