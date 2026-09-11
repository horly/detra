const header = document.querySelector('.corporate-header');
if (header) {
    const mobileButton = header.querySelector('[data-menu-toggle]');
    const mobilePanel = header.querySelector('#mobile-navigation');
    const servicesButton = header.querySelector('[data-services-toggle]');
    const servicesPanel = header.querySelector('#services-navigation');
    const backdrop = header.querySelector('[data-navigation-backdrop]');
    const desktop = matchMedia('(min-width: 1024px)');

    function updateBounds() {
        header.style.setProperty('--header-bottom', `${Math.max(0, header.getBoundingClientRect().bottom)}px`);
    }
    function syncBackdrop() {
        const open = !mobilePanel.hidden || !servicesPanel.hidden;
        backdrop.hidden = !open;
        header.classList.toggle('has-open-navigation', open);
        if (open) updateBounds();
    }
    function setPanel(button, panel, open) {
        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', open ? button.dataset.closeLabel : button.dataset.openLabel);
        panel.hidden = !open;
        syncBackdrop();
    }
    function closePanels() {
        setPanel(mobileButton, mobilePanel, false);
        setPanel(servicesButton, servicesPanel, false);
    }
    function togglePanel(button, panel) {
        const open = panel.hidden;
        closePanels();
        setPanel(button, panel, open);
        if (open) panel.querySelector('a')?.focus();
    }
    mobileButton.addEventListener('click', () => togglePanel(mobileButton, mobilePanel));
    servicesButton.addEventListener('click', () => togglePanel(servicesButton, servicesPanel));
    servicesButton.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            if (servicesPanel.hidden) togglePanel(servicesButton, servicesPanel);
            else servicesPanel.querySelector('a')?.focus();
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        const origin = !mobilePanel.hidden ? mobileButton : !servicesPanel.hidden ? servicesButton : null;
        if (origin) { closePanels(); origin.focus(); }
    });
    backdrop.addEventListener('click', closePanels);
    document.addEventListener('click', (event) => {
        if (!header.contains(event.target)) closePanels();
    });
    header.addEventListener('focusout', (event) => {
        if (!header.contains(event.relatedTarget)) closePanels();
    });
    desktop.addEventListener('change', () => {
        const focusWasInPanel = mobilePanel.contains(document.activeElement) || servicesPanel.contains(document.activeElement);
        closePanels();
        if (focusWasInPanel) header.querySelector('.header-brand').focus();
    });
    window.addEventListener('resize', updateBounds, { passive: true });
    window.addEventListener('scroll', () => {
        if (!backdrop.hidden) updateBounds();
    }, { passive: true });
    if ('ResizeObserver' in window) new ResizeObserver(updateBounds).observe(header);
    window.addEventListener('pageshow', closePanels);
}
