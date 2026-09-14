@props(['message' => 'Halo MaiHarta, saya ingin berkonsultasi tentang kebutuhan digital saya.'])

@php
    $number = preg_replace('/\D+/', '', (string) site('umum.brand.whatsapp'));
    $href = 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
@endphp

@if ($number)
{{-- Floating WhatsApp — Float → WhatsApp FAB (pojok kanan bawah) --}}
<div
    x-data="{
        shown: false,
        bubble: false,
        dismissed: false,
        init() {
            try { this.dismissed = sessionStorage.getItem('wa-bubble') === '1'; } catch (e) {}
            setTimeout(() => this.shown = true, 900);
            if (!this.dismissed) setTimeout(() => this.bubble = true, 3800);
        },
        close() {
            this.bubble = false; this.dismissed = true;
            try { sessionStorage.setItem('wa-bubble', '1'); } catch (e) {}
        },
    }"
    x-cloak
    x-show="shown"
    class="fab-wa fixed right-4 bottom-24 z-40 flex flex-col items-end gap-3 md:right-6 lg:bottom-6"
>
    {{-- Bubble ajakan --}}
    <div
        x-show="bubble"
        x-transition:enter="transition duration-500 ease-out-expo"
        x-transition:enter-start="translate-y-3 scale-95 opacity-0"
        x-transition:enter-end="translate-y-0 scale-100 opacity-100"
        x-transition:leave="transition duration-200"
        x-transition:leave-end="translate-y-2 opacity-0"
        class="relative w-[240px] origin-bottom-right rounded-card border border-brand-border bg-white p-4 pr-9 shadow-floating"
        role="status"
    >
        <button type="button" @click="close()" class="absolute top-2 right-2 grid size-6 place-items-center rounded-full text-brand-muted transition hover:bg-brand-light hover:text-brand-dark" aria-label="Tutup">
            <x-heroicon-o-x-mark class="size-3.5" />
        </button>
        <div class="flex items-start gap-3">
            <span class="relative mt-0.5 grid size-9 shrink-0 place-items-center rounded-full bg-brand-light text-brand-normal">
                <x-heroicon-o-chat-bubble-left-right class="size-4.5" />
                <span class="absolute -right-0.5 -bottom-0.5 size-2.5 rounded-full border-2 border-white bg-success"></span>
            </span>
            <div>
                <p class="text-label font-semibold text-brand-dark">Tim MaiHarta</p>
                <p class="mt-0.5 text-body-sm leading-snug text-brand-muted">Halo! Ada yang bisa kami bantu? Balasan cepat di jam kerja.</p>
            </div>
        </div>
        <span class="absolute -bottom-1.5 right-6 size-3 rotate-45 border-r border-b border-brand-border bg-white"></span>
    </div>

    {{-- Tombol --}}
    <a
        href="{{ $href }}"
        target="_blank"
        rel="noopener"
        @click="close()"
        class="fab-wa__btn group relative flex h-14 items-center gap-0 rounded-full bg-[#25d366] pl-0 text-white shadow-floating transition-[padding,box-shadow,transform] duration-300 ease-out-expo hover:pr-5 hover:shadow-hero focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#25d366]/40 active:scale-95"
        aria-label="Chat via WhatsApp"
    >
        <span class="fab-wa__ring" aria-hidden="true"></span>
        <span class="fab-wa__ring fab-wa__ring--late" aria-hidden="true"></span>
        <span class="relative grid size-14 shrink-0 place-items-center">
            <x-icons.social-whatsapp class="fab-wa__icon size-7" />
            <span class="absolute top-3 right-3 size-2.5 rounded-full border-2 border-[#25d366] bg-white"></span>
        </span>
        <span class="max-w-0 overflow-hidden text-label font-semibold whitespace-nowrap opacity-0 transition-[max-width,opacity] duration-300 ease-out-expo group-hover:max-w-[160px] group-hover:opacity-100">
            Chat via WhatsApp
        </span>
    </a>
</div>
@endif
