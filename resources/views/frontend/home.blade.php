@extends('frontend.layouts.master')

@section('title', 'Jojo Little Kitchen — Signature Shrimp Chilli')
@section('meta_description', 'Bring bold shrimp chilli flavour, aromatic crunch and a little Jojo joy to everyday meals.')

@php
    $pageLayoutFields = collect(json_decode(file_get_contents(config_path('public-page-layout.json')), true, 512, JSON_THROW_ON_ERROR))->collapse()->all();
    $pageLayoutValue = static fn (string $key) => \App\Support\AboutPageContent::value($key, $pageLayoutFields, $systemSettings);
    $pageLayoutLink = static function (string $key) use ($pageLayoutValue) {
        $link = trim($pageLayoutValue($key));
        return preg_match('~^(?:/(?!/)|https?://|#)~i', $link) ? $link : '#';
    };
    $heroImage = $pageLayoutValue('page_layout_home_image_slide_1');
    $heroSrcset = \App\Support\ResponsivePageImages::srcset($heroImage);
    $storyImage = $pageLayoutValue('page_layout_home_story_image');
    $storyImagePath = '/' . ltrim((string) parse_url($storyImage, PHP_URL_PATH), '/');
    $storyImageHost = parse_url($storyImage, PHP_URL_HOST);
    $legacyStoryImage = $storyImagePath === '/images/story_spices-optimized.webp'
        && ($storyImageHost === null || strcasecmp($storyImageHost, request()->getHost()) === 0);
    $storySrcset = $legacyStoryImage
        ? asset('images/story_spices-420.webp') . ' 420w, ' . asset('images/story_spices-560-optimized.webp') . ' 560w, ' . asset('images/story_spices-optimized.webp') . ' 1024w'
        : \App\Support\ResponsivePageImages::srcset($storyImage);
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/jojo-home.css') }}?v={{ filemtime(public_path('assets/css/jojo-home.css')) }}">
@endpush

