@php
    $tabs = [
        ['label' => 'Beranda',    'route' => 'home',             'active' => request()->routeIs('home'),         'icon' => 'home'],
        ['label' => 'Solusi',     'route' => 'layanan.index',    'active' => request()->routeIs('layanan.*'),    'icon' => 'squares-2x2'],
        ['label' => 'Portofolio', 'route' => 'portofolio.index', 'active' => request()->routeIs('portofolio.*'), 'icon' => 'rectangle-stack'],
        ['label' => 'Tentang',    'route' => 'tentang',          'active' => request()->routeIs('tentang'),      'icon' => 'user-circle'],
        ['label' => 'Kontak',     'route' => 'kontak',           'active' => request()->routeIs('kontak'),       'icon' => 'envelope'],
    ];
@endphp

{{-- Bottom nav mobile — pill melayang, sembunyi saat scroll ke bawah, muncul lagi saat scroll ke atas --}}
<nav
    x-data="{
        hidden: false, last: 0,
        init() { window.addEventListener('scroll', () => this.onScroll(), { passive: true }); },
        onScroll() {
            const y = window.scrollY;
            this.hidden = y > this.last && y > 120;
            this.last = y;
        },
    }"
    :class="hidden ? 'translate-y-[calc(100%+24px)]' : 'translate-y-0'"
    class="bottom-nav fixed inset-x-4 bottom-4 z-30 transition-transform duration-500 ease-out-expo lg:hidden"
    aria-label="Navigasi utama"
>
    <div class="mx-auto flex h-[68px] max-w-md items-center justify-between rounded-full border border-white/70 bg-white/85 px-2 shadow-floating backdrop-blur-xl">
        @foreach ($tabs as $tab)
            <a
                href="{{ route($tab['route']) }}"
                @class([
                    'group relative flex h-14 flex-1 flex-col items-center justify-center gap-0.5 rounded-full text-[11px] font-medium transition-colors',
                    'text-brand-normal' => $tab['active'],
                    'text-brand-muted active:text-brand-dark' => ! $tab['active'],
                ])
                @if ($tab['active']) aria-current="page" @endif
            >
                @if ($tab['active'])
                    <span class="bottom-nav__glow bottom-nav__active absolute inset-x-2 inset-y-1 rounded-full bg-brand-light" aria-hidden="true"></span>
                @endif
                <span @class(['relative grid size-7 place-items-center transition-transform duration-300 ease-out-expo', '-translate-y-0.5' => $tab['active'], 'group-active:scale-90' => ! $tab['active']])>
                    @svg('heroicon-' . ($tab['active'] ? 's' : 'o') . '-' . $tab['icon'], 'size-[22px]')
                </span>
                <span class="relative leading-none">{{ $tab['label'] }}</span>
                @if ($tab['active'])
                    <span class="bottom-nav__dot absolute -bottom-0.5 size-1 rounded-full bg-brand-normal" aria-hidden="true"></span>
                @endif
            </a>
        @endforeach
    </div>
</nav>
