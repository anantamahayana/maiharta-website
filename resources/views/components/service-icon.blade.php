@props(['icon' => 'code'])
@php
    $map = ['code' => 'service-code', 'palette' => 'service-palette', 'megaphone' => 'service-megaphone', 'uiux' => 'service-uiux', 'consulting' => 'service-consulting', 'qa' => 'service-qa', 'maintenance' => 'service-maintenance'];
    $component = 'icons.' . ($map[$icon] ?? 'service-code');
@endphp
<x-dynamic-component :component="$component" {{ $attributes->merge(['class' => 'h-6 w-6']) }} />
