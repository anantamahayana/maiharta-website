@php
    $steps = collect($service->process_steps ?? []);
    $tags = collect($service->tech_tags ?? []);
    $capabilities = collect($service->capabilities ?? [])->map(fn ($c) => [$c['title'], $c['description'] ?? ''])->all();
    $meta = collect($service->meta ?? [])->map(fn ($m) => [$m['label'], $m['value']])->all();
    $aboutTitle = $service->about_title ?: 'Sistem yang dibangun mengikuti proses bisnis Anda, bukan sebaliknya';
    $techGroups = [
        'Backend' => $tags->filter(fn ($t) => preg_match('/php|laravel|mysql|api|redis|node/i', $t))->values(),
        'Frontend' => $tags->filter(fn ($t) => preg_match('/javascript|bootstrap|tailwind|vue|react|css/i', $t))->values(),
        'Lainnya' => $tags->filter(fn ($t) => ! preg_match('/php|laravel|mysql|api|redis|node|javascript|bootstrap|tailwind|vue|react|css/i', $t))->values(),
    ];
@endphp

<x-layout :title="$service->name . ' — Layanan MaiHarta'" :description="$service->short_description">

    <x-page-hero :crumbs="[['Beranda', route('home')], ['Layanan', route('layanan.index')], [$service->name, null]]" title="">
        <div class="flex items-center gap-5">
            <span data-animate class="flex h-[72px] w-[72px] shrink-0 items-center justify-center rounded-card border border-brand-border bg-white"><x-service-icon :icon="$service->icon" class="h-8 w-8" /></span>
            <div>
                <p data-animate class="overline">Layanan Utama</p>
                <h1 data-animate class="mt-1 font-heading text-h2 font-semibold text-brand-dark md:text-h1-hero">{{ $service->name }}</h1>
            </div>
        </div>
        <p data-animate class="mt-5 text-body-sm text-brand-muted md:text-body">{{ $service->short_description }}</p>
        <div data-animate class="mt-6 flex flex-col gap-3 sm:flex-row">
            <x-button :href="route('kontak')" icon="arrow-right">Konsultasi Layanan Ini</x-button>
            <x-button href="#proyek-terkait" variant="outline" icon="arrow-down">Lihat Proyek Terkait</x-button>
        </div>

        @if ($meta)
        <x-slot:aside>
            <div class="w-full rounded-card border border-brand-border bg-white px-7 py-3 shadow-elevated lg:w-[400px]">
                @foreach ($meta as [$k, $v])
                    <div class="flex gap-4 py-3.5 {{ ! $loop->last ? 'border-b border-brand-light' : '' }}">
                        <span class="w-[110px] shrink-0 pt-0.5 text-label-sm font-medium uppercase tracking-wider text-brand-muted">{{ $k }}</span>
                        <span class="text-body-sm font-semibold text-brand-dark">{{ $v }}</span>
                    </div>
                @endforeach
            </div>
        </x-slot:aside>
        @endif
    </x-page-hero>

    {{-- Tentang layanan --}}
    <section class="container-site grid grid-cols-1 gap-10 py-16 md:py-20 {{ $capabilities ? 'lg:grid-cols-[1fr_520px]' : '' }} lg:gap-16">
        <div data-animate-group="0.07">
            <p data-animate class="overline">Tentang Layanan Ini</p>
            <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-[32px] md:leading-[42px]">{{ $aboutTitle }}</h2>
            <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $service->description }}</p>
        </div>
        @if ($capabilities)
        <div data-animate-group class="space-y-3">
            @foreach ($capabilities as $i => [$t, $desc])
                <div data-animate class="flex items-center gap-3.5 rounded-[14px] bg-brand-light px-4 py-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[10px] bg-white font-heading text-body-sm font-semibold text-brand-normal">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span><span class="block text-h5 font-medium text-brand-dark">{{ $t }}</span><span class="block text-label text-brand-muted">{{ $desc }}</span></span>
                </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- Proses kerja --}}
    @if ($steps->isNotEmpty())
        <section class="bg-brand-light py-16 md:py-20">
            <div class="container-site">
                <x-section-head eyebrow="Proses Kerja" title="Lima Tahap Menuju Sistem yang Siap Pakai" align="center" />
                <div data-animate-group class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ($steps as $i => $step)
                        <x-card data-animate :interactive="false" padding="p-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full font-heading text-h5 font-semibold bg-brand-light text-brand-dark">{{ $i + 1 }}</span>
                            <h3 class="mt-3 font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-label text-brand-muted">{{ $step['description'] }}</p>
                            @if (!empty($step['duration']))<x-chip class="mt-3">{{ $step['duration'] }}</x-chip>@endif
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Teknologi --}}
    @if ($tags->isNotEmpty())
        <section class="container-site py-16 md:py-20">
            <x-section-head eyebrow="Teknologi & Skillset" title="Stack yang Terbukti di Produksi" />
            <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ($techGroups as $g => $items)
                    @continue($items->isEmpty())
                    <x-card data-animate :interactive="false" padding="p-6">
                        <p class="text-h5 font-medium text-brand-dark">{{ $g }}</p>
                        <div class="mt-3 flex flex-wrap gap-1.5">@foreach ($items as $t)<x-chip class="bg-brand-light">{{ $t }}</x-chip>@endforeach</div>
                    </x-card>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Proyek terkait --}}
    <section id="proyek-terkait" class="container-site pb-16 md:pb-20 {{ $tags->isEmpty() ? 'pt-16 md:pt-20' : '' }}">
        <x-section-head eyebrow="Proyek Terkait" title="Yang Sudah Kami Bangun dengan Layanan Ini">
            <x-slot:action><x-button :href="route('portofolio.index')" variant="outline" size="sm" icon="arrow-right">Lihat Semua Portofolio</x-button></x-slot:action>
        </x-section-head>
        @if ($relatedProjects->isNotEmpty())
            <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ($relatedProjects as $project)<x-project-card data-animate :project="$project" />@endforeach
            </div>
        @else
            <x-empty-state class="mt-8" icon="rectangle-stack" title="Belum ada proyek untuk layanan ini" description="Studi kasus akan ditambahkan setelah proyek pertama selesai." />
        @endif
    </section>

    <x-cta-panel eyebrow="Mulai Proyek" :title="'Siap Memulai Proyek ' . $service->name . ' Anda?'" description="Ceritakan kebutuhan Anda, kami bantu rancang dari nol hingga siap dipakai." primary-label="Konsultasi Layanan Ini" :primary-href="route('kontak')" secondary-label="Lihat Layanan Lain" :secondary-href="route('layanan.index')" />
</x-layout>
