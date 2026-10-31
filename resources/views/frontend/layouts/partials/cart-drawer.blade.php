<div class="cart-drawer-overlay" id="cart-drawer-overlay"></div>
<div class="cart-drawer" id="cart-drawer">
    <div class="cart-drawer-header">
        <h2 class="cart-title">Your Cart</h2>
        <button class="cart-drawer-close" id="cart-drawer-close" aria-label="Close cart">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
    
    <div class="cart-drawer-shipping-msg">
        <div class="msg-text">✨ Free shipping unlocked!</div>
        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:100%"></div></div>
    </div>

    <div class="cart-drawer-items" id="drawer-cart-items">
        <!-- JS will render items here -->
    </div>

    <div class="cart-drawer-footer">
        <div class="cart-drawer-coupon" id="drawer-coupon-container">
            <div class="drawer-coupon-row">
                <input type="text" id="drawer-coupon-code-input" aria-label="Promo code" placeholder="Promo code" autocomplete="off">
                <button type="button" id="drawer-apply-coupon-btn">Apply</button>
            </div>
            <div id="drawer-coupon-message" style="font-size: 0.85rem; margin-top: 0.5rem; display: none;"></div>
        </div>

        <div class="cart-drawer-subtotal">
            <span>Subtotal</span>
            <span id="drawer-cart-subtotal">$0.00</span>
        </div>
        
        <div class="cart-drawer-bundle-discount" id="drawer-bundle-discount-container" style="display: none; justify-content: space-between; font-size: 1.1rem; color: #2E7D32; margin-bottom: 0.5rem;">
            <span>Bundle Discount</span>
            <span id="drawer-bundle-discount">-$0.00</span>
        </div>
        
        <div class="cart-drawer-discount" id="drawer-cart-discount-container" style="display: none; justify-content: space-between; font-size: 1.1rem; color: var(--spice-primary); margin-bottom: 0.5rem;">
            <span>Discount <small id="applied-coupon-code" style="background: rgba(193, 68, 14, 0.1); padding: 2px 6px; border-radius: 20px; font-size: 0.8rem;"></small> <a href="#" id="remove-coupon-btn" style="color: #d9534f; font-size: 0.8rem; text-decoration: none; margin-left: 5px;">(Remove)</a></span>
            <span id="drawer-cart-discount">-$0.00</span>
        </div>

        <div class="cart-drawer-total" id="drawer-cart-total-container" style="display: none; justify-content: space-between; font-size: 1.35rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--spice-text);">
            <span>Total</span>
            <span id="drawer-cart-total">$0.00</span>
        </div>

        <p class="shipping-calc-text">Shipping & taxes calculated at checkout.</p>
        <a href="/cart?step=checkout" class="cart-drawer-checkout" id="drawer-checkout-btn">Checkout</a>
        <a href="/cart" class="view-full-cart">View full cart</a>
    </div>
</div>

