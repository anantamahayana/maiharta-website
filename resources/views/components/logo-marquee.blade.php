@props(['logos', 'label' => null, 'reverse' => false, 'duration' => 40])

{{-- Deretan logo berjalan (marquee) — daftar diduplikasi agar loop mulus; berhenti saat hover;
     grayscale → berwarna saat hover; dimatikan untuk reduced-motion (jadi baris statis yang bisa di-scroll). --}}
@php
    $items = array_values($logos);
    // logo sedikit → ulang agar mengisi lebar layar sebelum diduplikasi
    while (count($items) < 8 && count($items) > 0) { $items = array_merge($items, array_values($logos)); }
@endphp

<div class="logo-marquee" style="--marquee-duration: {{ $duration }}s">
    @if ($label)<p class="mb-3 text-center text-chip font-medium uppercase tracking-[0.18em] text-brand-muted">{{ $label }}</p>@endif
    <div class="logo-marquee__viewport">
        <ul class="logo-marquee__track {{ $reverse ? 'logo-marquee__track--reverse' : '' }}" aria-label="{{ $label }}">
            @foreach ([$items, $items] as $i => $set)
                @foreach ($set as $logo)
                    <li class="logo-marquee__item" @if ($i === 1) aria-hidden="true" @endif>
                        <img src="{{ asset($logo['src']) }}" alt="{{ $i === 0 ? ($logo['caption'] ?? '') : '' }}" title="{{ $logo['caption'] ?? '' }}" loading="lazy" draggable="false">
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>
