@php
    $counts = $projects->countBy('category')->all();
    $counts = ['Semua' => $projects->count()] + $counts;
    $featured = $projects->firstWhere('slug', 'lais-market') ?? $projects->first();
    $grid = $projects->reject(fn ($p) => $p->is($featured))->values();
@endphp

<x-layout title="Portofolio — MaiHarta" description="Kumpulan proyek yang telah kami kerjakan bersama klien dari berbagai industri.">
<div x-data="{ active: 'Semua' }">

    <x-page-hero
        eyebrow="Portofolio Kami"
        title="Bukti Nyata Kapabilitas Kami"
        description="Kumpulan proyek yang telah kami kerjakan bersama klien dari berbagai industri — perbankan, pemerintahan, pariwisata, hingga e-commerce."
        :stats="[[$projects->count(), 'Proyek Unggulan'], [$projects->pluck('client_type')->filter()->map(fn ($c) => trim(explode('—', $c)[0]))->unique()->count(), 'Sektor Industri'], [site('umum.stats.clients'), 'Instansi']]"
    >
        <x-slot:footer>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <x-filter-tabs :items="$categories->all()" :counts="$counts" />
                <span class="text-caption text-brand-muted" x-text="active === 'Semua' ? 'Menampilkan semua proyek' : 'Filter: ' + active"></span>
            </div>
        </x-slot:footer>
    </x-page-hero>

    <section class="container-site py-12 md:py-16">
        {{-- Featured --}}
        @if ($featured)
            <div data-animate="scale" x-show="active === 'Semua' || active === @js($featured->category)" class="grid overflow-hidden rounded-panel bg-brand-dark text-white lg:grid-cols-[1fr_600px]">
                <div class="p-7 md:p-10">
                    <div class="flex flex-wrap gap-2">
                        <x-chip variant="accent">Proyek Unggulan</x-chip>
                        <x-chip variant="outline" class="border-transparent">{{ $featured->category }}</x-chip>
                        @if ($featured->external_url)<x-chip variant="outline" class="border-transparent"><span class="h-1.5 w-1.5 rounded-full bg-success"></span>Live</x-chip>@endif
                    </div>
                    <h2 class="mt-4 font-heading text-h3 font-semibold md:text-h2">{{ $featured->name }}</h2>
                    <p class="mt-3 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">{{ $featured->short_description }}</p>
                    @if ($featured->outcome_stats)
                        <div class="mt-5 flex flex-wrap gap-6">
                            @foreach (array_slice($featured->outcome_stats, 0, 3) as $stat)
                                <div><p class="font-heading text-[20px] font-semibold leading-7 text-brand-normal">{{ $stat['value'] }}</p><p class="text-caption text-brand-on-dark">{{ $stat['label'] }}</p></div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <x-button :href="route('portofolio.show', $featured)" icon="arrow-right">Lihat Studi Kasus</x-button>
                        @if ($featured->external_url)<x-button :href="$featured->external_url" variant="white" icon="arrow-top-right-on-square" target="_blank" rel="noopener">{{ parse_url($featured->external_url, PHP_URL_HOST) }}</x-button>@endif
                    </div>
                </div>
                <div class="relative min-h-[240px] overflow-hidden lg:min-h-[420px]">
                    <img src="{{ $featured->cover_image ? asset($featured->cover_image) : asset('images/projects/' . $featured->slug . '.jpg') }}" alt="{{ $featured->name }}" class="absolute left-6 top-6 h-[calc(100%+40px)] w-[calc(100%+40px)] rounded-xl object-cover object-left-top shadow-showcase lg:left-12 lg:top-12">
                </div>
            </div>
        @endif

        {{-- Grid --}}
        <div data-animate-group class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @foreach ($grid as $project)
                <div data-animate x-show="active === 'Semua' || active === @js($project->category)">
                    <x-project-card :project="$project" class="h-full" />
                </div>
            @endforeach
        </div>

        <template x-if="active !== 'Semua' && !@js($projects->pluck('category')->unique()->values()).includes(active)">
            <div class="mt-6"><x-empty-state title="Belum ada proyek di kategori ini" description="Coba kategori lain — atau jadilah klien pertama kami di kategori ini.">
                <x-button :href="route('kontak')" size="sm" icon="arrow-right">Konsultasi Gratis</x-button>
            </x-empty-state></div>
        </template>

        <p class="mt-6 text-caption text-brand-muted">*Tautan proyek akan diperbarui sesuai URL resmi masing-masing aplikasi.</p>
    </section>

    <x-cta-panel eyebrow="Mari Berkolaborasi" title="Punya Proyek Serupa?" description="Mari diskusikan bagaimana kami bisa membantu mewujudkan proyek digital Anda." primary-label="Konsultasi Gratis" :primary-href="route('kontak')" secondary-label="Lihat Layanan" :secondary-href="route('layanan.index')" />
</div>
</x-layout>
