<x-layout :title="$project->name . ' — MaiHarta'">

    {{-- Header --}}
    <section class="mx-auto max-w-[1440px] px-5 pt-10 md:px-20 md:pt-14">
        <a href="{{ route('portofolio.index') }}" class="group inline-flex items-center gap-1.5 text-sm font-medium text-brand-normal hover:text-brand-normal-hover">
            <x-icons.arrow-right class="h-3.5 w-3.5 rotate-180 transition-transform duration-300 group-hover:-translate-x-1" />
            Kembali ke Portofolio
        </a>

        <div class="mt-8 flex flex-wrap items-center gap-2">
            <span data-animate class="rounded-full bg-brand-light px-3 py-1 text-xs font-medium text-brand-dark">{{ $project->category }}</span>
            <span data-animate style="--reveal-delay:0.04s" class="rounded-full border border-brand-border px-3 py-1 text-xs font-medium text-brand-dark/80">{{ $project->client_type }}</span>
        </div>

        <h1 data-animate style="--reveal-delay:0.08s" class="mt-4 max-w-4xl font-heading text-3xl font-semibold text-brand-dark md:text-[44px] md:leading-[1.15]">
            {{ $project->name }}
        </h1>
        <p data-animate style="--reveal-delay:0.14s" class="mt-4 max-w-2xl text-brand-dark/80">{{ $project->short_description }}</p>
    </section>

    {{-- Cover --}}
    <section class="mx-auto max-w-[1440px] px-5 pt-10 md:px-20 md:pt-12">
        <div data-animate class="overflow-hidden rounded-2xl border border-brand-border bg-brand-light">
            <img
                src="{{ asset('images/projects/' . $project->slug . '.jpg') }}"
                alt="{{ $project->name }}"
                class="h-[240px] w-full object-cover md:h-[420px]"
            >
        </div>
    </section>

    {{-- Stats --}}
    @if (!empty($project->outcome_stats))
        <section class="mx-auto max-w-[1440px] px-5 pt-12 md:px-20 md:pt-16">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach ($project->outcome_stats as $stat)
                    <div data-animate style="--reveal-delay:{{ $loop->index * 0.08 }}s" class="rounded-2xl border border-brand-border bg-white p-6">
                        <p class="font-heading text-3xl font-semibold text-brand-normal">{{ $stat['value'] }}</p>
                        <p class="mt-2 text-sm text-brand-dark/80">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Narrative --}}
    <section class="mx-auto max-w-[1440px] px-5 py-16 md:px-20 md:py-24">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-[1fr_360px]">

            <div class="space-y-12">
                <div data-animate>
                    <h2 class="font-heading text-xl font-semibold text-brand-dark md:text-2xl">Tentang Proyek</h2>
                    <p class="mt-4 leading-relaxed text-brand-dark/80">{{ $project->description }}</p>
                </div>

                @if ($project->challenge)
                    <div data-animate>
                        <h2 class="font-heading text-xl font-semibold text-brand-dark md:text-2xl">Tantangan</h2>
                        <p class="mt-4 leading-relaxed text-brand-dark/80">{{ $project->challenge }}</p>
                    </div>
                @endif

                @if ($project->solution)
                    <div data-animate>
                        <h2 class="font-heading text-xl font-semibold text-brand-dark md:text-2xl">Solusi Kami</h2>
                        <p class="mt-4 leading-relaxed text-brand-dark/80">{{ $project->solution }}</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside data-animate style="--reveal-delay:0.1s" class="h-fit rounded-2xl border border-brand-border bg-brand-light/40 p-7 lg:sticky lg:top-28">
                <h3 class="font-heading text-base font-semibold text-brand-dark">Ringkasan Teknis</h3>
                <p class="mt-3 text-sm leading-relaxed text-brand-dark/80">{{ $project->tech_summary }}</p>

                @if ($project->service)
                    <div class="mt-6 border-t border-brand-border pt-6">
                        <p class="text-xs font-medium uppercase tracking-wide text-brand-dark/60">Layanan Terkait</p>
                        <a href="{{ route('layanan.show', $project->service) }}" class="group mt-2 inline-flex items-center gap-1 text-sm font-medium text-brand-normal hover:text-brand-normal-hover">
                            {{ $project->service->name }}
                            <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                        </a>
                    </div>
                @endif

                <div class="mt-6 border-t border-brand-border pt-6">
                    <x-button :href="route('kontak')" class="w-full justify-center">Diskusikan Proyek Anda</x-button>
                </div>
            </aside>
        </div>
    </section>

    {{-- Proyek lainnya --}}
    @if ($otherProjects->isNotEmpty())
        <section class="bg-brand-light/50 py-16 md:py-24">
            <div class="mx-auto max-w-[1440px] px-5 md:px-20">
                <h2 data-animate class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Proyek Lainnya</h2>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($otherProjects as $other)
                        <a
                            href="{{ route('portofolio.show', $other) }}"
                            data-animate
                            style="--reveal-delay:{{ $loop->index * 0.08 }}s"
                            class="group overflow-hidden rounded-2xl border border-brand-border bg-white transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-normal/30 hover:shadow-lg hover:shadow-brand-normal/10"
                        >
                            <div class="h-[160px] w-full overflow-hidden bg-brand-light">
                                <img
                                    src="{{ asset('images/projects/' . $other->slug . '.jpg') }}"
                                    alt="{{ $other->name }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                >
                            </div>
                            <div class="p-6">
                                <p class="text-xs font-medium uppercase tracking-wide text-brand-normal">{{ $other->category }}</p>
                                <h3 class="mt-2 font-heading text-base font-semibold leading-snug text-brand-dark">{{ $other->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layout>
