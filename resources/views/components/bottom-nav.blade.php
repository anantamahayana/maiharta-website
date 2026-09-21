@php
    $tabs = [
        ['label' => 'Beranda',    'route' => 'home',             'active' => request()->routeIs('home'),         'icon' => 'home'],
        ['label' => 'Solusi',     'route' => 'layanan.index',    'active' => request()->routeIs('layanan.*'),    'icon' => 'squares-2x2'],
        null, // slot tombol WhatsApp di tengah
        ['label' => 'Portofolio', 'route' => 'portofolio.index', 'active' => request()->routeIs('portofolio.*'), 'icon' => 'rectangle-stack'],
        ['label' => 'Blog',       'route' => 'blog.index',       'active' => request()->routeIs('blog.*'),       'icon' => 'newspaper'],
    ];
    $wa = preg_replace('/\D+/', '', (string) site('umum.brand.whatsapp'));
    $waHref = 'https://wa.me/' . $wa . '?text=' . rawurlencode('Halo MaiHarta, saya ingin berkonsultasi tentang kebutuhan digital saya.');
@endphp

{{-- Bottom nav mobile — pill melayang, selalu tampil (sticky), tombol WhatsApp menonjol di tengah --}}
<nav class="bottom-nav fixed inset-x-4 bottom-4 z-30 lg:hidden" aria-label="Navigasi utama">
    <div class="relative mx-auto max-w-md">
        {{-- Tombol WhatsApp tengah: duduk di lekukan (notch) pill sehingga menyatu dengan bar --}}
        <a href="{{ $waHref }}" target="_blank" rel="noopener" class="bottom-nav__wa" aria-label="Chat via WhatsApp">
            <span class="bottom-nav__wa-ring" aria-hidden="true"></span>
            <x-icons.social-whatsapp class="relative size-7" />
        </a>
        <div class="bottom-nav__pill flex h-[68px] items-center justify-between rounded-full px-2">
            @foreach ($tabs as $tab)
                @if ($tab === null)
                    <span class="h-14 w-[72px] shrink-0" aria-hidden="true"></span>
                    @continue
                @endif
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
    </div>
</nav>
