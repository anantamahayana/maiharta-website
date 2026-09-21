@php $h = site('beranda.hero'); @endphp
<x-layout title="MaiHarta — Ngga Ada Habisnya">

    {{-- ============================================================ Hero --}}
    <section class="bg-hero-gradient overflow-hidden">
        <div class="container-site grid grid-cols-1 items-center gap-12 py-12 md:py-16 lg:grid-cols-[1fr_600px] lg:gap-12 lg:py-20">

            {{-- Left: copy --}}
            <div data-animate-group="0.07" class="mx-auto max-w-[680px] text-center lg:mx-0 lg:text-left">
                <span data-animate class="inline-flex items-center gap-2 rounded-full border border-brand-border bg-white py-1.5 pl-1.5 pr-3.5 text-label font-medium text-brand-dark">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-light">
                        <x-heroicon-o-sparkles class="h-3.5 w-3.5 text-brand-normal" />
                    </span>
                    Dipercaya {{ site('umum.stats.clients') }} instansi &amp; bisnis
                </span>

                <h1 class="mt-6 font-heading font-semibold text-brand-dark">
                    <span data-animate class="text-gradient-brand animate-shimmer block text-h2-lg md:text-[56px] md:leading-[64px] xl:text-display-sm xl:whitespace-nowrap">Ngga ada habisnya</span>
                    <span data-animate class="block text-h2-lg md:text-[56px] md:leading-[64px] xl:text-display-sm">membangun produk digital untuk bisnis Anda</span>
                </h1>

                <p data-animate class="mt-6 max-w-[620px] text-body-sm text-brand-muted md:text-body">
                    MaiHarta membantu bisnis Anda berkembang cepat melalui jasa dan produk digital — dari sistem internal, aplikasi mobile, hingga marketplace — dengan standar keamanan internasional.
                </p>

                <div data-animate class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <x-button :href="route('kontak')" variant="gradient" size="lg" icon="arrow-right">Mulai Konsultasi Gratis</x-button>
                    <x-button :href="route('portofolio.index')" variant="outline" size="lg">Lihat Portofolio</x-button>
                </div>

                <ul data-animate class="mt-6 flex flex-wrap justify-center lg:justify-start gap-x-5 gap-y-2 text-caption text-brand-muted">
                    @foreach (['Konsultasi gratis', 'Tanpa biaya tersembunyi', 'Dukungan pascarilis'] as $bullet)
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span>{{ $bullet }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Right: floating product-card composition (layers mirror the Figma "Float → …" names) --}}
            <div data-animate-group="0.09" class="relative mx-auto h-[360px] w-full max-w-[362px] lg:h-[600px] lg:max-w-none">
                <div class="animate-glow absolute left-[14%] top-[6%] h-[75%] w-[72%] rounded-full bg-brand-normal/10 blur-3xl"></div>

                {{-- Maskot / ilustrasi (diganti di Admin → Beranda) --}}
                @if ($h['mascot'] ?? null)
                    <img data-animate src="{{ asset($h['mascot']) }}" alt="" width="574" height="519" fetchpriority="high" class="pointer-events-none absolute bottom-0 left-1/2 z-[5] h-[78%] w-auto max-w-none -translate-x-1/2 select-none drop-shadow-[0_24px_40px_rgba(18,48,111,0.25)] lg:h-[84%]">
                @endif

                {{-- Float → Dashboard Card --}}
                <div data-animate="scale" style="--float-dur:5s" class="animate-float absolute left-[28%] top-[8%] w-[72%] rounded-card bg-brand-dark p-4 text-white shadow-hero lg:left-[33%] lg:top-[12%] lg:w-[340px] lg:rounded-[18px] lg:p-5">
                    <div class="flex items-center gap-2">
                        <div class="flex-1">
                            <p class="text-label font-medium lg:text-h5">{{ $h['card_title'] }}</p>
                            <p class="text-caption text-brand-on-dark">{{ str_replace('{tahun}', date('Y'), $h['card_sub']) }}</p>
                        </div>
                        @if ($h['card_badge'])<x-chip variant="on-dark"><span class="h-1.5 w-1.5 rounded-full bg-success"></span>{{ $h['card_badge'] }}</x-chip>@endif
                    </div>
                    <div class="mt-3 flex gap-4 lg:mt-4 lg:gap-5">
                        <x-stat :value="rtrim(site('umum.stats.projects'), '+')" :suffix="str_ends_with(site('umum.stats.projects'), '+') ? '+' : ''" label="Proyek selesai" dark />
                        <x-stat :value="rtrim(site('umum.stats.clients'), '+')" :suffix="str_ends_with(site('umum.stats.clients'), '+') ? '+' : ''" label="Instansi" dark />
                        <x-stat :value="rtrim(site('umum.stats.years'), '+')" :suffix="str_ends_with(site('umum.stats.years'), '+') ? '+' : ''" label="Tahun" dark />
                    </div>
                    <div class="mt-3 flex h-[70px] items-end gap-1.5 lg:mt-4 lg:h-[120px]">
                        @foreach ([28, 43, 33, 58, 48, 72, 53, 80, 65, 92, 75, 100] as $i => $bar)
                            <span style="height:{{ $bar }}%;--bar-delay:{{ 0.5 + $i * 0.04 }}s" class="animate-bar flex-1 rounded {{ $i >= 9 ? 'bg-brand-normal' : 'bg-white/25' }}"></span>
                        @endforeach
                    </div>
                    <div class="mt-3 flex items-center gap-2 lg:mt-4">
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-brand-surface-on-dark"><span class="animate-fill block h-full w-full rounded-full bg-brand-normal"></span></div>
                        <span class="text-caption text-brand-on-dark">{{ $h['card_note'] }}</span>
                    </div>
                </div>

                {{-- Float → Photo Tile 1 --}}
                <div data-animate="scale" style="--float-dur:6s;--float-delay:0.6s" class="animate-float absolute left-0 top-[26%] w-[34%] overflow-hidden rounded-[14px] border-[3px] border-white shadow-hero lg:top-[16%] lg:w-[180px] lg:rounded-card lg:border-4">
                    <img src="{{ asset($h['photo_1']) }}" alt="Tim MaiHarta" class="aspect-[18/13] w-full object-cover">
                </div>

                {{-- Float → Badge dukungan --}}
                <div data-animate="scale" style="--float-dur:4.5s;--float-delay:1.1s" class="animate-float absolute right-0 top-0 flex items-center gap-2.5 rounded-xl bg-white p-2.5 pr-4 shadow-floating lg:right-[10px] lg:top-[1%] lg:rounded-[14px] lg:p-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-light lg:h-9 lg:w-9"><x-heroicon-o-lifebuoy class="h-5 w-5 text-brand-normal" /></span>
                    <span>
                        <span class="block text-label font-semibold text-brand-dark lg:text-body-sm">{{ $h['badge_title'] }}</span>
                        <span class="block text-caption text-brand-muted">{{ $h['badge_sub'] }}</span>
                    </span>
                </div>

                {{-- Float → Sparkle Node + Connector Line --}}
                <div data-animate="scale" style="--float-dur:4s;--float-delay:0.3s" class="animate-float absolute left-[12%] top-[52%] flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-floating lg:left-[15%] lg:top-[45%] lg:h-10 lg:w-10">
                    <x-heroicon-o-sparkles class="h-4 w-4 text-brand-normal lg:h-5 lg:w-5" />
                </div>
                <svg class="animate-draw absolute left-[20%] top-[56%] hidden h-[60px] w-[120px] lg:left-[20%] lg:top-[49%] lg:block" viewBox="0 0 120 60" fill="none" aria-hidden="true">
                    <path d="M0 0C40 0 60 60 120 60" stroke="#2155cd" stroke-width="1.5" stroke-dasharray="4 4" />
                </svg>

                {{-- Float → Helpdesk Bubble --}}
                <div data-animate="scale" style="--float-dur:5.5s;--float-delay:0.9s" class="animate-float absolute bottom-0 left-[8%] z-10 w-[84%] rounded-[14px] bg-white p-3.5 shadow-hero lg:bottom-[20%] lg:left-[33%] lg:w-[330px] lg:rounded-card lg:p-4">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-light-hover text-chip font-medium text-brand-dark">NS</span>
                        <span class="flex-1">
                            <span class="block text-label font-medium text-brand-dark">{{ $h['bubble_title'] }}</span>
                            <span class="block text-caption text-brand-muted">{{ $h['bubble_sub'] }}</span>
                        </span>
                        @if ($h['bubble_status'])<x-chip variant="success"><x-heroicon-o-check class="h-3 w-3" />{{ $h['bubble_status'] }}</x-chip>@endif
                    </div>
                    <p class="mt-2.5 text-caption text-brand-dark lg:text-body-sm">{{ $h['bubble_text'] }}</p>
                    <span class="animate-typing mt-2 flex gap-1 pl-0.5" aria-hidden="true">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span><span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span><span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span>
                    </span>
                </div>

                {{-- Float → SSO Card (desktop only) --}}
                <div data-animate="scale" style="--float-dur:6.5s;--float-delay:1.4s" class="animate-float absolute bottom-[4%] left-0 hidden items-center gap-2.5 rounded-[14px] bg-white p-3 pr-4 shadow-floating lg:flex">
                    <span class="flex h-9 w-9 items-center justify-center rounded-[10px] bg-brand-dark"><x-heroicon-o-lock-closed class="h-[18px] w-[18px] text-white" /></span>
                    <span>
                        <span class="block text-body-sm font-semibold text-brand-dark">{{ $h['sso_title'] }}</span>
                        <span class="block text-caption text-brand-muted">{{ $h['sso_sub'] }}</span>
                    </span>
                </div>

                {{-- Float → Photo Tile 2 (desktop only) --}}
                <div data-animate="scale" style="--float-dur:5.2s;--float-delay:0.4s" class="animate-float absolute bottom-0 right-0 hidden w-[180px] overflow-hidden rounded-card border-4 border-white shadow-hero lg:block">
                    <img src="{{ asset($h['photo_2']) }}" alt="Dashboard analitik" class="aspect-[18/13] w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================ Dipercaya oleh --}}
    @php $trustLogos = array_merge(site('tentang.partner.partners', []), site('tentang.partner.clients', [])); @endphp
    @if ($trustLogos)
        <section class="overflow-hidden border-y border-brand-border/60 bg-white py-8 md:py-10" aria-label="Partner dan klien kami">
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
            <x-section-head eyebrow="Blog" title="Wawasan &amp; Cerita dari Tim Kami" description="Tulisan seputar transformasi digital, tips membangun aplikasi, dan kabar terbaru MaiHarta.">
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
                @foreach ([
                    ['check', 'Profesional', 'Bekerja dengan standar dan proses yang konsisten di setiap proyek.'],
                    ['value-collab', 'Kolaboratif', 'Melibatkan klien secara aktif dari perencanaan hingga peluncuran.'],
                    ['value-result', 'Berorientasi Hasil', 'Setiap solusi dirancang untuk memberi dampak nyata pada bisnis Anda.'],
                ] as [$icon, $valueTitle, $valueDesc])
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
