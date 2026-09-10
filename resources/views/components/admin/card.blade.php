@props(['title' => null, 'padding' => 'p-5'])
<div {{ $attributes->merge(['class' => 'rounded-xl border border-brand-border bg-white ' . $padding]) }}>
    @if ($title || isset($action))
        <div class="mb-4 flex items-center justify-between gap-3">
            @if ($title)<h2 class="text-h5 font-medium text-brand-dark">{{ $title }}</h2>@endif
            @if (isset($action))<div>{{ $action }}</div>@endif
        </div>
    @endif
    {{ $slot }}
</div>
