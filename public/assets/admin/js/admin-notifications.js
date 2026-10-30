(() => {
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '1100';
    container.setAttribute('aria-live', 'polite');
    document.body.appendChild(container);
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.tabIndex = -1;
    modal.setAttribute('aria-labelledby', 'admin-confirm-title');
    modal.setAttribute('aria-hidden', 'true');
    modal.innerHTML = '<div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="admin-confirm-title">Confirm action</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" data-confirm-accept>Confirm</button></div></div></div>';
    document.body.appendChild(modal);
    const dialog = new bootstrap.Modal(modal);
    let pending = null;
    modal.querySelector('[data-confirm-accept]').addEventListener('click', () => { if (pending) pending.accepted = true; dialog.hide(); });
    modal.addEventListener('hidden.bs.modal', () => { if (pending) { const current = pending; pending = null; current.resolve(current.accepted); } });
    window.AdminUI = {
        toast(message, type = 'info') {
            const colors = {success:'success', error:'danger', warning:'warning', info:'primary'};
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${colors[type] || 'primary'} border-0`;
            toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
            const row = document.createElement('div'); row.className = 'd-flex';
            const body = document.createElement('div'); body.className = 'toast-body'; body.textContent = String(message);
            const close = document.createElement('button'); close.type = 'button'; close.className = 'btn-close btn-close-white me-2 m-auto'; close.setAttribute('data-bs-dismiss', 'toast'); close.setAttribute('aria-label', 'Close');
            row.append(body, close); toast.append(row); container.append(toast);
            toast.addEventListener('hidden.bs.toast', () => toast.remove());
            bootstrap.Toast.getOrCreateInstance(toast, {delay: type === 'error' ? 9000 : 5000}).show();
        },
        confirm(message) {
            if (pending) return Promise.resolve(false);
            modal.querySelector('.modal-body').textContent = message;
            return new Promise(resolve => { pending = {resolve, accepted:false}; dialog.show(); });
        }
    };
    const approved = new WeakSet();
    document.addEventListener('submit', async event => {
        const form = event.target;
        const submitter = event.submitter;
        const message = submitter?.dataset.confirm || form.dataset.confirm;
        if (!message || approved.has(form)) return;
        event.preventDefault();
        if (await AdminUI.confirm(message)) {
            approved.add(form);
            try { form.requestSubmit(submitter || undefined); } finally { approved.delete(form); }
        }
    }, true);
    (window.adminNotifications || []).forEach(item => AdminUI.toast(item.message, item.type));
})();
