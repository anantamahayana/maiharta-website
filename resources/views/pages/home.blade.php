<x-layout title="MaiHarta — Ngga Ada Habisnya">

    {{-- Hero --}}
    <section class="mx-auto max-w-[1440px] px-5 py-16 md:px-20 md:py-24">
        <div class="grid grid-cols-1 items-center gap-12 md:grid-cols-2">
            <div>
                <span data-animate class="inline-flex items-center rounded-full bg-brand-light px-3.5 py-2 text-[13px] font-medium text-brand-dark">
                    Bersertifikasi ISO/IEC 27001
                </span>

                <h1 data-animate style="--reveal-delay:0.08s" class="mt-6 font-heading text-5xl font-semibold text-brand-dark md:text-[72px] md:leading-[1.05]">MaiHarta</h1>
                <p data-animate style="--reveal-delay:0.14s" class="mt-1 font-heading text-2xl font-semibold text-brand-normal md:text-[40px] md:leading-[1.1]">Ngga Ada Habisnya</p>

                <p data-animate style="--reveal-delay:0.2s" class="mt-6 max-w-lg text-brand-dark/90">
                    MAIHARTA merupakan sebuah perusahaan yang bergerak di bidang IT dengan produknya berupa Jasa dan Produk Digital. Kami adalah tempat yang tepat bagi Anda untuk mendapatkan solusi lengkap untuk membantu bisnis Anda berkembang dengan cepat.
                </p>

                <div data-animate style="--reveal-delay:0.26s" class="mt-8 flex flex-wrap items-center gap-6">
                    <x-button :href="route('kontak')">Kontak Kami</x-button>
                    <a href="{{ route('portofolio.index') }}" class="group text-sm font-semibold text-brand-dark transition-colors hover:text-brand-normal">
                        Lihat Portofolio
                        <span class="inline-block transition-transform group-hover:translate-x-1">→</span>
                    </a>
                </div>

                <div data-animate style="--reveal-delay:0.32s" class="mt-10 flex flex-wrap gap-10">
                    <div>
                        <p class="font-heading text-2xl font-medium text-brand-dark">8+</p>
                        <p class="mt-1 text-xs text-brand-dark/70">Tahun Berkarya</p>
                    </div>
                    <div>
                        <p class="font-heading text-2xl font-medium text-brand-dark">199+</p>
                        <p class="mt-1 text-xs text-brand-dark/70">Proyek Selesai</p>
                    </div>
                    <div>
                        <p class="font-heading text-2xl font-medium text-brand-dark">40+</p>
                        <p class="mt-1 text-xs text-brand-dark/70">Instansi Terlayani</p>
                    </div>
                </div>
            </div>

            {{-- Layered visual: accent block + 2 overlapping photo cards --}}
            <div data-animate style="--reveal-delay:0.15s" class="relative mx-auto hidden h-[420px] w-full max-w-[480px] md:block">
                <div style="--float-rotate:-10deg" class="animate-float-slow absolute right-4 top-2 h-[300px] w-[300px] -rotate-[10deg] rounded-[28px] bg-brand-normal"></div>
                <div class="absolute left-0 top-[70px] h-[220px] w-[260px] rotate-[9deg] overflow-hidden rounded-[20px] shadow-xl transition-transform duration-500 hover:-translate-y-1.5 hover:rotate-[6deg]">
                    <img src="{{ asset('images/hero-dashboard.jpg') }}" alt="Dashboard analitik" class="h-full w-full object-cover">
                </div>
                <div class="absolute left-[70px] top-[130px] h-[260px] w-[300px] -rotate-[5deg] overflow-hidden rounded-[24px] shadow-xl transition-transform duration-500 hover:-translate-y-1.5 hover:rotate-[-2deg]">
                    <img src="{{ asset('images/hero-team.jpg') }}" alt="Tim MaiHarta bekerja" class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- Solusi Kita --}}
    <section class="bg-brand-light/40 py-16 md:py-24">
        <div class="mx-auto max-w-[1440px] px-5 md:px-20">
            <h2 data-animate class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Solusi Kita</h2>
            <p data-animate style="--reveal-delay:0.06s" class="mt-2 text-brand-dark/80">Solusi digital yang disesuaikan dengan kebutuhan bisnis Anda.</p>

            <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($services as $service)
                    <div
                        data-animate
                        style="--reveal-delay:{{ 0.1 + $loop->index * 0.08 }}s"
                        class="group rounded-2xl border border-brand-border bg-white p-7 transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-normal/30 hover:shadow-lg hover:shadow-brand-normal/10"
                    >
                        <div class="flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-brand-light transition-colors duration-300 group-hover:bg-brand-normal/15">
                            @if ($service->icon === 'code')
                                <x-icons.service-code class="h-6 w-6" />
                            @elseif ($service->icon === 'palette')
                                <x-icons.service-palette class="h-6 w-6" />
                            @else
                                <x-icons.service-megaphone class="h-6 w-6" />
                            @endif
                        </div>

                        <h3 class="mt-6 font-heading text-lg font-medium text-brand-dark">{{ $service->name }}</h3>
                        <p class="mt-3 text-sm text-brand-dark/80">{{ $service->short_description }}</p>

                        <a href="{{ route('layanan.show', $service) }}" class="mt-6 inline-flex items-center gap-1 text-[13px] font-medium text-brand-normal hover:text-brand-normal-hover">
                            Pelajari Lebih Lanjut
                            <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Portofolio --}}
    <section class="py-16 md:py-24">
        <div class="mx-auto max-w-[1440px] px-5 md:px-20">
            <div data-animate class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Portofolio</h2>
                    <p class="mt-2 text-brand-dark/80">Sebagian proyek yang telah kami kerjakan bersama klien dari berbagai industri.</p>
                </div>
                <a href="{{ route('portofolio.index') }}" class="group inline-flex items-center gap-1.5 text-sm font-semibold text-brand-normal hover:text-brand-normal-hover">
                    Lihat Semua Proyek
                    <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                </a>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($projects as $project)
                    <div
                        data-animate
                        style="--reveal-delay:{{ $loop->index * 0.08 }}s"
                        class="group overflow-hidden rounded-2xl border border-brand-border transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-normal/30 hover:shadow-lg hover:shadow-brand-normal/10"
                    >
                        <div class="h-[200px] w-full overflow-hidden bg-brand-light">
                            <img
                                src="{{ asset('images/projects/' . $project->slug . '.jpg') }}"
                                alt="{{ $project->name }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="font-heading text-lg font-semibold text-brand-dark">{{ $project->name }}</h3>
                                <span class="shrink-0 rounded-full bg-brand-light px-3 py-1 text-xs font-medium text-brand-dark">
                                    {{ $project->category }}
                                </span>
                            </div>
                            <p class="mt-4 text-sm text-brand-dark/80">{{ $project->short_description }}</p>
                            <a href="{{ route('portofolio.show', $project) }}" class="mt-5 inline-flex items-center gap-1 text-[13px] font-medium text-brand-normal hover:text-brand-normal-hover">
                                Kunjungi Proyek
                                <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Sertifikasi --}}
    <section class="bg-brand-darker py-16 text-white md:py-24">
        <div class="mx-auto grid max-w-[1440px] grid-cols-1 items-center gap-12 px-5 md:grid-cols-2 md:px-20">
            <div data-animate>
                <p class="text-sm font-semibold uppercase tracking-wide text-brand-normal">Kredibilitas &amp; Keamanan</p>
                <h2 class="mt-4 font-heading text-2xl font-semibold md:text-[30px]">Standar Keamanan yang Terjamin</h2>
                <p class="mt-4 max-w-md text-white/70">
                    Kami mengikuti standar keamanan informasi internasional ISO/IEC 27001 untuk memastikan data dan sistem klien kami terlindungi di setiap tahap kerja sama.
                </p>

                <ul class="mt-8 space-y-4">
                    <li class="flex items-center gap-3">
                        <x-icons.check class="h-[18px] w-[18px] shrink-0" />
                        <span class="text-sm text-white/90">Perlindungan data terenkripsi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icons.check class="h-[18px] w-[18px] shrink-0" />
                        <span class="text-sm text-white/90">Akses sistem yang terkontrol</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <x-icons.check class="h-[18px] w-[18px] shrink-0" />
                        <span class="text-sm text-white/90">Penilaian risiko berkala</span>
                    </li>
                </ul>
            </div>

            <div data-animate style="--reveal-delay:0.12s" class="rounded-2xl bg-white/5 p-10 text-center transition-transform duration-300 hover:-translate-y-1">
                <x-icons.shield class="mx-auto h-12 w-12" />
                <h3 class="mt-4 font-heading text-xl font-semibold">ISO/IEC 27001</h3>
                <p class="mt-1 text-sm text-white/60">Information Security Management</p>
            </div>
        </div>
    </section>

    {{-- Tentang --}}
    <section class="py-16 md:py-24">
        <div class="mx-auto grid max-w-[1440px] grid-cols-1 gap-12 px-5 md:grid-cols-2 md:px-20">
            <div data-animate>
                <p class="text-sm font-medium text-brand-normal">TENTANG MAIHARTA</p>
                <h2 class="mt-3 font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Mitra Transformasi Digital Bisnis Anda</h2>
                <p class="mt-4 text-brand-dark/80">
                    Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem.
                </p>
            </div>

            <div class="space-y-6">
                <div data-animate style="--reveal-delay:0.06s" class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light">
                        <x-icons.check class="h-5 w-5" />
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-brand-dark">Profesional</h3>
                        <p class="mt-1 text-sm text-brand-dark/80">Bekerja dengan standar dan proses yang konsisten di setiap proyek.</p>
                    </div>
                </div>
                <div data-animate style="--reveal-delay:0.12s" class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light">
                        <x-icons.value-collab class="h-5 w-5" />
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-brand-dark">Kolaboratif</h3>
                        <p class="mt-1 text-sm text-brand-dark/80">Melibatkan klien secara aktif dari perencanaan hingga peluncuran.</p>
                    </div>
                </div>
                <div data-animate style="--reveal-delay:0.18s" class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light">
                        <x-icons.value-result class="h-5 w-5" />
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-brand-dark">Berorientasi Hasil</h3>
                        <p class="mt-1 text-sm text-brand-dark/80">Setiap solusi dirancang untuk memberi dampak nyata pada bisnis Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Akhir --}}
    <section class="bg-brand-light/60 py-16 text-center md:py-20">
        <div data-animate class="mx-auto max-w-2xl px-5">
            <h2 class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Siap Membangun Produk Digital Anda?</h2>
            <p class="mt-3 text-brand-dark/80">Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menemukan solusi digital yang tepat.</p>
            <div class="mt-8">
                <x-button :href="route('kontak')">Hubungi Kami Sekarang</x-button>
            </div>
        </div>
    </section>

</x-layout>
