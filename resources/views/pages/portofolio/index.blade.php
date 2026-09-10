<x-layout title="Portofolio — MaiHarta">

    {{-- Header --}}
    <section class="mx-auto max-w-[1440px] px-5 py-16 md:px-20 md:py-24">
        <p data-animate class="text-sm font-semibold uppercase tracking-wide text-brand-normal">Portofolio</p>
        <h1 data-animate style="--reveal-delay:0.06s" class="mt-3 max-w-3xl font-heading text-3xl font-semibold text-brand-dark md:text-5xl md:leading-[1.15]">
            Karya yang Kami Kerjakan Bersama Klien
        </h1>
        <p data-animate style="--reveal-delay:0.12s" class="mt-4 max-w-2xl text-brand-dark/80">
            Dari sistem keamanan perbankan hingga portal pariwisata daerah — berikut sebagian proyek yang telah kami bangun dan kami dampingi hingga digunakan sehari-hari.
        </p>
    </section>

    {{-- Grid + Filter --}}
    <section class="pb-16 md:pb-24" x-data="{ cat: 'Semua' }">
        <div class="mx-auto max-w-[1440px] px-5 md:px-20">

            {{-- Filter --}}
            <div data-animate class="flex flex-wrap gap-2">
                @foreach ($categories as $category)
                    <button
                        type="button"
                        @click="cat = '{{ $category }}'"
                        :class="cat === '{{ $category }}'
                            ? 'bg-brand-normal text-white border-brand-normal'
                            : 'bg-white text-brand-dark border-brand-border hover:border-brand-normal/40 hover:text-brand-normal'"
                        class="rounded-full border px-4 py-2 text-[13px] font-medium transition-colors duration-200"
                    >
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            {{-- Cards --}}
            <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <article
                        x-show="cat === 'Semua' || cat === '{{ $project->category }}'"
                        x-transition.opacity.duration.300ms
                        data-animate
                        style="--reveal-delay:{{ ($loop->index % 3) * 0.08 }}s"
                        class="group flex flex-col overflow-hidden rounded-2xl border border-brand-border bg-white transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-normal/30 hover:shadow-lg hover:shadow-brand-normal/10"
                    >
                        <div class="h-[200px] w-full overflow-hidden bg-brand-light">
                            <img
                                src="{{ asset('images/projects/' . $project->slug . '.jpg') }}"
                                alt="{{ $project->name }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-start justify-between gap-3">
                                <h2 class="font-heading text-lg font-semibold leading-snug text-brand-dark">{{ $project->name }}</h2>
                                <span class="shrink-0 rounded-full bg-brand-light px-3 py-1 text-xs font-medium text-brand-dark">
                                    {{ $project->category }}
                                </span>
                            </div>

                            <p class="mt-2 text-xs font-medium uppercase tracking-wide text-brand-normal">{{ $project->client_type }}</p>
                            <p class="mt-3 flex-1 text-sm text-brand-dark/80">{{ $project->short_description }}</p>

                            <a href="{{ route('portofolio.show', $project) }}" class="mt-5 inline-flex items-center gap-1 text-[13px] font-medium text-brand-normal hover:text-brand-normal-hover">
                                Lihat Detail Proyek
                                <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-brand-light/60 py-16 text-center md:py-20">
        <div data-animate class="mx-auto max-w-2xl px-5">
            <h2 class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Punya Proyek Serupa?</h2>
            <p class="mt-3 text-brand-dark/80">Ceritakan kebutuhan Anda, kami bantu rancang solusinya dari awal hingga sistem siap digunakan.</p>
            <div class="mt-8">
                <x-button :href="route('kontak')">Mulai Diskusi</x-button>
            </div>
        </div>
    </section>

</x-layout>
