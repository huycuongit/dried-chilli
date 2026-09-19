<div class="nafu-home-content">
<section class="about-1-section section-padding" id="about">
<div class="w-layout-blockcontainer container w-container">
<div class="about-1-grid">
<div class="about-1-image-block">
<div class="about-1-image-1-block">
<img src="{{ asset($homeContent('nafu_home_sections_image_58')) }}" loading="lazy" alt="Single Image" class="about-1-image-1">
</div>
<div class="about-1-image-2-block">
<img src="{{ asset($homeContent('nafu_home_sections_image_59')) }}" loading="lazy" alt="Single Image" class="about-1-image-2">
</div>
</div>
<div>
<div class="about-1-content-block">
<div class="pretitle-text">{{ $homeContent('nafu_home_sections_text_1') }}</div>
<h2 class="about-section-heading">{{ $homeContent('nafu_home_sections_text_2') }}</h2>
<div class="about-1-desc-block">
<p>{{ $homeContent('nafu_home_sections_text_3') }}</p>
<p>{{ $homeContent('nafu_home_sections_text_4') }}</p>
</div>
<div class="about-1-btn-block">
<a href="#about" class="btn-block dark-btn w-inline-block">
<div class="btn-text">{{ $homeContent('nafu_home_sections_text_5') }}</div>
<div class="btn-overlay bg-skin">
</div>
</a>
</div>
</div>
</div>
</div>
</div>
</section>
@include('frontend.layouts.partials.nafu-services')
<section class="project-1-section section-padding" id="home-projects">
@php
    $homeDatabaseProjects = isset($projects) ? $projects->values()->take(3) : collect();
    $homeProjectCards = $homeDatabaseProjects->map(function ($project, $index) {
            $fallbackImages = [
                '682aef9310703914675fd085_project-img (4).avif',
                '682aefe6a46d07cc1744fa9d_project-img (3).avif',
                '682ade1088e04d40f8534321_project-0 (1).avif',
            ];

            return [
                'title' => $project->title,
                'image_url' => $project->avatar
                    ? $project->image_url
                    : asset('assets/nafu/'.$fallbackImages[$index % count($fallbackImages)]),
                'url' => page_route('projects.show', $project->slug),
            ];
        });
@endphp
<div class="w-layout-blockcontainer container w-container">
<div class="section-title center-text">
<h2 class="section-heading">{{ $homeContent('nafu_home_sections_text_6') }}</h2>
</div>
<div class="project-1-section-inner">
<div class="w-dyn-list">
<div role="list" class="project-1-grid w-dyn-items">
@foreach($homeProjectCards->take(2) as $card)
<div role="listitem" class="w-dyn-item">
<a href="{{ $card['url'] }}" class="project-1-link-block nafu-home-project-link" aria-label="View {{ $card['title'] }} details">
<div class="project-1-thumbnail">
<div class="project-item-btn-block">
<div class="btn-block skin-btn w-inline-block">
<div class="btn-text">{{ $homeContent('nafu_home_sections_text_7') }}</div>
<div class="btn-overlay bg-dark"></div>
</div>
</div>
<img src="{{ $card['image_url'] }}" loading="lazy" alt="{{ $card['title'] }}" class="project-1-image">
</div>
<div class="project-1-content-block">

<h3 class="project-1-item-title">{{ $card['title'] }}</h3>
</div>
</a>
</div>
@endforeach
</div>
</div>
@if($homeProjectCards->count() > 2)
@php($card = $homeProjectCards->get(2))
<div class="project-1-main-wrap">
<div class="project-1-wrap-center nafu-home-project-center">
<div class="w-dyn-list">
<div role="list" class="w-dyn-items">
<div role="listitem" class="w-dyn-item">
<a href="{{ $card['url'] }}" class="project-1-link-block nafu-home-project-link" aria-label="View {{ $card['title'] }} details">
<div class="project-1-thumbnail">
<img src="{{ $card['image_url'] }}" loading="lazy" alt="{{ $card['title'] }}" class="project-1-image project-center">
<div class="project-item-btn-block">
<div class="btn-block skin-btn w-inline-block">
<div class="btn-text">{{ $homeContent('nafu_home_sections_text_8') }}</div>
<div class="btn-overlay bg-dark"></div>
</div>
</div>
</div>
<div class="project-1-content-block">

