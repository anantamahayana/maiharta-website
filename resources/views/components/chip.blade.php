@props(['variant' => 'light']) {{-- light | outline | accent | success | error | on-dark --}}

@php
    $variants = [
        'light'   => 'bg-brand-light-hover text-brand-dark',
        'outline' => 'border border-brand-border bg-white text-brand-dark',
        'accent'  => 'bg-brand-normal text-white',
        'success' => 'bg-success-bg text-success-text',
        'error'   => 'bg-error-bg text-error',
        'on-dark' => 'border border-brand-border-on-dark bg-brand-surface-on-dark text-white',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-chip font-medium whitespace-nowrap ' . ($variants[$variant] ?? $variants['light'])]) }}>
    {{ $slot }}
</span>
