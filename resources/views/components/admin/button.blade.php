@props(['variant' => 'primary', 'href' => null, 'type' => 'button', 'icon' => null, 'size' => 'md'])
@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-normal disabled:opacity-45 ' . ($size === 'sm' ? 'px-3 py-2 text-label' : 'px-4 py-2.5 text-label');
    $variants = [
        'primary' => 'bg-brand-normal text-white hover:bg-brand-normal-hover',
        'secondary' => 'border border-brand-border bg-white text-brand-dark hover:bg-brand-light',
        'danger' => 'border border-error bg-white text-error hover:bg-error hover:text-white',
        'danger-solid' => 'bg-error text-white hover:bg-red-700',
        'ghost' => 'text-brand-dark hover:bg-brand-light',
    ];
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>@if ($icon)<x-dynamic-component :component="'heroicon-o-' . $icon" class="h-4 w-4" />@endif{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>@if ($icon)<x-dynamic-component :component="'heroicon-o-' . $icon" class="h-4 w-4" />@endif{{ $slot }}</button>
@endif
