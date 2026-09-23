@php
    // Kartu unggulan dihitung sebagai item pertama hanya pada tampilan "Semua"
    $extra = ($featured && ! $category) ? 1 : 0;
    $total = $articles->total() + $extra;
    $from = $articles->firstItem() ? $articles->firstItem() + ($articles->currentPage() === 1 ? 0 : $extra) : ($extra ?: 0);
    $to = ($articles->lastItem() ?? 0) + $extra;
    $rangeText = $total ? "Menampilkan {$from}–{$to} dari {$total} artikel" : 'Belum ada artikel';
@endphp

<x-layout title="Blog — MaiHarta" description="Wawasan transformasi digital, tips membangun aplikasi, studi kasus, dan kabar terbaru dari tim MaiHarta.">

    <x-page-hero
        eyebrow="MaiHarta Insights"
        title="Wawasan Digital untuk Bisnis & Instansi"
        description="Perspektif tim kami tentang transformasi digital, praktik membangun aplikasi yang aman, dan cerita di balik proyek yang kami kerjakan."
        :stats="[[$counts['semua'], 'Artikel'], [count($categories), 'Kategori'], [site('umum.stats.years'), 'Tahun Berkarya']]"
    >
        <x-slot:footer>
            <div class="flex flex-wrap items-center justify-between gap-4">
                {{-- Filter kategori: tautan (bukan Alpine) agar bisa dibagikan & dipaginasi --}}
                <nav class="inline-flex max-w-full gap-1 overflow-x-auto rounded-full border border-brand-border bg-white p-1" aria-label="Kategori artikel">
                    @foreach (['' => 'Semua'] + $categories as $key => $label)
                        @php $n = $counts[$key ?: 'semua'] ?? 0; $isActive = ($category ?? '') === $key; @endphp
                        <a href="{{ route('blog.index', $key ? ['kategori' => $key] : []) }}" @class(['flex shrink-0 items-center gap-2 rounded-full px-4 py-2 text-label font-medium transition-colors', 'bg-brand-dark text-white' => $isActive, 'text-brand-dark hover:bg-brand-light' => ! $isActive])>
                            {{ $label }}<span @class(['rounded-full px-1.5 py-px text-chip', 'bg-brand-surface-on-dark text-white' => $isActive, 'bg-brand-light text-brand-muted' => ! $isActive])>{{ $n }}</span>
                        </a>
                    @endforeach
                </nav>
                <span class="text-caption text-brand-muted">{{ $rangeText }}</span>
            </div>
        </x-slot:footer>
    </x-page-hero>

    <section class="container-site pt-6 pb-12 md:pt-8 md:pb-16">
        {{-- Unggulan (hanya di tampilan "Semua", halaman 1) --}}
        @if ($featured && ! $category && $articles->currentPage() === 1)
            <a href="{{ route('blog.show', $featured) }}" data-animate="scale" class="group grid overflow-hidden rounded-panel border border-brand-border bg-white shadow-card transition-shadow hover:shadow-elevated lg:grid-cols-[1.25fr_1fr]">
                <div class="aspect-video overflow-hidden bg-brand-light-hover lg:aspect-auto lg:min-h-[340px]">
                    @if ($featured->cover)<img src="{{ asset($featured->cover) }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">@endif
                </div>
                <div class="flex flex-col p-7 md:p-10">
                    <div class="flex flex-wrap gap-2">
                        <x-chip variant="accent"><x-heroicon-s-star class="h-3 w-3" /> Pilihan</x-chip>
                        <x-chip>{{ $categories[$featured->category] ?? $featured->category }}</x-chip>
                    </div>
                    <h2 class="mt-4 font-heading text-h3 font-semibold leading-snug text-brand-dark md:text-h2">{{ $featured->title }}</h2>
                    <p class="mt-3 line-clamp-3 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $featured->excerpt }}</p>
                    <div class="mt-auto flex flex-wrap items-center justify-between gap-3 pt-6 text-caption text-brand-muted">
                        <span class="flex items-center gap-3"><span class="flex items-center gap-1"><x-heroicon-o-calendar class="h-3.5 w-3.5" />{{ $featured->published_at->translatedFormat('d F Y') }}</span><span class="flex items-center gap-1"><x-heroicon-o-clock class="h-3.5 w-3.5" />{{ $featured->readingMinutes() }} mnt baca</span></span>
                        <span class="inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">Baca artikel <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" /></span>
                    </div>
                </div>
            </a>
        @endif

        @if ($articles->isEmpty() && ! ($featured && ! $category))
            <div data-animate class="rounded-panel border border-dashed border-brand-border bg-brand-light/50 px-6 py-16 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white shadow-card"><x-heroicon-o-newspaper class="h-6 w-6 text-brand-normal" /></span>
                <h2 class="mt-4 font-heading text-h4 font-medium text-brand-dark">Belum ada artikel{{ $category ? ' di kategori ini' : '' }}</h2>
                <p class="mt-1 text-body-sm text-brand-muted">Nantikan tulisan terbaru dari tim MaiHarta.</p>
                @if ($category)<div class="mt-5"><x-button :href="route('blog.index')" variant="outline" size="sm">Lihat semua artikel</x-button></div>@endif
            </div>
        @else
            <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article-card data-animate :article="$article" />
                @endforeach
            </div>
            @if ($articles->hasPages())
                <div class="mt-10 flex justify-center">{{ $articles->links('components.pagination') }}</div>
            @endif
        @endif
    </section>

    <x-cta-panel eyebrow="Punya kebutuhan digital?" title="Diskusikan Ide Anda dengan Tim MaiHarta" description="Konsultasi awal gratis — kami bantu petakan kebutuhan dan solusinya." primary-label="Konsultasi Gratis" :primary-href="route('kontak')" secondary-label="Lihat Layanan" :secondary-href="route('layanan.index')" />
</x-layout>
