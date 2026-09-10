@php
    $tabs = [
        [
            'label' => 'Beranda',
            'route' => 'home',
            'active' => request()->routeIs('home'),
            'icon' => 'M3 11.5 12 4l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-8.5Z',
        ],
        [
            'label' => 'Solusi Kita',
            'route' => 'layanan.index',
            'active' => request()->routeIs('layanan.*'),
            'icon' => 'M4 7a2 2 0 0 1 2-2h3l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z',
        ],
        [
            'label' => 'Portofolio',
            'route' => 'portofolio.index',
            'active' => request()->routeIs('portofolio.*'),
            'icon' => 'M4 5h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Zm3-2h10l1 2H6l1-2Z',
        ],
        [
            'label' => 'Tentang',
            'route' => 'tentang',
            'active' => request()->routeIs('tentang'),
            'icon' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0',
        ],
        [
            'label' => 'Kontak',
            'route' => 'kontak',
            'active' => request()->routeIs('kontak'),
            'icon' => 'M4 6h16v12H4V6Zm0 0 8 7 8-7',
        ],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-30 flex h-[78px] border-t border-brand-border bg-white lg:hidden">
    @foreach ($tabs as $tab)
        <a
            href="{{ route($tab['route']) }}"
            class="flex flex-1 flex-col items-center justify-center gap-1 text-[11px] font-medium {{ $tab['active'] ? 'text-brand-normal' : 'text-brand-darker/50' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-[22px] w-[22px]">
                <path d="{{ $tab['icon'] }}" />
            </svg>
            {{ $tab['label'] }}
        </a>
    @endforeach
</nav>