@section('full-content')
<main class="jojo-home" id="main-content">
    <section class="jojo-hero" aria-labelledby="jojo-hero-title">
        @if($heroImage !== '')
            <img class="jojo-hero-image" src="{{ asset($heroImage) }}" @if($heroSrcset !== '') srcset="{{ $heroSrcset }}" sizes="100vw" @endif alt="{{ $pageLayoutValue('page_layout_home_image_alt_1') }}" width="2048" height="683" fetchpriority="high">
        @endif
        <div class="jojo-hero-shade" aria-hidden="true"></div>
        <div class="jojo-container jojo-hero-inner">
            <div class="jojo-hero-copy">
                <span class="jojo-eyebrow jojo-hero-eyebrow">{{ $pageLayoutValue('page_layout_home_slide_1_01') }}</span>
                <h1 id="jojo-hero-title">{{ $pageLayoutValue('page_layout_home_slide_1_02') }}<br><em>{{ $pageLayoutValue('page_layout_home_slide_1_03') }}</em></h1>
                <p>{{ $pageLayoutValue('page_layout_home_slide_1_04') }}</p>
                <a class="jojo-button jojo-button-gold" href="{{ $pageLayoutLink('page_layout_home_link_slide_1') }}">{{ $pageLayoutValue('page_layout_home_slide_1_05') }} <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </section>

    <section class="jojo-benefits" aria-label="Why choose Jojo">
        <div class="jojo-container jojo-benefit-grid">
            <div class="jojo-benefit"><i data-lucide="flame" aria-hidden="true"></i><div><strong>Bold &amp; authentic</strong><small>Rich chilli, aromatic shrimp</small></div></div>
            <div class="jojo-benefit"><i data-lucide="soup" aria-hidden="true"></i><div><strong>Versatile &amp; delicious</strong><small>Perfect with rice, noodles and more</small></div></div>
            <div class="jojo-benefit"><i data-lucide="leaf" aria-hidden="true"></i><div><strong>Made with care</strong><small>A little flavour goes a long way</small></div></div>
            <div class="jojo-benefit"><i data-lucide="truck" aria-hidden="true"></i><div><strong>Australia-wide delivery</strong><small>See our shipping policy for rates</small></div></div>
        </div>
    </section>

    <section class="jojo-products jojo-section" id="products" aria-labelledby="jojo-products-title">
        <div class="jojo-container">
            <div class="jojo-section-heading">
                <span class="jojo-eyebrow">Our products</span>
                <h2 id="jojo-products-title">{{ $hasFeaturedProducts ? 'Meet Our Shrimp Chilli Range' : 'Explore Our Products' }}</h2>
                <p>Find your favourite way to bring Jojo flavour to the table.</p>
            </div>
            @if($latestProducts->isNotEmpty())
                <div class="jojo-product-grid">
                    @foreach($latestProducts as $product)
                        @php
                            $cardOverride = config('jojo-home.card_images.' . $product->slug);
                            $cardImage = is_array($cardOverride) && $product->image === $cardOverride['legacy_source']
                                ? $cardOverride['replacement'] : null;
                            $productSrcset = $cardImage ? '' : \App\Support\ResponsiveProductImages::srcset($product->image);
                            $salePrice = $product->sale_price;
                            $saleEligible = match ($product->sale_type) {
                                'limited_big' => \App\Support\Shop\CartItemPricing::limitedSaleIsActive($product),
                                'daily_flash' => $product->sale_start_date && $product->sale_end_date
                                    && \Carbon\Carbon::parse($product->sale_start_date)->lte(now())
                                    && \Carbon\Carbon::parse($product->sale_end_date)->gt(now()),
                                default => true,
                            };
                            $onSale = $saleEligible && $salePrice !== null && (float) $salePrice > 0 && (float) $salePrice < (float) $product->price;
                        @endphp
                        <article class="jojo-product-card">
                            <a class="jojo-product-image" href="{{ route('page.product', $product->slug) }}" aria-label="View {{ $product->name }}">
                                <img src="{{ $cardImage ? asset($cardImage) : $product->image_url }}" @if($productSrcset !== '') srcset="{{ $productSrcset }}" sizes="(max-width: 700px) 90vw, (max-width: 1100px) 45vw, 360px" @endif alt="{{ $product->name }}" width="360" height="300" loading="lazy" decoding="async">
                            </a>
                            <div class="jojo-product-info">
                                <h3><a href="{{ route('page.product', $product->slug) }}">{{ $product->name }}</a></h3>
                                @if($product->description)<p>{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 86) }}</p>@endif
                                <div class="jojo-product-bottom">
                                    <div class="jojo-price">
                                        <strong>${{ number_format($onSale ? $product->sale_price : $product->price, 2) }}</strong>
                                        @if($onSale)<s>${{ number_format($product->price, 2) }}</s>@endif
                                    </div>
                                    <button type="button" class="quick-add jojo-add" data-product-id="{{ $product->id }}" aria-label="Add {{ $product->name }} to cart">Add to Cart</button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="jojo-empty-products">Explore the shop for what is available today.</p>
            @endif
            <a class="jojo-button jojo-button-outline jojo-shop-all" href="{{ route('page.shop') }}">Shop all products <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>

    @if($pageLayoutValue('page_layout_home_story_visible') === '1')
        <section class="jojo-story" aria-labelledby="jojo-story-title">
            <div class="jojo-story-image">
                @if($storyImage !== '')<img src="{{ asset($storyImage) }}" @if($storySrcset !== '') srcset="{{ $storySrcset }}" sizes="(max-width: 760px) 100vw, 50vw" @endif alt="{{ $pageLayoutValue('page_layout_home_story_image_alt_text') }}" width="1024" height="760" loading="lazy" decoding="async">@endif
            </div>
            <div class="jojo-story-copy">
                <span class="jojo-eyebrow">{{ $pageLayoutValue('page_layout_home_story_label') }}</span>
                <h2 id="jojo-story-title">{{ $pageLayoutValue('page_layout_home_story_title') }}</h2>
                <p>{{ $pageLayoutValue('page_layout_home_story_description') }}</p>
                <a class="jojo-button jojo-button-gold" href="{{ $pageLayoutLink('page_layout_home_story_button_link') }}">{{ $pageLayoutValue('page_layout_home_story_button_text') }} <span aria-hidden="true">&rarr;</span></a>
            </div>
        </section>
    @endif

    <section class="jojo-recipes jojo-section" id="recipes" aria-labelledby="jojo-recipes-title">
        <div class="jojo-container jojo-recipes-layout">
            <div class="jojo-recipes-intro">
                <span class="jojo-eyebrow">Recipe inspiration</span>
                <h2 id="jojo-recipes-title">Simple Ways to Enjoy</h2>
                <p>A little chilli goes a long way. Try it with your favourite meals.</p>
            </div>
            <div class="jojo-recipe-grid">
                <div class="jojo-recipe"><img src="{{ asset('images/jojo-recipe-noodles.webp') }}" alt="Noodles topped with crispy chilli" width="627" height="627" loading="lazy" decoding="async"><span>Noodles</span></div>
                <div class="jojo-recipe"><img src="{{ asset('images/jojo-recipe-fried-rice.webp') }}" alt="Fried rice topped with crispy chilli" width="627" height="627" loading="lazy" decoding="async"><span>Fried Rice</span></div>
                <div class="jojo-recipe"><img src="{{ asset('images/jojo-recipe-dumplings.webp') }}" alt="Dumplings with crispy chilli" width="627" height="627" loading="lazy" decoding="async"><span>Dumplings</span></div>
                <div class="jojo-recipe"><img src="{{ asset('images/jojo-recipe-eggs.webp') }}" alt="Halved eggs with crispy chilli" width="627" height="627" loading="lazy" decoding="async"><span>Eggs</span></div>
            </div>
        </div>
    </section>

    @if($homeReviews->isNotEmpty())
        <section class="jojo-reviews jojo-section" aria-labelledby="jojo-reviews-title">
            <div class="jojo-container">
                <div class="jojo-section-heading"><span class="jojo-eyebrow">What our customers say</span><h2 id="jojo-reviews-title">A little love from our kitchen community</h2></div>
                <div class="jojo-review-grid">
                    @foreach($homeReviews as $review)
                        @php $rating = filter_var($review['rating'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 5]]) ?: null; @endphp
                        <article class="jojo-review-card">
                            <img class="jojo-review-image" src="{{ asset($review['image']) }}" alt="{{ !empty($review['alt']) ? $review['alt'] : (!empty($review['name']) ? 'Photo from ' . $review['name'] : 'Customer review photo') }}" width="320" height="240" loading="lazy" decoding="async">
                            @if(!empty($review['caption']))<p class="jojo-review-quote">“{{ $review['caption'] }}”</p>@endif
                            @if($rating)<div class="jojo-stars" role="img" aria-label="{{ $rating }} out of 5 stars">{{ str_repeat('★', $rating) }}</div>@endif
                            @if(!empty($review['name']))<strong>{{ $review['name'] }}</strong>@endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@push('scripts')
<script src="{{ asset('js/lucide.min.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) window.lucide.createIcons({ root: document.querySelector('.jojo-benefits') });
});
</script>
@endpush
@endsection
