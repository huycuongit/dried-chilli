<footer class="jojo-footer">
    <div class="jojo-container">
        <div class="jojo-footer-top">
            <div class="jojo-footer-brand"><a href="{{ route('home') }}" aria-label="Jojo Little Kitchen home"><img src="{{ asset('images/jojo-logo-pdf.svg') }}" alt="Jojo Little Kitchen" width="84" height="84" loading="lazy"></a><p>Bringing bold flavour and a little Jojo joy to everyday cooking.</p></div>
            <nav aria-label="Footer shop links"><a href="{{ route('page.shop') }}">Shop</a><a href="{{ route('page.sale') }}">Sale</a><a href="{{ route('page.about') }}">About Us</a><a href="{{ route('home') }}#recipes">Recipes</a></nav>
            <nav aria-label="Footer company links"><a href="{{ route('page.legacy') }}">Our Legacy</a><a href="{{ route('contact.page') }}">Contact</a><a href="{{ route('page.faq') }}">FAQ</a><a href="{{ route('page.cart') }}">Cart</a></nav>
            <div class="jojo-footer-newsletter"><strong>Claim your 15% voucher</strong><form id="footer-newsletter-form" class="newsletter-form"><label class="jojo-sr-only" for="footer-newsletter-email">Email address for voucher</label><input type="email" id="footer-newsletter-email" placeholder="Email address" required><button type="submit" id="footer-newsletter-btn">Get code</button></form><p id="footer-newsletter-feedback" role="status" hidden></p></div>
        </div>
        <div class="jojo-footer-bottom"><span>© {{ date('Y') }} Jojo Little Kitchen. All rights reserved.</span><nav aria-label="Legal links"><a href="{{ route('page.terms') }}">Terms &amp; Conditions</a><a href="{{ route('page.privacy') }}">Privacy Policy</a><a href="{{ route('page.shipping') }}">Shipping &amp; Refunds</a></nav></div>
    </div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('footer-newsletter-form');
    if (!form) return;
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const email = document.getElementById('footer-newsletter-email');
        const button = document.getElementById('footer-newsletter-btn');
        const feedback = document.getElementById('footer-newsletter-feedback');
        button.disabled = true; feedback.hidden = false; feedback.textContent = 'Claiming voucher…';
        try {
            const response = await fetch('/api/coupon/claim-voucher', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }, body: JSON.stringify({ email: email.value.trim() }) });
            const data = await response.json();
            feedback.textContent = data.success
                ? 'Your 15% code: ' + data.code + (data.mail_sent ? ' (sent to your email)' : ' (email could not be sent; please copy this code)')
                : (data.message || 'Unable to claim a voucher. Please try again.');
            if (data.success) email.value = '';
        } catch (error) { feedback.textContent = 'Connection error. Please try again.'; }
        finally { button.disabled = false; }
    });
});
</script>
