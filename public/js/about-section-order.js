(() => {
    const list = document.getElementById('about-section-sortable');
    if (!list) return;
    const status = document.getElementById('section-order-status');
    const items = () => [...list.querySelectorAll(':scope > details[data-section-name]')];
    let drag = null;
    function update(item) {
        const current = items();
        current.forEach((section, index) => {
            section.querySelector('.about-editor-number').textContent = index + 1;
            section.querySelector('[data-move="up"]').disabled = index === 0;
            section.querySelector('[data-move="down"]').disabled = index === current.length - 1;
        });
        if (item && status) status.textContent = item.dataset.sectionName + ' moved to position ' + (current.indexOf(item) + 1) + ' of ' + current.length + '.';
    }
    list.addEventListener('click', event => {
        const button = event.target.closest('.section-sort-controls button');
        if (!button) return;
        event.preventDefault();
        event.stopPropagation();
        const section = button.closest('details[data-section-name]');
        const current = items();
        const index = current.indexOf(section);
        if (button.dataset.move === 'up' && index > 0) current[index - 1].before(section);
        if (button.dataset.move === 'down' && index < current.length - 1) current[index + 1].after(section);
        update(section);
    });
    list.addEventListener('pointerdown', event => {
        const handle = event.target.closest('.section-sort-handle');
        if (!handle || (event.pointerType === 'mouse' && event.button !== 0)) return;
        event.preventDefault();
        event.stopPropagation();
        drag = { section: handle.closest('details[data-section-name]'), pointerId: event.pointerId, startY: event.clientY, moved: false };
        list.setPointerCapture(event.pointerId);
    });
    list.addEventListener('pointermove', event => {
        if (!drag || drag.pointerId !== event.pointerId) return;
        if (!drag.moved && Math.abs(event.clientY - drag.startY) < 5) return;
        drag.moved = true;
        drag.section.classList.add('is-dragging');
        const target = document.elementFromPoint(event.clientX, event.clientY)?.closest('details[data-section-name]');
        if (!target || target === drag.section || target.parentElement !== list) return;
        const box = target.getBoundingClientRect();
        if (event.clientY < box.top + box.height / 2) target.before(drag.section);
        else target.after(drag.section);
        update();
    });
    function finish(event) {
        if (!drag || drag.pointerId !== event.pointerId) return;
        const section = drag.section;
        section.classList.remove('is-dragging');
        if (list.hasPointerCapture(event.pointerId)) list.releasePointerCapture(event.pointerId);
        drag = null;
        update(section);
    }
    list.addEventListener('pointerup', finish);
    list.addEventListener('pointercancel', finish);
    update();
})();
