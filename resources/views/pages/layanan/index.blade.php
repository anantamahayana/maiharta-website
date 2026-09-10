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
    $steps = [
        ['Konsultasi', 'Memahami kebutuhan, tujuan bisnis, dan batasan proyek Anda.'],
        ['Perencanaan & Desain', 'Menyusun arsitektur sistem, alur pengguna, dan desain antarmuka.'],
        ['Pengembangan & QA', 'Membangun produk secara iteratif dengan pengujian berkelanjutan.'],
        ['Peluncuran & Support', 'Rilis ke produksi, pelatihan pengguna, dan pemeliharaan.'],
    ];
@endphp

<x-layout title="Layanan — MaiHarta" description="Solusi digital untuk setiap kebutuhan bisnis: software development, desain, digital marketing, hingga maintenance.">
<div x-data="{ active: 'Semua' }">

    <x-page-hero
        eyebrow="Layanan Kami"
        title="Solusi Digital untuk Setiap Kebutuhan Bisnis"
        description="Kami membantu bisnis Anda merancang, membangun, dan mengembangkan produk digital — dari website hingga sistem internal yang kompleks."
        :stats="[[$services->count(), 'Layanan'], ['199+', 'Proyek'], ['ISO', '27001']]"
    >
        <x-slot:footer><x-filter-tabs :items="$groups" /></x-slot:footer>
    </x-page-hero>

    <section class="container-site py-12 md:py-16">
        {{-- Featured --}}
        @if ($featured)
            <div data-animate="scale" x-show="active === 'Semua' || active === @js($groupOf($featured))" class="flex flex-col gap-8 rounded-panel bg-brand-dark p-7 text-white md:flex-row md:items-center md:p-9">
                <div class="flex-1">
                    <x-chip variant="accent">Layanan Utama</x-chip>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-brand-surface-on-dark [&_svg]:text-white"><x-service-icon :icon="$featured->icon" class="h-7 w-7" /></span>
                        <h2 class="font-heading text-h3 font-semibold md:text-[28px] md:leading-9">{{ $featured->name }}</h2>
                    </div>
                    <p class="mt-4 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">{{ $featured->short_description }} Termasuk sistem internal, portal publik, e-commerce, dan integrasi API.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach (collect($featured->tech_tags ?? [])->take(5) as $tag)<x-chip variant="on-dark">{{ $tag }}</x-chip>@endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-3 md:items-end">
                    <x-button :href="route('layanan.show', $featured)" icon="arrow-right">Pelajari Lebih Lanjut</x-button>
                    <div class="rounded-xl border border-brand-border-on-dark bg-brand-surface-on-dark px-5 py-4 md:text-right">
                        <p class="text-body-sm font-semibold">{{ $featured->projects_count ?? 5 }} proyek unggulan</p>
                        <p class="text-caption text-brand-on-dark">SSO, Helpdesk, E-PBBKB, LoveBali, Klungkung</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Grid --}}
        <div data-animate-group class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @foreach ($rest as $i => $service)
                <div data-animate x-show="active === 'Semua' || active === @js($groupOf($service))">
                    <x-card :href="route('layanan.show', $service)" class="flex h-full flex-col">
                        <div class="flex items-start justify-between">
                            <span class="flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-brand-light transition-colors group-hover:bg-brand-light-hover"><x-service-icon :icon="$service->icon" /></span>
                            <span class="text-label-sm tracking-widest text-brand-muted">{{ str_pad($loop->iteration + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h3 class="mt-5 font-heading text-[19px] font-medium leading-7 text-brand-dark">{{ $service->name }}</h3>
                        <p class="mt-3 flex-1 text-body-sm text-brand-muted">{{ $service->short_description }}</p>
                        <span class="mt-5 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">Pelajari Lebih Lanjut <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" /></span>
                    </x-card>
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
                        <span class="flex h-10 w-10 items-center justify-center rounded-full font-heading text-h5 font-semibold {{ $i === 0 ? 'bg-brand-normal text-white' : 'bg-brand-light text-brand-dark' }}">{{ $i + 1 }}</span>
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
