@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'left', // left | center
    'dark' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center gap-6 text-center md:flex-row md:items-end md:justify-between md:text-left ' . ($align === 'center' ? 'md:flex-col md:items-center md:text-center' : '')]) }}>
    <div class="max-w-[720px] {{ $align === 'center' ? 'mx-auto' : 'mx-auto md:mx-0' }}">
        @if ($eyebrow)
            <p data-animate class="eyebrow {{ $dark ? 'text-brand-accent-on-dark' : '' }}">{{ $eyebrow }}</p>
        @endif
        <h2 data-animate style="--reveal-delay:0.06s" class="mt-2.5 font-heading text-h3 font-semibold md:text-h2-lg {{ $dark ? 'text-white' : 'text-brand-dark' }}">{{ $title }}</h2>
        @if ($description && $align === 'center')
            <p data-animate style="--reveal-delay:0.12s" class="mt-3 text-body-sm md:text-body {{ $dark ? 'text-brand-on-dark' : 'text-brand-muted' }}">{{ $description }}</p>
        @endif
    </div>

    @if ($description && $align !== 'center')
        <p data-animate style="--reveal-delay:0.12s" class="max-w-[400px] text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $description }}</p>
    @endif

    @if (isset($action))
        <div data-animate style="--reveal-delay:0.12s" class="shrink-0">{{ $action }}</div>
    @endif
</div>
