@php
    $hero = site('sertifikasi.hero');
    $iso = site('sertifikasi.iso');
    $pr = site('sertifikasi.praktik');
    $lain = site('sertifikasi.lain');
    $cta = site('sertifikasi.cta');
    $practiceIcons = ['lock-closed', 'key', 'clipboard-document-check', 'shield-check'];
@endphp

<x-layout title="Sertifikasi — MaiHarta" :description="$hero['description']">

    <x-page-hero :eyebrow="$hero['eyebrow']" :title="$hero['title']" :description="$hero['description']" :stats="collect($hero['stats'])->map(fn ($s) => [$s['value'], $s['label']])->all()" />

    {{-- ISO panel --}}
    <section class="container-site pb-16 md:pb-20">
        <div data-animate="scale" class="grid overflow-hidden rounded-cta bg-brand-dark text-white lg:grid-cols-[440px_1fr]">
            <div class="flex flex-col items-center justify-center bg-brand-surface-on-dark p-10 text-center md:p-14">
                <span class="flex h-32 w-32 items-center justify-center rounded-full border border-brand-border-on-dark bg-brand-surface-on-dark"><x-icons.shield class="h-14 w-14" /></span>
                <p class="mt-5 font-heading text-[28px] font-semibold leading-9">{{ $iso['name'] }}</p>
                <p class="mt-1 text-body-sm text-brand-on-dark">{{ $iso['sub'] }}</p>
                @if ($iso['status'])<span class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-success/50 bg-success/20 px-3 py-1.5 text-label-sm font-medium"><span class="h-1.5 w-1.5 rounded-full bg-[#5ee59a]"></span>{{ $iso['status'] }}</span>@endif
            </div>
            <div class="p-8 md:p-14">
                <p class="overline text-brand-accent-on-dark">{{ $iso['eyebrow'] }}</p>
                <h2 class="mt-3 font-heading text-h3 font-semibold md:text-[28px] md:leading-[38px]">{{ $iso['title'] }}</h2>
                <p class="mt-4 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">{{ $iso['description'] }}</p>
                <ul class="mt-6 space-y-2.5">
                    @foreach ($iso['points'] as $p)
                        <li class="flex items-center gap-2.5 text-body-sm font-medium"><span class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full bg-brand-normal"><x-heroicon-o-check class="h-3 w-3" /></span>{{ $p['text'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Praktik --}}
    @if ($pr['items'])
        <section class="bg-brand-light py-16 md:py-20">
            <div class="container-site">
                <x-section-head :eyebrow="$pr['eyebrow']" :title="$pr['title']" :description="$pr['description']" />
                <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
                    @foreach ($pr['items'] as $i => $item)
                        <x-card data-animate :interactive="false" padding="p-7">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-light text-brand-normal"><x-dynamic-component :component="'heroicon-o-' . ($practiceIcons[$i] ?? 'shield-check')" class="h-5 w-5" /></span>
                            <h3 class="mt-4 font-heading text-[19px] font-medium leading-7 text-brand-dark">{{ $item['title'] }}</h3>
                            <p class="mt-3 text-body-sm text-brand-muted">{{ $item['description'] }}</p>
                            @if ($item['tag'])<x-chip class="mt-4 bg-brand-light">{{ $item['tag'] }}</x-chip>@endif
                        </x-card>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Sertifikasi lain --}}
    @if ($lain['items'])
        <section class="container-site py-16 md:py-20">
            <x-section-head :eyebrow="$lain['eyebrow']" :title="$lain['title']" />
            <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6">
                @foreach ($lain['items'] as $c)
                    <x-card data-animate :interactive="false" padding="p-6" class="flex items-center gap-5">
                        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[14px] bg-brand-light font-heading text-body font-semibold text-brand-dark">{{ Str::of($c['name'])->before(' ')->limit(4, '') }}</span>
                        <span class="flex-1"><span class="block font-heading text-h4 font-medium text-brand-dark">{{ $c['name'] }}</span><span class="block text-label font-medium text-brand-normal">{{ $c['sub'] }}</span><span class="mt-1 block text-label text-brand-muted">{{ $c['description'] }}</span></span>
                        <x-chip variant="success">Aktif</x-chip>
                    </x-card>
                @endforeach
            </div>
        </section>
    @endif

    <x-cta-panel :eyebrow="$cta['eyebrow']" :title="$cta['title']" :description="$cta['description']" :primary-label="$cta['primary']" :primary-href="route('kontak')" :secondary-label="$cta['secondary']" :secondary-href="route('layanan.index')" />
</x-layout>
