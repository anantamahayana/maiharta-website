@php
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Solusi Kita', 'route' => 'layanan.index', 'active' => request()->routeIs('layanan.*')],
        ['label' => 'Portofolio', 'route' => 'portofolio.index', 'active' => request()->routeIs('portofolio.*')],
        ['label' => 'Sertifikasi', 'route' => 'sertifikasi', 'active' => request()->routeIs('sertifikasi')],
        ['label' => 'Tentang', 'route' => 'tentang', 'active' => request()->routeIs('tentang')],
    ];
@endphp

{{-- Navbar — pill melayang; mengecil & lebih pekat setelah scroll --}}
<header
    x-data="{ scrolled: false }"
    x-init="scrolled = window.scrollY > 8; window.addEventListener('scroll', () => scrolled = window.scrollY > 8, { passive: true })"
    class="navbar fixed inset-x-4 top-4 z-30 md:inset-x-6 md:top-5"
>
    <div
        :class="scrolled && 'is-scrolled'"
        class="navbar__pill mx-auto flex max-w-[1320px] bg-white/75 shadow-card items-center justify-between rounded-full border border-white/70 pr-2 pl-5 backdrop-blur-xl transition-[height,background-color,box-shadow] duration-500 ease-out-expo md:pr-2.5 md:pl-7"
    >
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset(site('umum.brand.logo')) }}" alt="MaiHarta" class="navbar__logo w-auto transition-[height] duration-500 ease-out-expo">
        </a>

        <nav class="hidden items-center gap-1 rounded-full bg-brand-light/60 p-1 lg:flex" aria-label="Navigasi utama">
            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'relative rounded-full px-4 py-2 text-sm font-medium transition-all duration-300',
                        'navbar__active bg-white text-brand-normal shadow-card' => $link['active'],
                        'text-brand-dark/75 hover:bg-white/70 hover:text-brand-normal' => ! $link['active'],
                    ])
                    @if ($link['active']) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <a
                href="{{ route('kontak') }}"
                class="hidden items-center gap-2 rounded-full bg-brand-normal py-3 pr-5 pl-6 text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-normal-hover hover:shadow-lg hover:shadow-brand-normal/30 active:translate-y-0 lg:inline-flex"
            >
                Kontak Kami
                <x-heroicon-o-arrow-right class="size-4" />
            </a>
            <a
                href="{{ route('kontak') }}"
                class="grid size-11 place-items-center rounded-full bg-brand-normal text-white shadow-card transition active:scale-95 lg:hidden"
                aria-label="Kontak Kami"
            >
                <x-heroicon-o-chat-bubble-left-right class="size-5" />
            </a>
        </div>
    </div>
</header>

{{-- Ruang untuk navbar melayang --}}
<div class="h-[96px] bg-brand-light lg:h-[112px]" aria-hidden="true"></div>
