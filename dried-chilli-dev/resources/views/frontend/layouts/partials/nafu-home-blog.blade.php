@php
    $homeArticles = isset($news) ? $news->take(3) : collect();
@endphp
<section class="blog-1-section section-bottom-padding" id="home-blog">
<div class="container w-container"><div class="blog-1-grid">
@forelse($homeArticles as $article)
@php
    $image = $article->avatar ? (str_starts_with($article->avatar, 'assets/') ? asset($article->avatar) : Storage::url($article->avatar)) : asset('assets/nafu/682ad431addb8bf5a550e766_blog (2).avif');
    $date = $article->publish_time ?: \Carbon\Carbon::parse($article->created_at);
@endphp
<article class="blog-1-item-block"><a class="nafu-blog-card-link" href="{{ page_route('news.show', $article->slug) }}" aria-label="{{ $article->name }}">
<div class="blog-1-thumbnail-block"><img src="{{ $image }}" class="blog-1-image" loading="lazy" alt="" decoding="async"></div>
<div class="blog-1-content-block"><div><div class="blog-category-text">{{ $article->category_name ?: 'Home care' }}</div></div><div class="blog-bottom-content"><time class="blog-1-post-date" datetime="{{ $date->toDateString() }}">{{ $date->format('F j, Y') }}</time><h3 class="blog-1-item-title">{{ $article->name }}</h3></div></div>
<div class="blog-1-btn-block"><span class="btn-block skin-btn w-inline-block"><span class="btn-text">View details</span><span class="btn-overlay bg-dark"></span></span></div>
</a></article>
@empty
<div class="nafu-blog-empty"><h3>New insights are on the way.</h3><p>Check back soon for practical home care advice from Nafu.</p></div>
@endforelse
</div></div></section>
