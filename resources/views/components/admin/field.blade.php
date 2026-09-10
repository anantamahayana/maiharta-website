@props(['label', 'name', 'type' => 'text', 'value' => null, 'placeholder' => '', 'required' => false, 'help' => null, 'rows' => 4, 'prefix' => null])
@php
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
    $hasError = $errors->has($errorKey);
    $inputClass = 'w-full bg-transparent px-3.5 py-2.5 text-body-sm text-brand-dark outline-none placeholder:text-brand-placeholder';
@endphp
<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="mb-1.5 block text-label font-medium text-brand-dark">{{ $label }}@if ($required) <span class="text-error">*</span>@endif</label>
    <div class="flex items-center overflow-hidden rounded-lg border bg-brand-input transition focus-within:border-brand-normal focus-within:bg-white focus-within:ring-[3px] focus-within:ring-brand-normal/20 {{ $hasError ? 'border-error' : 'border-brand-border' }}">
        @if ($prefix)<span class="pl-3.5 text-body-sm text-brand-muted">{{ $prefix }}</span>@endif
        @if ($type === 'textarea')
            <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" @required($required) {{ $attributes->except('class') }} class="{{ $inputClass }}">{{ old($name, $value) }}</textarea>
        @elseif ($type === 'select')
            <select name="{{ $name }}" id="{{ $name }}" {{ $attributes->except('class') }} class="{{ $inputClass }}">{{ $slot }}</select>
        @else
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" @required($required) {{ $attributes->except('class') }} class="{{ $inputClass }} {{ $prefix ? 'pl-1' : '' }}">
        @endif
    </div>
    @if ($hasError)
        <p class="mt-1.5 flex items-center gap-1 text-caption text-error"><x-heroicon-o-exclamation-circle class="h-3.5 w-3.5" />{{ $errors->first($errorKey) }}</p>
    @elseif ($help)
        <p class="mt-1.5 text-caption text-brand-muted">{{ $help }}</p>
    @endif
</div>
