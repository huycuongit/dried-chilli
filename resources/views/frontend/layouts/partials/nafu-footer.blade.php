@php
    $nafuFooterHome = request()->routeIs('home') ? '' : page_route('home');
@endphp
<section id="Footer" class="footer nafu-footer">
<div class="footer-inner">
<div class="w-layout-blockcontainer container w-container">
<div class="first-footer">
<div id="w-node-_4b87f2c6-20a9-4cea-e236-181faafab1fe-aafab1fb" class="footer-widget">
<div class="footer-widget-block widget-flex-box">
<div>
<a class="nafu-footer-brand" href="{{ $nafuFooterHome }}#top"><img class="nafu-logo-image" src="{{ asset($companySetting('logo', 'assets/nafu/nafu-logo.png')) }}" alt="{{ $companySetting('name', 'Nafu Services') }}" width="612" height="408" loading="lazy">
</a>
<p class="footer-desc">{{ $companySetting('footer_description', 'A local Melbourne team for apartment repairs, painting, flooring and maintenance. Professional service, clear prices and care for every detail.') }}</p>
</div>
</div>
</div>
<div class="footer-widget">
<div class="footer-widget-block">
<div class="footer-nav-block">
<div>
<div class="footer-title-2">Quick  links</div>
<ul role="list" class="footer-nav-list">
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#top" class="footer-nav-list-list">Home</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#about" class="footer-nav-list-list">About us</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ page_route('services.index') }}" class="footer-nav-list-list">Services</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ page_route('projects.index') }}" class="footer-nav-list-list">Projects</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ page_route('news.index') }}" class="footer-nav-list-list">Blog</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ route('contact.page') }}" class="footer-nav-list-list">Contact us</a>
</li>
</ul>
</div>
<div>
<div class="footer-title-2">Our services</div>
<ul role="list" class="footer-nav-list">
@foreach(config('nafu-services') as $slug => $service)
<li class="footer-nav-list-item">
<a href="{{ page_route('services.show', $slug) }}" class="footer-nav-list-list">{{ $service['name'] }}</a>
</li>
@endforeach
</ul>
</div>
</div>
</div>
</div>
<div class="footer-widget">
<div class="footer-contact-grid">
<div>
<div class="footer-title-2">Contact</div>
<div>
<div class="footer-contact-address-text">{{ $companySetting('address', '265 Exhibition St, Melbourne VIC 3000') }}</div>
<div>
<a href="tel:{{ preg_replace('/[^+0-9]/', '', $companySetting('hotline', '0481 818 836')) }}" class="footer-contact-link call-link">{{ $companySetting('hotline', '0481 818 836') }}</a>
</div>
<div>
<a href="mailto:{{ $companySetting('email', 'admin@nafuservices.com') }}" class="footer-contact-link">{{ $companySetting('email', 'admin@nafuservices.com') }}</a>
</div>
</div>
</div>
<div>
<div class="footer-title-2">Follow</div>
<ul role="list" class="footer-nav-list">
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#contact-modal" class="footer-nav-list-list {{ request()->routeIs('home') ? 'js-open-contact' : '' }}">Facebook</a>
</li>
<li class="footer-nav-list-item">
<a href="https://www.instagram.com/nafuservices/" class="footer-nav-list-list" target="_blank" rel="noopener noreferrer">Instagram</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#contact-modal" class="footer-nav-list-list {{ request()->routeIs('home') ? 'js-open-contact' : '' }}">LinkedIn</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#contact-modal" class="footer-nav-list-list {{ request()->routeIs('home') ? 'js-open-contact' : '' }}">YouTube</a>
</li>
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#contact-modal" class="footer-nav-list-list {{ request()->routeIs('home') ? 'js-open-contact' : '' }}">X</a>
</li>
</ul>
</div>
</div>
</div>
</div>
<div class="copyright-block">
<div class="copyright">
<div class="copyright-text">
{{ $companySetting('copyright', '© ' . date('Y') . ' Nafu Home Care. All rights reserved.') }}
<span class="footer-credit"> · Designed and developed by <a href="https://febdigi.com" target="_blank" rel="noopener noreferrer">FEB Digi</a></span>
</div>
</div>
</div>
</div>
<div class="bottom-footer">
<div class="footer-bottom-text">{{ $companySetting('footer_watermark', 'Nafu') }}</div>
</div>
</div>
<div class="w-embed">
<style>
.footer-form > input:-webkit-autofill,
.footer-form > input:-webkit-autofill:hover, 
.footer-form > input:-webkit-autofill:focus, 
.footer-form > input:-webkit-autofill:active,
.footer-form > input:-internal-autofill-selected {
  transition: background-color 5000s;
  background-color: rgba(255, 255, 255, 0.08) !important;
  -webkit-text-fill-color: #fff !important;
}
</style>

<style>
.contact-form input:-webkit-autofill,
.contact-form input:-webkit-autofill:hover, 
.contact-form input:-webkit-autofill:focus, 
.contact-form input:-webkit-autofill:active,
.contact-form input:-internal-autofill-selected {
  transition: background-color 5000s;
  background-color: transparent !important;
  -webkit-text-fill-color: #000 !important;
}
</style>
</div>
</section>

