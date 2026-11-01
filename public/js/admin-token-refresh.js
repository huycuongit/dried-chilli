(function () {
    const script = document.currentScript;
    const endpoint = script.dataset.endpoint;
    const loginPage = script.dataset.login === '1';
    const csrf = script.dataset.csrf;
    let pending = null;
    let lastRefresh = Date.now();
    function refresh() {
        if (pending) return pending;
        pending = fetch(endpoint, { method: 'POST', credentials: 'same-origin', headers: {
            'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf
        }}).then(async function (response) {
            if (response.ok) lastRefresh = Date.now();
            if (response.ok && loginPage) {
                const data = await response.json();
                window.location.replace(data.redirect_url);
            } else if (!loginPage && response.status === 419) {
                window.location.reload();
            }
            return response.ok;
        }).catch(function () { return false; }).finally(function () { pending = null; });
        return pending;
    }
    if (loginPage) window.adminRefreshReady = refresh();
    else {
        setInterval(refresh, 10 * 60 * 1000);
        document.addEventListener('visibilitychange', function () { if (!document.hidden && Date.now() - lastRefresh >= 5 * 60 * 1000) refresh(); });
    }
})();
