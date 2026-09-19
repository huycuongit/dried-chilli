@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/nafu-contact.css') }}?v=20260918-1">
@endpush

@section('meta')
<title>{{ $homeContent('page_contact_text_1') }}</title>
<meta name="description" content="{{ $homeContent('page_contact_seo_32') }}">
<meta property="og:title" content="{{ $homeContent('page_contact_seo_33') }}">
<meta property="og:description" content="{{ $homeContent('page_contact_seo_34') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('contact.page') }}">
<link rel="canonical" href="{{ route('contact.page') }}">
@endsection

@section('full-content')
<main id="top">
<section class="nafu-contact-hero" aria-labelledby="contact-page-title">
<div class="container w-container">
<div class="nafu-contact-hero__eyebrow">{{ $homeContent('page_contact_text_2') }}<span></span></div>
<div class="nafu-contact-hero__grid">
<div><h1 id="contact-page-title">{{ $homeContent('page_contact_text_3') }}</h1></div>
<p>{{ $homeContent('page_contact_text_4') }}</p>
</div>
</div>
</section>

<section class="nafu-contact-main section-padding" aria-labelledby="contact-info-title">
<div class="container w-container">
<div class="nafu-contact-layout">
<div class="nafu-contact-details">
<div class="nafu-contact-details__heading">
<span>{{ $homeContent('page_contact_text_5') }}</span>
<h2 id="contact-info-title">{{ $homeContent('page_contact_text_6') }}</h2>
</div>
<div class="nafu-contact-info-grid">
<article class="nafu-contact-info-card">
<div class="nafu-contact-info-card__icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 43s14-12 14-25a14 14 0 1 0-28 0c0 13 14 25 14 25Z"/><circle cx="24" cy="18" r="4"/></svg></div>
<h3>{{ $homeContent('page_contact_text_7') }}</h3>
<p>{{ $homeContent('page_contact_text_8') }}<br>{{ $homeContent('page_contact_text_9') }}</p>
</article>
<article class="nafu-contact-info-card">
<div class="nafu-contact-info-card__icon" aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M15 8h7l3 9-5 4c3 6 7 10 13 13l4-5 9 3v7c0 3-2 5-5 5C21 43 5 27 5 8c0-3 2-5 5-5"/></svg></div>
<h3>{{ $homeContent('page_contact_text_10') }}</h3>
<p><a href="tel:+61481818836">{{ $homeContent('page_contact_text_11') }}</a><br><a href="mailto:admin@nafuservices.com">admin@nafuservices.com</a></p>
</article>
<article class="nafu-contact-info-card">
<div class="nafu-contact-info-card__icon" aria-hidden="true"><svg viewBox="0 0 48 48"><circle cx="24" cy="24" r="19"/><path d="M24 13v12l8 5"/></svg></div>
<h3>{{ $homeContent('page_contact_text_12') }}</h3>
<p>{{ $homeContent('page_contact_text_13') }}<br>{{ $homeContent('page_contact_text_14') }}</p>
</article>
</div>
</div>

<div class="nafu-contact-form-wrap" id="contact-form">
<div class="nafu-contact-form-heading"><span>{{ $homeContent('page_contact_text_15') }}</span><h2>{{ $homeContent('page_contact_text_16') }}</h2><p>{{ $homeContent('page_contact_text_17') }}</p></div>
@if(session('success'))<div class="nafu-contact-alert nafu-contact-alert--success" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="nafu-contact-alert" role="alert">{{ $homeContent('page_contact_text_19') }}</div>@endif
<form class="nafu-contact-form" action="{{ route('contact.store') }}" method="POST">
@csrf
<input type="hidden" name="source" value="contact-page">
<div class="nafu-contact-form__grid">
<label><span>{{ $homeContent('page_contact_text_20') }}</span><input name="full_name" type="text" value="{{ old('full_name') }}" placeholder="{{ $homeContent('page_contact_placeholder_35') }}" autocomplete="name" required>@error('full_name')<small>{{ $message }}</small>@enderror</label>
<label><span>{{ $homeContent('page_contact_text_21') }}</span><input name="email" type="email" value="{{ old('email') }}" placeholder="{{ $homeContent('page_contact_placeholder_36') }}" autocomplete="email">@error('email')<small>{{ $message }}</small>@enderror</label>
<label><span>{{ $homeContent('page_contact_text_22') }}</span><div class="nafu-contact-phone"><select name="phone_country" aria-label="Country calling code"><option value="+61" selected>+61</option><option value="+64">+64</option><option value="+84">+84</option></select><input name="phone" type="tel" value="{{ old('phone') }}" placeholder="{{ $homeContent('page_contact_placeholder_37') }}" autocomplete="tel"></div>@error('phone')<small>{{ $message }}</small>@enderror</label>
<label><span>{{ $homeContent('page_contact_text_23') }}</span><select name="project_type" required><option value="">{{ $homeContent('page_contact_text_24') }}</option>@foreach(config('nafu-services') as $slug => $service)<option value="{{ $slug }}" @selected(old('project_type') === $slug)>{{ $service['name'] }}</option>@endforeach<option value="other" @selected(old('project_type') === 'other')>{{ $homeContent('page_contact_text_25') }}</option></select>@error('project_type')<small>{{ $message }}</small>@enderror</label>
<label class="nafu-contact-form__message"><span>{{ $homeContent('page_contact_text_26') }}</span><textarea name="message" rows="5" placeholder="{{ $homeContent('page_contact_placeholder_38') }}" required>{{ old('message') }}</textarea>@error('message')<small>{{ $message }}</small>@enderror</label>
</div>
<button type="submit">{{ $homeContent('page_contact_text_27') }}<span aria-hidden="true">→</span></button>
</form>
</div>
</div>
</div>
</section>

<section class="nafu-contact-map" aria-label="Nafu Home Care location">
<iframe title="Map showing 265 Exhibition Street, Melbourne" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=265+Exhibition+St+Melbourne+VIC+3000&amp;output=embed"></iframe>
</section>

<section class="nafu-contact-cta">
<div class="container w-container"><div class="nafu-contact-cta__inner">
<div><span>{{ $homeContent('page_contact_text_28') }}</span><h2>{{ $homeContent('page_contact_text_29') }}</h2><p>{{ $homeContent('page_contact_text_30') }}</p></div>
<a href="tel:+61481818836">{{ $homeContent('page_contact_text_31') }}<b aria-hidden="true">↗</b></a>
</div></div>
</section>
</main>
@endsection