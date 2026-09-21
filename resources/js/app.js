import './bootstrap';
import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Quill = Quill;

window.Alpine = Alpine;
// Navbar desktop: pill indikator meluncur ke link yang diklik, lalu navigasi.
// Halaman baru merender pill langsung di posisi link aktif (tanpa animasi), sehingga
// dikombinasikan dengan View Transitions terasa seperti satu aplikasi.
Alpine.data('slidingNav', () => ({
    moving: false,   // true saat pill JS mengambil alih highlight dari link aktif
    target: null,    // link tujuan (teksnya jadi biru saat pill tiba)
    ready: false,
    pillStyle: '',
    init() {
        window.addEventListener('pageshow', () => { this.moving = false; this.target = null; this.ready = false; });
    },
    rect(el) { return `transform:translateX(${el.offsetLeft}px);width:${el.offsetWidth}px`; },
    go(e, el) {
        const current = this.$root.querySelector('[data-nav-active]');
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0 || el === current) return;
        e.preventDefault();
        const href = el.href;
        if (matchMedia('(prefers-reduced-motion: reduce)').matches) { window.location.href = href; return; }
        // 1) letakkan pill tepat di atas highlight aktif & sembunyikan highlight statis (tanpa transisi),
        // 2) paksa reflow agar posisi awal ter-commit, 3) nyalakan transisi & geser ke tujuan,
        // 4) navigasi setelah animasi hampir selesai.
        const pill = this.$root.querySelector('.sliding-nav__pill');
        pill.classList.remove('is-ready');
        pill.style.cssText = current ? this.rect(current) : `${this.rect(el)};opacity:0`;
        this.$root.classList.add('is-moving');
        void pill.offsetWidth; // reflow
        pill.classList.add('is-ready');
        pill.style.cssText = this.rect(el);
        this.moving = true;
        this.ready = true;
        this.target = el;
        this.pillStyle = this.rect(el);
        setTimeout(() => (window.location.href = href), 340);
    },
}));

// Form artikel admin: editor Quill + unggah gambar + preview sampul
Alpine.data('articleForm', (opts) => ({
    body: opts.body,
    coverPreview: opts.cover,
    removeCover: false,
    uploading: false,
    quill: null,
    init() {
        this.quill = new Quill(this.$refs.editor, {
            theme: 'snow',
            placeholder: 'Tulis isi artikel di sini…',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'link', 'image'],
                        ['clean'],
                    ],
                    handlers: { image: () => this.pickImage() },
                },
            },
        });
        if (this.body) this.quill.clipboard.dangerouslyPasteHTML(this.body);
        this.quill.on('text-change', () => { this.body = this.quill.getSemanticHTML(); });
    },
    pickImage() {
        const input = document.createElement('input');
        input.type = 'file'; input.accept = 'image/*';
        input.onchange = async () => {
            const file = input.files[0]; if (!file) return;
            if (file.size > 2 * 1024 * 1024) { alert('Ukuran gambar maksimal 2 MB.'); return; }
            const fd = new FormData(); fd.append('image', file);
            this.uploading = true;
            try {
                const res = await fetch(opts.uploadUrl, { method: 'POST', body: fd, headers: { 'X-CSRF-TOKEN': opts.csrf, Accept: 'application/json' } });
                if (!res.ok) throw new Error();
                const { url } = await res.json();
                const range = this.quill.getSelection(true);
                this.quill.insertEmbed(range.index, 'image', url, 'user');
                this.quill.setSelection(range.index + 1);
            } catch (e) { alert('Gagal mengunggah gambar.'); }
            finally { this.uploading = false; }
        };
        input.click();
    },
    previewCover(e) { const f = e.target.files[0]; if (!f) return; this.removeCover = false; this.coverPreview = URL.createObjectURL(f); },
    slugify(v) { return v.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''); },
}));

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

// ---------------------------------------------------------------------------
// Validasi inline (laporan bug #3 & #5): form dengan atribut `novalidate` tidak lagi memakai
// tooltip bawaan browser ("Harap isi bidang ini"). Saat submit, field wajib/email/telepon
// diperiksa di sini dan pesan tampil di bawah field — gaya sama dengan error dari server.
// Validasi server tetap berjalan sebagai jaring pengaman.
const ICON = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3.5 w-3.5 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>';
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const PHONE_RE = /^\+?[0-9]{8,15}$/;

function fieldMessage(el) {
    const v = el.value.trim();
    if (el.required && !v) return el.dataset.msgRequired || 'Wajib diisi.';
    if (!v) return '';
    if (el.type === 'email' && !EMAIL_RE.test(v)) return el.dataset.msgEmail || 'Format email tidak valid (contoh: nama@domain.com).';
    if (el.type === 'tel' && !PHONE_RE.test(v.replace(/[\s().-]/g, ''))) return el.dataset.msgTel || 'Nomor telepon hanya boleh angka (8–15 digit).';
    if (el.minLength > 0 && v.length < el.minLength) return `Minimal ${el.minLength} karakter.`;
    if (el.dataset.match) {
        const other = el.form.querySelector(`[name="${el.dataset.match}"]`);
        if (other && other.value !== el.value) return el.dataset.msgMatch || 'Konfirmasi tidak cocok.';
    }
    return '';
}

function fieldWrap(el) {
    // komponen admin membungkus input dengan [data-field]; form publik memakai input langsung
    return el.closest('[data-field]') || el;
}

function showError(el, msg) {
    const wrap = fieldWrap(el);
    let p = wrap.nextElementSibling?.classList.contains('js-error') ? wrap.nextElementSibling : null;
    wrap.classList.toggle('is-invalid', !!msg);
    if (!msg) { p?.remove(); return; }
    if (!p) {
        p = document.createElement('p');
        p.className = 'js-error mt-1.5 flex items-center gap-1 text-caption text-error';
        wrap.insertAdjacentElement('afterend', p);
    }
    p.innerHTML = ICON + '<span></span>';
    p.lastChild.textContent = msg;
}

function validateForm(form) {
    let first = null;
    for (const el of form.querySelectorAll('input, textarea, select')) {
        if (el.disabled || ['hidden', 'checkbox', 'radio', 'file', 'submit'].includes(el.type) || el.closest('.hidden')) continue;
        const msg = fieldMessage(el);
        showError(el, msg);
        if (msg && !first) first = el;
    }
    if (first) {
        first.focus({ preventScroll: true });
        first.scrollIntoView({ block: 'center', behavior: 'smooth' });
    }
    return !first;
}

document.addEventListener('submit', (e) => {
    const form = e.target;
    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('novalidate')) return;
    if (!validateForm(form)) { e.preventDefault(); e.stopImmediatePropagation(); }
}, true);

// hapus pesan begitu pengguna memperbaiki isian
document.addEventListener('input', (e) => {
    const el = e.target;
    if (el.form?.hasAttribute('novalidate') && fieldWrap(el)?.classList.contains('is-invalid')) showError(el, fieldMessage(el));
});
