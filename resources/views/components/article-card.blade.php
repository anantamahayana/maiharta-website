@props(['article'])
@php $cats = \App\Models\Article::categories(); @endphp
<x-card {{ $attributes }} :href="route('blog.show', $article)" padding="p-0" class="flex h-full flex-col overflow-hidden">
    <div class="aspect-video w-full overflow-hidden bg-brand-light-hover">
        @if ($article->cover)
            <img src="{{ asset($article->cover) }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-normal to-brand-dark"><x-heroicon-o-newspaper class="h-10 w-10 text-white/60" /></div>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5 md:p-6">
        <x-chip class="self-start">{{ $cats[$article->category] ?? $article->category }}</x-chip>
        <h3 class="mt-3 line-clamp-2 font-heading text-h4 font-medium leading-snug text-brand-dark">{{ $article->title }}</h3>
        <p class="mt-2 line-clamp-3 text-body-sm text-brand-muted">{{ $article->excerpt }}</p>
        <div class="mt-auto flex items-center justify-between gap-3 pt-4 text-caption text-brand-muted">
            <span class="flex items-center gap-3"><span class="flex items-center gap-1"><x-heroicon-o-calendar class="h-3.5 w-3.5" />{{ $article->published_at->translatedFormat('d M Y') }}</span><span class="flex items-center gap-1"><x-heroicon-o-clock class="h-3.5 w-3.5" />{{ $article->readingMinutes() }} mnt</span></span>
            <span class="inline-flex items-center gap-1 text-label font-medium text-brand-normal">Baca <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" /></span>
        </div>
    </div>
</x-card>
