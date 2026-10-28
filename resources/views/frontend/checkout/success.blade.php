@extends('frontend.layouts.master')

@section('meta')
<title>Order Confirmation #{{ $order->id }} — Dried Chili Pantry</title>
<meta name="description" content="Thank you for your order! Your artisanal dried chili and spice selection is confirmed and being prepared.">
<meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="order-success-page">
    <div class="success-glow"></div>
    <div class="container success-container">

        <!-- Top Status Hero Card -->
        <div class="success-hero-card">
            <div class="success-icon-badge">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <h1 class="success-hero-title">Thank You for Your Order!</h1>
            <p class="success-hero-subtitle">
                We've received your order <strong>#ORD-{{ $order->id }}</strong>. Our artisan kitchen is preparing your handcrafted chili and spice jars with passion and care.
            </p>

            @if(session('success'))
                <div class="session-notice">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="success-meta-strip">
                <div class="meta-item">
                    <span class="meta-label">Order Number</span>
                    <strong class="meta-val">#ORD-{{ $order->id }}</strong>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Date & Time</span>
                    <strong class="meta-val">{{ $order->created_at->format('M d, Y • h:i A') }}</strong>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Payment Method</span>
                    <strong class="meta-val">{{ $order->payment_method === 'paypal' ? 'PayPal / Card' : strtoupper($order->payment_method ?? 'COD') }}</strong>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Payment Status</span>
                    <strong class="meta-val status-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status ?? 'Pending') }}
                    </strong>
                </div>
                @if($order->transaction_id)
                <div class="meta-item">
                    <span class="meta-label">Transaction ID</span>
                    <strong class="meta-val txn-id">{{ $order->transaction_id }}</strong>
                </div>
                @endif
            </div>
        </div>

        <!-- 2-Column Content Grid: Details & Summary -->
        <div class="success-grid">

            <!-- Left: Order Items & Delivery Information -->
            <div class="success-main-col">

                <!-- Purchased Items Card -->
                <div class="success-card">
                    <div class="card-title-row">
                        <div class="card-icon">🌶️</div>
                        <h2 class="card-title">Artisanal Items in This Order</h2>
                    </div>

                    <div class="items-list">
                        @forelse($order->items as $item)
                            @php
                                $itemName = $item->product ? $item->product->name : ($item->bundle ? $item->bundle->name : 'Artisan Chili Product');
                                $variantSku = $item->variant ? $item->variant->sku : null;
                                $itemSubtotal = $item->price * $item->quantity;
                            @endphp
                            <div class="receipt-item">
                                <div class="item-img-frame">
                                    <img src="{{ asset('images/product_hero.png') }}" alt="{{ $itemName }}">
                                </div>
                                <div class="item-details">
                                    <h3 class="item-name">{{ $itemName }}</h3>
                                    @if($variantSku)
                                        <span class="item-sku">SKU: {{ $variantSku }}</span>
                                    @endif
                                    <div class="item-calc">
                                        ${{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </div>
                                </div>
                                <div class="item-total">
                                    ${{ number_format($itemSubtotal, 2) }}
                                </div>
                            </div>
                        @empty
                            <p class="no-items-text">No items found for this order.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Shipping Destination Card -->
                <div class="success-card">
                    <div class="card-title-row">
                        <div class="card-icon">📍</div>
                        <h2 class="card-title">Delivery & Shipping Address</h2>
                    </div>
                    <div class="address-box">
                        <p class="address-text">{{ $order->shipping_address ?? 'Standard address on file' }}</p>
                    </div>
                </div>

            </div>

            <!-- Right: Financial Breakdown & Next Steps -->
            <div class="success-side-col">

                <!-- Payment Summary Card -->
                <div class="success-card summary-card">
                    <h2 class="summary-card-title">Order Breakdown</h2>

                    <div class="summary-rows">
                        @php
                            $itemsSubtotal = $order->items->sum(function($i) { return $i->price * $i->quantity; });
                        @endphp
                        <div class="sum-row">
                            <span>Subtotal</span>
                            <strong>${{ number_format($itemsSubtotal, 2) }}</strong>
                        </div>

                        @if($order->discount_amount > 0)
                        <div class="sum-row discount">
                            <span>Discount @if($order->coupon_code) ({{ $order->coupon_code }}) @endif</span>
                            <strong>-${{ number_format($order->discount_amount, 2) }}</strong>
                        </div>
                        @endif

                        <div class="sum-row">
                            <span>Shipping</span>
                            <strong class="text-free">FREE</strong>
                        </div>

                        <div class="sum-divider"></div>

                        <div class="sum-row total-row">
                            <div>
                                <span class="total-title">Total Paid</span>
                                <small class="tax-hint">Inclusive of all taxes</small>
                            </div>
                            <strong class="total-price">${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="success-actions-block">
                        <a href="/shop" class="btn-primary-action">
                            <span>Explore More Flavors</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>

                        @auth('web')
                            <a href="{{ route('account.orders') }}" class="btn-secondary-action">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                <span>View In Account Orders</span>
                            </a>
                        @endauth

                        <button type="button" onclick="window.print()" class="btn-print-action">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            <span>Print Order Receipt</span>
                        </button>
                    </div>

                    <!-- Trust Note -->
                    <div class="guarantee-box">
                        <div class="shield-icon">🛡️</div>
                        <div class="guarantee-text">
                            <strong>100% Quality Guarantee</strong>
                            <p>Hand-crafted in small batches. If you have any inquiries, contact our kitchen team anytime.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<style>
/* ==========================================================================
   ORDER CONFIRMATION / THANK YOU PAGE
   Design System: Fiery Spicy 60-30-10 Palette
   ========================================================================== */

.order-success-page {
    position: relative;
    background-color: var(--spice-bg, #FDF9F1);
    min-height: 85vh;
    padding: 3rem 0 6rem 0;
    overflow-x: hidden;
    font-family: var(--font-body, 'Inter', -apple-system, BlinkMacSystemFont, sans-serif);
    color: var(--spice-text, #28120B);
}

.success-glow {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 700px;
    height: 400px;
    background: radial-gradient(circle, rgba(228, 93, 62, 0.08) 0%, rgba(253, 249, 241, 0) 70%);
    pointer-events: none;
    z-index: 0;
}

.success-container {
    position: relative;
    z-index: 1;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Hero Section */
.success-hero-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 3rem 2.5rem 2.5rem;
    text-align: center;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 10px 35px rgba(40, 18, 11, 0.04);
    margin-bottom: 2.5rem;
}

.success-icon-badge {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.28);
    animation: successPulse 2s infinite ease-in-out;
}

@keyframes successPulse {
    0% { transform: scale(1); box-shadow: 0 10px 25px rgba(16, 185, 129, 0.28); }
    50% { transform: scale(1.05); box-shadow: 0 14px 30px rgba(16, 185, 129, 0.4); }
    100% { transform: scale(1); box-shadow: 0 10px 25px rgba(16, 185, 129, 0.28); }
}

.success-hero-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: clamp(2rem, 3.5vw, 2.75rem);
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 0.75rem;
    line-height: 1.2;
}

.success-hero-subtitle {
    font-size: 1.05rem;
    color: #7C685E;
    max-width: 650px;
    margin: 0 auto 1.75rem;
    line-height: 1.6;
}

.session-notice {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #ECFDF5;
    border: 1px solid #A7F3D0;
    color: #065F46;
    padding: 0.6rem 1.25rem;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 600;
    margin-bottom: 1.75rem;
}

.success-meta-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.25rem;
    background: #FAF6F0;
    border-radius: 16px;
    padding: 1.25rem 1.75rem;
    border: 1px solid rgba(40, 18, 11, 0.05);
    text-align: left;
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.meta-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #9E8C82;
    font-weight: 700;
}

.meta-val {
    font-size: 0.98rem;
    color: var(--spice-text, #28120B);
    word-break: break-all;
}

.meta-val.status-paid {
    color: #059669;
}

.meta-val.status-pending {
    color: #D97706;
}

.txn-id {
    font-family: monospace;
    font-size: 0.88rem;
    color: #4B5563;
}

/* 2 Column Layout */
.success-grid {
    display: grid;
    grid-template-columns: 1.7fr 1.1fr;
    gap: 2rem;
    align-items: start;
}

.success-card {
    background: #FFFFFF;
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(40, 18, 11, 0.06);
    box-shadow: 0 6px 22px rgba(40, 18, 11, 0.03);
    margin-bottom: 1.75rem;
}

.card-title-row {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.06);
}

.card-icon {
    font-size: 1.35rem;
}

.card-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0;
}

/* Item List */
.items-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.receipt-item {
    display: grid;
    grid-template-columns: 65px 1fr auto;
    gap: 1.25rem;
    align-items: center;
    padding-bottom: 1.25rem;
    border-bottom: 1px dashed rgba(40, 18, 11, 0.08);
}

.receipt-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-img-frame {
    width: 65px;
    height: 65px;
    background: #FAF6F0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.35rem;
    overflow: hidden;
}

.item-img-frame img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.item-details {
    min-width: 0;
}

.item-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 0.25rem;
    line-height: 1.35;
}