<h3 class="project-1-item-title">{{ $card['title'] }}</h3>
</div>
</a>
</div>
</div>
</div>
</div>
</div>
@endif
</div>
<div class="nafu-home-projects-more"><a href="{{ page_route('projects.index') }}" class="btn-block dark-btn w-inline-block"><span class="btn-text">{{ $homeContent('nafu_home_sections_text_9') }}</span><span class="btn-overlay bg-skin"></span></a></div>
</div>
</section>
<section class="cta-1-section section-padding-80">
<div class="w-layout-blockcontainer container w-container">
<div class="cta-1-section-inner">
<div class="cta-1-content-block">
<div class="pretitle-text">{{ $homeContent('nafu_home_sections_text_10') }}</div>
<h2 class="cta-1-title">{{ $homeContent('nafu_home_sections_text_11') }}</h2>
<div class="cta-contact-block cta-2-block center-box">
<div class="cta-contact-box">
<div class="cta-contact-icon dark-bg">
<img src="{{ asset($homeContent('nafu_home_sections_image_60')) }}" loading="lazy" alt="Image">
</div>
<div>
<a href="mailto:admin@nafuservices.com" class="cta-contact-link dark-link">admin@nafuservices.com</a>
</div>
</div>
<div class="cta-contact-box">
<div class="cta-contact-icon dark-bg">
<img src="{{ asset($homeContent('nafu_home_sections_image_61')) }}" loading="lazy" alt="Image">
</div>
<div>
<a href="tel:+61481818836" class="cta-contact-link dark-link">{{ $homeContent('nafu_home_sections_text_12') }}</a>
</div>
</div>
</div>
<div class="cta-1-btn-block">
<a href="#contact-modal" class="btn-block dark-btn w-inline-block js-open-contact">
<div class="btn-text">{{ $homeContent('nafu_home_sections_text_13') }}</div>
<div class="btn-overlay bg-skin">
</div>
</a>
</div>
</div>
<img src="{{ asset($homeContent('nafu_home_sections_image_62')) }}" loading="lazy" alt="Single Image" class="cta-1-image-1">
<img src="{{ asset($homeContent('nafu_home_sections_image_63')) }}" loading="lazy" alt="Single Image" class="cta-1-image-2">
</div>
</div>
</section>
<section class="marquee-section">
<div class="marquee-wrapper">
<div class="marquee-block">
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_14') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_15') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_16') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_17') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_18') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_19') }}</div>
<div class="marquee-text">/</div>
</div>
<div class="marquee-block">
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_20') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_21') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_22') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_23') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_24') }}</div>
<div class="marquee-text">/</div>
<div class="marquee-text">{{ $homeContent('nafu_home_sections_text_25') }}</div>
<div class="marquee-text">/</div>
</div>
</div>
</section>
<section class="nafu-why section-padding" id="home-pricing">
<div class="w-layout-blockcontainer container w-container">
<div class="nafu-why__grid">
<div class="nafu-why__intro">
<div class="nafu-why__eyebrow"><span>{{ $homeContent('nafu_home_sections_text_26') }}</span><i aria-hidden="true"></i></div>
<h2>{{ $homeContent('nafu_home_sections_text_27') }}</h2>
<p>{{ $homeContent('nafu_home_sections_text_28') }}</p>
<ul class="nafu-why__benefits">
<li>{{ $homeContent('nafu_home_sections_text_29') }}</li>
<li>{{ $homeContent('nafu_home_sections_text_30') }}</li>
<li>{{ $homeContent('nafu_home_sections_text_31') }}</li>
<li>{{ $homeContent('nafu_home_sections_text_32') }}</li>
<li>{{ $homeContent('nafu_home_sections_text_33') }}</li>
</ul>
<a href="#contact-modal" class="nafu-why__primary js-open-contact">{{ $homeContent('nafu_home_sections_text_34') }}<span aria-hidden="true">{{ $homeContent('nafu_home_sections_text_35') }}</span></a>
</div>
<div class="nafu-why__cards">
<article class="nafu-why-card nafu-why-card--home">
<div class="nafu-why-card__tag">{{ $homeContent('nafu_home_sections_text_36') }}</div>
<div class="nafu-why-card__main">
<div class="nafu-why-card__copy">
<div class="nafu-why-card__icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M7 22.5 24 8l17 14.5M11.5 20v20h10V29h5v11h10V20"/></svg></div>
<h3>{{ $homeContent('nafu_home_sections_text_37') }}</h3>
<p>{{ $homeContent('nafu_home_sections_text_38') }}</p>
<a href="#contact-modal" class="nafu-why-card__button js-open-contact">{{ $homeContent('nafu_home_sections_text_39') }}</a>
</div>
<ul class="nafu-why-card__list">
<li>{{ $homeContent('nafu_home_sections_text_40') }}</li><li>{{ $homeContent('nafu_home_sections_text_41') }}</li><li>{{ $homeContent('nafu_home_sections_text_42') }}</li><li>{{ $homeContent('nafu_home_sections_text_43') }}</li><li>{{ $homeContent('nafu_home_sections_text_44') }}</li>
</ul>
</div>
</article>
<article class="nafu-why-card nafu-why-card--manager">
<div class="nafu-why-card__tag">{{ $homeContent('nafu_home_sections_text_45') }}</div>
<div class="nafu-why-card__main">
<div class="nafu-why-card__copy">
<div class="nafu-why-card__icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M9 41h30M14 41V10h20v31M20 16h3m5 0h3m-11 7h3m5 0h3m-11 7h3m5 0h3m-7 11v-6h5v6"/></svg></div>
<h3>{{ $homeContent('nafu_home_sections_text_46') }}</h3>
<p>{{ $homeContent('nafu_home_sections_text_47') }}</p>
<a href="#contact-modal" class="nafu-why-card__button js-open-contact">{{ $homeContent('nafu_home_sections_text_48') }}</a>
</div>
<ul class="nafu-why-card__list">
<li>{{ $homeContent('nafu_home_sections_text_49') }}</li><li>{{ $homeContent('nafu_home_sections_text_50') }}</li><li>{{ $homeContent('nafu_home_sections_text_51') }}</li><li>{{ $homeContent('nafu_home_sections_text_52') }}</li><li>{{ $homeContent('nafu_home_sections_text_53') }}</li>
</ul>
</div>
</article>
</div>
</div>
</div>
</section>
@include('frontend.layouts.partials.nafu-testimonials')
@include('frontend.layouts.partials.nafu-home-blog')
<section class="newsletter-section">
<div class="newsletter-bg-overlay">
</div>
<div class="w-layout-blockcontainer container w-container">
<div class="footer-info-wrapper">
<div class="footer-client-wrapper">
<div class="footer-client-title">{{ $homeContent('nafu_home_sections_text_54') }}</div>
<div class="footer-client-box">
<img src="{{ asset($homeContent('nafu_home_sections_image_64')) }}" loading="lazy" alt="Client Image" class="footer-client-image">
<img src="{{ asset($homeContent('nafu_home_sections_image_65')) }}" loading="lazy" alt="Client Image" class="footer-client-image">
<img src="{{ asset($homeContent('nafu_home_sections_image_66')) }}" loading="lazy" alt="Client Image" class="footer-client-image">
<img src="{{ asset($homeContent('nafu_home_sections_image_67')) }}" loading="lazy" alt="Client Image" class="footer-client-image">
</div>
</div>
<h2 class="footer-main-title">{{ $homeContent('nafu_home_sections_text_55') }}</h2>
<div class="footer-form-block w-form">
<form id="email-form-2" class="footer-form nafu-newsletter-form">
<div class="footer-form-grid">
<input class="footer-text-field w-input" maxlength="256" name="email-2" data-name="Email 2" placeholder="Your email address" type="email" id="email-2" required="required">
<input type="submit" class="btn-block grey-submit-btn w-button" value="Submit now">
</div>
</form>
<div class="success-message w-form-done" hidden="hidden">
<div>{{ $homeContent('nafu_home_sections_text_56') }}</div>
</div>
<div class="error-message w-form-fail" hidden="hidden">
<div>{{ $homeContent('nafu_home_sections_text_57') }}</div>
</div>
</div>
<img src="{{ asset($homeContent('nafu_home_sections_image_68')) }}" loading="lazy" alt="Image" class="info-bg-image">
</div>
</div>
</section>
</div>
