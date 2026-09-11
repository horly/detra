<div id="page-loader" role="status" aria-live="polite" hidden>
    <div class="loader-content"><x-logo /><div class="loader-track" aria-hidden="true"><span></span></div><p>{{ __('navigation.loading') }}</p></div>
</div>
<script>
    (() => {
        const loader = document.getElementById('page-loader');
        const started = performance.now();
        const minimum = matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 420;
        let finishTimer;
        let removalTimer;
        let watchdog;
        let dismissed = false;

        function hide() {
            dismissed = true;
            clearTimeout(finishTimer);
            clearTimeout(removalTimer);
            clearTimeout(watchdog);
            loader.hidden = true;
        }

        function finish(immediate = false) {
            if (dismissed) return;
            clearTimeout(finishTimer);
            finishTimer = setTimeout(() => {
                dismissed = true;
                clearTimeout(watchdog);
                loader.classList.add('is-leaving');
                removalTimer = setTimeout(hide, 260);
            }, immediate ? 0 : Math.max(0, minimum - (performance.now() - started)));
        }

        loader.hidden = false;
        // Keep this independent of the application bundle and slow external assets.
        watchdog = setTimeout(() => finish(true), 4500);
        window.addEventListener('load', () => finish(), { once: true });
        window.addEventListener('pagehide', hide);
        window.addEventListener('pageshow', (event) => { if (event.persisted) hide(); });
        loader.addEventListener('pointerdown', hide);
        document.addEventListener('keydown', (event) => {
            if (!loader.hidden && (event.key === 'Tab' || event.key === 'Escape')) hide();
        });
        if (document.readyState === 'complete') finish();
    })();
</script>
