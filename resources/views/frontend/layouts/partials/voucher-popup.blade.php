<!-- The Small Floating Voucher -->
<div id="voucher-popup" class="voucher-popup-container">
    <div class="voucher-popup-content" id="open-newsletter-modal">
        <button id="close-voucher" class="voucher-close-btn" aria-label="Close voucher">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="voucher-text">Get 10% Off</div>
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
                <img src="{{ asset('images/story_spices.jpg') }}" alt="Dried Chilli Spices">
            </div>
            <div class="newsletter-form-side">
                <h2>GET 15% OFF EVERYTHING</h2>
                <p>Sitewide until Mon 5 Oct. Sign up for recipes and first dibs on deals.</p>
                <form id="newsletter-form" onsubmit="event.preventDefault(); alert('Subscribed!'); document.getElementById('close-newsletter').click();">
                    <input type="email" placeholder="Email" required class="newsletter-input">
                    <button type="submit" class="newsletter-submit">SIGN ME UP!</button>
                </form>
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
        font-family: 'Outfit', sans-serif;
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
        background: rgba(43, 29, 20, 0.6);
        backdrop-filter: blur(5px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
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
        border-radius: 20px;
        overflow: hidden;
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
        font-family: 'Outfit', sans-serif;
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

    @media (max-width: 768px) {
        .newsletter-split { grid-template-columns: 1fr; }
        .newsletter-image { height: 250px; }
        .newsletter-form-side { padding: 2.5rem 1.5rem; }
        .newsletter-form-side h2 { font-size: 1.8rem; }
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
    });
</script>
