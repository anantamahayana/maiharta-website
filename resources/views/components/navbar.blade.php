@php
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Solusi Kita', 'route' => 'layanan.index', 'active' => request()->routeIs('layanan.*')],
        ['label' => 'Portofolio', 'route' => 'portofolio.index', 'active' => request()->routeIs('portofolio.*')],
        ['label' => 'Sertifikasi', 'route' => 'sertifikasi', 'active' => request()->routeIs('sertifikasi')],
        ['label' => 'Tentang', 'route' => 'tentang', 'active' => request()->routeIs('tentang')],
    ];
@endphp

<header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 8, { passive: true })"
    :class="scrolled ? 'shadow-sm shadow-brand-darker/5' : ''"
    class="sticky top-0 z-30 border-b border-brand-border bg-white transition-shadow duration-300"
>
    <div class="mx-auto flex h-[84px] max-w-[1440px] items-center justify-between px-5 md:px-20">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logo-maiharta.png') }}" alt="MaiHarta" class="h-10 w-auto">
        </a>

        <nav class="hidden items-center gap-6 lg:flex">
            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="group relative py-1 text-sm font-medium transition-colors {{ $link['active'] ? 'text-brand-normal' : 'text-brand-darker/80 hover:text-brand-normal' }}"
                >
                    {{ $link['label'] }}
                    <span class="absolute inset-x-0 -bottom-0.5 h-px bg-brand-normal transition-transform duration-300 {{ $link['active'] ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                </a>
            @endforeach
        </nav>

        <a
            href="{{ route('kontak') }}"
            class="hidden items-center rounded-lg bg-brand-normal px-6 py-3 text-sm font-semibold text-white transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-normal-hover hover:shadow-md hover:shadow-brand-normal/30 active:translate-y-0 lg:inline-flex"
        >
            Kontak Kami
        </a>
    </div>
</header>
