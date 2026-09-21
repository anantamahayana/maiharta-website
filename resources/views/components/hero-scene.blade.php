@props(['h'])

@php
    $stat = fn ($key) => ['value' => rtrim(site("umum.stats.$key"), '+'), 'suffix' => str_ends_with(site("umum.stats.$key"), '+') ? '+' : ''];
    $stats = [
        [$stat('projects'), 'Proyek'],
        [$stat('clients'), 'Instansi'],
        [$stat('years'), 'Tahun'],
    ];
    $bars = [38, 52, 46, 70, 58, 86, 74, 100];
@endphp

{{-- Scene 3D bergaya kartun — dibangun murni CSS/SVG (tanpa aset gambar). Mengikuti gerakan mouse (parallax tilt). --}}
<div class="hero-scene" data-hero-scene aria-hidden="true">
    <div class="hero-scene__stage">

        {{-- cahaya latar --}}
        <div class="hero-scene__glow"></div>

        {{-- cincin orbit dengan lencana ikon --}}
        <div class="hero-scene__ring hero-scene__ring--outer">
            @foreach ([['shield-check', 'from-[#22c55e] to-[#0f9d58]'], ['code-bracket', 'from-[#5b86e0] to-[#2155cd]'], ['chat-bubble-left-right', 'from-[#f59e0b] to-[#d97706]'], ['rocket-launch', 'from-[#a855f7] to-[#7c3aed]']] as $i => [$icon, $grad])
                <div class="hero-scene__orbit" style="--i: {{ $i }}; --n: 4">
                    <span class="hero-scene__badge bg-gradient-to-br {{ $grad }}">@svg('heroicon-o-' . $icon, 'size-6')</span>
                </div>
            @endforeach
        </div>

        {{-- bola glossy --}}
        <span class="hero-scene__sphere hero-scene__sphere--a"></span>
        <span class="hero-scene__sphere hero-scene__sphere--b"></span>
        <span class="hero-scene__sphere hero-scene__sphere--c"></span>

        {{-- perangkat dashboard 3D --}}
        <div class="hero-scene__device">
            <div class="hero-scene__device-top">
                <span class="hero-scene__dots"><i></i><i></i><i></i></span>
                <span class="hero-scene__url">maiharta.com/dashboard</span>
            </div>
            <div class="hero-scene__screen">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-heading text-[15px] font-semibold text-white md:text-[17px]">{{ $h['card_title'] }}</p>
                        <p class="text-[11px] text-brand-on-dark md:text-caption">{{ str_replace('{tahun}', date('Y'), $h['card_sub']) }}</p>
                    </div>
                    @if ($h['card_badge'])<span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-medium text-white"><span class="size-1.5 rounded-full bg-success shadow-[0_0_8px_#22c55e]"></span>{{ $h['card_badge'] }}</span>@endif
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2">
                    @foreach ($stats as [$s, $label])
                        <div class="rounded-xl bg-white/[0.07] px-3 py-2">
                            <p class="font-heading text-[18px] font-semibold leading-6 text-white md:text-[22px] md:leading-7">
                                @if (is_numeric($s['value']))<span data-count="{{ $s['value'] }}" data-suffix="{{ $s['suffix'] }}">0{{ $s['suffix'] }}</span>@else{{ $s['value'] . $s['suffix'] }}@endif
                            </p>
                            <p class="text-[10px] text-brand-on-dark md:text-[11px]">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 flex h-[64px] items-end gap-1.5 md:h-[84px]">
                    @foreach ($bars as $i => $height)
                        <span class="animate-bar flex-1 rounded-t-md {{ $i >= 5 ? 'bg-brand-accent-on-dark' : 'bg-white/25' }}" style="height: {{ $height }}%; --bar-delay: {{ 0.9 + $i * 0.08 }}s"></span>
                    @endforeach
                </div>
                <div class="mt-3 flex items-center justify-between text-[10px] text-brand-on-dark md:text-[11px]">
                    <span class="flex items-center gap-1.5"><span class="hero-scene__pulse"></span>{{ $h['card_note'] }}</span>
                    <span class="text-success">▲ 24%</span>
                </div>
            </div>
            <div class="hero-scene__device-side"></div>
        </div>

        {{-- kartu melayang: helpdesk --}}
        <div class="hero-scene__card hero-scene__card--chat">
            <div class="flex items-center gap-2.5">
                <span class="grid size-8 shrink-0 place-items-center rounded-full bg-brand-light-hover text-[10px] font-semibold text-brand-dark">NS</span>
                <span class="min-w-0 flex-1">
                    <span class="block truncate text-[12px] font-semibold text-brand-dark">{{ $h['bubble_title'] }}</span>
                    <span class="block text-[10px] text-brand-muted">{{ $h['bubble_sub'] }}</span>
                </span>
                <span class="hidden rounded-full bg-success-bg px-2 py-0.5 text-[10px] font-medium text-success-text sm:inline-flex">{{ $h['bubble_status'] }}</span>
            </div>
            <p class="mt-2 line-clamp-2 text-[11px] leading-4 text-brand-dark/80">{{ $h['bubble_text'] }}</p>
            <span class="hero-scene__typing"><i></i><i></i><i></i></span>
        </div>

        {{-- kartu melayang: dukungan --}}
        <div class="hero-scene__card hero-scene__card--support">
            <span class="grid size-9 place-items-center rounded-xl bg-gradient-to-br from-[#2155cd] to-[#12306f] text-white"><x-heroicon-o-lifebuoy class="size-5" /></span>
            <span>
                <span class="block text-[12px] font-semibold text-brand-dark">{{ $h['badge_title'] }}</span>
                <span class="block text-[10px] text-brand-muted">{{ $h['badge_sub'] }}</span>
            </span>
        </div>

        {{-- kartu melayang: SSO --}}
        <div class="hero-scene__card hero-scene__card--sso">
            <span class="grid size-9 place-items-center rounded-xl bg-brand-dark text-white"><x-heroicon-o-lock-closed class="size-[18px]" /></span>
            <span>
                <span class="block text-[12px] font-semibold text-brand-dark">{{ $h['sso_title'] }}</span>
                <span class="block text-[10px] text-brand-muted">{{ $h['sso_sub'] }}</span>
            </span>
        </div>

        {{-- bayangan lantai --}}
        <span class="hero-scene__floor"></span>

        {{-- kilau --}}
        @foreach ([[8, 18, 0], [86, 12, 1.2], [78, 78, 0.6], [14, 70, 1.8]] as [$x, $y, $d])
            <span class="hero-scene__spark" style="left: {{ $x }}%; top: {{ $y }}%; --d: {{ $d }}s"></span>
        @endforeach
    </div>
</div>
