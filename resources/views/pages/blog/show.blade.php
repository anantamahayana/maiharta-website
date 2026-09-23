@php
    $cats = \App\Models\Article::categories();
    $catLabel = $cats[$article->category] ?? $article->category;
    $url = route('blog.show', $article);
    $shareText = $article->title . ' — ' . $url;
@endphp

<x-layout :title="$article->title . ' — Blog MaiHarta'" :description="$article->excerpt">
    <x-slot:head>
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $article->title }}">
        <meta property="og:description" content="{{ $article->excerpt }}">
        @if ($article->cover)<meta property="og:image" content="{{ asset($article->cover) }}">@endif
        <meta property="og:url" content="{{ $url }}">
        @if ($article->published_at)<meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">@endif
        <link rel="canonical" href="{{ $url }}">
    </x-slot:head>

    @unless ($article->isLive())
        <div class="bg-amber-50 text-amber-900"><div class="container-site flex items-center gap-2 py-2 text-label"><x-heroicon-o-eye class="h-4 w-4" /> Pratinjau — artikel ini {{ $article->statusLabel() === 'Terjadwal' ? 'terjadwal tayang ' . $article->published_at->translatedFormat('d M Y, H:i') : 'masih draft' }} dan belum terlihat oleh publik.</div></div>
    @endunless

    <x-page-hero :crumbs="[['Beranda', route('home')], ['Blog', route('blog.index')], [Str::limit($article->title, 60), null]]" class="pb-0">
        <x-chip class="mb-4">{{ $catLabel }}</x-chip>
        <h1 data-animate class="font-heading text-h2 font-semibold leading-tight text-brand-dark md:text-h1">{{ $article->title }}</h1>
        <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-body">{{ $article->excerpt }}</p>
        <div data-animate class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-caption text-brand-muted">
            <span class="flex items-center gap-1.5"><x-heroicon-o-calendar class="h-4 w-4" />{{ ($article->published_at ?? $article->created_at)->translatedFormat('d F Y') }}</span>
            <span class="flex items-center gap-1.5"><x-heroicon-o-clock class="h-4 w-4" />{{ $article->readingMinutes() }} mnt baca</span>
            <span class="flex items-center gap-1.5"><x-heroicon-o-user-circle class="h-4 w-4" />{{ $article->author?->name ?? 'Tim MaiHarta' }}</span>
        </div>
    </x-page-hero>

    <article class="container-site grid grid-cols-1 gap-10 py-10 md:py-14 lg:grid-cols-[minmax(0,1fr)_340px] lg:gap-16">
        <div class="min-w-0">
            @if ($article->cover)
                <figure data-animate="scale" class="overflow-hidden rounded-panel border border-brand-border bg-brand-light-hover shadow-card">
                    <img src="{{ asset($article->cover) }}" alt="{{ $article->title }}" width="1280" height="720" fetchpriority="high" class="aspect-video w-full object-cover">
                </figure>
            @endif

            <div class="prose-brand mt-8">{!! $article->body !!}</div>

            @if ($article->tags)
                <div class="mt-8 flex flex-wrap items-center gap-2 pt-2">
                    <span class="text-caption text-brand-muted">Tag:</span>
                    @foreach ($article->tags as $tag)<x-chip variant="light">#{{ $tag }}</x-chip>@endforeach
                </div>
            @endif

            {{-- Bagikan --}}
            <div class="mt-6 flex flex-wrap items-center gap-2" x-data="{ copied: false, copy() { navigator.clipboard?.writeText(@js($url)).then(() => { this.copied = true; setTimeout(() => this.copied = false, 2000); }); } }">
                <span class="mr-1 text-label font-medium text-brand-dark">Bagikan:</span>
                <a href="https://wa.me/?text={{ rawurlencode($shareText) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-brand-border bg-white px-3.5 py-2 text-label font-medium text-brand-dark transition hover:border-[#25d366] hover:text-[#128c7e]"><x-icons.social-whatsapp class="h-4 w-4" /> WhatsApp</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode($url) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-brand-border bg-white px-3.5 py-2 text-label font-medium text-brand-dark transition hover:border-brand-normal hover:text-brand-normal">LinkedIn</a>
                <button type="button" @click="copy()" class="inline-flex items-center gap-1.5 rounded-full border border-brand-border bg-white px-3.5 py-2 text-label font-medium text-brand-dark transition hover:border-brand-normal hover:text-brand-normal">
                    <template x-if="!copied"><span class="inline-flex items-center gap-1.5"><x-heroicon-o-link class="h-4 w-4" /> Salin tautan</span></template>
                    <template x-if="copied"><span class="inline-flex items-center gap-1.5 text-success-text"><x-heroicon-o-check class="h-4 w-4" /> Tersalin</span></template>
                </button>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
            @if ($related->isNotEmpty())
                <div data-animate class="rounded-panel border border-brand-border bg-white p-5 shadow-card">
                    <p class="eyebrow">Artikel Terkait</p>
                    <ul class="mt-4 divide-y divide-brand-light">
                        @foreach ($related as $rel)
                            <li>
                                <a href="{{ route('blog.show', $rel) }}" class="group flex gap-3 py-3">
                                    <span class="h-16 w-24 shrink-0 overflow-hidden rounded-lg bg-brand-light-hover">@if ($rel->cover)<img src="{{ asset($rel->cover) }}" alt="" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">@endif</span>
                                    <span class="min-w-0">
                                        <span class="block text-chip font-medium uppercase tracking-wider text-brand-normal">{{ $cats[$rel->category] ?? $rel->category }}</span>
                                        <span class="mt-0.5 line-clamp-2 block text-label font-medium leading-snug text-brand-dark group-hover:text-brand-normal">{{ $rel->title }}</span>
                                        <span class="mt-1 block text-caption text-brand-muted">{{ $rel->readingMinutes() }} mnt baca</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('blog.index') }}" class="mt-2 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal hover:text-brand-normal-hover">Semua artikel <x-heroicon-o-arrow-right class="h-3.5 w-3.5" /></a>
                </div>
            @endif

            <div data-animate class="rounded-panel bg-brand-dark p-6 text-white">
                <p class="eyebrow text-brand-accent-on-dark">Butuh bantuan?</p>
                <h2 class="mt-2 font-heading text-h4 font-semibold">Wujudkan produk digital Anda bersama MaiHarta</h2>
                <p class="mt-2 text-body-sm text-brand-on-dark">Konsultasi awal gratis untuk memetakan kebutuhan dan solusi yang tepat.</p>
                <div class="mt-5 flex flex-col gap-2">
                    <x-button :href="route('kontak')" size="sm" icon="arrow-right">Konsultasi Gratis</x-button>
                    <x-button :href="route('layanan.index')" variant="white" size="sm">Lihat Layanan</x-button>
                </div>
            </div>
        </aside>
    </article>
</x-layout>
