(() => {
    const content = document.querySelector('.nafu-home-content');
    if (!content) return;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const blocks = [...content.querySelectorAll('.service-1-block')];
    let initialized = false;
    const setService = (active) => blocks.forEach((block, index) => {
        const opened = index === active;
        const title = block.querySelector('.service-1-title-block');
        const wasOpen = title.getAttribute('aria-expanded') === 'true';
        block.classList.toggle('service-1-active', opened);
        title.setAttribute('aria-expanded', String(opened));
        const panel = block.querySelector('.service-1-content');
        panel.getAnimations().forEach((animation) => animation.cancel());
        panel.style.height = 'auto';
        if (!initialized || reducedMotion.matches || wasOpen === opened) { panel.hidden = !opened; return; }
        panel.hidden = false;
        const fullHeight = `${panel.scrollHeight}px`;
        const animation = panel.animate(opened ? [{ height: '0px', opacity: 0 }, { height: fullHeight, opacity: 1 }] : [{ height: fullHeight, opacity: 1 }, { height: '0px', opacity: 0 }], { duration: 380, easing: 'cubic-bezier(.22,1,.36,1)' });
        animation.onfinish = () => { panel.hidden = !opened; };
    });
    blocks.forEach((block, index) => {
        const title = block.querySelector('.service-1-title-block');
        const panel = block.querySelector('.service-1-content');
        panel.id = `nafu-service-panel-${index}`;
        title.setAttribute('role', 'button');
        title.setAttribute('tabindex', '0');
        title.setAttribute('aria-controls', panel.id);
        const toggle = () => setService(title.getAttribute('aria-expanded') === 'true' ? -1 : index);
        title.addEventListener('click', toggle);
        title.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); toggle(); }
        });
    });
    setService(0);
    initialized = true;
    if (!reducedMotion.matches && 'IntersectionObserver' in window) {
        const targets = content.querySelectorAll('.about-1-grid > div, .project-1-link-block, .cta-1-section .container, .pricing-content-block, .pricing-wrap, .blog-1-item-block');
        const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
            if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
        }), { threshold: .1 });
        targets.forEach((target) => { target.dataset.nafuReveal = ''; observer.observe(target); });
        content.classList.add('nafu-reveal-ready');
        reducedMotion.addEventListener('change', () => {
            if (reducedMotion.matches) { content.classList.remove('nafu-reveal-ready'); observer.disconnect(); }
        });
    }
    content.querySelectorAll('.nafu-newsletter-form').forEach((newsletter) => {
        newsletter.addEventListener('submit', (event) => {
            event.preventDefault();
            if (!newsletter.reportValidity()) return;
            document.querySelector('.site-header .talk-button.js-open-contact')?.click();
            const email = document.querySelector('#contact-email');
            if (email) email.value = newsletter.querySelector('input[type=email]').value.trim();
            const message = document.querySelector('#contact-message');
            if (message) message.value = 'I would like to receive Nafu Home Care updates and offers.';
            const type = document.querySelector('#contact-project-type');
            if (type) type.value = 'other';
        });
    });
    const dialog = document.createElement('dialog');
    dialog.className = 'nafu-detail-dialog';
    dialog.setAttribute('aria-labelledby', 'nafu-detail-title');
    const close = document.createElement('button');
    close.type = 'button'; close.className = 'nafu-detail-close'; close.textContent = '×'; close.setAttribute('aria-label', 'Close details');
    const body = document.createElement('div');
    dialog.append(close, body); document.body.append(dialog);
    close.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => { if (event.target === dialog) { const r = dialog.getBoundingClientRect(); if (event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom) dialog.close(); } });
    content.querySelectorAll('.project-1-link-block').forEach((card) => {
        card.querySelectorAll('a').forEach((link) => link.addEventListener('click', (event) => {
            event.preventDefault(); body.replaceChildren();
            const photo = card.querySelector('.project-1-image, .blog-1-image');
            if (photo) body.append(photo.cloneNode());
            const heading = document.createElement('h2'); heading.id = 'nafu-detail-title'; heading.textContent = card.querySelector('h3').textContent; body.append(heading);
            const description = document.createElement('p'); description.textContent = card.querySelector('p')?.textContent || 'Explore ideas for a better home with Nafu Home Care. Speak with our team about the scope, materials and care your home needs.'; body.append(description);
            const list = card.querySelector('ul'); if (list) body.append(list.cloneNode(true));
            const action = document.createElement('button'); action.className = 'btn-block dark-btn'; action.textContent = 'REQUEST A QUOTE'; action.type = 'button';
            action.addEventListener('click', () => { dialog.close(); document.querySelector('.site-header .talk-button.js-open-contact')?.click(); const type = document.querySelector('#contact-project-type'); if (type && card.dataset.serviceSlug) type.value = card.dataset.serviceSlug; }); body.append(action);
            dialog.showModal();
        }));
    });
})();
