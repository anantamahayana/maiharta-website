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
            <x-icons.social-whatsapp class="relative size-8" />
        </a>
        <div class="bottom-nav__pill flex h-[76px] items-center justify-between rounded-[28px] px-2">
            @foreach ($tabs as $tab)
                @if ($tab === null)
                    <span class="h-16 w-[76px] shrink-0" aria-hidden="true"></span>
                    @continue
                @endif
                <a
                    href="{{ route($tab['route']) }}"
                    title="{{ $tab['label'] }}"
                    @class([
                        'bottom-nav__tab group relative flex h-16 flex-1 flex-col items-center justify-center gap-0.5 rounded-2xl text-[11px] font-medium transition-colors',
                        'is-active text-brand-normal' => $tab['active'],
                        'text-brand-muted/70 active:text-brand-dark' => ! $tab['active'],
                    ])
                    @if ($tab['active']) aria-current="page" @endif
                >
                    <span @class(['grid size-7 place-items-center transition-transform duration-300 ease-out-expo', '-translate-y-0.5' => $tab['active'], 'group-active:scale-90' => ! $tab['active']])>
                        @svg('heroicon-o-' . $tab['icon'], 'size-[22px]')
                    </span>
                    <span class="leading-none">{{ $tab['label'] }}</span>
                    @if ($tab['active'])
                        <span class="bottom-nav__dot absolute bottom-0.5 left-1/2 size-1.5 -translate-x-1/2 rounded-full bg-brand-normal" aria-hidden="true"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</nav>
