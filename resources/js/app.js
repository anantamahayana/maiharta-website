import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Scroll-reveal: fades/slides [data-animate] elements into view once, the
// first time they cross into the viewport. Elements inside a
// [data-animate-group] are staggered automatically (--reveal-delay is
// computed from their index unless set explicitly).
function initScrollReveal() {
    const targets = document.querySelectorAll('[data-animate]');
    if (!targets.length) return;

    document.querySelectorAll('[data-animate-group]').forEach((group) => {
        const step = parseFloat(group.dataset.animateGroup) || 0.08;
        group.querySelectorAll(':scope [data-animate]').forEach((el, i) => {
            if (!el.style.getPropertyValue('--reveal-delay')) {
                el.style.setProperty('--reveal-delay', `${(i * step).toFixed(2)}s`);
            }
        });
    });

    if (!('IntersectionObserver' in window) || reducedMotion) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach((el) => observer.observe(el));
}

// Count-up numbers: <span data-count="199" data-suffix="+">0</span>
function initCounters() {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    const run = (el) => {
        const target = parseFloat(el.dataset.count);
        const suffix = el.dataset.suffix ?? '';
        const duration = parseInt(el.dataset.duration ?? '1200', 10);
        if (reducedMotion || Number.isNaN(target)) {
            el.textContent = `${target}${suffix}`;
            return;
        }
        const start = performance.now();
        const tick = (now) => {
            const t = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - t, 4); // ease-out-quart
            el.textContent = `${Math.round(target * eased)}${suffix}`;
            if (t < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    if (!('IntersectionObserver' in window)) {
        counters.forEach(run);
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    run(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.5 }
    );

    counters.forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initCounters();
});
