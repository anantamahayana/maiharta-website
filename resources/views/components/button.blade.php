@props([
    'variant' => 'primary', // primary | outline | gradient | white | ghost
    'size' => 'md',         // sm | md | lg
    'href' => null,
    'type' => 'button',
    'icon' => null,         // heroicon name, rendered after the label
])

@php
    $base = 'group/btn inline-flex items-center justify-center gap-2 font-medium transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-normal';

    $sizes = [
        'sm' => 'rounded-lg px-4 py-2.5 text-label',
        'md' => 'rounded-lg px-6 py-3.5 text-body-sm',
        'lg' => 'rounded-full px-7 py-4 text-nav',
    ];

    $variants = [
        'primary'  => 'bg-brand-normal text-white hover:bg-brand-normal-hover hover:shadow-floating',
        'outline'  => 'border-[1.5px] border-brand-border bg-white text-brand-dark hover:border-brand-light-active hover:bg-brand-light',
        'gradient' => 'bg-button-gradient text-white shadow-floating hover:shadow-hero',
        'white'    => 'bg-white text-brand-dark hover:bg-brand-light',
        'ghost'    => 'text-brand-normal hover:text-brand-normal-hover hover:translate-y-0',
    ];

    $classes = implode(' ', [$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary']]);
    $iconSize = $size === 'lg' ? 'h-[18px] w-[18px]' : 'h-4 w-4';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
        @if ($icon)
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="{{ $iconSize }} transition-transform duration-300 group-hover/btn:translate-x-1" />
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
        @if ($icon)
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="{{ $iconSize }} transition-transform duration-300 group-hover/btn:translate-x-1" />
        @endif
    </button>
@endif
