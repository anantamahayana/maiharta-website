@props(['icon' => 'magnifying-glass', 'title', 'description' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center rounded-card border border-dashed border-brand-border bg-white px-6 py-14 text-center']) }}>
    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-light">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-7 w-7 text-brand-normal" />
    </span>
    <p class="mt-5 font-heading text-h4 font-medium text-brand-dark">{{ $title }}</p>
    @if ($description)<p class="mt-2 max-w-[400px] text-body-sm text-brand-muted">{{ $description }}</p>@endif
    @if ($slot->isNotEmpty())<div class="mt-6">{{ $slot }}</div>@endif
</div>
