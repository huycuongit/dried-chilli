@extends('frontend.layouts.master')
@php
    $cover = $article->avatar ? (str_starts_with($article->avatar, 'assets/') ? asset($article->avatar) : Storage::url($article->avatar)) : asset($homeContent('page_news_details_image_9'));
    $description = strip_tags($article->description ?: 'Practical ideas for a better home from your local Melbourne team.');
    $publishedAt = $article->publish_time ?: \Carbon\Carbon::parse($article->created_at);
    $seoTitle = $article->meta?->title ?: $article->name;
@endphp
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260918-2">
<link rel="stylesheet" href="{{ asset('assets/css/nafu-blog.css') }}?v=20260918-2">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap">
@endpush
@section('meta')
<title>{{ $seoTitle }} | Nafu Home Care</title>
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($article->meta?->description ?: $description), 160) }}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $cover }}">
<meta property="og:url" content="{{ page_route('news.show', $article->slug) }}">
<link rel="canonical" href="{{ page_route('news.show', $article->slug) }}">
@endsection
@section('full-content')
<main id="top">
<section class="pagetitle-section" aria-labelledby="news-page-title"><div class="container w-container"><div class="pagetitle-inner">
<div class="pagetitle-grid">
<div class="pagetitle-heading-block">
<div class="blog-single-meta-block"><div class="blog-author-block">{{ $article->author_name ?: 'Nafu Home Care' }}</div><div class="blog-post-separator">/</div><time class="blog-post-month-text" datetime="{{ $publishedAt->toDateString() }}">{{ $publishedAt->format('F j, Y') }}</time></div>
<h1 class="pagetitle-heading" id="news-page-title">{{ $article->name }}</h1>
</div>
<div class="pagetitle-image-block"><img src="{{ asset($homeContent('page_news_details_image_11')) }}" width="320" height="320" class="pagetitle-image" alt="" fetchpriority="high"></div>
</div>
<div class="pagetitle-desc-wrapper"><div class="pagetitle-right-desc-box">
<div class="page-pretitle">{{ $homeContent('page_news_details_text_4') }}</div><p class="pagetitle-desc-text">{{ $description }}</p>
<a href="#Section-Block" class="pagetitle-link-block" aria-label="Read article"><svg class="pagetitle-arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18m-6-6 6 6 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
</div></div></div></div></section>
<section id="Section-Block" class="blog-single-section section-padding"><div class="container container-2 w-container"><article class="blog-single-wrapper">
<img src="{{ $cover }}" alt="{{ $article->name }}" class="blog-single-image" loading="lazy" decoding="async">
<div class="nafu-news-article-body">
<div class="blog-rich-text w-richtext ql-content">{!! $article->content !!}</div>
</div>
<a class="nafu-news-back" href="{{ page_route('news.index') }}">{{ $homeContent('page_news_details_text_8') }}</a>
</article></div></section>
</main>
@endsection
