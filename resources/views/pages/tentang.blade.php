@php
    $valueIcons = ['check', 'value-collab', 'value-result'];
    $values = collect(site('tentang.nilai.items', []))->filter(fn ($v) => filled($v['title'] ?? null))->take(3)->values()
        ->map(fn ($v, $k) => [$valueIcons[$k % 3], $v['title'], $v['description'] ?? ''])->all();
    $cerita = site('tentang.cerita');
    $partners = site('tentang.partner.partners', []);
    $clients = site('tentang.partner.clients', []);
@endphp

<x-layout title="Tentang — MaiHarta" description="Maiharta adalah tim yang berfokus membantu bisnis bertransformasi digital melalui solusi teknologi yang aman, scalable, dan berorientasi hasil.">

    <x-page-hero eyebrow="Tentang Maiharta" title="Mitra Transformasi Digital Bisnis Anda" description="Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem." :stats="[[site('umum.stats.years'), 'Tahun'], [site('umum.stats.projects'), 'Proyek'], [site('umum.stats.clients'), 'Instansi']]" />

    {{-- Cerita + nilai --}}
    <section class="container-site grid grid-cols-1 gap-10 pb-16 md:pb-20 lg:grid-cols-[1fr_560px] lg:gap-16">
        <div data-animate-group="0.07">
            <p data-animate class="eyebrow">Siapa Kami</p>
            <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-[32px] md:leading-[42px]">{{ $cerita['title'] }}</h2>
            <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $cerita['description'] }}</p>
            @if ($cerita['quote'])
                <blockquote data-animate class="mt-6 rounded-[14px] border-l-[3px] border-brand-normal bg-brand-light px-6 py-5">
                    <p class="font-heading text-body font-medium text-brand-dark">{{ $cerita['quote'] }}</p>
                    @if ($cerita['quote_by'])<footer class="mt-2 text-label text-brand-muted">{{ $cerita['quote_by'] }}</footer>@endif
                </blockquote>
            @endif
            <div data-animate class="mt-6"><x-button :href="route('kontak')" icon="arrow-right">Hubungi Tim Kami</x-button></div>
        </div>
        <div data-animate-group class="space-y-3.5">
            <p data-animate class="eyebrow">Nilai Kerja Kami</p>
            @foreach ($values as [$icon, $t, $d])
                <x-card data-animate :interactive="false" padding="px-5 py-5" class="flex items-center gap-4 !rounded-[14px]">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light text-brand-normal"><x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" /></span>
                    <span><span class="block font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $t }}</span><span class="block text-body-sm text-brand-muted">{{ $d }}</span></span>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- Partner & klien — logo berjalan (marquee) --}}
    @if ($partners || $clients)
    <section class="overflow-hidden bg-white py-16 md:py-20">
        <div class="container-site">
            <x-section-head eyebrow="Partner & Klien" title="Dipercaya oleh Instansi dan Mitra Terkemuka" align="center" />
        </div>
        <div data-animate class="mt-10 space-y-8">
            @if ($partners)<x-logo-marquee :logos="$partners" label="Partner Kami" :duration="36" />@endif
            @if ($clients)<x-logo-marquee :logos="$clients" label="Klien Kami" :duration="48" :reverse="true" />@endif
        </div>
    </section>
    @endif

    <div class="bg-brand-light">
        <x-cta-panel eyebrow="Bergabung / Kolaborasi" title="Tertarik Bergabung atau Berkolaborasi?" description="Kami selalu terbuka untuk talenta baru dan kemitraan strategis." primary-label="Hubungi Kami" :primary-href="route('kontak')" secondary-label="Lihat Portofolio" :secondary-href="route('portofolio.index')" />
    </div>
</x-layout>
