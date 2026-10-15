@extends('frontend.layouts.master')

@section('meta')
    <title>Your Cart & Checkout</title>
    <meta name="description" content="Review your shopping cart and complete secure checkout for premium handcrafted dried chili, chili crisps, and artisanal spices.">
@endsection

@section('content')
<div class="cart-page-wrapper" id="cart-page-app">
    <div class="cart-bg-glow"></div>
    <div class="container cart-container">
        
        <!-- Cart Top Navigation & Header -->
        <header class="cart-header-section">
            <div class="cart-breadcrumbs">
                <a href="/shop" class="cart-back-link" id="cart-shop-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Back to Shop</span>
                </a>
                <button type="button" class="cart-back-link btn-back-to-cart" id="btn-return-cart" style="display: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Return to Cart Review</span>
                </button>
            </div>

            <div class="cart-title-row">
                <div class="cart-title-group">
                    <h1 class="cart-title" id="page-main-heading">
                        <span id="title-text">Your Cart</span> 
                    </h1>
                </div>
            </div>

            <!-- Free Shipping Progress Tracker -->
            <div class="shipping-progress-banner" id="shipping-progress-banner">
                <div class="shipping-progress-info">
                    <div class="shipping-icon-pulse">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="1" y="3" width="15" height="13" rx="1"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <span id="shipping-progress-text" class="shipping-text">Add <strong>$50.00</strong> more to qualify for <strong>FREE NATIONWIDE SHIPPING!</strong></span>
                </div>
                <div class="shipping-meter">
                    <div class="shipping-meter-fill" id="shipping-meter-fill" style="width: 0%;"></div>
                </div>
            </div>
        </header>

        <!-- Main Cart Grid -->
        <div class="cart-grid">
            
            <!-- Left Column: Cart Items OR Checkout Form -->
            <div class="cart-main-col">
                
                <!-- VIEW 1: CART ITEMS SECTION -->
                <div id="cart-items-section">
                    <!-- Dynamic Items Container -->
                    <div id="cart-items-container" class="cart-items-list">
                        <div class="cart-skeleton-loading">
                            <p>Loading your flavorful goodies...</p>
                        </div>
                    </div>

                    <!-- Empty State Card (Hidden by default) -->
                    <div id="cart-empty-state" class="cart-empty-card" style="display: none;">
                        <div class="empty-state-badge">BASKET IS WAITING</div>
                        <h2 class="empty-state-title">Your cart is craving some heat!</h2>
                        <p class="empty-state-desc">Looks like you haven't added any of our fiery chili crisps, umami shrimp sauces, or handcrafted spice jars yet.</p>
                        
                        <div class="empty-illustration-frame">
                            <img src="{{ asset('images/cart_illustration.jpg') }}" alt="Empty Cart" class="cart-empty-img">
                        </div>

                        <div class="empty-actions">
                            <a href="/shop" class="btn-explore-shop">
                                <span>Explore The Pantry</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <div class="empty-perks-row">
                            <div class="empty-perk">
                                <span class="perk-icon">🔥</span>
                                <span>Handcrafted Small Batches</span>
                            </div>
                            <div class="empty-perk">
                                <span class="perk-icon">🚚</span>
                                <span>Free Shipping Over $50</span>
                            </div>
                            <div class="empty-perk">
                                <span class="perk-icon">🌶️</span>
                                <span>100% Real Artisan Flavor</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VIEW 2: PROFESSIONAL CHECKOUT FORM SECTION -->
                <div id="checkout-details-section" class="checkout-card-form" style="display: none;">
                    
                    <!-- Section Header -->
                    <div class="checkout-section-intro">
                        <h2 class="checkout-form-title">Shipping & Payment Details</h2>
                        <p class="checkout-form-desc">Please provide your contact and delivery address to complete your order.</p>
                    </div>

                    <!-- Alert message container -->
                    <div id="checkout-form-alert" class="checkout-alert" style="display: none;"></div>

                    <form id="express-checkout-form" onsubmit="return false;">
                        
                        <!-- Step 1: Contact Information -->
                        <div class="checkout-block">
                            <div class="checkout-block-header">
                                <div class="step-num">1</div>
                                <h3 class="step-title">Contact Information</h3>
                            </div>
                            <div class="checkout-grid-2">
                                <div class="form-field">
                                    <label for="checkout-name" class="field-label">Full Name<span class="req">*</span></label>
                                    <input type="text" id="checkout-name" class="checkout-input" placeholder="e.g. Alex Morgan" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                                    <div class="field-error-msg" id="error-checkout-name"></div>
                                </div>
                                <div class="form-field">
                                    <label for="checkout-phone" class="field-label">Phone Number<span class="req">*</span></label>
                                    <input type="tel" id="checkout-phone" class="checkout-input" placeholder="e.g. 0912 345 678" value="{{ auth()->check() ? (auth()->user()->phone ?? '') : '' }}" required>
                                    <div class="field-error-msg" id="error-checkout-phone"></div>
                                </div>
                            </div>
                            <div class="form-field mt-3">
                                <label for="checkout-email" class="field-label">Email Address<span class="req">*</span></label>
                                <input type="email" id="checkout-email" class="checkout-input" placeholder="e.g. alex@example.com" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                                <div class="field-error-msg" id="error-checkout-email"></div>
                            </div>
                        </div>

                        <!-- Step 2: Shipping Destination -->
                        <div class="checkout-block">
                            <div class="checkout-block-header">
                                <div class="step-num">2</div>
                                <h3 class="step-title">Delivery Address</h3>
                            </div>
                            <div class="form-field">
                                <label for="checkout-street" class="field-label">Street Address<span class="req">*</span></label>
                                <input type="text" id="checkout-street" class="checkout-input" placeholder="e.g. 124 King Street, Apt 3B, Ward 5" required>
                                <div class="field-error-msg" id="error-checkout-street"></div>
                            </div>
                            <div class="checkout-grid-2 mt-3">
                                <div class="form-field">
                                    <label for="checkout-city" class="field-label">City, Province<span class="req">*</span></label>
                                    <input type="text" id="checkout-city" class="checkout-input" placeholder="e.g. Ho Chi Minh City, Ha Noi..." required>
                                    <div class="field-error-msg" id="error-checkout-city"></div>
                                </div>
                                <div class="form-field">
                                    <label for="checkout-note" class="field-label">Delivery Note</label>
                                    <input type="text" id="checkout-note" class="checkout-input" placeholder="e.g. Call 15 mins before delivery...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Payment Method Cards -->
                        <div class="checkout-block">
                            <div class="checkout-block-header">
                                <div class="step-num">3</div>
                                <h3 class="step-title">Select Payment Method</h3>
                            </div>

                            <div class="payment-cards-group">
                                
                                <!-- COD Card -->
                                <label class="payment-card active" id="card-method-cod">
                                    <input type="radio" name="checkout_payment_method" value="cod" checked class="payment-radio-input">
                                    <div class="custom-radio-circle"></div>
                                    <div class="payment-icon-box">💵</div>
                                    <div class="payment-card-info">
                                        <div class="payment-card-title-row">
                                            <strong>Cash on Delivery</strong>
                                        </div>
                                    </div>
                                </label>

                                <!-- PayPal Card -->
                                <label class="payment-card" id="card-method-paypal">
                                    <input type="radio" name="checkout_payment_method" value="paypal" class="payment-radio-input">
                                    <div class="custom-radio-circle"></div>
                                    <div class="payment-icon-box">💳</div>
                                    <div class="payment-card-info">
                                        <div class="payment-card-title-row">
                                            <strong>PayPal / Credit Card</strong>
                                        </div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- Submit Order Button -->
                        <div class="checkout-submit-bar">
                            <button type="button" id="confirm-checkout-btn" class="checkout-btn-final">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span id="confirm-checkout-btn-text">Confirm & Place Order • <strong id="btn-checkout-total-val">$0.00</strong></span>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- Right Column: Order Summary & Review -->
            <div class="cart-summary-col">
                <div class="cart-summary-card">
                    <div class="summary-header">
                        <h2 class="summary-heading">Order Summary</h2>
                    </div>

                    <!-- Price breakdown -->
                    <div class="summary-rows-group">
                        <div class="summary-row subtotal-row">
                            <span class="summary-label">Subtotal</span>
                            <strong id="cart-subtotal" class="summary-value">$0.00</strong>
                        </div>

                        <!-- Dynamic discounts -->
                        <div id="cart-bundle-discount" class="summary-row discount-row" style="display: none;">
                            <span class="summary-label text-success">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                Bundle Discount
                            </span>
                            <span id="cart-bundle-val" class="summary-value text-success">-$0.00</span>
                        </div>

                        <div id="cart-coupon-discount" class="summary-row discount-row" style="display: none;">
                            <span class="summary-label text-success">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                Coupon (<span id="cart-applied-coupon-code"></span>)
                            </span>
                            <span id="cart-coupon-val" class="summary-value text-success">-$0.00</span>
                        </div>

                        <div class="summary-row shipping-row">
                            <span class="summary-label">Shipping</span>
                            <span id="cart-shipping-val" class="summary-value shipping-status">Calculated at checkout</span>
                        </div>

                        <div class="summary-row tax-row">
                            <span class="summary-label">Estimated Tax</span>
                            <span class="summary-value tax-status">Calculated at checkout</span>
                        </div>
                    </div>

                    <!-- Promo Code Input Group -->
                    <div class="cart-promo-box">
                        <label class="promo-label" for="coupon-code-input">Have a promo or voucher code?</label>
                        <div class="promo-input-group">
                            <input type="text" id="coupon-code-input" class="promo-input" placeholder="e.g. SPICY10, FEBCHILLI" autocomplete="off">
                            <button type="button" id="apply-coupon-btn" class="promo-btn">Apply</button>
                        </div>
                        <div id="coupon-message" class="coupon-feedback" style="display: none;"></div>
                    </div>

                    <!-- Elegant Divider -->
                    <div class="summary-divider"></div>

                    <!-- Grand Total -->
                    <div class="summary-total-row">
                        <div class="total-label-box">
                            <span class="total-label">Estimated Total</span>
                            <span class="total-note">Taxes & shipping finalized at next step</span>
                        </div>
                        <div class="total-amount-box">
                            <span id="cart-total" class="total-price">$0.00</span>
                        </div>
                    </div>

                    <!-- Main Checkout Action in Summary -->
                    <button type="button" class="checkout-submit-btn" id="checkout-btn">
                        <span>Proceed to Checkout</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>

                    <!-- In checkout mode, show quick edit button -->
                    <button type="button" class="checkout-edit-btn" id="checkout-edit-cart-btn" style="display: none;">
                        <span>← Edit Items in Cart</span>
                    </button>

                    <!-- Payment Badges & Trust -->
                    <div class="summary-security-note">
                        <div class="security-badge-row">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span>Encrypted & Safe Checkout</span>
                        </div>
                        <div class="payment-methods-pills">
                            <span class="pay-pill">PayPal</span>
                            <span class="pay-pill">Visa</span>
                            <span class="pay-pill">Mastercard</span>
                            <span class="pay-pill">Apple Pay</span>
                            <span class="pay-pill">COD</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<!-- ORDER CONFIRMATION SUCCESS MODAL -->
