const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-slide]')];
    const selectors = [...carousel.querySelectorAll('[data-slide-to]')];
    const playButton = carousel.querySelector('[data-slide-play]');
    const status = carousel.querySelector('[data-slide-status]');
    let current = 0;
    let playing = !reducedMotion.matches;
    let hovered = false;
    let focused = false;
    let inView = true;
    let timer;

    function schedule() {
        clearTimeout(timer);
        playButton.hidden = reducedMotion.matches;
        playButton.classList.toggle('is-paused', !playing);
        playButton.setAttribute('aria-label', playing ? playButton.dataset.pauseLabel : playButton.dataset.playLabel);
        if (playing && !hovered && !focused && inView && !document.hidden && !reducedMotion.matches) {
            timer = setTimeout(() => show(current + 1), 7000);
        }
    }

    function show(index, manual = false) {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === current);
            slide.setAttribute('aria-hidden', String(i !== current));
            selectors[i].setAttribute('aria-pressed', String(i === current));
        });
        carousel.querySelector('[data-slide-count]').textContent = String(current + 1).padStart(2, '0');
        if (manual) {
            playing = false;
            status.textContent = `${current + 1} / ${slides.length} — ${slides[current].dataset.title}`;
        }
        schedule();
    }

    carousel.querySelector('[data-carousel-controls]').hidden = false;
    selectors.forEach((button, i) => button.addEventListener('click', () => show(i, true)));
    carousel.querySelector('[data-slide-previous]').addEventListener('click', () => show(current - 1, true));
    carousel.querySelector('[data-slide-next]').addEventListener('click', () => show(current + 1, true));
    playButton.addEventListener('click', () => {
        playing = !playing;
        schedule();
    });
    carousel.addEventListener('mouseenter', () => { hovered = true; schedule(); });
    carousel.addEventListener('mouseleave', () => { hovered = false; schedule(); });
    carousel.addEventListener('focusin', () => { focused = true; schedule(); });
    carousel.addEventListener('focusout', (event) => { focused = carousel.contains(event.relatedTarget); schedule(); });
    document.addEventListener('visibilitychange', schedule);
    reducedMotion.addEventListener('change', () => {
        if (reducedMotion.matches) playing = false;
        schedule();
    });
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(([entry]) => { inView = entry.isIntersecting; schedule(); }).observe(carousel);
    }
    schedule();
});

document.querySelectorAll('[data-gallery]').forEach((gallery) => {
    const items = [...gallery.querySelectorAll('[data-gallery-item]')];
    const dialog = gallery.querySelector('dialog');
    const picture = dialog.querySelector('.lightbox-image');
    let current = 0;
    let opener;
    if (typeof dialog.showModal !== 'function') return;

    function show(index) {
        current = (index + items.length) % items.length;
        const item = items[current];
        picture.src = item.href;
        picture.alt = item.querySelector('img').alt;
        dialog.querySelector('#lightbox-title').textContent = item.dataset.title;
        dialog.querySelector('[data-gallery-count]').textContent = `${current + 1} / ${items.length}`;
    }

    items.forEach((item, i) => item.addEventListener('click', (event) => {
        if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        opener = item;
        show(i);
        dialog.showModal();
        document.documentElement.classList.add('lightbox-open');
    }));
    dialog.querySelector('[data-gallery-close]').addEventListener('click', () => dialog.close());
    dialog.querySelector('[data-gallery-previous]').addEventListener('click', () => show(current - 1));
    dialog.querySelector('[data-gallery-next]').addEventListener('click', () => show(current + 1));
    dialog.addEventListener('click', (event) => {
        const bounds = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) dialog.close();
    });
    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            event.preventDefault();
            show(current + (event.key === 'ArrowRight' ? 1 : -1));
        }
    });
    dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('lightbox-open');
        opener?.focus({ preventScroll: true });
    });
});

const quickContact = document.querySelector('[data-quick-contact]');
if (quickContact) {
    const toggle = quickContact.querySelector('button');
    const links = quickContact.querySelector('#quick-contact-links');
    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? toggle.dataset.closeLabel : toggle.dataset.openLabel);
        links.hidden = !open;
    };
    quickContact.hidden = false;
    toggle.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') !== 'true';
        setOpen(open);
        if (open) links.querySelector('a')?.focus();
    });
    document.addEventListener('click', (event) => {
        if (!quickContact.contains(event.target)) setOpen(false);
    });
    quickContact.addEventListener('focusout', (event) => {
        if (!quickContact.contains(event.relatedTarget)) setOpen(false);
    });
    quickContact.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') { setOpen(false); toggle.focus(); }
    });
}

document.querySelectorAll('[data-copy-address]').forEach((button) => {
    button.hidden = false;
    button.addEventListener('click', async () => {
        const status = button.parentElement.querySelector('[data-copy-status]');
        try {
            await navigator.clipboard.writeText(button.dataset.copyAddress);
            status.textContent = button.dataset.success;
        } catch {
            status.textContent = button.dataset.failure;
        }
    });
});
