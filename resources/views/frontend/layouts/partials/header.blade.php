<!-- Global Storefront Header: Jojo Little Kitchen -->
@include('frontend.layouts.partials.jojo-home-header')

<style>
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
        /* --- JOJO LITTLE KITCHEN COLOR SYSTEM --- */
        
        /* MÀU NỀN & CHỮ (Base & Text) */
        --spice-bg: #fff8ee; /* Jojo Warm Cream */
        --spice-bg-alt: #fffaf2; /* Jojo Soft Card Cream */
        --spice-bg-dark: #401b1b; /* Jojo Deep Ink / Dark Brown */
        --spice-bg-bundle: #401b1b;
        --spice-text: #401b1b; /* Jojo Dark Brown Text */
        
        /* MÀU PHỤ (Secondary) */
        --spice-text-light: #fff8ee;
        --spice-secondary: #f2c455; /* Jojo Brand Gold */
        
        /* MÀU NHẤN CHÍNH (CTA / Accent) */
        --spice-primary: #a4000b; /* Jojo Chili Red */
        --spice-accent: #710007; /* Jojo Dark Red Hover */
        
        /* BỘ MÀU HỖ TRỢ */
        --spice-fire: #a4000b;
        --spice-tangerine: #f2c455;
        --spice-honey: #f2c455;
        --spice-herb: #4E7837;
        --spice-mint: #7FD2BD;
        --spice-steel: #ead8c9;
        
        /* CHUẨN HÓA BORDER-RADIUS CARD & FORM ĐỒNG BỘ 20PX */
        --spice-radius: 20px;
        --jojo-card-radius: 20px;
        
        --font-heading: Georgia, 'Times New Roman', serif;
        --font-body: Arial, Helvetica, sans-serif;
    }

    /* GLOBAL RULE: TẤT CẢ KHUNG CARD, FORM VÀ INPUT ĐỀU ĐỒNG BỘ BORDER-RADIUS 20PX */
    button:not(.btn-circle):not(.pin-marker):not(.cart-btn):not([class*="carousel"]):not(.slick-arrow):not(.swiper-button):not(.mobile-menu-toggle),
    .btn:not(.btn-circle),
    .btn-primary,
    .btn-outline,
    .btn-ghost,
    .btn-open-map,
    .submit-btn,
    .add-to-cart-btn,
    .yum-btn,
    input:not([type="checkbox"]):not([type="radio"]):not([type="color"]),
    select,
    textarea,
    .spice-form input,
    .spice-form select,
    .spice-form textarea,
    .card:not(.card-circle),
    .product-card,
    .yum-card,
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
    .cart-summary-card,
    .checkout-card-form,
    .checkout-block,
    .faq-card,
    .alert {
        border-radius: 20px !important;
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
    /* Long-form editorial & legal reading content: elegant justified formatting */
    .document-wrapper p,
    .faq-card p,
    .pillar-body p,
    .story-content p {
        text-align: justify !important;
        text-justify: inter-word !important;
        text-align-last: left !important;
        -webkit-hyphens: auto;
        hyphens: auto;
        overflow-wrap: break-word;
        text-rendering: optimizeLegibility;
    }

    /* Small cards, product features & badges: clean left-aligned typography to prevent awkward word gaps */
    .feat-details p,
    .step-desc,
    .mini-card-content p,
    .trust-card-desc,
    .spotlight-text,
    .yum-desc,
    .accordion-content p,
    .compact-testimonial-item p,
    .testi-quote,
    .bundle-desc,
    .product-description p {
        text-align: left !important;
        text-justify: auto !important;
        line-height: 1.62;
        overflow-wrap: break-word;
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
        max-width: 1460px !important;
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    @media (max-width: 1460px) {
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
