<!-- The Small Floating Voucher -->
<div id="voucher-popup" class="voucher-popup-container">
    <div class="voucher-popup-content" id="open-newsletter-modal">
        <button id="close-voucher" class="voucher-close-btn" aria-label="Close voucher">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="voucher-text">Get 15% Off</div>
    </div>
</div>

<!-- The Large Newsletter Modal -->
<div class="newsletter-modal-overlay" id="newsletter-modal">
    <div class="newsletter-modal-content">
        <button class="newsletter-close" id="close-newsletter" aria-label="Close newsletter">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        
        <div class="newsletter-split">
            <div class="newsletter-image">
                <!-- Fallback to an existing image from the source code -->
                <img src="{{ asset('images/story_spices-optimized.webp') }}" alt="Dried Chilli Spices" width="1024" height="1024" loading="lazy" decoding="async">
            </div>
            <div class="newsletter-form-side">
                <h2>GET 15% OFF EVERYTHING</h2>
                <p>Sign up to receive recipes, exclusive deals, and an instant 15% discount code sent to your email.</p>
                
                <div id="voucher-feedback-msg" style="display: none; margin-bottom: 1rem; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.95rem; font-weight: 600;"></div>

                <form id="newsletter-form">
                    @csrf
                    <input type="email" id="newsletter-email" name="email" placeholder="Enter your email" required class="newsletter-input">
                    <button type="submit" id="newsletter-submit-btn" class="newsletter-submit">GET 15% VOUCHER</button>
                </form>

                <!-- Success Box -->
                <div id="voucher-success-box" style="display: none; text-align: center;">
                    <div style="background: #FFF5F5; border: 2px dashed #D32F2F; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.25rem;">
                        <span style="font-size: 0.85rem; font-weight: 700; color: #8D6E63; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.4rem;">YOUR 15% PROMO CODE</span>
                        <div id="generated-voucher-code" style="font-family: monospace; font-size: 1.8rem; font-weight: 900; letter-spacing: 2px; color: #D32F2F; margin-bottom: 0.75rem; user-select: all;"></div>
                        <button type="button" id="copy-voucher-btn" style="background: #2B1D14; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.5rem 1.25rem; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                            Copy Promo Code
                        </button>
                    </div>
                    <p id="voucher-delivery-message" style="font-size: 0.9rem; color: #2E7D32; font-weight: 600; margin-bottom: 1.25rem;">
                        ✔ We've sent your 15% promo code to your email! Enter it in cart or checkout.
                    </p>
                    <a href="{{ route('page.shop') }}" class="newsletter-submit" style="display: block; text-decoration: none; padding: 1rem; text-align: center;">SHOP NOW</a>
                </div>

                <button type="button" class="newsletter-no-thanks" id="no-thanks-btn">NO, THANKS</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Small Floating Voucher */
    .voucher-popup-container {
        position: fixed;
        bottom: 50px;
        left: 0;
        z-index: 998;
        transform: translateX(-150px);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .voucher-popup-container.show { transform: translateX(0); }

    .voucher-popup-content {
        background: #FDF9F3;
        color: #C2185B;
        padding: 1.5rem 0.5rem;
        border-radius: 0 20px 20px 0;
        position: relative;
        box-shadow: 5px 0 15px rgba(0,0,0,0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .voucher-popup-content:hover { 
        transform: translateX(3px); 
        box-shadow: 8px 0 20px rgba(0,0,0,0.25); 
    }
    
    .voucher-text {
        font-family: var(--font-heading);
        font-weight: 800;
        font-size: 1.2rem;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        margin: 0;
        white-space: nowrap;
        writing-mode: vertical-rl;
        transform: rotate(180deg);
    }

    .voucher-close-btn {
        position: absolute;
        top: -10px; 
        right: -10px;
        background: #000000;
        color: #FFFFFF;
        border: 2px solid #FDF9F3;
        border-radius: 20px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        transition: transform 0.2s;
        padding: 0;
        z-index: 10;
    }
    .voucher-close-btn svg {
        width: 14px;
        height: 14px;
    }
    .voucher-close-btn:hover { background: #333333; transform: scale(1.1); }

    /* Large Newsletter Modal */
    .newsletter-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(43, 29, 20, 0.65);
        backdrop-filter: blur(5px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        box-sizing: border-box;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .newsletter-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .newsletter-modal-content {
        background: #FDF9F3;
        width: 850px;
        max-width: 95vw;
        max-height: 90vh;
        border-radius: 20px;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        position: relative;
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .newsletter-modal-overlay.active .newsletter-modal-content {
        transform: scale(1);
    }

    .newsletter-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        border: 2px solid #2B1D14;
        width: 36px;
        height: 36px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        color: #2B1D14;
        transition: transform 0.2s, background 0.2s;
    }
    .newsletter-close:hover { 
        transform: scale(1.1); 
        background: #f0f0f0; 
    }

    .newsletter-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    
    .newsletter-image {
        position: relative;
    }
    .newsletter-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .newsletter-form-side {
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        background: #FDF9F3;
    }

    .newsletter-form-side h2 {
        color: var(--spice-primary);
        font-family: var(--font-heading);
        font-weight: 900;
        font-size: 2.2rem;
        margin: 0 0 1rem 0;
        line-height: 1.1;
        text-transform: uppercase;
        letter-spacing: -0.5px;
    }
    
    .newsletter-form-side p {
        color: #555;
        font-size: 1.05rem;
        margin: 0 0 2rem 0;
        line-height: 1.5;
        font-weight: 500;
    }

    .newsletter-input {
        width: 100%;
        padding: 1rem 1.5rem;
        border: 2px solid #2B1D14;
        border-radius: 20px;
        font-family: var(--font-body);
        font-size: 1rem;
        margin-bottom: 1rem;
        background: white;
        text-align: center;
        outline: none;
        transition: border-color 0.3s;
    }
    .newsletter-input:focus {
        border-color: var(--spice-primary);
    }

    .newsletter-submit {
        width: 100%;
        padding: 1.1rem;
        background: #D32F2F; /* Matching reference image red */
        color: white;
        border: 2px solid #2B1D14;
        border-radius: 20px;
        font-family: var(--font-body);
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 4px 4px 0 #2B1D14;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .newsletter-submit:hover {
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0 #2B1D14;
        background: #B71C1C;
    }
    
    .newsletter-no-thanks {
        background: none;
        border: none;
        color: #777;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: underline;
        cursor: pointer;
        text-transform: uppercase;
        transition: color 0.2s;
        text-underline-offset: 4px;
    }
    .newsletter-no-thanks:hover {
        color: #2B1D14;
    }

    /* Responsive: Tablet (768px x 1024px) */
    @media (min-width: 577px) and (max-width: 991px) {
        .newsletter-modal-content {
            width: 700px;
            max-width: 92vw;
            max-height: 85vh;
            border-radius: 18px;
        }
        .newsletter-split {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
        }
        .newsletter-image {
            min-height: 420px;
            height: 100%;
        }
        .newsletter-form-side {
            padding: 2.75rem 2rem;
        }
        .newsletter-form-side h2 {
            font-size: 1.85rem;
        }
        .newsletter-form-side p {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        .newsletter-submit {
            font-size: 1.05rem;
            padding: 1rem;
        }
        .voucher-popup-container {
            bottom: 35px;
        }
    }

    /* Responsive: Mobile Phone (375px x 667px and below) */
    @media (max-width: 576px) {
        .newsletter-modal-overlay {
            padding: 10px;
        }
        .newsletter-modal-content {
            width: 100%;
            max-width: 355px;
            max-height: calc(100vh - 30px);
            border-radius: 16px;
            margin: auto;
        }
        .newsletter-split {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .newsletter-image {
            width: 100%;
            height: 115px;
            flex-shrink: 0;
        }
        .newsletter-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .newsletter-form-side {
            padding: 1.25rem 1.1rem 1rem;
        }
        .newsletter-form-side h2 {
            font-size: 1.35rem;
            margin: 0 0 0.35rem 0;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }
        .newsletter-form-side p {
            font-size: 0.82rem;
            margin: 0 0 0.85rem 0;
            line-height: 1.4;
            color: #666;
        }
        #voucher-feedback-msg {
            padding: 0.5rem 0.75rem;
            font-size: 0.82rem;
            margin-bottom: 0.75rem;
        }
        .newsletter-input {
            padding: 0.7rem 0.9rem;
            font-size: 0.9rem;
            margin-bottom: 0.65rem;
            border-radius: 12px;
        }
        .newsletter-submit {
            padding: 0.8rem 0.9rem;
            font-size: 0.92rem;
            margin-bottom: 0.65rem;
            border-radius: 12px;
            box-shadow: 3px 3px 0 #2B1D14;
        }
        .newsletter-no-thanks {
            font-size: 0.78rem;
        }
        .newsletter-close {
            top: 8px;
            right: 8px;
            width: 30px;
            height: 30px;
        }
        #voucher-success-box > div {
            padding: 0.85rem 0.75rem !important;
            margin-bottom: 0.75rem !important;
        }
        #voucher-success-box span {
            font-size: 0.75rem !important;
        }
        #generated-voucher-code {
            font-size: 1.35rem !important;
            margin-bottom: 0.5rem !important;
            letter-spacing: 1.5px !important;
        }
        #copy-voucher-btn {
            padding: 0.4rem 0.9rem !important;
            font-size: 0.78rem !important;
        }
        #voucher-success-box p {
            font-size: 0.8rem !important;
            margin-bottom: 0.75rem !important;
        }
        #voucher-success-box a.newsletter-submit {
            padding: 0.75rem 0.9rem !important;
            font-size: 0.85rem !important;
        }

        /* Hide floating side tab on mobile - accessed via Mobile Bottom Nav "Nhận 15%" button */
        .voucher-popup-container {
            display: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voucherPopup = document.getElementById('voucher-popup');
        const closeVoucherBtn = document.getElementById('close-voucher');
        const openModalBtn = document.getElementById('open-newsletter-modal');
        const modal = document.getElementById('newsletter-modal');
        const closeModalBtn = document.getElementById('close-newsletter');
        const noThanksBtn = document.getElementById('no-thanks-btn');

        if (voucherPopup) {
            // Check if user already closed/subscribed
            if (!sessionStorage.getItem('voucher_closed') && !sessionStorage.getItem('newsletter_subscribed')) {
                setTimeout(() => { voucherPopup.classList.add('show'); }, 2000);
            }

            // Click X on small voucher
            if (closeVoucherBtn) {
                closeVoucherBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    voucherPopup.classList.remove('show');
                    sessionStorage.setItem('voucher_closed', 'true');
                });
            }
            
            // Click the small voucher to open large modal
            if (openModalBtn) {
                openModalBtn.addEventListener('click', function(e) {
                    if (e.target.closest('#close-voucher')) return;
                    modal.classList.add('active');
                    voucherPopup.classList.remove('show'); // hide small voucher while modal is open
                });
            }
        }

        // Close large modal
        function closeNewsletterModal() {
            if(modal) modal.classList.remove('active');
            sessionStorage.setItem('voucher_closed', 'true');
        }

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeNewsletterModal);
        if (noThanksBtn) noThanksBtn.addEventListener('click', closeNewsletterModal);
        
        // Close on background overlay click
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeNewsletterModal();
            });
        }

        // Handle Claim Voucher Form Submission
        const newsletterForm = document.getElementById('newsletter-form');
        const newsletterEmail = document.getElementById('newsletter-email');
        const submitBtn = document.getElementById('newsletter-submit-btn');
        const successBox = document.getElementById('voucher-success-box');
        const generatedCodeEl = document.getElementById('generated-voucher-code');
        const copyBtn = document.getElementById('copy-voucher-btn');
        const feedbackMsg = document.getElementById('voucher-feedback-msg');

        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = newsletterEmail.value.trim();
                if (!email) return;

                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'SENDING...';
                feedbackMsg.style.display = 'none';

                fetch('/api/coupon/claim-voucher', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, data })))
                .then(response => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;

                    if (response.ok && response.data.success) {
                        newsletterForm.style.display = 'none';
                        successBox.style.display = 'block';
                        generatedCodeEl.textContent = response.data.code;
                        document.getElementById('voucher-delivery-message').textContent = response.data.mail_sent
                            ? 'Your promo code was sent to your email. Enter it in your cart or checkout.'
                            : 'We could not send the email. Please copy your promo code above.';
                        sessionStorage.setItem('newsletter_subscribed', 'true');
                    } else {
                        feedbackMsg.style.display = 'block';
                        feedbackMsg.style.backgroundColor = '#FFEBEE';
                        feedbackMsg.style.color = '#C62828';
                        const errMsg = response.data.message || (response.data.errors ? Object.values(response.data.errors)[0][0] : 'Could not process request.');
                        feedbackMsg.textContent = errMsg;
                    }
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    feedbackMsg.style.display = 'block';
                    feedbackMsg.style.backgroundColor = '#FFEBEE';
                    feedbackMsg.style.color = '#C62828';
                    feedbackMsg.textContent = 'Connection error. Please try again.';
                });
            });
        }

        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const code = generatedCodeEl.textContent;
                if (!code) return;
                navigator.clipboard.writeText(code).then(() => {
                    const prevText = copyBtn.textContent;
                    copyBtn.textContent = 'Copied! ✓';
                    copyBtn.style.backgroundColor = '#2E7D32';
                    setTimeout(() => {
                        copyBtn.textContent = prevText;
                        copyBtn.style.backgroundColor = '#2B1D14';
                    }, 2500);
                }).catch(() => {
                    copyBtn.textContent = 'Copied!';
                });
            });
        }
    });
</script>
