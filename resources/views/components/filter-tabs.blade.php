{{-- Alpine-driven filter pill. Expects parent x-data with `active`. --}}
@props(['items' => [], 'counts' => []])

<div {{ $attributes->merge(['class' => 'inline-flex max-w-full gap-1 overflow-x-auto rounded-full border border-brand-border bg-white p-1']) }}>
    @foreach ($items as $item)
        <button
            type="button"
            @click="active = @js($item)"
            :class="active === @js($item) ? 'bg-brand-dark text-white' : 'text-brand-dark hover:bg-brand-light'"
            class="flex shrink-0 items-center gap-2 rounded-full px-4 py-2 text-label font-medium transition-colors"
        >
            {{ $item }}
            @if (isset($counts[$item]))
                <span :class="active === @js($item) ? 'bg-brand-surface-on-dark text-white' : 'bg-brand-light text-brand-muted'" class="rounded-full px-1.5 py-px text-chip">{{ $counts[$item] }}</span>
            @endif
        </button>
    @endforeach
</div>
