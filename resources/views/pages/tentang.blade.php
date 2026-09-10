@php
    $hero = site('tentang.hero');
    $cerita = site('tentang.cerita');
    $nilai = site('tentang.nilai');
    $partner = site('tentang.partner');
    $cta = site('tentang.cta');
    $st = site('umum.stats');
    $valueIcons = ['check', 'value-collab', 'value-result', 'check'];
@endphp

<x-layout title="Tentang — MaiHarta" :description="$hero['description']">

    <x-page-hero :eyebrow="$hero['eyebrow']" :title="$hero['title']" :description="$hero['description']" :stats="[[$st['years'], 'Tahun'], [$st['projects'], 'Proyek'], [$st['clients'], 'Instansi']]" />

    {{-- Cerita + nilai --}}
    <section class="container-site grid grid-cols-1 gap-10 pb-16 md:pb-20 lg:grid-cols-[1fr_560px] lg:gap-16">
        <div data-animate-group="0.07">
            <p data-animate class="overline">{{ $cerita['eyebrow'] }}</p>
            <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-[32px] md:leading-[42px]">{{ $cerita['title'] }}</h2>
            <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">{{ $cerita['description'] }}</p>
            @if ($cerita['quote'])
                <blockquote data-animate class="mt-6 rounded-[14px] border-l-[3px] border-brand-normal bg-brand-light px-6 py-5">
                    <p class="font-heading text-body font-medium text-brand-dark">{{ $cerita['quote'] }}</p>
                    @if ($cerita['quote_by'])<footer class="mt-2 text-label text-brand-muted">{{ $cerita['quote_by'] }}</footer>@endif
                </blockquote>
            @endif
            <div data-animate class="mt-6"><x-button :href="route('kontak')" icon="arrow-right">{{ $cerita['button'] }}</x-button></div>
        </div>
        <div data-animate-group class="space-y-3.5">
            <p data-animate class="overline">{{ $nilai['eyebrow'] }}</p>
            @foreach ($nilai['items'] as $i => $v)
                <x-card data-animate :interactive="false" padding="px-5 py-5" class="flex items-center gap-4 !rounded-[14px]">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light text-brand-normal"><x-dynamic-component :component="'icons.' . ($valueIcons[$i] ?? 'check')" class="h-5 w-5" /></span>
                    <span><span class="block font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $v['title'] }}</span><span class="block text-body-sm text-brand-muted">{{ $v['description'] }}</span></span>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- Partner & klien --}}
    @if ($partner['partners'] || $partner['clients'])
        <section class="bg-brand-light py-16 md:py-20">
            <div class="container-site">
                <x-section-head :eyebrow="$partner['eyebrow']" :title="$partner['title']" align="center" />
                <div data-animate-group class="mt-9 flex flex-col gap-6 md:flex-row">
                    @foreach ([['Partner Kami', $partner['partners']], ['Client Kami', $partner['clients']]] as [$label, $logos])
                        @continue(empty($logos))
                        <x-card data-animate :interactive="false" padding="p-7" class="{{ $loop->last ? 'flex-1' : '' }}">
                            <p class="font-heading text-body font-medium text-brand-dark">{{ $label }}</p>
                            <div class="mt-5 flex flex-wrap gap-4">
                                @foreach ($logos as $logo)
                                    <span title="{{ $logo['caption'] ?? '' }}" class="flex h-[88px] w-[88px] items-center justify-center rounded-xl bg-brand-light p-3 transition-transform hover:-translate-y-1"><img src="{{ asset($logo['src']) }}" alt="{{ $logo['caption'] ?? '' }}" class="max-h-full max-w-full object-contain" loading="lazy"></span>
                                @endforeach
                            </div>
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="bg-brand-light">
        <x-cta-panel :eyebrow="$cta['eyebrow']" :title="$cta['title']" :description="$cta['description']" :primary-label="$cta['primary']" :primary-href="route('kontak')" :secondary-label="$cta['secondary']" :secondary-href="route('portofolio.index')" />
    </div>
</x-layout>
