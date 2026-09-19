@php
    $locale = app()->getLocale();
    $footerIsHome = request()->routeIs('home');
    $sharedSetting = fn ($key, $locale, $default = '') => renderData($systemSettings, "page_shared_{$key}_{$locale}", $default);
    $footerDescriptionEn = $sharedSetting('footer_description', 'en', 'Focused web experiences that turn ideas into useful products.');
    $footerDescriptionVi = $sharedSetting('footer_description', 'vi', 'Trải nghiệm web tập trung, biến ý tưởng thành sản phẩm hữu ích.');
    $footerEyebrowEn = $sharedSetting('footer_eyebrow', 'en', 'HAVE A PROJECT IN MIND?');
    $footerEyebrowVi = $sharedSetting('footer_eyebrow', 'vi', 'BẠN ĐANG CÓ MỘT DỰ ÁN?');
    $footerTitleEn = $sharedSetting('footer_title', 'en', 'Let’s build a website<br>that feels <em>different.</em>');
    $footerTitleVi = $sharedSetting('footer_title', 'vi', 'Hãy tạo nên một website<br>thật <em>khác biệt.</em>');
    $footerButtonEn = trim(str_replace('↗', '', $sharedSetting('footer_button', 'en', 'Start a project')));
    $footerButtonVi = trim(str_replace('↗', '', $sharedSetting('footer_button', 'vi', 'Bắt đầu dự án')));
    $footerCopyrightEn = str_replace('{year}', date('Y'), $sharedSetting('footer_copyright', 'en', '© {year} NAFU Services.'));
    $footerCopyrightVi = str_replace('{year}', date('Y'), $sharedSetting('footer_copyright', 'vi', '© {year} NAFU Services.'));
    $footerNavProjects = $sharedSetting('nav_projects', $locale, $locale === 'vi' ? 'Dự án đã tham gia' : 'Joined Projects');
    $footerNavServices = $sharedSetting('nav_services', $locale, $locale === 'vi' ? 'Dịch vụ' : 'Services');
    $footerNavNews = $sharedSetting('nav_news', $locale, $locale === 'vi' ? 'Bài viết' : 'News');
    $footerNavContact = $sharedSetting('nav_contact', $locale, $locale === 'vi' ? 'Liên hệ' : "Let's talk");
@endphp

<footer class="public-footer" id="contact">
    <div class="footer-glow" aria-hidden="true"></div>
    <div class="footer-shell">
        <div class="footer-top">
            <div class="footer-identity">
                <a class="footer-brand" href="{{ $footerIsHome ? '#top' : page_route('home') }}" aria-label="NAFU Services home">
                    <img class="footer-logo" src="{{ asset('assets/imgs/logo-hori.webp') }}" width="640" height="221" alt="NAFU Services" loading="lazy" decoding="async">
                </a>
                <p>{{ $locale === 'vi' ? $footerDescriptionVi : $footerDescriptionEn }}</p>
            </div>
            <div class="footer-pitch">
                <span>{{ $locale === 'vi' ? $footerEyebrowVi : $footerEyebrowEn }}</span>
                <h2>{!! $locale === 'vi' ? $footerTitleVi : $footerTitleEn !!}</h2>
                <a class="footer-cta {{ $footerIsHome ? 'js-open-contact' : '' }}" href="{{ $footerIsHome ? '#contact-modal' : page_route('home') . '#contact' }}">
                    <i></i><span>{{ $locale === 'vi' ? $footerButtonVi : $footerButtonEn }}</span><b class="external-arrow" aria-hidden="true"></b>
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ $locale === 'vi' ? $footerCopyrightVi : $footerCopyrightEn }}</p>
            <nav class="footer-links" aria-label="Footer navigation">
                <a class="{{ request()->routeIs('projects.*') ? 'is-active' : '' }}" href="{{ page_route('projects.index') }}">{{ $footerNavProjects }}</a>
                <a class="{{ request()->routeIs('services.*') ? 'is-active' : '' }}" href="{{ page_route('services.index') }}">{{ $footerNavServices }}</a>
                <a class="{{ request()->routeIs('news.*') ? 'is-active' : '' }}" href="{{ page_route('news.index') }}">{{ $footerNavNews }}</a>
                <a class="{{ $footerIsHome ? 'js-open-contact' : '' }}" href="{{ $footerIsHome ? '#contact-modal' : page_route('home') . '#contact' }}">{{ $footerNavContact }}</a>
            </nav>
            <a class="back-top" href="#top">{{ $locale === 'vi' ? 'Về đầu trang ↑' : 'Back to top ↑' }}</a>
        </div>
    </div>
</footer>
