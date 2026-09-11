import './experience';
import './navigation';

const motionPreference = matchMedia('(prefers-reduced-motion: reduce)');
const desktopViewport = matchMedia('(min-width: 1024px)');
const siteHeader = document.querySelector('.site-header');
const hero = document.querySelector('.hero');
const heroImage = hero?.querySelector('.hero-image');
let scrollFrame = null;
let heroHeight = hero?.offsetHeight ?? 0;

function updateScrollEffects() {
    scrollFrame = null;
    const position = window.scrollY;
    const scrollable = document.documentElement.scrollHeight - window.innerHeight;
    siteHeader?.classList.toggle('is-scrolled', position > 12);
    siteHeader?.style.setProperty('--scroll-progress', String(scrollable > 0 ? Math.min(1, Math.max(0, position / scrollable)) : 0));

    if (heroImage) {
        const offset = !motionPreference.matches && desktopViewport.matches ? Math.min(position, heroHeight) * 0.1 : 0;
        hero.style.setProperty('--hero-offset', `${offset.toFixed(1)}px`);
    }
}

function scheduleScrollEffects() {
    if (scrollFrame === null) scrollFrame = requestAnimationFrame(updateScrollEffects);
}

window.addEventListener('scroll', scheduleScrollEffects, { passive: true });
window.addEventListener('resize', () => {
    heroHeight = hero?.offsetHeight ?? 0;
    scheduleScrollEffects();
}, { passive: true });
window.addEventListener('load', scheduleScrollEffects);
updateScrollEffects();

const revealTargets = document.querySelectorAll([
    '[data-reveal]', '.section-heading', '.service-card', '.about-visual',
    '.about-section .site-container > div:last-child', '.product-preview-card',
    '.commitment-banner .site-container > *', '.cta-section .site-container > *',
    '.page-heading h1', '.page-intro', '.mission-block', '.value-card',
    '.service-detail > div', '.process-step', '.product-card', '.commitment-card',
    '.custom-product', '.privacy-section',
].join(', '));
let revealObserver;

if (!motionPreference.matches && 'IntersectionObserver' in window) {
    revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(({ isIntersecting, target }) => {
            if (!isIntersecting) return;
            target.classList.add('is-visible');
            revealObserver.unobserve(target);
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -24px 0px' });

    revealTargets.forEach((target) => {
        const siblings = [...target.parentElement.children].filter(element => element.matches('.service-card, .product-preview-card, .value-card, .process-step, .product-card, .commitment-card'));
        const order = Math.max(0, siblings.indexOf(target));
        target.style.setProperty('--reveal-delay', `${Math.min(order, 3) * 90}ms`);
        target.classList.add('motion-reveal');
        if (target.querySelector('[data-form-status]') || target.contains(document.activeElement)) {
            target.classList.add('is-visible');
        } else {
            revealObserver.observe(target);
        }
    });
}

// Keyboard navigation must never land inside a visually hidden section.
document.addEventListener('focusin', (event) => {
    let target = event.target.closest('.motion-reveal');
    while (target) {
        target.classList.add('is-visible');
        target.style.setProperty('--reveal-delay', '0ms');
        revealObserver?.unobserve(target);
        target = target.parentElement?.closest('.motion-reveal');
    }
});

motionPreference.addEventListener('change', () => {
    if (motionPreference.matches) {
        revealObserver?.disconnect();
        revealTargets.forEach(target => target.classList.add('is-visible'));
    }
    scheduleScrollEffects();
});

const catalog = document.querySelector('[data-product-catalog]');
if (catalog) {
    const filters = catalog.querySelectorAll('[data-product-filter]');
    const products = catalog.querySelectorAll('[data-product-category]');
    const count = catalog.querySelector('[data-product-count]');
    filters.forEach((filter) => filter.addEventListener('click', () => {
        const category = filter.dataset.productFilter;
        let visible = 0;
        filters.forEach((button) => button.setAttribute('aria-pressed', String(button === filter)));
        products.forEach((product) => {
            product.hidden = category !== 'all' && product.dataset.productCategory !== category;
            if (!product.hidden) {
                if (!motionPreference.matches) {
                    product.animate([
                        { opacity: 0, transform: 'translateY(12px)' },
                        { opacity: 1, transform: 'translateY(0)' },
                    ], { duration: 350, delay: visible * 60, easing: 'ease-out' });
                }
                visible++;
            }
        });
        count.textContent = count.dataset.countLabel.replace('{count}', visible);
    }));
}

const inquiryForm = document.querySelector('[data-inquiry-form]');
const messageField = inquiryForm?.querySelector('#message');
const messageCount = inquiryForm?.querySelector('[data-message-count]');
if (messageField && messageCount) {
    const formatter = new Intl.NumberFormat(document.documentElement.lang);
    const updateMessageCount = () => {
        messageCount.textContent = `${formatter.format(messageField.value.length)} / ${formatter.format(messageField.maxLength)}`;
    };
    messageCount.hidden = false;
    messageField.addEventListener('input', updateMessageCount);
    window.addEventListener('pageshow', updateMessageCount);
    updateMessageCount();
}
inquiryForm?.addEventListener('submit', () => {
    const button = inquiryForm.querySelector('button[type="submit"]');
    button.disabled = true;
    button.querySelector('span').textContent = button.dataset.sendingLabel;
});
window.addEventListener('pageshow', () => {
    const button = inquiryForm?.querySelector('button[type="submit"]');
    if (button) {
        button.disabled = false;
        button.querySelector('span').textContent = button.dataset.submitLabel;
    }
});
const formStatus = document.querySelector('[data-form-status]');
if (formStatus) {
    // Wait for the redirect's fragment navigation before focusing its feedback.
    const focusFeedback = () => requestAnimationFrame(() => formStatus.focus());
    window.addEventListener('pageshow', focusFeedback);
    if (document.readyState === 'complete') focusFeedback();
}
