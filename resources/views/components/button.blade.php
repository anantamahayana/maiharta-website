@props([
    'variant' => 'primary', // primary | outline
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98]';
    $variants = [
        'primary' => 'bg-brand-normal text-white shadow-sm hover:bg-brand-normal-hover hover:shadow-md hover:shadow-brand-normal/30',
        'outline' => 'border border-brand-border text-brand-dark hover:bg-brand-light',
    ];
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
