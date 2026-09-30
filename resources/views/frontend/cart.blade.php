@extends('frontend.layouts.master')
@section('meta')
    <title>Your Cart | Dried Chili</title>
@endsection
@section('content')
<div class="container cart-page">
    <h1 class="cart-title">Your Cart</h1>
    
    <div class="cart-grid reveal">
        <div class="cart-items-wrapper">
            <!-- Dynamic Cart Items Container -->
            <div id="cart-items-container">
                <p>Loading cart...</p>
            </div>
            
            <!-- Empty State Illustration (Hidden by default) -->
            <div id="cart-empty-state" class="cart-illustration-wrapper" style="display: none;">
                <p style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">Your cart is feeling a bit empty!</p>
                <img src="{{ asset('images/cart_illustration.jpg') }}" alt="Empty Cart" class="cart-illustration">
                <br>
                <a href="/shop" class="btn-primary" style="margin-top: 2rem; display: inline-block;">Start Shopping</a>
            </div>
        </div>
        
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <div class="summary-row">
                <span>Subtotal</span>
                <strong id="cart-subtotal">$0.00</strong>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span>Calculated at checkout</span>
            </div>
            <div class="summary-row total-row">
                <span>Total</span>
                <span id="cart-total">$0.00</span>
            </div>
            <a href="#" class="checkout-btn w-100" id="checkout-btn">Checkout <span style="font-size: 1.8rem; margin-left: 0.5rem;">→</span></a>
        </div>
    </div>
</div>

<style>
.cart-page { padding: 4rem 1rem; min-height: 70vh; }
.cart-title { font-family: var(--font-heading); font-size: 3rem; border-bottom: 4px solid var(--spice-text); padding-bottom: 1rem; margin-bottom: 2rem; color: var(--spice-primary); }
.cart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; }
.cart-item { display: flex; align-items: center; gap: 1.5rem; border: 2px solid var(--spice-text); padding: 1rem; border-radius: 8px; box-shadow: 4px 4px 0px var(--spice-text); margin-bottom: 1.5rem; background: white; }
.cart-item img { width: 100px; height: 100px; object-fit: contain; background: var(--spice-bg-alt); border-radius: 4px; border: 2px solid var(--spice-text); }
.item-info { flex: 1; }
.item-info h3 { font-family: var(--font-heading); margin: 0; font-size: 1.5rem; }
.item-info p { margin: 0.5rem 0; opacity: 0.7; }
.item-actions { display: flex; align-items: center; gap: 1rem; }
.item-actions input { width: 60px; padding: 0.5rem; border: 2px solid var(--spice-text); font-weight: bold; border-radius: 4px; }
.remove-btn { color: var(--spice-accent); font-weight: bold; text-decoration: underline; cursor: pointer; }
.item-price { font-weight: bold; font-size: 1.25rem; }
.cart-illustration-wrapper { text-align: center; margin-top: 1rem; }
.cart-illustration { max-width: 350px; width: 100%; border: 4px solid var(--spice-text); box-shadow: 6px 6px 0px var(--spice-text); border-radius: 12px; }
.cart-summary { background: var(--spice-bg-alt); border: 2px solid var(--spice-text); padding: 2rem; border-radius: 12px; box-shadow: 6px 6px 0px var(--spice-text); height: fit-content; position: sticky; top: 100px; }
.cart-summary h2 { font-family: var(--font-heading); margin-top: 0; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 1rem; }
.summary-row:not(:last-of-type) { border-bottom: 2px dashed var(--spice-text); padding-bottom: 1rem; }
.total-row { margin-bottom: 2rem; font-size: 1.5rem; font-weight: bold; color: var(--spice-primary); border-bottom: none !important; padding-bottom: 0 !important; }
.w-100 { display: block; text-align: center; width: 100%; box-sizing: border-box; }

.checkout-btn {
    background: var(--spice-primary);
    color: white;
    border: 3px solid var(--spice-text);
    padding: 1rem 2rem;
    font-family: var(--font-heading);
    font-size: 1.5rem;
    font-weight: 800;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 12px;
    box-shadow: 6px 6px 0px var(--spice-text);
    transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}
.checkout-btn:hover {
    background: #e33b3b;
    transform: translateY(-4px);
    box-shadow: 8px 8px 0px var(--spice-text);
}
.checkout-btn:active {
    transform: translate(4px, 4px);
    box-shadow: 0px 0px 0px var(--spice-text);
}

@media (max-width: 900px) {
    .cart-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .cart-item { flex-direction: column; text-align: center; }
    .item-actions { justify-content: center; }
}
</style>
@endsection
