@php
    $featured = $services->first();
    $rest = $services->skip(1);
    $groups = ['Semua', 'Pengembangan', 'Desain', 'Pemasaran', 'Dukungan'];
    $groupOf = fn ($s) => match ($s->icon) {
        'code', 'consulting' => 'Pengembangan',
        'palette', 'uiux' => 'Desain',
        'megaphone' => 'Pemasaran',
        default => 'Dukungan',
    };
    $steps = collect(site('layanan.proses.items', []))->filter(fn ($s) => filled($s['title'] ?? null))->take(4)
        ->map(fn ($s) => [$s['title'], $s['description'] ?? ''])->values()->all();
@endphp

<x-layout title="Layanan — MaiHarta" description="Solusi digital untuk setiap kebutuhan bisnis: software development, desain, digital marketing, hingga maintenance.">
<div x-data="{ active: 'Semua' }">

    <x-page-hero
        eyebrow="Layanan Kami"
        title="Solusi Digital untuk Setiap Kebutuhan Bisnis"
        description="Kami membantu bisnis Anda merancang, membangun, dan mengembangkan produk digital — dari website hingga sistem internal yang kompleks."
        :stats="[[$services->count(), 'Layanan'], [site('umum.stats.projects'), 'Proyek'], [site('umum.stats.years'), 'Tahun']]"
    >
        <x-slot:footer><x-filter-tabs :items="$groups" /></x-slot:footer>
    </x-page-hero>

    <section class="container-site pt-6 pb-12 md:pt-8 md:pb-16">
        {{-- Featured --}}
        @if ($featured)
            <x-service-featured :service="$featured" data-animate="scale" x-show="active === 'Semua' || active === @js($groupOf($featured))" />
        @endif

        {{-- Grid --}}
        <div data-animate-group class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @foreach ($rest as $i => $service)
                <div data-animate x-show="active === 'Semua' || active === @js($groupOf($service))">
                    <x-service-card :service="$service" />
                </div>
            @endforeach
        </div>

        <template x-if="active !== 'Semua' && !@js($services->map($groupOf)->unique()->values()).includes(active)">
            <div class="mt-6"><x-empty-state title="Belum ada layanan di kategori ini" description="Coba kategori lain atau hubungi kami untuk kebutuhan khusus." /></div>
        </template>
    </section>

    {{-- Proses kerja --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site">
            <x-section-head eyebrow="Cara Kami Bekerja" title="Empat Langkah dari Ide ke Produk" align="center" />
            <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $i => [$t, $d])
                    <x-card data-animate :interactive="false" padding="p-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full font-heading text-h5 font-semibold bg-brand-light text-brand-dark">{{ $i + 1 }}</span>
                        <h3 class="mt-4 font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $t }}</h3>
                        <p class="mt-2 text-label text-brand-muted">{{ $d }}</p>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    <div class="bg-brand-light">
        <x-cta-panel eyebrow="Konsultasi Gratis" title="Tidak Yakin Layanan Mana yang Anda Butuhkan?" description="Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menentukan solusi yang paling tepat." primary-label="Konsultasi Gratis" :primary-href="route('kontak')" secondary-label="Lihat Portofolio" :secondary-href="route('portofolio.index')" />
    </div>
</div>
</x-layout>
