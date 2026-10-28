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

    // Drawer toggling functions
    window.openCartDrawer = function() {
        // On mobile phones (<= 768px), do not open drawer to avoid blocking viewport
        if (window.innerWidth <= 768) {
            return;
        }
        const drawer = document.getElementById('cart-drawer');
        const overlay = document.getElementById('cart-drawer-overlay');
        if(drawer) drawer.classList.add('active');
        if(overlay) overlay.classList.add('active');
    };
    
    window.closeCartDrawer = function() {
        const drawer = document.getElementById('cart-drawer');
        const overlay = document.getElementById('cart-drawer-overlay');
        if(drawer) drawer.classList.remove('active');
        if(overlay) overlay.classList.remove('active');
    };

    // Differentiate Cart Behavior: PC opens dropdown drawer, Mobile navigates directly to /cart
    const cartBtnHeader = document.querySelector('.cart-btn');
    if (cartBtnHeader) {
        cartBtnHeader.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                // Mobile: Navigate directly to /cart page
                window.location.href = '/cart';
            } else {
                // Desktop PC: Open/Toggle the Cart Dropdown Drawer
                e.preventDefault();
                e.stopPropagation();
                const drawer = document.getElementById('cart-drawer');
                if (drawer) {
                    if (drawer.classList.contains('active')) {
                        closeCartDrawer();
                    } else {
                        drawer.classList.add('active');
                    }
                }
            }
        });
    }
    
    document.getElementById('cart-drawer-close')?.addEventListener('click', closeCartDrawer);
    document.getElementById('cart-drawer-overlay')?.addEventListener('click', closeCartDrawer);

    // Close when clicking outside of the cart drawer
    document.addEventListener('click', function(e) {
        const drawer = document.getElementById('cart-drawer');
        if (!drawer || !drawer.classList.contains('active')) return;

        // Ignore clicks inside the drawer
        if (drawer.contains(e.target)) return;

        // Ignore clicks on the cart trigger button (handled by its own click event)
        if (e.target.closest('.cart-btn')) return;

        // Ignore clicks on Add To Cart / Bundle buttons that open the drawer
        if (e.target.closest('.quick-add, .add-to-cart-btn, .add-bundle-btn')) return;

        closeCartDrawer();
    });

    // Close on pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartDrawer();
        }
    });


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
            const items = data.cart ? data.cart.items : data.items;
            if (items) items.forEach(item => totalItems += item.quantity);
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
            fetchCart();
            openCartDrawer();
        })
        .catch(err => {
            // Mock fallback
            let existing = mockCartState.items.find(i => i.product_id == productId);
            if(existing) {
                existing.quantity = parseInt(existing.quantity) + parseInt(quantity);
            } else {
                mockCartState.items.push({ id: mockItemIdCounter++, product_id: productId, quantity: quantity, price: 25.00, product: { name: 'Extra Garlic Crunch (Mock)' } });
            }
            fetchCart();
            openCartDrawer();
        });
    };

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

    window.addBundleToCart = function(bundleId, quantity = 1) {
        fetch(API_URL + '/add-bundle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' },
            body: JSON.stringify({ bundle_id: bundleId, quantity: quantity })
        })
        .then(async res => {
            if (!res.ok) {
                const data = await res.json();
                throw new Error(data.error || 'Failed to add bundle');
            }
            return res.json();
        })
        .then(data => {
            fetchCart();
            openCartDrawer();
        })
        .catch(err => {
            alert(err.message);
        });
    };

    function attachAddToCartListeners() {
        const buttons = document.querySelectorAll('.quick-add, .add-to-cart-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                window._lastClickedBtn = this;
                const productId = this.getAttribute('data-product-id');
                if (productId) {
                    const originalHtml = this.innerHTML;
                    this.innerHTML = `<span>Added ✓</span>`;
                    this.style.backgroundColor = 'var(--spice-primary)';
                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                        this.style.backgroundColor = '';
                    }, 1200);
                    addToCart(productId, 1);
                }
            });
        });

        const bundleButtons = document.querySelectorAll('.add-bundle-btn');
        bundleButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                const bundleId = this.getAttribute('data-bundle-id');
                if (bundleId) {
                    addBundleToCart(bundleId, 1);
                }
            });
        });
    }

    // Handle Cart Page & Drawer Render
    window.addEventListener('cartUpdated', function(e) {
        const cartData = e.detail;
        
        // --- 1. Drawer Logic ---
        const drawerContainer = document.getElementById('drawer-cart-items');
        const drawerSubtotal = document.getElementById('drawer-cart-subtotal');
        const drawerDiscountContainer = document.getElementById('drawer-cart-discount-container');
        const drawerDiscount = document.getElementById('drawer-cart-discount');
        const drawerTotalContainer = document.getElementById('drawer-cart-total-container');
        const drawerTotal = document.getElementById('drawer-cart-total');
        const appliedCouponCode = document.getElementById('applied-coupon-code');
        const drawerCheckout = document.getElementById('drawer-checkout-btn');

        if (drawerContainer) {
            const items = cartData.cart ? cartData.cart.items : cartData.items;
            if (!items || items.length === 0) {
                drawerContainer.innerHTML = '<div class="drawer-empty-msg">Your cart is empty.</div>';
                if(drawerSubtotal) drawerSubtotal.textContent = '$0.00';
                if(drawerCheckout) {
                    drawerCheckout.style.pointerEvents = 'none';
                    drawerCheckout.style.opacity = '0.5';
                }
            } else {
                if(drawerCheckout) {
                    drawerCheckout.style.pointerEvents = 'auto';
                    drawerCheckout.style.opacity = '1';
                }
                let html = '';
                let total = 0;
                
                items.forEach(item => {
                    const productName = item.product ? item.product.name : (item.bundle ? item.bundle.name : 'Chili Product');
                    const productPrice = parseFloat(item.price) || 25.00;
                    const itemTotal = productPrice * item.quantity;
                    total += itemTotal;
                    
                    html += `
                        <div class="drawer-item">
                            <img src="/images/product_hero.png" alt="Chili">
                            <div class="drawer-item-details">
                                <h3 class="drawer-item-title">${productName}</h3>
                                <div class="drawer-item-actions">
                                    <div class="drawer-qty-control">
                                        <button type="button" class="drawer-qty-btn decrease-qty" data-id="${item.id}" data-price="${productPrice}">-</button>
                                        <input type="text" class="drawer-qty-input" value="${item.quantity}" readonly>
                                        <button type="button" class="drawer-qty-btn increase-qty" data-id="${item.id}" data-price="${productPrice}">+</button>
                                    </div>
                                    <div class="drawer-item-price">$${itemTotal.toFixed(2)}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                cartData.subtotal = total; // Mock if missing
                const actualSubtotal = cartData.subtotal !== undefined ? cartData.subtotal : total;
                const actualTotal = cartData.total !== undefined ? cartData.total : total;
                const discount = cartData.discount_amount || 0;
                const bundleDiscount = cartData.bundle_discount || 0;

                drawerContainer.innerHTML = html;
                if(drawerSubtotal) drawerSubtotal.textContent = '$' + actualSubtotal.toFixed(2);
                
                const drawerBundleDiscountContainer = document.getElementById('drawer-bundle-discount-container');
                const drawerBundleDiscount = document.getElementById('drawer-bundle-discount');
                if(drawerBundleDiscountContainer && bundleDiscount > 0) {
                    drawerBundleDiscountContainer.style.display = 'flex';
                    drawerBundleDiscount.textContent = '-$' + bundleDiscount.toFixed(2);
                } else if(drawerBundleDiscountContainer) {
                    drawerBundleDiscountContainer.style.display = 'none';
                }

                if(drawerDiscountContainer && discount > 0) {
                    drawerDiscountContainer.style.display = 'flex';
                    drawerDiscount.textContent = '-$' + discount.toFixed(2);
                    if(appliedCouponCode && cartData.applied_coupon) {
                        appliedCouponCode.textContent = cartData.applied_coupon.code;
                    }
                } else {
                    if(drawerDiscountContainer) drawerDiscountContainer.style.display = 'none';
                }
                
                if(drawerTotalContainer && (discount > 0 || bundleDiscount > 0)) {
                    drawerTotalContainer.style.display = 'flex';
                    drawerTotal.textContent = '$' + actualTotal.toFixed(2);
                } else {
                    if(drawerTotalContainer) drawerTotalContainer.style.display = 'none';
                }
                
                // Add event listeners for drawer buttons
                drawerContainer.querySelectorAll('.increase-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.previousElementSibling;
                        const newQty = parseInt(input.value) + 1;
                        const price = parseFloat(this.getAttribute('data-price'));
                        
                        // Optimistic UI updates
                        input.value = newQty;
                        const itemPriceEl = this.closest('.drawer-item-actions').querySelector('.drawer-item-price');
                        if (itemPriceEl) itemPriceEl.textContent = '$' + (price * newQty).toFixed(2);
                        
                            if (drawerSubtotal) {
                                const current = parseFloat(drawerSubtotal.textContent.replace('$', '')) || 0;
                                drawerSubtotal.textContent = '$' + (current + price).toFixed(2);
                            }
                        
                        updateCartItem(this.dataset.id, newQty);
                    });
                });
                drawerContainer.querySelectorAll('.decrease-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.nextElementSibling;
                        const newVal = parseInt(input.value) - 1;
                        const price = parseFloat(this.getAttribute('data-price'));
                        
                        if (newVal > 0) {
                            // Optimistic UI updates
                            input.value = newVal;
                            const itemPriceEl = this.closest('.drawer-item-actions').querySelector('.drawer-item-price');
                            if (itemPriceEl) itemPriceEl.textContent = '$' + (price * newVal).toFixed(2);
                            
                            if (drawerSubtotal) {
                                const current = parseFloat(drawerSubtotal.textContent.replace('$', '')) || 0;
                                drawerSubtotal.textContent = '$' + Math.max(0, current - price).toFixed(2);
                            }
                            updateCartItem(this.dataset.id, newVal);
                        } else {
                            removeCartItem(this.dataset.id);
                        }
                    });
                });
            }
        }
        
        // --- 2. Cart Page Logic ---
        const container = document.getElementById('cart-items-container');
        const emptyState = document.getElementById('cart-empty-state');
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');
        const headerCountEl = document.getElementById('cart-header-count');
        const progressMeter = document.getElementById('shipping-meter-fill');
        const progressText = document.getElementById('shipping-progress-text');
        const shippingVal = document.getElementById('cart-shipping-val');

        if (!container) return; // Not on cart page

        const items = cartData.cart ? cartData.cart.items : cartData.items;

        if (!items || items.length === 0) {
            container.innerHTML = '';
            emptyState.style.display = 'block';
            subtotalEl.textContent = '$0.00';
            totalEl.textContent = '$0.00';
            if (headerCountEl) headerCountEl.textContent = '(0)';
            if (progressMeter) progressMeter.style.width = '0%';
            if (progressText) progressText.innerHTML = 'Add <strong>$50.00</strong> more to qualify for <strong>FREE NATIONWIDE SHIPPING!</strong>';
            if (shippingVal) shippingVal.textContent = 'Calculated at checkout';
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.pointerEvents = 'none';
            return;
        }

        emptyState.style.display = 'none';
        checkoutBtn.style.opacity = '1';
        checkoutBtn.style.pointerEvents = 'auto';
        
        let html = '';
        let total = 0;
        let totalQty = 0;

        items.forEach(item => {
            const productName = item.product ? item.product.name : (item.bundle ? item.bundle.name : 'Dried Chili Artisan Product');
            const productPrice = parseFloat(item.price) || 25.00;
            const itemTotal = productPrice * item.quantity;
            total += itemTotal;
            totalQty += parseInt(item.quantity) || 1;

            html += `
                <div class="cart-item" data-id="${item.id}">
                    <div class="cart-item-img-box">
                        <img src="/images/product_hero.png" alt="${productName}">
                    </div>
                    <div class="cart-item-content">
                        <span class="cart-item-brand">DRIED CHILI PANTRY</span>
                        <h3 class="cart-item-title">${productName}</h3>
                        <div class="cart-item-unit-price">$${productPrice.toFixed(2)} each</div>
                        <div class="cart-item-bottom">
                            <div class="cart-item-stepper">
                                <button type="button" class="stepper-btn stepper-dec" data-id="${item.id}" aria-label="Decrease quantity">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                                <input type="number" value="${item.quantity}" min="1" data-id="${item.id}" class="update-qty-input stepper-input" aria-label="Quantity">
                                <button type="button" class="stepper-btn stepper-inc" data-id="${item.id}" aria-label="Increase quantity">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                            </div>
                            <button type="button" class="cart-item-remove remove-btn" data-id="${item.id}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                <span>Remove</span>
                            </button>
                        </div>
                    </div>
                    <div class="cart-item-total-col">
                        <span class="cart-item-total-label">Subtotal</span>
                        <span class="item-price cart-item-total-amount">$${itemTotal.toFixed(2)}</span>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        const actualSubtotal = cartData.subtotal !== undefined ? cartData.subtotal : total;
        const actualTotal = cartData.total !== undefined ? cartData.total : total;
        
        subtotalEl.textContent = '$' + actualSubtotal.toFixed(2);
        totalEl.textContent = '$' + actualTotal.toFixed(2);

        const btnCheckoutTotalVal = document.getElementById('btn-checkout-total-val');
        if (btnCheckoutTotalVal) {
            btnCheckoutTotalVal.textContent = '$' + actualTotal.toFixed(2);
        }
        window.currentCartTotal = actualTotal;
        window.currentAppliedCoupon = cartData.applied_coupon ? cartData.applied_coupon.code : (cartData.coupon_code || null);

        if (headerCountEl) {
            headerCountEl.textContent = `(${totalQty})`;
        }

        // Free shipping calculation
        const freeShippingThreshold = 50.00;
        if (progressMeter && progressText) {
            if (actualSubtotal >= freeShippingThreshold) {
                progressMeter.style.width = '100%';
                progressText.innerHTML = '<strong>Congratulations!</strong> You qualify for <strong>FREE NATIONWIDE SHIPPING!</strong>';
                if (shippingVal) shippingVal.innerHTML = '<span class="badge-free">FREE</span>';
            } else {
                const diff = (freeShippingThreshold - actualSubtotal).toFixed(2);
                const pct = Math.min(100, Math.max(0, (actualSubtotal / freeShippingThreshold) * 100));
                progressMeter.style.width = pct + '%';
                progressText.innerHTML = `Add <strong>$${diff}</strong> more to qualify for <strong>FREE NATIONWIDE SHIPPING!</strong>`;
                if (shippingVal) shippingVal.textContent = 'Calculated at checkout';
            }
        }
        
        // Handle Bundle Discount UI on Cart Page
        const cartBundleDiscountEl = document.getElementById('cart-bundle-discount');
        if (cartBundleDiscountEl) {
            if (cartData.bundle_discount && cartData.bundle_discount > 0) {
                cartBundleDiscountEl.style.display = 'flex';
                document.getElementById('cart-bundle-val').textContent = '-$' + cartData.bundle_discount.toFixed(2);
            } else {
                cartBundleDiscountEl.style.display = 'none';
            }
        }

        // Handle Coupon Discount UI on Cart Page
        const cartCouponDiscountEl = document.getElementById('cart-coupon-discount');
        if (cartCouponDiscountEl) {
            if (cartData.discount_amount && cartData.discount_amount > 0) {
                cartCouponDiscountEl.style.display = 'flex';
                document.getElementById('cart-coupon-val').textContent = '-$' + cartData.discount_amount.toFixed(2);
                const couponCodeSpan = document.getElementById('cart-applied-coupon-code');
                if (couponCodeSpan) {
                    couponCodeSpan.textContent = cartData.applied_coupon ? cartData.applied_coupon.code : 'Applied';
                }
            } else {
                cartCouponDiscountEl.style.display = 'none';
            }
        }

        // Event listeners for quantity inputs
        container.querySelectorAll('.update-qty-input').forEach(input => {
            input.addEventListener('change', function() {
                updateCartItem(this.dataset.id, this.value);
            });
        });

        // Event listeners for stepper plus/minus
        container.querySelectorAll('.stepper-dec').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.parentNode.querySelector('.update-qty-input');
                const cur = parseInt(input.value) || 1;
                if (cur > 1) {
                    input.value = cur - 1;
                    updateCartItem(this.dataset.id, cur - 1);
                } else {
                    removeCartItem(this.dataset.id);
                }
            });
        });

        container.querySelectorAll('.stepper-inc').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.parentNode.querySelector('.update-qty-input');
                const cur = parseInt(input.value) || 1;
                input.value = cur + 1;
                updateCartItem(this.dataset.id, cur + 1);
            });
        });

        // Event listeners for remove buttons
        container.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                removeCartItem(this.dataset.id);
            });
        });
    });

    // --- 3. Checkout Page & Transition Logic ---
    const checkoutBtn = document.getElementById('checkout-btn');
    const returnCartBtn = document.getElementById('btn-return-cart');
    const editCartBtn = document.getElementById('checkout-edit-cart-btn');
    const cartItemsSec = document.getElementById('cart-items-section');
    const checkoutSec = document.getElementById('checkout-details-section');
    const pageHeadingText = document.getElementById('title-text');
    const cartShopLink = document.getElementById('cart-shop-link');

    function switchToCheckoutView() {
        const subtotalEl = document.getElementById('cart-subtotal');
        const subtotalVal = parseFloat(subtotalEl?.textContent?.replace('$', '') || 0);
        if (subtotalVal <= 0) {
            alert('Your cart is empty. Please add items to checkout.');
            return;
        }

        if (cartItemsSec && checkoutSec) {
            cartItemsSec.style.display = 'none';
            checkoutSec.style.display = 'block';
        }
        if (checkoutBtn) checkoutBtn.style.display = 'none';
        if (editCartBtn) editCartBtn.style.display = 'inline-flex';
        if (cartShopLink) cartShopLink.style.display = 'none';
        if (returnCartBtn) returnCartBtn.style.display = 'inline-flex';
        if (pageHeadingText) pageHeadingText.textContent = 'Checkout Details';

        const btnTotal = document.getElementById('btn-checkout-total-val');
        const totalEl = document.getElementById('cart-total');
        if (btnTotal && totalEl) {
            btnTotal.textContent = totalEl.textContent;
        }

        window.scrollTo({ top: 100, behavior: 'smooth' });
    }

    function switchToCartView() {
        if (cartItemsSec && checkoutSec) {
            checkoutSec.style.display = 'none';
            cartItemsSec.style.display = 'block';
        }
        if (checkoutBtn) checkoutBtn.style.display = 'inline-flex';
        if (editCartBtn) editCartBtn.style.display = 'none';
        if (cartShopLink) cartShopLink.style.display = 'inline-flex';
        if (returnCartBtn) returnCartBtn.style.display = 'none';
        if (pageHeadingText) pageHeadingText.textContent = 'Your Cart';

        window.scrollTo({ top: 100, behavior: 'smooth' });
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            switchToCheckoutView();
        });
    }

    if (returnCartBtn) {
        returnCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            switchToCartView();
        });
    }

    if (editCartBtn) {
        editCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            switchToCartView();
        });
    }

    // Payment Cards Toggle
    const paymentCards = document.querySelectorAll('.payment-card');
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            paymentCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                document.dispatchEvent(new CustomEvent('checkout:payment-method', { detail: radio.value }));
            }
        });
    });

    // Form Validation (shared with card / PayPal payments in checkout-payments.js)
    const readCheckoutForm = () => {
        // Clear previous errors
        document.querySelectorAll('.field-error-msg').forEach(el => el.textContent = '');
        document.querySelectorAll('.checkout-input').forEach(el => el.classList.remove('is-invalid'));
        const alertBox = document.getElementById('checkout-form-alert');
        if (alertBox) alertBox.style.display = 'none';

        const nameInput = document.getElementById('checkout-name');
        const phoneInput = document.getElementById('checkout-phone');
        const emailInput = document.getElementById('checkout-email');
        const streetInput = document.getElementById('checkout-street');
        const cityInput = document.getElementById('checkout-city');
        const noteInput = document.getElementById('checkout-note');

        const name = nameInput ? nameInput.value.trim() : '';
        const phone = phoneInput ? phoneInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';
        const street = streetInput ? streetInput.value.trim() : '';
        const city = cityInput ? cityInput.value.trim() : '';
        const note = noteInput ? noteInput.value.trim() : '';

        let hasError = false;

        if (!name) {
            if (nameInput) nameInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-name');
            if (err) err.textContent = 'Please enter your full name.';
            hasError = true;
        }

        if (!phone) {
            if (phoneInput) phoneInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-phone');
            if (err) err.textContent = 'Please enter your phone number.';
            hasError = true;
        } else if (phone.length < 8) {
            if (phoneInput) phoneInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-phone');
            if (err) err.textContent = 'Please enter a valid phone number.';
            hasError = true;
        }

        if (!email) {
            if (emailInput) emailInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-email');
            if (err) err.textContent = 'Please enter your email address.';
            hasError = true;
        }

        if (!street) {
            if (streetInput) streetInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-street');
            if (err) err.textContent = 'Please enter your delivery street address.';
            hasError = true;
        }

        if (!city) {
            if (cityInput) cityInput.classList.add('is-invalid');
            const err = document.getElementById('error-checkout-city');
            if (err) err.textContent = 'Please enter your city / province.';
            hasError = true;
        }

        if (hasError) {
            if (alertBox) {
                alertBox.className = 'checkout-alert alert-danger';
                alertBox.textContent = 'Please fill in all required fields indicated in red.';
                alertBox.style.display = 'flex';
            }
            const firstInvalid = document.querySelector('.checkout-input.is-invalid');
            if (firstInvalid) firstInvalid.focus();
            return null;
        }

        return {
            name, phone, email, street, city, note,
            shippingAddress: `${name} (Phone: ${phone}, Email: ${email}) | Address: ${street}, ${city}${note ? ' | Note: ' + note : ''}`,
            couponCode: window.currentAppliedCoupon || null
        };
    };

    const paymentLabels = { cod: 'Cash on Delivery (COD)', bank_transfer: 'Bank Transfer', stripe: 'Credit / Debit Card', paypal: 'PayPal' };

    // Success Modal Display
    const showCheckoutSuccess = (orderId, paymentMethod, details) => {
        const modal = document.getElementById('checkout-success-modal');
        const modalOrderId = document.getElementById('modal-order-id');
        const modalPaymentMethod = document.getElementById('modal-payment-method');
        const modalOrderTotal = document.getElementById('modal-order-total');
        const modalShippingSummary = document.getElementById('modal-shipping-summary');
        const currentTotal = document.getElementById('cart-total')?.textContent || '$0.00';

        if (modalOrderId) modalOrderId.textContent = `#ORD-${orderId || 'SUCCESS'}`;
        if (modalPaymentMethod) modalPaymentMethod.textContent = paymentLabels[paymentMethod] || paymentMethod;
        if (modalOrderTotal) modalOrderTotal.textContent = currentTotal;
        if (modalShippingSummary) modalShippingSummary.textContent = details ? `${details.name} • ${details.phone} • ${details.street}, ${details.city}` : '';

        if (modal) {
            modal.style.display = 'flex';
        }

        // Clear and refresh cart state
        mockCartState = { items: [] };
        fetchCart();
    };

    window.ShopCheckout = { sessionId, readCheckoutForm, showCheckoutSuccess };

    // Form Submission
    const confirmCheckoutBtn = document.getElementById('confirm-checkout-btn');
    if (confirmCheckoutBtn) {
        confirmCheckoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();

            const details = readCheckoutForm();
            if (!details) return;
            const alertBox = document.getElementById('checkout-form-alert');

            const activeRadio = document.querySelector('input[name="checkout_payment_method"]:checked');
            const paymentMethod = activeRadio ? activeRadio.value : 'cod';

            // Card payments are collected by Stripe; the order is created only after payment succeeds.
            if (paymentMethod === 'stripe' && window.ShopPayments) {
                window.ShopPayments.startCard(details);
                return;
            }

            const originalBtnHtml = confirmCheckoutBtn.innerHTML;
            confirmCheckoutBtn.disabled = true;
            confirmCheckoutBtn.innerHTML = `
                <svg class="spinner-rotate" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
                <span>Processing Order...</span>
            `;

            try {
                const response = await fetch('/api/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Session-Id': sessionId
                    },
                    body: JSON.stringify({
                        shipping_address: details.shippingAddress,
                        payment_method: paymentMethod,
                        coupon_code: details.couponCode
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                        return;
                    }

                    // Success Modal Display
                    const modal = document.getElementById('checkout-success-modal');
                    const modalOrderId = document.getElementById('modal-order-id');
                    const modalPaymentMethod = document.getElementById('modal-payment-method');
                    const modalOrderTotal = document.getElementById('modal-order-total');
                    const modalShippingSummary = document.getElementById('modal-shipping-summary');
                    const currentTotal = document.getElementById('cart-total')?.textContent || '$0.00';

                    if (modalOrderId) modalOrderId.textContent = `#ORD-${result.order_id || 'SUCCESS'}`;
                    if (modalPaymentMethod) modalPaymentMethod.textContent = paymentMethod === 'paypal' ? 'PayPal / Credit Card' : 'Cash on Delivery (COD)';
                    if (modalOrderTotal) modalOrderTotal.textContent = currentTotal;
                    if (modalShippingSummary) modalShippingSummary.textContent = `${name} • ${phone} • ${street}, ${city}`;

                    if (result.success_url) {
                        const viewOrderLink = modal?.querySelector('.btn-primary-success');
                        if (viewOrderLink) {
                            viewOrderLink.href = result.success_url;
                            viewOrderLink.textContent = 'View Order Receipt';
                        }
                    }

                    if (modal) {
                        modal.style.display = 'flex';
                    }

                    // Clear and refresh cart state
                    mockCartState = { items: [] };
                    fetchCart();

                } else {
                    if (alertBox) {
                        alertBox.className = 'checkout-alert alert-danger';
                        alertBox.textContent = result.error || (result.errors ? Object.values(result.errors)[0][0] : 'Checkout failed. Please try again.');
                        alertBox.style.display = 'flex';
                    }
                    confirmCheckoutBtn.disabled = false;
                    confirmCheckoutBtn.innerHTML = originalBtnHtml;
                }
            } catch (error) {
                console.error('Checkout error:', error);
                if (alertBox) {
                    alertBox.className = 'checkout-alert alert-danger';
                    alertBox.textContent = 'Network or server error while placing order. Please try again.';
                    alertBox.style.display = 'flex';
                }
                confirmCheckoutBtn.disabled = false;
                confirmCheckoutBtn.innerHTML = originalBtnHtml;
            }
        });
    }

    fetchCart();
    attachAddToCartListeners();

    // Coupon logic
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const removeCouponBtn = document.getElementById('remove-coupon-btn');
    const couponInput = document.getElementById('coupon-code-input');
    const couponMsg = document.getElementById('coupon-message');

    if(applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const code = couponInput.value.trim();
            if(!code) return;
            applyCouponBtn.disabled = true;
            applyCouponBtn.textContent = '...';
            
            fetch('/api/coupon/apply', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Apply';
                couponMsg.style.display = 'block';
                if(data.success) {
                    couponMsg.style.color = '#2E7D32';
                    couponMsg.textContent = data.message;
                    couponInput.value = '';
                    fetchCart(); // Refresh cart to get new totals
                } else {
                    couponMsg.style.color = '#D32F2F';
                    couponMsg.textContent = data.message || (data.errors ? Object.values(data.errors)[0][0] : 'Failed');
                }
            }).catch(e => {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Apply';
            });
        });
    }

    if(removeCouponBtn) {
        removeCouponBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/api/coupon/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Session-Id': sessionId, 'Accept': 'application/json' }
            }).then(() => fetchCart());
        });
    }
});
