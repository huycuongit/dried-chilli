(() => {
    const cards = document.querySelectorAll('.nafu-services-page [data-service]');
    if (!cards.length) return;
    if (!matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } }), {threshold:.08});
        cards.forEach(card => { const image = card.querySelector('.service-image-block'); image.dataset.reveal = ''; observer.observe(image); });
    }
})();
