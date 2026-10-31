(function () {
    let container;
    window.showToast = function (message, type = 'error') {
        if (!container) {
            container = document.createElement('div');
            container.className = 'shop-toast-container';
            container.setAttribute('aria-live', 'polite');
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.className = 'shop-toast shop-toast--' + (type === 'success' ? 'success' : 'error');
        toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
        const text = document.createElement('span');
        text.textContent = message;
        const close = document.createElement('button');
        close.type = 'button';
        close.setAttribute('aria-label', 'Dismiss notification');
        close.textContent = '×';
        close.addEventListener('click', () => toast.remove());
        toast.append(text, close);
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 6000);
    };
})();