<div id="checkout-success-modal" class="checkout-modal-backdrop" style="display: none;">
    <div class="checkout-modal-card">
        <div class="success-icon-wrap">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="success-tag">ORDER CONFIRMED</div>
        <h2 class="success-title">Thank You For Your Order!</h2>
        <p class="success-msg">Your artisanal spice selection has been booked. Our kitchen is getting your handcrafted jars sealed and prepared for delivery!</p>
        
        <div class="success-order-box">
            <div class="success-order-row">
                <span class="row-label">Order Reference:</span>
                <strong id="modal-order-id" class="row-val">#ORD-1001</strong>
            </div>
            <div class="success-order-row">
                <span class="row-label">Payment Method:</span>
                <strong id="modal-payment-method" class="row-val">Cash on Delivery (COD)</strong>
            </div>
            <div class="success-order-row">
                <span class="row-label">Total Amount:</span>
                <strong id="modal-order-total" class="row-val price-highlight">$0.00</strong>
            </div>
            <div class="success-order-row destination-row">
                <span class="row-label">Delivering To:</span>
                <span id="modal-shipping-summary" class="row-val address-val"></span>
            </div>
        </div>

        <div class="success-actions">
            <a href="/account/orders" class="btn-primary-success">View My Orders</a>
            <a href="/shop" class="btn-secondary-success">Continue Shopping</a>
        </div>
    </div>
