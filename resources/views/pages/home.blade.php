@php $h = site('beranda.hero'); $st = site('umum.stats'); $sol = site('beranda.solusi'); $pf = site('beranda.portofolio'); $sf = site('beranda.sertifikasi'); $tt = site('beranda.tentang'); $cta = site('beranda.cta'); $values = site('tentang.nilai.items'); $valueIcons = ['check', 'value-collab', 'value-result']; @endphp
<x-layout title="MaiHarta — Ngga Ada Habisnya">

    {{-- ============================================================ Hero --}}
    <section class="bg-hero-gradient overflow-hidden">
        <div class="container-site grid grid-cols-1 items-center gap-12 py-12 md:py-16 lg:grid-cols-[1fr_600px] lg:gap-12 lg:py-20">

            {{-- Left: copy --}}
            <div data-animate-group="0.07" class="max-w-[680px]">
                <span data-animate class="inline-flex items-center gap-2 rounded-full border border-brand-border bg-white py-1.5 pl-1.5 pr-3.5 text-label font-medium text-brand-dark">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-light">
                        <x-heroicon-o-shield-check class="h-3.5 w-3.5 text-brand-normal" />
                    </span>
                    {{ $h['badge'] }}
                </span>

                <h1 class="mt-6 font-heading font-semibold text-brand-dark">
                    <span data-animate class="text-gradient-brand animate-shimmer block text-h2-lg md:text-[56px] md:leading-[64px] xl:text-display-sm xl:whitespace-nowrap">{{ $h['headline_gradient'] }}</span>
                    <span data-animate class="block text-h2-lg md:text-[56px] md:leading-[64px] xl:text-display-sm">{{ $h['headline'] }}</span>
                </h1>

                <p data-animate class="mt-6 max-w-[620px] text-body-sm text-brand-muted md:text-body">
                    {{ $h['description'] }}
                </p>

                <div data-animate class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <x-button :href="route('kontak')" variant="gradient" size="lg" icon="arrow-right">{{ $h['primary'] }}</x-button>
                    <x-button :href="route('portofolio.index')" variant="outline" size="lg">{{ $h['secondary'] }}</x-button>
                </div>

                <ul data-animate class="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-caption text-brand-muted">
                    @foreach ($h['bullets'] as $b)
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-brand-normal"></span>{{ $b['text'] }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Right: floating product-card composition (layers mirror the Figma "Float → …" names) --}}
            <div data-animate-group="0.09" class="relative mx-auto h-[360px] w-full max-w-[362px] lg:h-[600px] lg:max-w-none">
                <div class="animate-glow absolute left-[14%] top-[6%] h-[75%] w-[72%] rounded-full bg-brand-normal/10 blur-3xl"></div>

                {{-- Float → Dashboard Card --}}
                <div data-animate="scale" style="--float-dur:5s" class="animate-float absolute left-[28%] top-[8%] w-[72%] rounded-card bg-brand-dark p-4 text-white shadow-hero lg:left-[33%] lg:top-[12%] lg:w-[340px] lg:rounded-[18px] lg:p-5">
                    <div class="flex items-center gap-2">
                        <div class="flex-1">
                            <p class="text-label font-medium lg:text-h5">{{ $h['card_title'] }}</p>
                            <p class="text-caption text-brand-on-dark">Semua klien · {{ date('Y') }}</p>
                        </div>
                        <x-chip variant="on-dark"><span class="h-1.5 w-1.5 rounded-full bg-success"></span>Live</x-chip>
                    </div>
                    <div class="mt-3 flex gap-4 lg:mt-4 lg:gap-5">
                        <x-stat :value="rtrim($st['projects'], '+')" :suffix="str_ends_with($st['projects'], '+') ? '+' : ''" label="Proyek selesai" dark />
                        <x-stat :value="rtrim($st['clients'], '+')" :suffix="str_ends_with($st['clients'], '+') ? '+' : ''" label="Instansi" dark />
                        <x-stat :value="rtrim($st['years'], '+')" :suffix="str_ends_with($st['years'], '+') ? '+' : ''" label="Tahun" dark />
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
                    <img src="{{ asset('images/hero-team.jpg') }}" alt="Tim MaiHarta" class="aspect-[18/13] w-full object-cover">
                </div>

                {{-- Float → ISO Badge --}}
                <div data-animate="scale" style="--float-dur:4.5s;--float-delay:1.1s" class="animate-float absolute right-0 top-0 flex items-center gap-2.5 rounded-xl bg-white p-2.5 pr-4 shadow-floating lg:right-[10px] lg:top-[1%] lg:rounded-[14px] lg:p-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-light lg:h-9 lg:w-9"><x-heroicon-o-shield-check class="h-5 w-5 text-brand-normal" /></span>
                    <span>
                        <span class="block text-label font-semibold text-brand-dark lg:text-body-sm">ISO/IEC 27001</span>
                        <span class="block text-caption text-brand-muted">Keamanan informasi tersertifikasi</span>
                    </span>
                </div>

                {{-- Float → Sparkle Node + Connector Line --}}
                <div data-animate="scale" style="--float-dur:4s;--float-delay:0.3s" class="animate-float absolute left-[12%] top-[52%] flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-floating lg:left-[15%] lg:top-[45%] lg:h-10 lg:w-10">
                    <x-heroicon-o-sparkles class="h-4 w-4 text-brand-normal lg:h-5 lg:w-5" />
                </div>
                <svg class="animate-draw absolute left-[20%] top-[56%] hidden h-[60px] w-[120px] lg:left-[20%] lg:top-[49%] lg:block" viewBox="0 0 120 60" fill="none" aria-hidden="true">
                    <path d="M0 0C40 0 60 60 120 60" stroke="#0aa1dd" stroke-width="1.5" stroke-dasharray="4 4" />
                </svg>

                {{-- Float → Helpdesk Bubble --}}
                <div data-animate="scale" style="--float-dur:5.5s;--float-delay:0.9s" class="animate-float absolute bottom-0 left-[8%] z-10 w-[84%] rounded-[14px] bg-white p-3.5 shadow-hero lg:bottom-[20%] lg:left-[33%] lg:w-[330px] lg:rounded-card lg:p-4">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-light-hover text-chip font-medium text-brand-dark">NS</span>
                        <span class="flex-1">
                            <span class="block text-label font-medium text-brand-dark">{{ $h['bubble_title'] }}</span>
                            <span class="block text-caption text-brand-muted">{{ $h['bubble_sub'] }}</span>
                        </span>
                        <x-chip variant="success"><x-heroicon-o-check class="h-3 w-3" />Selesai · SLA</x-chip>
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
                    <img src="{{ asset('images/hero-dashboard.jpg') }}" alt="Dashboard analitik" class="aspect-[18/13] w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================== Solusi Kita --}}
    <section class="container-site py-16 md:py-20">
        <x-section-head :eyebrow="$sol['eyebrow']" :title="$sol['title']" :description="$sol['description']">
            <x-slot:action><x-button :href="route('layanan.index')" variant="outline" size="sm" icon="arrow-right">Semua Layanan</x-button></x-slot:action>
        </x-section-head>

        <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
            @foreach ($services as $service)
                @php $tags = collect($service->tech_tags ?? [])->take(3); @endphp
                <x-card data-animate :href="route('layanan.show', $service)" padding="p-6 md:p-7">
                    <div class="flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-brand-light transition-colors duration-300 group-hover:bg-brand-light-hover">
                        @if ($service->icon === 'code') <x-icons.service-code class="h-6 w-6" />
                        @elseif ($service->icon === 'palette') <x-icons.service-palette class="h-6 w-6" />
                        @else <x-icons.service-megaphone class="h-6 w-6" /> @endif
                    </div>
                    <h3 class="mt-5 font-heading text-h4 font-medium text-brand-dark md:text-[20px] md:leading-7">{{ $service->name }}</h3>
                    <p class="mt-3 text-body-sm text-brand-muted">{{ $service->short_description }}</p>
                    @if ($tags->isNotEmpty())
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach ($tags as $tag) <x-chip>{{ $tag }}</x-chip> @endforeach
                        </div>
                    @endif
                    <span class="mt-5 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">
                        Pelajari Lebih Lanjut <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                    </span>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- ====================================================== Portofolio --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site">
            <x-section-head :eyebrow="$pf['eyebrow']" :title="$pf['title']">
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

    {{-- ===================================================== Sertifikasi --}}
    <section class="container-site grid grid-cols-1 items-center gap-10 py-16 md:py-20 lg:grid-cols-[1fr_520px] lg:gap-16">
        <div data-animate-group="0.07">
            <p data-animate class="overline">{{ $sf['eyebrow'] }}</p>
            <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-h2-lg">{{ $sf['title'] }}</h2>
            <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $sf['description'] }}</p>
            <ul class="mt-6 space-y-3">
                @foreach ($sf['points'] as $pt)
                    <li data-animate class="flex items-start gap-3.5 rounded-xl bg-brand-light px-4 py-3.5">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-normal"><x-heroicon-o-check class="h-3.5 w-3.5 text-white" /></span>
                        <span>
                            <span class="block text-[15px] font-medium leading-[22px] text-brand-dark">{{ $pt['title'] }}</span>
                            <span class="block text-label text-brand-muted">{{ $pt['description'] }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div data-animate="scale" class="flex flex-col items-center rounded-panel bg-brand-dark px-8 py-10 text-center text-white md:px-12 md:py-12">
            <span class="flex h-28 w-28 items-center justify-center rounded-full border border-brand-border-on-dark bg-brand-surface-on-dark">
                <x-icons.shield class="h-12 w-12" />
            </span>
            <p class="mt-5 font-heading text-h3 font-semibold md:text-[26px] md:leading-[34px]">{{ $sf['panel_title'] }}</p>
            <p class="mt-1 text-body-sm text-brand-on-dark">{{ $sf['panel_sub'] }}</p>
            <div class="mt-5 flex flex-wrap justify-center gap-2">
                @foreach (site_list('beranda.sertifikasi.panel_tags') as $tag)
                    <x-chip variant="on-dark" class="text-label-sm">{{ $tag }}</x-chip>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========================================================= Tentang --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site grid grid-cols-1 items-center gap-10 lg:grid-cols-[1fr_560px] lg:gap-16">
            <div data-animate-group="0.07">
                <p data-animate class="overline">{{ $tt['eyebrow'] }}</p>
                <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-h2-lg">{{ $tt['title'] }}</h2>
                <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $tt['description'] }}</p>
                <div data-animate class="mt-6"><x-button :href="route('tentang')" icon="arrow-right">{{ $tt['button'] }}</x-button></div>
            </div>

            <div data-animate-group class="space-y-3.5">
                @foreach (array_slice($values, 0, 3) as $vi => $v)
                    @php $icon = $valueIcons[$vi] ?? 'check'; @endphp
                    <div data-animate class="flex items-center gap-4 rounded-[14px] border border-brand-border bg-white px-5 py-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light text-brand-normal">
                            <x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" />
                        </span>
                        <span>
                            <span class="block font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $v['title'] }}</span>
                            <span class="block text-body-sm text-brand-muted">{{ $v['description'] }}</span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================= CTA --}}
    <div class="bg-brand-light">
        <x-cta-panel
            :eyebrow="$cta['eyebrow']"
            :title="$cta['title']"
            :description="$cta['description']"
            :primary-label="$cta['primary']"
            :primary-href="route('kontak')"
            :secondary-label="$cta['secondary']"
            :secondary-href="route('layanan.index')"
        />
    </div>

</x-layout>
