<!-- Dual Header Architecture: Desktop (> 900px) & Mobile (<= 900px) -->
@include('frontend.layouts.partials.header-desktop')
@include('frontend.layouts.partials.header-mobile')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap');

    /* Native View Transitions Animations */
    ::view-transition-old(root) {
        animation: 0.3s cubic-bezier(0.4, 0, 0.2, 1) both fade-out-up;
    }
    ::view-transition-new(root) {
        animation: 0.4s cubic-bezier(0.4, 0, 0.2, 1) both fade-in-up;
    }
    
    @keyframes fade-out-up {
        to { opacity: 0; transform: translateY(-15px); }
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Fallback Page Transition for unsupported browsers */
    .page-transition-enter {
        opacity: 0;
        animation: fallbackFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    .page-transition-leave {
        opacity: 1;
        animation: fallbackFadeOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    @keyframes fallbackFadeIn { to { opacity: 1; } }
    @keyframes fallbackFadeOut { to { opacity: 0; } }

    :root {
        /* --- QUY TẮC 60-30-10 (FIERY SPICY THEME) --- */
        
        /* 60%: MÀU NỀN & CHỮ (Base & Text) */
        --spice-bg: #FDF9F1; /* Trắng ngà ánh vàng (Warm Cream) */
        --spice-bg-alt: #F0E6DD; /* Be đậm ấm cúng (Chai Latte Beige) cho trang phụ */
        --spice-bg-dark: #2A0800; /* Nâu Đỏ Rực Sâu (Hero/Header) */
        --spice-bg-bundle: #3A1B14; /* Nâu Ca-cao Đậm (Dark Cocoa) - Hợp tone ấm thay vì xanh */
        --spice-text: #28120B; /* Nâu than ấm cho text */
        
        /* 30%: MÀU PHỤ (Secondary) */
        --spice-text-light: #F4DFD4; /* Cam sữa nhạt cho chữ trên nền tối */
        --spice-secondary: #FFB300; /* Vàng Cà-ri (Curry Gold) - Thêm độ nóng */
        
        /* 10%: MÀU NHẤN CHÍNH (CTA / Accent) */
        --spice-primary: #E45D3E; /* Cam San Hô rực rỡ (Coral Red) */
        --spice-accent: #C73B1B; /* Đỏ Ớt Đậm (Hover state) */
        
        /* BỘ MÀU HỖ TRỢ MỞ RỘNG */
        --spice-fire: #C4141E;       /* Đỏ ớt tươi studio */
        --spice-tangerine: #FF7A1A;  /* Cam vỏ ớt bão hòa */
        --spice-honey: #E59528;      /* Vàng mật ong hổ phách */
        --spice-herb: #4E7837;       /* Xanh thảo mộc */
        --spice-mint: #7FD2BD;       /* Xanh mint tương phản */
        --spice-steel: #B5BAC2;      /* Bạc kim loại bếp ăn */
        
        /* CHUẨN HÓA BORDER-RADIUS TOÀN BỘ WEBSITE = 20PX */
        --spice-radius: 20px;
        
        --font-heading: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* GLOBAL RULE: TẤT CẢ PHẦN TỬ CÓ BORDER-RADIUS ĐỀU ĐỒNG BỘ 20PX */
    button:not(.btn-circle):not(.pin-marker):not(.cart-btn):not([class*="carousel"]):not(.slick-arrow):not(.swiper-button):not(.mobile-menu-toggle),
    .btn:not(.btn-circle),
    .btn-primary,
    .btn-outline,
    .btn-ghost,
    .btn-open-map,
    .submit-btn,
    input:not([type="checkbox"]):not([type="radio"]):not([type="color"]),
    select,
    textarea,
    .spice-form input,
    .spice-form select,
    .spice-form textarea,
    .card:not(.card-circle),
    .product-card,
    .feed-card,
    .contact-item,
    .contact-form-wrapper,
    .hero-sticker,
    .hero-subtitle,
    .search-box,
    .dropdown-selected,
    .dropdown-options,
    .price-input,
    .price-btn,
    .cart-item,
    .cart-summary,
    .faq-card,
    .alert {
        border-radius: var(--spice-radius, 20px) !important;
    }

    body {
        margin: 0;
        font-family: var(--font-body);
        background-color: var(--spice-bg);
        color: var(--spice-text);
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden; 
        width: 100%;
        box-sizing: border-box;
    }
    
    main {
        display: flow-root;
    }
    
    *, *::before, *::after {
        box-sizing: inherit;
    }

    /* CHUẨN HÓA CĂN ĐỀU HAI BÊN (JUSTIFY) ĐẦY ĐỦ CHO TẤT CẢ NỘI DUNG VĂN BẢN, THẺ P, SUBTITLE & DESC */
    .content-desc,
    .section-desc,
    .hero-desc,
    .product-description,
    .product-description p,
    .story-content p,
    .about-text p,
    .editor-content p,
    .editor-content,
    .legal-document p,
    .document-wrapper p,
    .faq-card p,
    .compact-testimonial-item p,
    .testi-quote,
    .bundle-desc,
    .pillar-body p,
    .feat-details p,
    .step-desc,
    .mini-card-content p,
    .trust-card-desc,
    .spotlight-text,
    .yum-desc,
    .accordion-content p {
        text-align: justify !important;
        text-justify: inter-word !important;
        text-align-last: left !important;
        -webkit-hyphens: auto;
        hyphens: auto;
        overflow-wrap: break-word;
        text-rendering: optimizeLegibility;
    }

    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }
    
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* CHUẨN HÓA BỘ ICON LUCIDE (Outline, Stroke 1.75 - 2px) */
    .header-nav svg,
    .desktop-nav svg,
    .cart-btn svg,
    .header-icon {
        width: 22px;
        height: 22px;
        stroke: currentColor;
        stroke-width: 2px;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: inline-block;
        flex-shrink: 0;
    }
    .spice-dropdown-wrapper .nav-link svg {
        width: 20px;
        height: 20px;
    }

    /* Icon trong các loại nút bấm (Button Icon: 16-20px, Stroke 2px) */
    button svg,
    .btn svg,
    .btn-primary svg,
    .btn-outline svg,
    .btn-ghost svg,
    .quick-add svg,
    .bundle-add-btn svg,
    .view-all-btn svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 2px;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
    }

    /* RESPONSIVE CONTAINER & CONTENT MAX-WIDTH STANDARDS */
    .container,
    .header-container,
    .spice-container {
        max-width: 1430px !important;
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    @media (max-width: 1440px) {
        .container,
        .header-container,
        .spice-container {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
    }

    @media (max-width: 768px) {
        .container,
        .header-container,
        .spice-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    @media (max-width: 480px) {
        .container,
        .header-container,
        .spice-container {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
    }
</style>
