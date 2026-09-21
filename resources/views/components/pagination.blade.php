@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="inline-flex items-center gap-1 rounded-full border border-brand-border bg-white p-1">
        @if ($paginator->onFirstPage())
            <span class="flex h-9 w-9 items-center justify-center rounded-full text-brand-placeholder"><x-heroicon-o-chevron-left class="h-4 w-4" /></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex h-9 w-9 items-center justify-center rounded-full text-brand-dark hover:bg-brand-light" aria-label="Sebelumnya"><x-heroicon-o-chevron-left class="h-4 w-4" /></a>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))<span class="px-2 text-brand-muted">…</span>@endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="flex h-9 min-w-9 items-center justify-center rounded-full bg-brand-dark px-3 text-label font-medium text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="flex h-9 min-w-9 items-center justify-center rounded-full px-3 text-label font-medium text-brand-dark hover:bg-brand-light">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex h-9 w-9 items-center justify-center rounded-full text-brand-dark hover:bg-brand-light" aria-label="Berikutnya"><x-heroicon-o-chevron-right class="h-4 w-4" /></a>
        @else
            <span class="flex h-9 w-9 items-center justify-center rounded-full text-brand-placeholder"><x-heroicon-o-chevron-right class="h-4 w-4" /></span>
        @endif
    </nav>
@endif