</div>

<style>
/* ==========================================================================
   DRIED CHILI LUXURY CART & CHECKOUT STYLES
   Design System: Fiery Spicy 60-30-10 Palette
   Clean Elevated Modern Aesthetic - Zero Harsh Black Borders
   ========================================================================== */

.cart-page-wrapper {
    position: relative;
    background-color: var(--spice-bg, #FDF9F1);
    min-height: 80vh;
    padding: 2.5rem 0 5rem 0;
    overflow: hidden;
}

.cart-bg-glow {
    position: absolute;
    top: 0;
    right: 15%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(228, 93, 62, 0.05) 0%, rgba(253, 249, 241, 0) 70%);
    pointer-events: none;
    z-index: 0;
}

.cart-container {
    position: relative;
    z-index: 1;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Header Section */
.cart-header-section {
    margin-bottom: 2.5rem;
}

.cart-breadcrumbs {
    margin-bottom: 1.25rem;
}

.cart-back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #7C685E;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.2s ease;
}

.cart-back-link:hover {
    color: var(--spice-primary, #E45D3E);
    transform: translateX(-3px);
}

.cart-title-row {
    margin-bottom: 1.5rem;
}

.cart-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: clamp(2.4rem, 4vw, 3.2rem);
    font-weight: 700;
    color: var(--spice-text, #28120B);
    line-height: 1.15;
    margin: 0;
    border-bottom: none !important;
    padding-bottom: 0 !important;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.cart-counter-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(228, 93, 62, 0.1);
    color: var(--spice-primary, #E45D3E);
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    padding: 0.2rem 0.85rem;
    border-radius: 999px;
    vertical-align: middle;
}

/* Free Shipping Progress Tracker */
.shipping-progress-banner {
    background: #FFFFFF;
    border-radius: 18px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 4px 18px rgba(40, 18, 11, 0.03);
    margin-top: 1rem;
    transition: all 0.3s ease;
}

.shipping-progress-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    color: var(--spice-text, #28120B);
}

.shipping-icon-pulse {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 12px;
    background: rgba(228, 93, 62, 0.1);
    color: var(--spice-primary, #E45D3E);
    flex-shrink: 0;
}

.shipping-text {
    line-height: 1.4;
}

.shipping-text strong {
    color: var(--spice-primary, #E45D3E);
}

.shipping-meter {
    background: #F0EAE1;
    height: 8px;
    border-radius: 999px;
    margin-top: 0.85rem;
    overflow: hidden;
    position: relative;
}

.shipping-meter-fill {
    height: 100%;
    background: linear-gradient(90deg, #FFB300 0%, var(--spice-primary, #E45D3E) 100%);
    border-radius: 999px;
    transition: width 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

/* Main Grid Layout */
.cart-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.8fr) minmax(340px, 1.1fr);
    gap: 2.5rem;
    align-items: start;
}

/* Cart Items Container */
.cart-items-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.cart-skeleton-loading {
    background: #FFFFFF;
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
    color: #7C685E;
    font-family: var(--font-body, 'Inter', sans-serif);
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 4px 18px rgba(40, 18, 11, 0.03);
}

/* Individual Cart Item Card */
.cart-item {
    display: grid;
    grid-template-columns: 100px 1fr auto;
    gap: 1.5rem;
    align-items: center;
    background: #FFFFFF;
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 6px 20px rgba(40, 18, 11, 0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    margin-bottom: 0;
}

.cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(40, 18, 11, 0.07);
    border-color: rgba(228, 93, 62, 0.15);
}

.cart-item-img-box {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    background: #FAF5EE;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    flex-shrink: 0;
    overflow: hidden;
}

.cart-item img,
.cart-item-img-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 12px;
    border: none !important;
    background: transparent !important;
}

.cart-item-content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    min-width: 0;
}

.cart-item-brand {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 1.2px;
    color: var(--spice-primary, #E45D3E);
    text-transform: uppercase;
}

.cart-item-title {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0;
    line-height: 1.35;
    word-break: break-word;
}

.cart-item-unit-price {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.9rem;
    color: #7C685E;
    font-weight: 500;
}

.cart-item-bottom {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex-wrap: wrap;
}

/* Stepper Quantity Control */
.cart-item-stepper {
    display: inline-flex;
    align-items: center;
    background: #F7F3EC;
    border-radius: 999px;
    padding: 3px 4px;
    border: 1px solid rgba(40, 18, 11, 0.08);
}

.stepper-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #FFFFFF;
    border: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--spice-text, #28120B);
    box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
    padding: 0;
}

.stepper-btn:hover {
    background: var(--spice-primary, #E45D3E);
    color: #FFFFFF;
    transform: scale(1.08);
}

.stepper-input {
    width: 44px;
    border: none !important;
    background: transparent !important;
    text-align: center;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    padding: 0;
    box-shadow: none !important;
    -moz-appearance: textfield;
}

.stepper-input::-webkit-outer-spin-button,
.stepper-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Remove Button */
.cart-item-remove {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: none;
    border: none;
    color: #9E8C82;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0.3rem 0.5rem;
    border-radius: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.cart-item-remove:hover {
    color: var(--spice-accent, #C73B1B);
    background: rgba(199, 59, 27, 0.08);
}

.cart-item-total-col {
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
}

.cart-item-total-label {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #9E8C82;
    margin-bottom: 0.2rem;
}

.cart-item-total-amount {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--spice-text, #28120B);
    letter-spacing: -0.02em;
}

/* Empty State Card */
.cart-empty-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 3.5rem 2rem;
    text-align: center;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 10px 30px rgba(40, 18, 11, 0.04);
}

.empty-state-badge {
    display: inline-block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 2px;
    color: var(--spice-primary, #E45D3E);
    background: rgba(228, 93, 62, 0.08);
    padding: 0.35rem 1rem;
    border-radius: 999px;
    margin-bottom: 1.25rem;
}

.empty-state-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: clamp(1.8rem, 3vw, 2.4rem);
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 0.8rem 0;
}

.empty-state-desc {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.05rem;
    color: #7C685E;
    max-width: 520px;
    margin: 0 auto 2rem auto;
    line-height: 1.6;
}

.empty-illustration-frame {
    max-width: 320px;
    margin: 0 auto 2.25rem auto;
    position: relative;
}

.cart-empty-img {
    width: 100%;
    border-radius: 20px;
    border: 1px solid rgba(40, 18, 11, 0.08) !important;
    box-shadow: 0 16px 36px rgba(40, 18, 11, 0.08) !important;
    transition: transform 0.3s ease;
}

.empty-actions {
    margin-bottom: 2.5rem;
}

.btn-explore-shop {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: linear-gradient(135deg, var(--spice-primary, #E45D3E) 0%, var(--spice-accent, #C73B1B) 100%);
    color: #FFFFFF;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.05rem;
    font-weight: 700;
    text-decoration: none;
    padding: 1rem 2.4rem;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(228, 93, 62, 0.28);
    transition: all 0.3s ease;
}

.btn-explore-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(228, 93, 62, 0.4);
    filter: brightness(1.03);
    color: #FFFFFF;
}

.empty-perks-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    padding-top: 1.75rem;
    border-top: 1px solid rgba(40, 18, 11, 0.07);
}

.empty-perk {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.9rem;
    font-weight: 600;
    color: #7C685E;
}

/* Guarantees bar */
.cart-guarantee-bar {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
}

.guarantee-item {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    background: #FFFFFF;
    border-radius: 16px;
    padding: 1.15rem;
    border: 1px solid rgba(40, 18, 11, 0.05);
    box-shadow: 0 4px 15px rgba(40, 18, 11, 0.02);
}

.guarantee-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(228, 93, 62, 0.08);
    color: var(--spice-primary, #E45D3E);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.guarantee-text strong {
    display: block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin-bottom: 0.15rem;
}

.guarantee-text p {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.8rem;
    color: #8C7B71;
    margin: 0;
    line-height: 1.35;
}

/* ==========================================================================
   VIEW 2: DEDICATED PROFESSIONAL CHECKOUT FORM
   ========================================================================== */
.checkout-card-form {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 2.5rem;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 12px 36px rgba(40, 18, 11, 0.05);
    animation: fadeInForm 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.checkout-section-intro {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.07);
}

.checkout-step-badge {
    display: inline-block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: var(--spice-primary, #E45D3E);
    background: rgba(228, 93, 62, 0.08);
    padding: 0.3rem 0.85rem;
    border-radius: 999px;
    margin-bottom: 0.75rem;
}

.checkout-form-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: clamp(1.8rem, 2.5vw, 2.2rem);
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 0.4rem 0;
}

.checkout-form-desc {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    color: #7C685E;
    margin: 0;
}

.checkout-alert {
    padding: 1rem 1.25rem;
    border-radius: 14px;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.checkout-alert.alert-danger {
    background: #FDEDED;
    color: #D32F2F;
    border: 1px solid rgba(211, 47, 47, 0.2);
}

.checkout-block {
    margin-bottom: 2.25rem;
    background: #FAF7F2;
    padding: 1.75rem;
    border-radius: 18px;
    border: 1px solid rgba(40, 18, 11, 0.05);
}

.checkout-block-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.step-num {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--spice-primary, #E45D3E);
    color: #FFFFFF;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.85rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step-title {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0;
}

.checkout-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

.form-field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.form-field.mt-3 {
    margin-top: 1rem;
}

.field-label {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
}

.field-label .req {
    color: var(--spice-primary, #E45D3E);
}

.checkout-input {
    width: 100%;
    background: #FFFFFF;
    border: 1.5px solid rgba(40, 18, 11, 0.1);
    border-radius: 12px;
    padding: 0.8rem 1rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.92rem;
    color: var(--spice-text, #28120B);
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.checkout-input:focus {
    outline: none;
    border-color: var(--spice-primary, #E45D3E);
    box-shadow: 0 0 0 3px rgba(228, 93, 62, 0.12);
}

.checkout-input.is-invalid {
    border-color: #D32F2F !important;
    background: #FFF9F9 !important;
    box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1) !important;
}

.field-error-msg {
    color: #D32F2F;
    font-size: 0.78rem;
    font-weight: 600;
    min-height: 1rem;
    font-family: var(--font-body, 'Inter', sans-serif);
}

/* Payment Option Cards */
.payment-cards-group {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.payment-card {
    display: flex;
    align-items: flex-start;
    gap: 1.15rem;
    background: #FFFFFF;
    border: 1.5px solid rgba(40, 18, 11, 0.08);
    border-radius: 16px;
    padding: 1.25rem;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    user-select: none;
}

.payment-card:hover {
    border-color: rgba(228, 93, 62, 0.35);
    background: #FFFAF5;
}

.payment-card.active {
    border-color: var(--spice-primary, #E45D3E);
    background: #FFF8F5;
    box-shadow: 0 6px 20px rgba(228, 93, 62, 0.1);
}

.payment-radio-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.custom-radio-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #C5B8AE;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 3px;
    transition: all 0.2s ease;
}

.payment-card.active .custom-radio-circle {
    border-color: var(--spice-primary, #E45D3E);
}

.payment-card.active .custom-radio-circle::after {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--spice-primary, #E45D3E);
}

.payment-icon-box {
    font-size: 1.6rem;
    line-height: 1;
    flex-shrink: 0;
}

.payment-card-info {
    flex: 1;
}

.payment-card-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.35rem;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.payment-card-title-row strong {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
}

.payment-pill-badge {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--spice-herb, #4E7837);
    background: rgba(78, 120, 55, 0.1);
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
}

.payment-pill-badge.blue {
    color: #0070BA;
    background: rgba(0, 112, 186, 0.1);
}

.payment-card-desc {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.85rem;
    color: #7C685E;
    margin: 0;
    line-height: 1.45;
}

/* Submit Bar */
.checkout-submit-bar {
    margin-top: 2rem;
    text-align: center;
}

.checkout-btn-final {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, var(--spice-primary, #E45D3E) 0%, var(--spice-accent, #C73B1B) 100%);
    color: #FFFFFF;
    border: none;
    border-radius: 16px;
    padding: 1.25rem 2rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.15rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    cursor: pointer;
    box-shadow: 0 10px 28px rgba(228, 93, 62, 0.35);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.checkout-btn-final:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 34px rgba(228, 93, 62, 0.45);
    filter: brightness(1.03);
}

.checkout-btn-final:active {
    transform: translateY(0);
}

.checkout-btn-final:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

.checkout-footer-guarantee {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.8rem;
    font-weight: 600;
    color: #8C7B71;
    margin-top: 1rem;
}

/* ==========================================================================
   ORDER SUMMARY SIDEBAR
   ========================================================================== */
.cart-summary-col {
    position: sticky;
    top: 110px;
}

.cart-summary-card {
    background: #FFFFFF !important;
    border-radius: 20px;
    border: 1px solid rgba(40, 18, 11, 0.06) !important;
    box-shadow: 0 12px 36px rgba(40, 18, 11, 0.06) !important;
    padding: 2rem;
    position: relative;
}

.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.summary-heading {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0;
}

.summary-sub-badge {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: var(--spice-herb, #4E7837);
    background: rgba(78, 120, 55, 0.1);
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
}

.summary-rows-group {
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
    margin-bottom: 1.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    color: #7C685E;
    border-bottom: none !important;
    padding-bottom: 0 !important;
}

.summary-row.subtotal-row {
    font-size: 1.05rem;
    color: var(--spice-text, #28120B);
}

.summary-value {
    font-weight: 600;
    color: var(--spice-text, #28120B);
}

.subtotal-row .summary-value {
    font-size: 1.25rem;
    font-weight: 800;
}

.discount-row {
    background: rgba(78, 120, 55, 0.06);
    padding: 0.5rem 0.75rem !important;
    border-radius: 10px;
}

.discount-row .summary-label,
.discount-row .summary-value {
    color: var(--spice-herb, #4E7837) !important;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.badge-free {
    background: rgba(78, 120, 55, 0.12);
    color: var(--spice-herb, #4E7837);
    font-weight: 800;
    font-size: 0.8rem;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

/* Promo Voucher Box */
.cart-promo-box {
    margin-bottom: 1.5rem;
    background: #FAF7F2;
    padding: 1.15rem;
    border-radius: 16px;
    border: 1px solid rgba(40, 18, 11, 0.05);
}

.promo-label {
    display: block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.82rem;
    font-weight: 600;
    color: #7C685E;
    margin-bottom: 0.6rem;
}

.promo-input-group {
    display: flex;
    gap: 0.5rem;
}

.promo-input {
    flex: 1;
    min-width: 0;
    background: #FFFFFF;
    border: 1.5px solid rgba(40, 18, 11, 0.1);
    border-radius: 12px;
    padding: 0.65rem 0.9rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--spice-text, #28120B);
    transition: all 0.2s ease;
}

.promo-input:focus {
    outline: none;
    border-color: var(--spice-primary, #E45D3E);
    box-shadow: 0 0 0 3px rgba(228, 93, 62, 0.12);
}

.promo-btn {
    background: var(--spice-text, #28120B);
    color: #FFFFFF;
    border: none;
    border-radius: 12px;
    padding: 0.65rem 1.25rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.promo-btn:hover {
    background: var(--spice-primary, #E45D3E);
    transform: translateY(-1px);
}

.coupon-feedback {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.82rem;
    font-weight: 600;
    margin-top: 0.5rem;
}

.summary-divider {
    height: 1px;
    background: rgba(40, 18, 11, 0.08);
    margin: 1.5rem 0;
}

/* Total Row */
.summary-total-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 1.75rem;
}

.total-label {
    display: block;
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
}

.total-note {
    display: block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.75rem;
    color: #9E8C82;
    margin-top: 0.15rem;
}

.total-price {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 2rem;
    font-weight: 800;
    color: var(--spice-primary, #E45D3E);
    letter-spacing: -0.02em;
    line-height: 1;
}

/* Checkout Button */
.checkout-submit-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    background: linear-gradient(135deg, var(--spice-primary, #E45D3E) 0%, var(--spice-accent, #C73B1B) 100%) !important;
    color: #FFFFFF !important;
    border: none !important;
    border-radius: 16px;
    padding: 1.15rem 2rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: none;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(228, 93, 62, 0.3) !important;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.checkout-submit-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 12px 30px rgba(228, 93, 62, 0.42) !important;
    filter: brightness(1.03);
}

.checkout-edit-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #FAF7F2;
    color: #7C685E;
    border: 1px solid rgba(40, 18, 11, 0.08);
    border-radius: 14px;
    padding: 0.85rem 1.5rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}

.checkout-edit-btn:hover {
    background: #FFFFFF;
    color: var(--spice-primary, #E45D3E);
    border-color: var(--spice-primary, #E45D3E);
}

/* Security Trust Note */
.summary-security-note {
    margin-top: 1.75rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(40, 18, 11, 0.06);
    text-align: center;
}

.security-badge-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.8rem;
    font-weight: 600;
    color: #8C7B71;
    margin-bottom: 0.75rem;
}

.payment-methods-pills {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pay-pill {
    background: #FAF7F2;
    border: 1px solid rgba(40, 18, 11, 0.06);
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.72rem;
    font-weight: 700;
    color: #7C685E;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
}

/* ==========================================================================
   ORDER CONFIRMATION SUCCESS MODAL
   ========================================================================== */
.checkout-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(40, 18, 11, 0.65);
    backdrop-filter: blur(8px);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    animation: fadeInModal 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes fadeInModal {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

.checkout-modal-card {
    background: #FFFFFF;
    border-radius: 28px;
    max-width: 520px;
    width: 100%;
    padding: 3rem 2.5rem;
    text-align: center;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
}

.success-icon-wrap {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2E7D32 0%, #43A047 100%);
    box-shadow: 0 10px 25px rgba(46, 125, 50, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
}

.success-tag {
    display: inline-block;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 2px;
    color: #2E7D32;
    background: rgba(46, 125, 50, 0.1);
    padding: 0.3rem 0.9rem;
    border-radius: 999px;
    margin-bottom: 0.85rem;
}

.success-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: 2.1rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 0.75rem 0;
}

.success-msg {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1rem;
    color: #7C685E;
    line-height: 1.55;
    margin: 0 0 2rem 0;
}

.success-order-box {
    background: #FAF7F2;
    border-radius: 18px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(40, 18, 11, 0.06);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    text-align: left;
}

.success-order-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.92rem;
}

.success-order-row .row-label {
    color: #8C7B71;
}

.success-order-row .row-val {
    color: var(--spice-text, #28120B);
    font-weight: 700;
}

.success-order-row .price-highlight {
    color: var(--spice-primary, #E45D3E);
    font-size: 1.15rem;
}

.destination-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.25rem;
    padding-top: 0.5rem;
    border-top: 1px dashed rgba(40, 18, 11, 0.1);
}

.destination-row .address-val {
    color: #5C4B41;
    font-size: 0.85rem;
    line-height: 1.4;
    word-break: break-word;
}

.success-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-primary-success {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, var(--spice-primary, #E45D3E) 0%, var(--spice-accent, #C73B1B) 100%);
    color: #FFFFFF;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 1.05rem;
    font-weight: 700;
    padding: 1rem 1.5rem;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(228, 93, 62, 0.28);
    transition: all 0.25s ease;
    box-sizing: border-box;
}

.btn-primary-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(228, 93, 62, 0.4);
    color: #FFFFFF;
}

.btn-secondary-success {
    display: block;
    width: 100%;
    background: #FAF7F2;
    color: #7C685E;
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.95rem;
    font-weight: 600;
    padding: 0.85rem 1.5rem;
    border-radius: 14px;
    text-decoration: none;
    border: 1px solid rgba(40, 18, 11, 0.08);
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.btn-secondary-success:hover {
    background: #FFFFFF;
    color: var(--spice-primary, #E45D3E);
    border-color: var(--spice-primary, #E45D3E);
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .cart-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .cart-summary-col {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-page-wrapper {
        padding: 1.5rem 0 3.5rem 0;
    }
    .checkout-card-form {
        padding: 1.5rem;
    }
    .checkout-grid-2 {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .cart-item {
        grid-template-columns: 80px 1fr;
        gap: 1rem;
        padding: 1.25rem;
    }
    .cart-item-img-box {
        width: 80px;
        height: 80px;
    }
    .cart-item-total-col {
        grid-column: 1 / -1;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(40, 18, 11, 0.06);
        margin-top: 0.5rem;
        width: 100%;
    }
    .cart-guarantee-bar {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    .empty-perks-row {
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
    }
    .checkout-modal-card {
        padding: 2rem 1.5rem;
    }
}
</style>
@endsection
