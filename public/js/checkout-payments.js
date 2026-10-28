// Card (Stripe Payment Element) and PayPal payments for the cart checkout.
// Same flow as jojo-fe: the browser never marks an order paid. It starts a server-priced payment
// attempt, lets the provider collect the payment, then waits for the server (Stripe webhook /
// PayPal capture) to report PAID with the created order. The cart stays intact until then.
document.addEventListener('DOMContentLoaded', function () {
    const config = window.shopPaymentConfig || {};
    const checkout = window.ShopCheckout;
    const panel = document.getElementById('online-payment-panel');
    if (!checkout || !panel) return;

    const confirmBtn = document.getElementById('confirm-checkout-btn');
    const stripeBox = document.getElementById('stripe-payment-box');
    const stripePayBtn = document.getElementById('stripe-pay-btn');
    const paypalBox = document.getElementById('paypal-button-container');
    const statusBox = document.getElementById('online-payment-status');
    const stripe = config.stripeKey && window.Stripe ? window.Stripe(config.stripeKey) : null;
    const DETAILS_KEY = 'checkout_payment_details';

    const showAlert = (message) => {
        const alertBox = document.getElementById('checkout-form-alert');
        if (!alertBox) return;
        alertBox.className = 'checkout-alert alert-danger';
        alertBox.textContent = message;
        alertBox.style.display = message ? 'flex' : 'none';
    };
    const showStatus = (message) => { statusBox.textContent = message || ''; statusBox.style.display = message ? 'block' : 'none'; };
    const newKey = (prefix) => prefix + '_' + Array.from(crypto.getRandomValues(new Uint8Array(16)), (b) => b.toString(16).padStart(2, '0')).join('');

    const api = async (url, options = {}) => {
        const response = await fetch(url, {
            ...options,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Session-Id': checkout.sessionId, ...(options.headers || {}) }
        });
        const body = await response.json().catch(() => ({}));
        if (!response.ok) throw new Error(body.error || body.message || (body.errors ? Object.values(body.errors)[0][0] : 'Payment could not be started. Please try again.'));
        return body;
    };

    const startPayment = (provider, details, idempotencyKey) => api(`/api/checkout/${provider}`, {
        method: 'POST',
        headers: { 'Idempotency-Key': idempotencyKey },
        body: JSON.stringify({ shipping_address: details.shippingAddress, coupon_code: details.couponCode })
    });

    const savedDetails = () => { try { return JSON.parse(sessionStorage.getItem(DETAILS_KEY) || 'null'); } catch (e) { return null; } };
    const saveDetails = (details) => { try { sessionStorage.setItem(DETAILS_KEY, JSON.stringify(details)); } catch (e) { /* summary only */ } };

    const completed = (attempt, details) => {
        showStatus('');
        try { sessionStorage.removeItem(DETAILS_KEY); } catch (e) { /* ignore */ }
        resetCard();
        checkout.showCheckoutSuccess(attempt.orderId, attempt.provider, details || savedDetails());
    };

    // Poll until the server reports the paid order (or a failure). PROCESSING keeps waiting.
    const poll = async (attemptId, details, round = 0) => {
        showStatus('Confirming your payment. Please keep this page open…');
        try {
            const attempt = await api(`/api/checkout/payments/${attemptId}`, { method: 'GET' });
            if (attempt.status === 'PAID' && attempt.orderId) return completed(attempt, details);
            if (attempt.status === 'FAILED') {
                showStatus('');
                resetCard();
                return showAlert(attempt.failureMessage || 'Payment was not completed. Your cart is still here — please try again.');
            }
        } catch (error) {
            if (round > 3) { showStatus(''); return showAlert(error.message); }
        }
        if (round >= 60) {
            showStatus('');
            return showAlert('We have not received payment confirmation yet. Please check your orders again in a few minutes.');
        }
        setTimeout(() => poll(attemptId, details, round + 1), Math.min(2000 + round * 500, 10000));
    };

    // ---- Card (Stripe) ----
    let card = null; // { revision, key, attempt, elements }

    function resetCard() {
        card = null;
        stripeBox.style.display = 'none';
        document.getElementById('stripe-payment-element').innerHTML = '';
        stripePayBtn.disabled = false;
        if (confirmBtn && currentMethod() === 'stripe') confirmBtn.style.display = '';
    }

    const startCard = async (details) => {
        if (!stripe) return showAlert('Card payment is not available right now.');
        // A changed cart, address or coupon needs a new server-priced attempt.
        const revision = [details.shippingAddress, details.couponCode, document.getElementById('cart-total')?.textContent].join('|');
        if (!card || card.revision !== revision) card = { revision, key: newKey('stripe') };

        confirmBtn.disabled = true;
        showAlert('');
        try {
            const attempt = await startPayment('stripe', details, card.key);
            if (attempt.status === 'PAID') return poll(attempt.paymentAttemptId, details);
            card.attempt = attempt;
            card.details = details;
            card.elements = stripe.elements({
                clientSecret: attempt.clientSecret,
                appearance: { theme: 'stripe', variables: { colorPrimary: '#B3261E', borderRadius: '10px' } }
            });
            document.getElementById('stripe-payment-element').innerHTML = '';
            card.elements.create('payment', { layout: 'tabs' }).mount('#stripe-payment-element');
            stripePayBtn.querySelector('strong').textContent = document.getElementById('cart-total')?.textContent || '';
            stripeBox.style.display = 'block';
            confirmBtn.style.display = 'none';
            stripeBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (error) {
            showAlert(error.message);
        } finally {
            confirmBtn.disabled = false;
        }
    };

    stripePayBtn.addEventListener('click', async () => {
        if (!card || !card.elements || stripePayBtn.disabled) return;
        stripePayBtn.disabled = true;
        showAlert('');
        saveDetails(card.details);
        const returnUrl = new URL('/cart', window.location.origin);
        returnUrl.searchParams.set('payment_attempt', card.attempt.paymentAttemptId);
        const result = await stripe.confirmPayment({ elements: card.elements, confirmParams: { return_url: returnUrl.toString() }, redirect: 'if_required' });
        if (!result.error || result.error.payment_intent?.status === 'succeeded') return poll(card.attempt.paymentAttemptId, card.details);
        stripePayBtn.disabled = false;
        showAlert(result.error.message || 'Your card payment could not be confirmed.');
    });

    // ---- PayPal ----
    let paypalRendered = false;
    const renderPayPal = () => {
        if (paypalRendered || !config.paypalClientId) return;
        paypalRendered = true;
        const script = document.createElement('script');
        script.src = `https://www.paypal.com/sdk/js?client-id=${encodeURIComponent(config.paypalClientId)}&currency=${encodeURIComponent(config.currency)}&intent=capture&components=buttons`;
        script.onerror = () => { paypalRendered = false; showAlert('PayPal could not be loaded. Please try again.'); };
        script.onload = () => {
            let details = null;
            let attemptId = null;
            window.paypal.Buttons({
                style: { layout: 'vertical', shape: 'rect', label: 'paypal' },
                onClick: (data, actions) => {
                    details = checkout.readCheckoutForm();
                    return details ? actions.resolve() : actions.reject();
                },
                createOrder: async () => {
                    showAlert('');
                    const attempt = await startPayment('paypal', details, newKey('paypal'));
                    if (!attempt.paypalOrderId) throw new Error('PayPal order was not created');
                    attemptId = attempt.paymentAttemptId;
                    return attempt.paypalOrderId;
                },
                onApprove: async ({ orderID }) => {
                    showStatus('Confirming your PayPal payment…');
                    try {
                        const attempt = await api(`/api/checkout/paypal/${attemptId}/capture`, { method: 'POST', body: JSON.stringify({ paypalOrderId: orderID }) });
                        attempt.status === 'PAID' && attempt.orderId ? completed(attempt, details) : poll(attemptId, details);
                    } catch (error) {
                        showStatus('');
                        showAlert(error.message);
                    }
                },
                onCancel: () => showAlert('PayPal checkout was cancelled. Your cart is still here.'),
                onError: () => { showStatus(''); showAlert('PayPal could not complete this payment. Please try again.'); }
            }).render('#paypal-button-container');
        };
        document.head.appendChild(script);
    };

    // ---- Payment method switching ----
    const currentMethod = () => document.querySelector('input[name="checkout_payment_method"]:checked')?.value || 'cod';
    const applyMethod = (method) => {
        const isPayPal = method === 'paypal';
        panel.style.display = method === 'stripe' || isPayPal ? 'block' : 'none';
        paypalBox.style.display = isPayPal ? 'block' : 'none';
        if (method !== 'stripe') { card = null; stripeBox.style.display = 'none'; }
        if (confirmBtn) confirmBtn.style.display = isPayPal ? 'none' : '';
        if (isPayPal) renderPayPal();
        showAlert('');
    };
    document.addEventListener('checkout:payment-method', (event) => applyMethod(event.detail));
    applyMethod(currentMethod());

    window.ShopPayments = { startCard };

    // Returning from a Stripe redirect (e.g. 3-D Secure): resume waiting for the order.
    const url = new URL(window.location.href);
    const returningAttempt = url.searchParams.get('payment_attempt');
    if (returningAttempt) {
        ['payment_attempt', 'payment_intent', 'payment_intent_client_secret', 'redirect_status'].forEach((key) => url.searchParams.delete(key));
        window.history.replaceState({}, '', url.toString());
        panel.style.display = 'block';
        poll(returningAttempt, savedDetails());
    }
});
