@php
    $cover = $project->cover_image ? asset($project->cover_image) : asset('images/projects/' . $project->slug . '.jpg');
    $gallery = collect($project->gallery ?? []);
    $stats = collect($project->outcome_stats ?? []);
    $host = $project->external_url ? parse_url($project->external_url, PHP_URL_HOST) : null;
    $year = $project->created_at?->format('Y') ?? date('Y');
    $meta = array_filter([
        ['Klien', $project->client_type],
        ['Layanan', $project->service?->name],
        ['Kategori', $project->category],
        ['Tahun', $year],
        ['Status', $project->external_url ? 'Live & Aktif Beroperasi' : 'Selesai'],
    ], fn ($m) => filled($m[1]));
    $summary = array_filter([
        ['Tantangan', $project->challenge],
        ['Solusi', $project->solution],
        ['Teknologi', $project->tech_summary],
    ], fn ($s) => filled($s[1]));
@endphp

<x-layout :title="$project->name . ' — Portofolio MaiHarta'" :description="$project->short_description">

    <x-page-hero :crumbs="[['Beranda', route('home')], ['Portofolio', route('portofolio.index')], [$project->name, null]]">
        <div data-animate class="flex flex-wrap gap-2">
            <x-chip>{{ $project->category }}</x-chip>
            @if ($project->client_type)<x-chip variant="outline">{{ $project->client_type }}</x-chip>@endif
            @if ($project->external_url)<x-chip variant="accent">Live</x-chip>@endif
        </div>
        <h1 data-animate class="mt-5 font-heading text-h2 font-semibold text-brand-dark md:text-h1-hero md:tracking-[-0.5px]">{{ $project->name }}</h1>
        <p data-animate class="mt-5 text-body-sm text-brand-muted md:text-body">{{ $project->short_description }}</p>
        <div data-animate class="mt-6 flex flex-col gap-3 sm:flex-row">
            @if ($project->external_url)
                <x-button :href="$project->external_url" icon="arrow-top-right-on-square" target="_blank" rel="noopener">Kunjungi {{ $host }}</x-button>
            @else
                <x-button :href="route('kontak')" icon="arrow-right">Konsultasi Proyek Serupa</x-button>
            @endif
            @if ($gallery->isNotEmpty())<x-button href="#galeri" variant="outline" icon="arrow-down">Lihat Galeri Tampilan</x-button>@endif
        </div>

        <x-slot:aside>
            <div class="w-full rounded-card border border-brand-border bg-white px-7 py-3 shadow-elevated lg:w-[400px]">
                @foreach ($meta as [$k, $v])
                    <div class="flex gap-4 py-3.5 {{ ! $loop->last ? 'border-b border-brand-light' : '' }}">
                        <span class="w-[90px] shrink-0 pt-0.5 text-label-sm font-medium uppercase tracking-wider text-brand-muted">{{ $k }}</span>
                        <span class="text-body-sm font-semibold text-brand-dark">{{ $v }}</span>
                    </div>
                @endforeach
            </div>
        </x-slot:aside>
    </x-page-hero>

    {{-- Showcase: browser mock + stats --}}
    <section class="container-site py-12 md:py-16">
        <div data-animate="scale" class="overflow-hidden rounded-card border border-brand-border bg-white shadow-showcase">
            <div class="flex items-center gap-4 border-b border-brand-border bg-brand-input px-4 py-3">
                <span class="flex gap-1.5"><i class="h-2.5 w-2.5 rounded-full bg-[#ff5f57]"></i><i class="h-2.5 w-2.5 rounded-full bg-[#febc2e]"></i><i class="h-2.5 w-2.5 rounded-full bg-[#28c840]"></i></span>
                <span class="flex flex-1 items-center justify-center gap-2 rounded-full border border-brand-border bg-white px-3.5 py-1.5 text-label-sm font-medium text-brand-dark">
                    <x-heroicon-o-lock-closed class="h-3 w-3 text-brand-muted" />{{ $host ?? Str::slug($project->name) . '.app' }}
                </span>
                @if ($project->external_url)<x-chip variant="success"><span class="h-1.5 w-1.5 rounded-full bg-success"></span>Live</x-chip>@endif
            </div>
            <img src="{{ $cover }}" alt="Tampilan {{ $project->name }}" class="w-full object-cover object-top">
        </div>

        @if ($stats->isNotEmpty())
            <div data-animate-group class="mt-8 grid grid-cols-2 divide-brand-border rounded-card bg-brand-light {{ $stats->count() >= 4 ? 'md:grid-cols-4' : 'md:grid-cols-3' }} md:divide-x">
                @foreach ($stats as $stat)
                    <div data-animate class="px-6 py-6">
                        <p class="font-heading text-h2 font-semibold text-brand-normal">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-h5 font-medium text-brand-dark">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- Ringkasan --}}
    @if ($summary)
        <section class="bg-brand-light py-16 md:py-20">
            <div class="container-site">
                <x-section-head eyebrow="Ringkasan Proyek" title="Tantangan, Solusi, dan Teknologi" />
                <div data-animate-group class="mt-9 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
                    @foreach ($summary as $i => [$t, $d])
                        <x-card data-animate :interactive="false" padding="p-7">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl font-heading text-[15px] font-semibold {{ $loop->index === 1 ? 'bg-brand-normal text-white' : 'bg-brand-light text-brand-dark' }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="mt-4 font-heading text-h4 font-medium text-brand-dark">{{ $t }}</h3>
                            <p class="mt-3 text-body-sm text-brand-muted">{{ $d }}</p>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Galeri --}}
    @if ($gallery->isNotEmpty())
        <section id="galeri" class="container-site py-16 md:py-20" x-data="{ open: null }">
            <x-section-head eyebrow="Galeri Tampilan" title="Jelajahi Setiap Sudut Platform" />
            <div data-animate-group class="mt-9 grid grid-cols-2 gap-4 md:grid-cols-3 md:gap-5">
                @foreach ($gallery as $i => $img)
                    @php $src = is_array($img) ? $img['src'] : $img; $cap = is_array($img) ? ($img['caption'] ?? null) : null; @endphp
                    <button type="button" data-animate @click="open = {{ $i }}" class="group overflow-hidden rounded-card border border-brand-border bg-white text-left shadow-card transition-all hover:-translate-y-1 hover:shadow-elevated">
                        <img src="{{ asset($src) }}" alt="{{ $cap ?? $project->name }}" class="aspect-[16/10] w-full object-cover object-top" loading="lazy">
                        <span class="flex items-center justify-between px-4 py-3"><span class="text-label font-medium text-brand-dark">{{ $cap ?? 'Tampilan ' . ($i + 1) }}</span><span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-light"><x-heroicon-o-arrows-pointing-out class="h-4 w-4 text-brand-dark" /></span></span>
                    </button>
                @endforeach
            </div>
            {{-- Lightbox --}}
            <div x-show="open !== null" x-transition.opacity x-cloak @keydown.escape.window="open = null" @click="open = null" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-darker/80 p-4 backdrop-blur-sm">
                @foreach ($gallery as $i => $img)
                    @php $src = is_array($img) ? $img['src'] : $img; @endphp
                    <img x-show="open === {{ $i }}" src="{{ asset($src) }}" alt="" class="max-h-[90vh] max-w-full rounded-xl shadow-hero" @click.stop>
                @endforeach
                <button type="button" class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20"><x-heroicon-o-x-mark class="h-5 w-5" /></button>
            </div>
        </section>
    @endif

    {{-- Outcome --}}
    <section class="container-site py-16 md:py-20 {{ $gallery->isEmpty() ? 'pt-0 md:pt-0' : '' }}">
        <div data-animate="scale" class="flex flex-col gap-8 rounded-panel bg-brand-dark p-8 text-white md:flex-row md:items-center md:p-12">
            <div class="flex-1">
                <p class="overline text-brand-accent-on-dark">Hasil & Outcome</p>
                <h2 class="mt-3 font-heading text-h3 font-semibold md:text-[28px] md:leading-[38px]">Dampak nyata bagi {{ $project->client_type ? explode('—', $project->client_type)[0] : 'klien' }}</h2>
                <p class="mt-3 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">{{ $project->description }}</p>
            </div>
            @if ($stats->isNotEmpty())
                <div class="grid shrink-0 grid-cols-3 gap-3 md:grid-cols-1 lg:grid-cols-3">
                    @foreach ($stats->take(3) as $stat)
                        <div class="rounded-[14px] border border-brand-border-on-dark bg-brand-surface-on-dark px-4 py-4 md:w-[150px]">
                            <p class="font-heading text-h3 font-semibold text-brand-normal md:text-[32px] md:leading-10">{{ $stat['value'] }}</p>
                            <p class="mt-1 text-caption text-brand-on-dark">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Proyek lainnya --}}
    @if ($otherProjects->isNotEmpty())
        <section class="container-site pb-16 md:pb-20">
            <x-section-head eyebrow="Proyek Lainnya" title="Lihat Karya Kami yang Lain">
                <x-slot:action><x-button :href="route('portofolio.index')" variant="outline" size="sm" icon="arrow-right">Semua Proyek</x-button></x-slot:action>
            </x-section-head>
            <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ($otherProjects as $other)<x-project-card data-animate :project="$other" /> @endforeach
            </div>
        </section>
    @endif

    <x-cta-panel eyebrow="Mari Berkolaborasi" title="Punya Proyek Serupa yang Ingin Diwujudkan?" description="Ceritakan kebutuhan Anda, kami bantu wujudkan dengan standar yang sama." primary-label="Konsultasi Gratis" :primary-href="route('kontak')" secondary-label="Lihat Layanan" :secondary-href="route('layanan.index')" />
</x-layout>
