@php
    $h = site('beranda.hero');
    $u = site('beranda.utama');
    $valueIcons = ['check', 'value-collab', 'value-result'];
    $values = collect(site('tentang.nilai.items', []))->filter(fn ($v) => filled($v['title'] ?? null))->take(3)->values();
@endphp
<x-layout title="MaiHarta — Ngga Ada Habisnya">

    {{-- ============================================================ Hero --}}
    {{-- Urutan DOM: (1) badge+judul, (2) scene 3D, (3) deskripsi+tombol. Di mobile tampil berurutan
         (scene tepat di bawah judul); di desktop scene menempati kolom kanan penuh. --}}
    <section class="hero-fit bg-hero-gradient overflow-hidden">
        <div class="container-site grid grid-cols-1 items-center gap-8 py-10 md:py-16 lg:h-full lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:grid-rows-[1fr_auto_auto_1fr] lg:gap-x-12 lg:gap-y-0 lg:py-6">

            {{-- 1. Badge + judul --}}
            <div data-animate-group="0.07" class="mx-auto max-w-[680px] text-center lg:col-start-1 lg:row-start-2 lg:mx-0 lg:text-left">
                <span data-animate class="inline-flex items-center gap-2 rounded-full border border-brand-border bg-white py-1.5 pl-1.5 pr-3.5 text-label font-medium text-brand-dark">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-light">
                        <x-heroicon-o-sparkles class="h-3.5 w-3.5 text-brand-normal" />
                    </span>
                    Dipercaya {{ site('umum.stats.clients') }} instansi &amp; bisnis
                </span>

                <h1 class="mt-6 font-heading font-semibold text-brand-dark">
                    <span data-animate class="hero-title text-gradient-brand animate-shimmer block text-h2-lg md:text-[56px] md:leading-[64px] xl:whitespace-nowrap">{{ $u['title_1'] }}</span>
                    <span data-animate class="hero-title block text-h2-lg md:text-[56px] md:leading-[64px]">{{ $u['title_2'] }}</span>
                </h1>
            </div>

            {{-- 2. Scene 3D --}}
            <div data-animate="scale" class="mx-auto w-full max-w-[420px] lg:col-start-2 lg:row-span-4 lg:row-start-1 lg:flex lg:h-full lg:max-w-none lg:items-center lg:justify-center">
                @if ($h['character'] ?? null)<x-hero-character :h="$h" />@else<x-hero-scene :h="$h" />@endif
            </div>

            {{-- 3. Deskripsi + CTA --}}
            <div data-animate-group="0.07" class="mx-auto max-w-[680px] text-center lg:col-start-1 lg:row-start-3 lg:mx-0 lg:text-left">
                <p data-animate class="mx-auto max-w-[620px] text-body-sm text-brand-muted md:text-body lg:mx-0 lg:mt-6">
                    {{ $u['description'] }}
                </p>

                <div data-animate class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-center lg:justify-start">
                    <x-button :href="route('kontak')" variant="gradient" size="lg" icon="arrow-right">Mulai Konsultasi Gratis</x-button>
                    <x-button :href="route('portofolio.index')" variant="outline" size="lg">Lihat Portofolio</x-button>
                </div>

                <ul data-animate class="mt-6 flex flex-wrap justify-center gap-x-5 gap-y-2 text-caption text-brand-muted lg:justify-start">
                    @foreach (collect(preg_split('/\r?\n/', (string) $u['bullets']))->map(fn ($b) => trim($b))->filter()->take(3) as $bullet)
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span>{{ $bullet }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- ================================================ Dipercaya oleh --}}
    @php $trustLogos = array_merge(site('tentang.partner.partners', []), site('tentang.partner.clients', [])); @endphp
    @if ($trustLogos)
        <section class="overflow-hidden bg-white py-8 md:py-10" aria-label="Partner dan klien kami">
            <x-logo-marquee :logos="$trustLogos" label="Dipercaya oleh instansi & mitra" :duration="60" />
        </section>
    @endif

    {{-- ===================================================== Solusi Kita --}}
    <section class="container-site py-16 md:py-20">
        <x-section-head eyebrow="Solusi Kita" title="Satu Mitra untuk Seluruh Kebutuhan Digital Anda" description="Solusi digital yang disesuaikan dengan kebutuhan bisnis Anda — dari sistem internal hingga identitas brand.">
            <x-slot:action><x-button :href="route('layanan.index')" variant="outline" size="sm" icon="arrow-right">Semua Layanan</x-button></x-slot:action>
        </x-section-head>

        @if ($featuredService)
            <div class="mt-10"><x-service-featured :service="$featuredService" data-animate="scale" /></div>
        @endif
        <div data-animate-group class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @foreach ($services as $service)
                <x-service-card data-animate :service="$service" />
            @endforeach
        </div>
    </section>

    {{-- ============================================= Mengapa MaiHarta --}}
    @php $why = site('beranda.alasan'); $whyItems = collect($why['items'] ?? [])->filter(fn ($i) => filled($i['title'] ?? null))->take(4); $whyIcons = ['user-group', 'lifebuoy', 'shield-check', 'adjustments-horizontal']; @endphp
    @if ($whyItems->isNotEmpty())
        <section class="bg-brand-dark py-16 text-white md:py-20">
            <div class="container-site grid grid-cols-1 items-center gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)] lg:gap-16">
                <div data-animate-group="0.07" class="text-center lg:text-left">
                    <p data-animate class="eyebrow text-brand-accent-on-dark">Mengapa MaiHarta?</p>
                    <h2 data-animate class="mt-3 font-heading text-h2 font-semibold leading-tight md:text-h1">{{ $why['title'] }}</h2>
                    <p data-animate class="mt-4 text-body-sm text-brand-on-dark md:text-body">{{ $why['description'] }}</p>
                    <ul data-animate class="mt-6 space-y-3 text-left">
                        @foreach (collect(preg_split('/\r?\n/', (string) $why['checks']))->filter()->take(4) as $check)
                            <li class="flex items-start gap-3 text-body-sm md:text-[15px]"><x-heroicon-o-check-circle class="mt-0.5 h-5 w-5 shrink-0 text-brand-accent-on-dark" />{{ $check }}</li>
                        @endforeach
                    </ul>
                    <div data-animate class="mt-8 flex justify-center lg:justify-start"><x-button :href="route('kontak')" icon="arrow-right">Konsultasikan Bisnis Anda</x-button></div>
                </div>
                <div data-animate-group class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-5">
                    @foreach ($whyItems as $k => $item)
                        <div data-animate class="rounded-panel border border-brand-border-on-dark bg-brand-surface-on-dark p-6 transition-colors hover:bg-white/10">
                            <div class="flex items-start justify-between">
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-normal/25 text-brand-accent-on-dark">@svg('heroicon-o-' . $whyIcons[$k % 4], 'h-6 w-6')</span>
                                <span class="text-label text-brand-on-dark/60">{{ str_pad($k + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="mt-5 font-heading text-h4 font-semibold">{{ $item['title'] }}</h3>
                            <p class="mt-2 text-body-sm text-brand-on-dark">{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ====================================================== Portofolio --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site">
            <x-section-head eyebrow="Portofolio" title="Bukti Nyata Kapabilitas Kami">
                <x-slot:action><x-button :href="route('portofolio.index')" variant="outline" size="sm" icon="arrow-right">Lihat Semua Proyek</x-button></x-slot:action>
            </x-section-head>

            <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
                @foreach ($projects as $project)
                    <x-card data-animate :href="route('portofolio.show', $project)" padding="p-0" class="overflow-hidden">
                        <div class="aspect-[16/10] w-full overflow-hidden bg-brand-light-hover">
                            <img src="{{ $project->cover_image ? asset($project->cover_image) : asset('images/projects/' . $project->slug . '.jpg') }}" alt="{{ $project->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        </div>
                        <div class="p-5 md:p-6">
                            <x-chip>{{ $project->category }}</x-chip>
                            <h3 class="mt-3 font-heading text-h4 font-medium text-brand-dark">{{ $project->name }}</h3>
                            <p class="mt-2 line-clamp-3 text-body-sm text-brand-muted">{{ $project->short_description }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">
                                Lihat Detail Proyek <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                            </span>
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ Blog --}}
    @if ($articles->isNotEmpty())
        <section class="container-site py-16 md:py-20">
            <x-section-head eyebrow="Blog" title="Wawasan & Cerita dari Tim Kami" description="Tulisan seputar transformasi digital, tips membangun aplikasi, dan kabar terbaru MaiHarta.">
                <x-slot:action><x-button :href="route('blog.index')" variant="outline" size="sm" icon="arrow-right">Lihat Semua Artikel</x-button></x-slot:action>
            </x-section-head>
            <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
                @foreach ($articles as $article)
                    <x-article-card data-animate :article="$article" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ========================================================= Tentang --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site grid grid-cols-1 items-center gap-10 lg:grid-cols-[1fr_560px] lg:gap-16">
            <div data-animate-group="0.07">
                <p data-animate class="eyebrow">Tentang Maiharta</p>
                <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-h2-lg">Mitra Transformasi Digital Bisnis Anda</h2>
                <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem.</p>
                <div data-animate class="mt-6"><x-button :href="route('tentang')" icon="arrow-right">Kenali Kami Lebih Dekat</x-button></div>
            </div>

            <div data-animate-group class="space-y-3.5">
                @foreach ($values as $k => $v)
                    @php [$icon, $valueTitle, $valueDesc] = [$valueIcons[$k % 3], $v['title'], $v['description'] ?? '']; @endphp
                    <div data-animate class="flex items-center gap-4 rounded-[14px] border border-brand-border bg-white px-5 py-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light text-brand-normal">
                            <x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" />
                        </span>
                        <span>
                            <span class="block font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $valueTitle }}</span>
                            <span class="block text-body-sm text-brand-muted">{{ $valueDesc }}</span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================= CTA --}}
    <div class="bg-brand-light">
        <x-cta-panel
            eyebrow="Mulai Sekarang"
            title="Siap Membangun Produk Digital Anda?"
            description="Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menemukan solusi digital yang tepat."
            primary-label="Hubungi Kami Sekarang"
            :primary-href="route('kontak')"
            secondary-label="Lihat Layanan"
            :secondary-href="route('layanan.index')"
        />
    </div>

</x-layout>