<style>
    .cart-drawer-overlay {
        display: none !important;
    }

    .cart-drawer {
        position: absolute;
        top: calc(100% + 20px);
        right: -10px;
        width: 380px;
        max-width: 90vw;
        max-height: calc(100vh - 120px);
        background-color: #FDF9F1;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-15px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0,0,0,0.08);
        font-family: var(--font-body);
        gap: 0;
    }
    
    .cart-drawer > div {
        margin: 0 !important;
    }
    
    /* Triangle pointing up */
    .cart-drawer::before {
        content: '';
        position: absolute;
        top: -7px;
        right: 40px; /* Aligned to point at the center of the cart button */
        width: 14px;
        height: 14px;
        background-color: var(--spice-bg);
        transform: rotate(45deg);
        border-left: 1px solid rgba(0,0,0,0.08);
        border-top: 1px solid rgba(0,0,0,0.08);
        z-index: -1;
    }
    
    .cart-drawer.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .cart-drawer-header {
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(43, 29, 20, 0.1);
    }
    
    .cart-drawer-header .cart-title {
        margin: 0;
        font-family: var(--font-heading);
        font-size: 1.8rem;
        font-weight: 500;
        color: var(--spice-text);
        letter-spacing: 0.5px;
    }

    .cart-drawer-close {
        background: transparent;
        border: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--spice-text);
        transition: transform 0.3s ease, opacity 0.3s;
        opacity: 0.7;
        padding: 0;
    }
    
    .cart-drawer-close:hover {
        transform: rotate(90deg);
        opacity: 1;
    }

    .cart-drawer-shipping-msg {
        padding: 1.2rem 2rem;
        text-align: center;
        font-size: 0.9rem;
        color: var(--spice-primary);
        border-bottom: 1px solid rgba(43, 29, 20, 0.05);
        background: rgba(232, 163, 61, 0.05);
    }
    
    .cart-drawer-shipping-msg .msg-text {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .progress-bar-bg {
        background-color: rgba(43, 29, 20, 0.1);
        border-radius: 20px;
        height: 4px;
        margin-top: 0.8rem;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        background-color: var(--spice-primary);
        height: 100%;
        border-radius: 20px;
        transition: width 0.5s ease;
    }

    .cart-drawer-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 2rem;
        display: flex;
        flex-direction: column;
    }
    
    /* Scrollbar styling */
    .cart-drawer-items::-webkit-scrollbar { width: 6px; }
    .cart-drawer-items::-webkit-scrollbar-track { background: transparent; }
    .cart-drawer-items::-webkit-scrollbar-thumb { background: rgba(43, 29, 20, 0.2); border-radius: 20px; }
    
    .drawer-item {
        display: flex;
        padding: 1.5rem 0;
        gap: 1.5rem;
        align-items: center;
        border-bottom: 1px solid rgba(43, 29, 20, 0.1);
    }
    .drawer-item:last-child {
        border-bottom: none;
    }
    
    .drawer-item img {
        width: 75px;
        height: 75px;
        object-fit: contain;
        background: rgba(43, 29, 20, 0.03);
        border-radius: 20px;
        padding: 0.5rem;
    }
    
    .drawer-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .drawer-item-title {
        font-family: var(--font-body);
        font-weight: 600;
        font-size: 16px;
        line-height: 1.35;
        margin: 0 0 0.4rem 0;
        color: var(--spice-text);
    }
    
    .drawer-item-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }
    
    .drawer-qty-control {
        display: flex;
        align-items: center;
        border: 1px solid rgba(43, 29, 20, 0.2);
        border-radius: 20px;
        overflow: hidden;
        background: transparent;
    }
    
    .drawer-qty-btn {
        background: none;
        border: none;
        padding: 0.3rem 0.6rem;
        cursor: pointer;
        color: var(--spice-text);
        font-size: 1rem;
        transition: background 0.2s;
    }
    
    .drawer-qty-btn:hover {
        background: rgba(43, 29, 20, 0.05);
    }
    
    .drawer-qty-input {
        width: 30px;
        text-align: center;
        border: none;
        font-weight: 500;
        font-size: 0.95rem;
        pointer-events: none;
        background: transparent;
        color: var(--spice-text);
    }
    
    .drawer-item-price {
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 18px;
        color: var(--spice-text);
    }
    
    .drawer-empty-msg {
        text-align: center;
        font-weight: 400;
        color: rgba(43, 29, 20, 0.6);
        margin-top: 3rem;
        font-size: 1.1rem;
    }

    .cart-drawer-footer {
        padding: 2rem;
        background-color: var(--spice-bg);
        border-top: 1px solid rgba(43, 29, 20, 0.1);
        box-shadow: 0 -5px 15px rgba(43, 29, 20, 0.03);
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .cart-drawer-coupon {
        margin-bottom: 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    
    .drawer-coupon-row {
        display: flex;
        gap: 0.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    
    #drawer-coupon-code-input {
        flex: 1;
        min-width: 0;
        box-sizing: border-box;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(43, 29, 20, 0.15);
        border-radius: 20px;
        font-family: var(--font-body);
        font-size: 0.95rem;
        background: #ffffff;
        color: var(--spice-text);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    #drawer-coupon-code-input:focus {
        border-color: var(--spice-primary);
        box-shadow: 0 0 0 2px rgba(228, 93, 62, 0.15);
    }
    
    #drawer-apply-coupon-btn {
        flex-shrink: 0;
        background-color: var(--spice-primary);
        color: #FDFBF7;
        border: none;
        border-radius: 20px;
        padding: 0.75rem 1.25rem;
        font-family: var(--font-body);
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(193, 68, 14, 0.2);
        transition: all 0.2s ease;
    }
    
    #drawer-apply-coupon-btn:hover {
        background-color: var(--spice-accent);
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(193, 68, 14, 0.25);
    }
    
    .cart-drawer-subtotal {
        display: flex;
        justify-content: space-between;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--spice-text);
    }
    
    .shipping-calc-text {
        font-size: 0.85rem;
        color: rgba(43, 29, 20, 0.6);
        margin-bottom: 1.5rem;
        font-weight: 400;
    }
    
    .cart-drawer-checkout {
        display: block;
        width: 100%;
        background-color: var(--spice-primary);
        color: #FDFBF7;
        text-align: center;
        text-decoration: none;
        padding: 1.1rem;
        font-weight: 500;
        font-size: 1.05rem;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all 0.3s ease;
        margin-bottom: 1.2rem;
        border: none;
        box-shadow: 0 10px 20px rgba(193, 68, 14, 0.2);
    }
    
    .cart-drawer-checkout:hover {
        transform: translateY(-2px);
        background-color: var(--spice-accent);
        box-shadow: 0 15px 25px rgba(193, 68, 14, 0.3);
        color: #FDFBF7;
    }
    
    .cart-drawer-checkout[style*="pointer-events: none"] {
        background-color: rgba(43, 29, 20, 0.2);
        box-shadow: none;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .view-full-cart {
        display: block;
        text-align: center;
        color: var(--spice-text);
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        border-bottom: 1px solid var(--spice-text);
        width: fit-content;
        margin: 0 auto;
        padding-bottom: 2px;
        transition: color 0.3s, border-color 0.3s;
    }
    .view-full-cart:hover {
        color: var(--spice-primary);
        border-color: var(--spice-primary);
    }

    @media (max-width: 900px) {
        .cart-drawer,
        .cart-drawer-overlay {
            display: none !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
    }
</style>
