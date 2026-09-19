@php
    $reviews = [
        ['name' => $homeContent('reviews_field_6'), 'initials' => $homeContent('reviews_field_7'), 'service' => $homeContent('reviews_field_8'), 'text' => $homeContent('reviews_field_9')],
        ['name' => $homeContent('reviews_field_10'), 'initials' => $homeContent('reviews_field_11'), 'service' => $homeContent('reviews_field_12'), 'text' => $homeContent('reviews_field_13')],
        ['name' => $homeContent('reviews_field_14'), 'initials' => $homeContent('reviews_field_15'), 'service' => $homeContent('reviews_field_16'), 'text' => $homeContent('reviews_field_17')],
    ];
    $partners = [
        ['name' => $homeContent('reviews_field_18'), 'image' => $homeContent('reviews_field_19'), 'url' => $homeContent('reviews_field_20')],
        ['name' => $homeContent('reviews_field_21'), 'image' => $homeContent('reviews_field_22'), 'url' => $homeContent('reviews_field_23')],
        ['name' => $homeContent('reviews_field_24'), 'image' => $homeContent('reviews_field_25'), 'url' => $homeContent('reviews_field_26')],
        ['name' => $homeContent('reviews_field_27'), 'image' => $homeContent('reviews_field_28'), 'url' => $homeContent('reviews_field_29')],
        ['name' => $homeContent('reviews_field_30'), 'image' => $homeContent('reviews_field_31'), 'url' => $homeContent('reviews_field_32')],
    ];
@endphp
<section class="nafu-testimonials" id="home-reviews" aria-labelledby="reviews-title">
    <div class="container w-container">
        <h2 id="reviews-title">{{ $homeContent('nafu_testimonials_text_1') }}</h2>
        <div class="nafu-review-grid">
            @foreach($reviews as $review)
                <article class="nafu-review-card">
                    <svg class="nafu-quote-icon" viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M3 17C3 9 6 5 13 4v5c-4 1-5 3-5 6h5v13H3zm16 0c0-8 3-12 10-13v5c-4 1-5 3-5 6h5v13H19z"/></svg>
                    <p>{{ $review['text'] }}</p>
                    <div class="nafu-review-person">
                        <div><h3>{{ $review['name'] }}</h3><span>{{ $review['service'] }}</span></div>
                        <div class="nafu-review-avatar" aria-hidden="true">{{ $review['initials'] }}</div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<section class="nafu-partners" aria-label="Our partners">
    <div class="nafu-partner-window"><div class="nafu-partner-track">
        @for($copy = 0; $copy < 2; $copy++)
            <div class="nafu-partner-group" @if($copy) aria-hidden="true" inert @endif>
                @foreach($partners as $partner)
                    <a href="{{ $partner['url'] }}" target="_blank" rel="noopener noreferrer" class="nafu-partner-logo"><img src="{{ asset('assets/nafu/' . $partner['image']) }}" alt="{{ $partner['name'] }}" loading="lazy" decoding="async"></a>
                @endforeach
            </div>
        @endfor
    </div></div>
    <p>{{ $homeContent('nafu_testimonials_text_3') }}</p>
</section>
