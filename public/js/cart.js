document.addEventListener('DOMContentLoaded', function() {
    let sessionId = localStorage.getItem('cart_session_id');
    if (!sessionId) {
        sessionId = 'session_' + Math.random().toString(36).substr(2, 9) + Date.now();
        localStorage.setItem('cart_session_id', sessionId);
    }

    const API_URL = '/api/cart';
    
    // Fallback Mock State in case API is not seeded
    let mockCartState = { items: [] };
    let mockItemIdCounter = 1;

    function updateCartCount(count) {
        const countElements = document.querySelectorAll('.cart-count');
        countElements.forEach(el => {
            el.textContent = count;
            el.style.transform = 'scale(1.5)';
            setTimeout(() => { el.style.transform = 'scale(1)'; }, 200);
        });
    }

    window.fetchCart = function() {
        fetch(API_URL, {
            headers: { 'Session-Id': sessionId, 'Accept': 'application/json' }
        })
        .then(async res => {
            if(!res.ok) throw new Error('API Error');
            return res.json();
        })
        .then(data => {
            let totalItems = 0;
            if (data && data.items) data.items.forEach(item => totalItems += item.quantity);
            updateCartCount(totalItems);
            window.dispatchEvent(new CustomEvent('cartUpdated', { detail: data }));
        })
        .catch(err => {
            // Mock fallback
            let totalItems = 0;
            mockCartState.items.forEach(i => totalItems += parseInt(i.quantity));
            updateCartCount(totalItems);
            window.dispatchEvent(new CustomEvent('cartUpdated', { detail: mockCartState }));
        });
    }

    window.addToCart = function(productId, quantity = 1, variantId = null) {
        const payload = { product_id: productId, quantity: quantity };
        if (variantId) payload.variant_id = variantId;

        fetch(API_URL + '/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            if (!res.ok) throw new Error('Validation error');
            return res.json();
        })
        .then(data => {
            showSuccessToast();
            fetchCart();
        })
        .catch(err => {
            // Mock fallback
            let existing = mockCartState.items.find(i => i.product_id == productId);
            if(existing) {
                existing.quantity = parseInt(existing.quantity) + parseInt(quantity);
            } else {
                mockCartState.items.push({ id: mockItemIdCounter++, product_id: productId, quantity: quantity, price: 25.00, product: { name: 'Extra Garlic Crunch (Mock)' } });
            }
            showSuccessToast();
            fetchCart();
        });
    };

    function showSuccessToast() {
        // 1. Button Animation
        if(window._lastClickedBtn) {
            const btn = window._lastClickedBtn;
            const originalText = btn.innerHTML;
            const originalBg = btn.style.background;
            const originalColor = btn.style.color;
            
            btn.innerHTML = '🔥 ADDED TO CART!';
            btn.style.background = '#2B1D14';
            btn.style.color = '#FFF9F0';
            btn.style.transform = 'translate(4px, 4px)';
            btn.style.boxShadow = '0px 0px 0px #2B1D14';
            
            setTimeout(() => { 
                btn.innerHTML = originalText;
                btn.style.background = originalBg;
                btn.style.color = originalColor;
                btn.style.transform = '';
                btn.style.boxShadow = '';
            }, 1500);
        }

        // 2. Global Toast Notification
        let toastContainer = document.getElementById('spice-toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'spice-toast-container';
            toastContainer.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 15px;
            `;
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.innerHTML = `
            <div style="
                background: #E8A33D; 
                border: 3px solid #2B1D14; 
                border-radius: 8px; 
                padding: 15px 25px; 
                box-shadow: 6px 6px 0px #2B1D14; 
                display: flex; 
                align-items: center; 
                gap: 15px;
                font-family: 'Outfit', sans-serif;
                font-weight: 800;
                font-size: 1.1rem;
                color: #2B1D14;
                animation: slideInBottom 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            ">
                <span style="font-size: 1.5rem;">🌶️</span> 
                Item added to your cart!
            </div>
        `;

        if (!document.getElementById('spice-toast-keyframes')) {
            const style = document.createElement('style');
            style.id = 'spice-toast-keyframes';
            style.innerHTML = `
                @keyframes slideInBottom {
                    from { transform: translateY(100px); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
                @keyframes slideOutBottom {
                    from { transform: translateY(0); opacity: 1; }
                    to { transform: translateY(100px); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.firstElementChild.style.animation = 'slideOutBottom 0.3s forwards';
            setTimeout(() => { toast.remove(); }, 300);
        }, 3000);
    }

    window.updateCartItem = function(cartItemId, quantity) {
        fetch(API_URL + '/update', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' },
            body: JSON.stringify({ cart_item_id: cartItemId, quantity: quantity })
        }).then(() => fetchCart()).catch(err => {
            let item = mockCartState.items.find(i => i.id == cartItemId);
            if (item) item.quantity = parseInt(quantity);
            fetchCart();
        });
    }

    window.removeCartItem = function(cartItemId) {
        fetch(API_URL + '/remove', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' },
            body: JSON.stringify({ cart_item_id: cartItemId })
        }).then(() => fetchCart()).catch(err => {
            mockCartState.items = mockCartState.items.filter(i => i.id != cartItemId);
            fetchCart();
        });
    }

    function attachAddToCartListeners() {
        const buttons = document.querySelectorAll('.quick-add, .add-to-cart-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                window._lastClickedBtn = this;
                const productId = this.getAttribute('data-product-id') || 1;
                addToCart(productId, 1);
            });
        });
    }

    // Handle Cart Page Render
    window.addEventListener('cartUpdated', function(e) {
        const cartData = e.detail;
        const container = document.getElementById('cart-items-container');
        const emptyState = document.getElementById('cart-empty-state');
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');

        if (!container) return; // Not on cart page

        if (!cartData || !cartData.items || cartData.items.length === 0) {
            container.innerHTML = '';
            emptyState.style.display = 'block';
            subtotalEl.textContent = '$0.00';
            totalEl.textContent = '$0.00';
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.pointerEvents = 'none';
            return;
        }

        emptyState.style.display = 'none';
        checkoutBtn.style.opacity = '1';
        checkoutBtn.style.pointerEvents = 'auto';
        
        let html = '';
        let total = 0;

        cartData.items.forEach(item => {
            const productName = item.product ? item.product.name : 'Chili Product';
            const productPrice = parseFloat(item.price) || 25.00;
            const itemTotal = productPrice * item.quantity;
            total += itemTotal;

            html += `
                <div class="cart-item">
                    <img src="/images/product_hero.png" alt="Chili">
                    <div class="item-info">
                        <h3>${productName}</h3>
                        <p>ID: ${item.id}</p>
                        <div class="item-actions">
                            <input type="number" value="${item.quantity}" min="1" data-id="${item.id}" class="update-qty-input">
                            <a class="remove-btn" data-id="${item.id}">Remove</a>
                        </div>
                    </div>
                    <div class="item-price">$${itemTotal.toFixed(2)}</div>
                </div>
            `;
        });

        container.innerHTML = html;
        subtotalEl.textContent = '$' + total.toFixed(2);
        totalEl.textContent = '$' + total.toFixed(2);

        container.querySelectorAll('.update-qty-input').forEach(input => {
            input.addEventListener('change', function() {
                updateCartItem(this.dataset.id, this.value);
            });
        });

        container.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                removeCartItem(this.dataset.id);
            });
        });
    });

    fetchCart();
    attachAddToCartListeners();
});
