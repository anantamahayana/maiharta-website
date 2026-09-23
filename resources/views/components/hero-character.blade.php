@props(['h'])

{{-- Hero bergaya referensi: karakter 3D di tengah cincin konsentris berdenyut, dikelilingi objek 3D
     dan kartu melayang. Gambar karakter (PNG transparan) diunggah di Admin → Beranda. --}}
<div class="hero-char" data-hero-scene aria-hidden="true">
    <div class="hero-scene__stage">
        {{-- cincin konsentris --}}
        <span class="hero-char__ring hero-char__ring--1"></span>
        <span class="hero-char__ring hero-char__ring--2"></span>
        <span class="hero-char__ring hero-char__ring--3"></span>

        {{-- karakter --}}
        <img src="{{ asset($h['character']) }}" alt="" width="1066" height="1100" fetchpriority="high" class="hero-char__img">

        {{-- objek 3D melayang --}}
        <span class="hero-char__obj hero-char__obj--code bg-gradient-to-br from-[#5b86e0] to-[#2155cd]"><x-heroicon-o-code-bracket class="size-6" /></span>
        <span class="hero-scene__sphere hero-char__sphere"></span>

        {{-- kartu: konsultasi --}}
        <div class="hero-scene__card hero-char__card--team">
            <span class="grid size-9 place-items-center rounded-xl bg-gradient-to-br from-[#22c55e] to-[#15803d] text-white"><x-heroicon-o-chat-bubble-left-right class="size-5" /></span>
            <span>
                <span class="block text-[12px] font-semibold text-brand-dark">Konsultasi Gratis</span>
                <span class="block text-[10px] text-brand-muted">Respons &lt; 24 jam kerja</span>
            </span>
        </div>

        {{-- kartu: dukungan --}}
        <div class="hero-scene__card hero-char__card--support">
            <span class="grid size-9 place-items-center rounded-xl bg-gradient-to-br from-[#2155cd] to-[#12306f] text-white"><x-heroicon-o-lifebuoy class="size-5" /></span>
            <span>
                <span class="block text-[12px] font-semibold text-brand-dark">{{ $h['badge_title'] }}</span>
                <span class="block text-[10px] text-brand-muted">{{ $h['badge_sub'] }}</span>
            </span>
        </div>

        {{-- kartu: statistik --}}
        <div class="hero-scene__card hero-char__card--stat">
            <span class="grid size-9 place-items-center rounded-xl bg-success-bg text-success-text"><x-heroicon-o-chart-bar class="size-5" /></span>
            <span>
                <span class="block font-heading text-[16px] font-semibold leading-5 text-brand-dark">{{ site('umum.stats.projects') }}</span>
                <span class="block text-[10px] text-brand-muted">Proyek selesai</span>
            </span>
        </div>

        @foreach ([[10, 20, 0], [88, 16, 1.2], [84, 76, 0.6], [12, 72, 1.8]] as [$x, $y, $d])
            <span class="hero-scene__spark" style="left: {{ $x }}%; top: {{ $y }}%; --d: {{ $d }}s"></span>
        @endforeach
    </div>
</div>
