@props(['value', 'label', 'suffix' => '', 'dark' => false, 'size' => 'md'])

@php
    $numeric = is_numeric($value);
    $valueClass = $size === 'lg' ? 'text-h2' : 'text-h3';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <p class="font-heading {{ $valueClass }} font-semibold {{ $dark ? 'text-brand-normal' : 'text-brand-dark' }}">
        @if ($numeric)
            <span data-count="{{ $value }}" data-suffix="{{ $suffix }}">0{{ $suffix }}</span>
        @else
            {{ $value }}{{ $suffix }}
        @endif
    </p>
    <p class="text-caption {{ $dark ? 'text-brand-on-dark' : 'text-brand-muted' }}">{{ $label }}</p>
</div>
