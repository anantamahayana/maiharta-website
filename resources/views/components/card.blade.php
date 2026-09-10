@props([
    'href' => null,
    'padding' => 'p-7',
    'interactive' => true,
])

@php
    $classes = 'block rounded-card border border-brand-border bg-white shadow-card ' . $padding;
    if ($interactive) {
        $classes .= ' transition-all duration-300 hover:-translate-y-1 hover:border-brand-light-active hover:shadow-elevated';
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'group ' . $classes]) }}>{{ $slot }}</a>
@else
    <div {{ $attributes->merge(['class' => 'group ' . $classes]) }}>{{ $slot }}</div>
@endif
