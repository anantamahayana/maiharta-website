@php
    $left = [
        ['label' => 'Beranda', 'route' => 'home',          'active' => request()->routeIs('home'),      'icon' => 'home'],
        ['label' => 'Solusi',  'route' => 'layanan.index', 'active' => request()->routeIs('layanan.*'), 'icon' => 'squares-2x2'],
    ];
    $right = [
        ['label' => 'Portofolio', 'route' => 'portofolio.index', 'active' => request()->routeIs('portofolio.*'), 'icon' => 'rectangle-stack'],
        ['label' => 'Blog',       'route' => 'blog.index',       'active' => request()->routeIs('blog.*'),       'icon' => 'newspaper'],
    ];
    $wa = preg_replace('/\D+/', '', (string) site('umum.brand.whatsapp'));
    $waHref = 'https://wa.me/' . $wa . '?text=' . rawurlencode('Halo MaiHarta, saya ingin berkonsultasi tentang kebutuhan digital saya.');
@endphp

{{-- Bottom nav mobile — pill melayang; tengahnya melengkung ke dalam (cekungan halus, bahu membulat)
     tempat tombol WhatsApp yang sedikit naik. Bentuk tengah = SVG agar kurvanya mulus. --}}
<nav class="bottom-nav fixed inset-x-4 bottom-4 z-30 lg:hidden" aria-label="Navigasi utama">
    <div class="bottom-nav__shape relative mx-auto flex h-[68px] max-w-md">
        <div class="bottom-nav__side flex flex-1 items-center rounded-l-full pl-2">
            @foreach ($left as $tab) @include('components.partials.bottom-nav-tab', ['tab' => $tab]) @endforeach
        </div>

        <svg class="bottom-nav__notch h-[68px] w-[112px] shrink-0" viewBox="0 0 112 68" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 0 H4 C14 0 17 3 20 9 C27 30 39 46 56 46 C73 46 85 30 92 9 C95 3 98 0 108 0 H112 V68 H0 Z" />
        </svg>

        <div class="bottom-nav__side flex flex-1 items-center rounded-r-full pr-2">
            @foreach ($right as $tab) @include('components.partials.bottom-nav-tab', ['tab' => $tab]) @endforeach
        </div>

        <a href="{{ $waHref }}" target="_blank" rel="noopener" class="bottom-nav__wa" aria-label="Chat via WhatsApp">
            <x-icons.social-whatsapp class="size-8" />
        </a>
    </div>
</nav>