.item-sku {
    display: block;
    font-size: 0.78rem;
    color: #9E8C82;
    margin-bottom: 0.25rem;
}

.item-calc {
    font-size: 0.85rem;
    color: #7C685E;
    font-weight: 500;
}

.item-total {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    text-align: right;
}

/* Address Box */
.address-box {
    background: #FAF6F0;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(40, 18, 11, 0.04);
}

.address-text {
    margin: 0;
    font-size: 0.98rem;
    line-height: 1.6;
    color: var(--spice-text, #28120B);
}

/* Summary Card */
.summary-card {
    position: sticky;
    top: 2rem;
}

.summary-card-title {
    font-family: var(--font-heading, 'Playfair Display', Georgia, serif);
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--spice-text, #28120B);
    margin: 0 0 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(40, 18, 11, 0.06);
}

.summary-rows {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    margin-bottom: 1.75rem;
}

.sum-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.95rem;
    color: #7C685E;
}

.sum-row strong {
    color: var(--spice-text, #28120B);
    font-weight: 600;
}

.sum-row.discount {
    color: #059669;
}

.sum-row.discount strong {
    color: #059669;
}

.text-free {
    color: #059669 !important;
    font-weight: 800;
}

.sum-divider {
    height: 1px;
    background: rgba(40, 18, 11, 0.08);
    margin: 0.5rem 0;
}

.sum-row.total-row {
    align-items: baseline;
    padding-top: 0.25rem;
}

.total-title {
    display: block;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--spice-text, #28120B);
}

.tax-hint {
    font-size: 0.75rem;
    color: #9E8C82;
}

.total-price {
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--spice-primary, #E45D3E);
    letter-spacing: -0.02em;
}

/* Actions */
.success-actions-block {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.btn-primary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: var(--spice-primary, #E45D3E);
    color: #FFFFFF;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    padding: 0.95rem 1.5rem;
    border-radius: 14px;
    transition: all 0.25s ease;
    box-shadow: 0 4px 15px rgba(228, 93, 62, 0.25);
}

.btn-primary-action:hover {
    background: var(--spice-accent, #C73B1B);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(228, 93, 62, 0.35);
    color: #FFFFFF;
}

.btn-secondary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #FAF6F0;
    color: var(--spice-text, #28120B);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.85rem 1.25rem;
    border-radius: 12px;
    border: 1px solid rgba(40, 18, 11, 0.08);
    transition: all 0.2s ease;
}

.btn-secondary-action:hover {
    background: #F0EAE1;
    color: var(--spice-text, #28120B);
}

.btn-print-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    background: transparent;
    color: #7C685E;
    border: none;
    cursor: pointer;
    font-size: 0.88rem;
    font-weight: 600;
    padding: 0.6rem 0.8rem;
    transition: color 0.2s ease;
}

.btn-print-action:hover {
    color: var(--spice-text, #28120B);
}

/* Guarantee Box */
.guarantee-box {
    display: flex;
    gap: 0.75rem;
    background: #FAF6F0;
    border-radius: 12px;
    padding: 1rem 1.15rem;
    font-size: 0.85rem;
    line-height: 1.45;
}

.shield-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.guarantee-text strong {
    display: block;
    color: var(--spice-text, #28120B);
    margin-bottom: 0.15rem;
}

.guarantee-text p {
    margin: 0;
    color: #7C685E;
}

/* Print Styles */
@media print {
    .spice-marquee,
    .cart-btn,
    .btn-primary-action,
    .btn-secondary-action,
    .btn-print-action,
    header,
    footer {
        display: none !important;
    }

    .order-success-page {
        background: #FFFFFF !important;
        padding: 0 !important;
    }

    .success-hero-card,
    .success-card {
        box-shadow: none !important;
        border: 1px solid #CCCCCC !important;
    }
}

/* Responsive */
@media (max-width: 900px) {
    .success-grid {
        grid-template-columns: 1fr;
    }

    .summary-card {
        position: static;
    }
}

@media (max-width: 600px) {
    .success-hero-card {
        padding: 2rem 1.25rem 1.5rem;
    }

    .success-icon-badge {
        width: 65px;
        height: 65px;
    }

    .success-meta-strip {
        grid-template-columns: 1fr 1fr;
        padding: 1rem;
        gap: 0.85rem;
    }

    .success-card {
        padding: 1.5rem 1.25rem;
    }

    .receipt-item {
        grid-template-columns: 55px 1fr;
    }

    .item-total {
        grid-column: 2 / -1;
        text-align: left;
        margin-top: 0.25rem;
    }
}
</style>
@endsection
