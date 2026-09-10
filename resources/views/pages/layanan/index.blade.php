@php
    $icons = [
        'code' => 'service-code',
        'palette' => 'service-palette',
        'megaphone' => 'service-megaphone',
        'uiux' => 'service-uiux',
        'consulting' => 'service-consulting',
        'qa' => 'service-qa',
        'maintenance' => 'service-maintenance',
    ];
@endphp

<x-layout title="Layanan Kami — MaiHarta">

    {{-- Header --}}
    <section class="mx-auto max-w-[1440px] px-5 py-16 md:px-20 md:py-24">
        <p data-animate class="text-sm font-semibold uppercase tracking-wide text-brand-normal">Layanan Kami</p>
        <h1 data-animate style="--reveal-delay:0.06s" class="mt-3 max-w-3xl font-heading text-3xl font-semibold text-brand-dark md:text-5xl md:leading-[1.15]">
            Solusi Digital untuk Setiap Kebutuhan Bisnis
        </h1>
        <p data-animate style="--reveal-delay:0.12s" class="mt-4 max-w-2xl text-brand-dark/80">
            Kami membantu bisnis Anda merancang, membangun, dan mengembangkan produk digital — dari website hingga sistem internal yang kompleks.
        </p>
    </section>

    {{-- Services Grid --}}
    <section class="pb-16 md:pb-24">
        <div class="mx-auto max-w-[1440px] px-5 md:px-20">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                @foreach ($services as $service)
                    @php $isWide = $loop->index >= 3; @endphp
                    <div
                        data-animate
                        style="--reveal-delay:{{ ($loop->index % 3) * 0.08 }}s"
                        class="group col-span-1 sm:col-span-3 {{ $isWide ? 'lg:col-span-3' : 'lg:col-span-2' }} rounded-2xl border border-brand-border bg-white p-7 transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-normal/30 hover:shadow-lg hover:shadow-brand-normal/10"
                    >
                        <div class="flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-brand-light transition-colors duration-300 group-hover:bg-brand-normal/15">
                            <x-dynamic-component :component="'icons.' . ($icons[$service->icon] ?? 'service-code')" class="h-6 w-6" />
                        </div>

                        <h3 class="mt-6 font-heading text-lg font-medium text-brand-dark">{{ $service->name }}</h3>
                        <p class="mt-3 text-sm text-brand-dark/80">{{ $service->short_description }}</p>

                        <a href="{{ route('layanan.show', $service) }}" class="mt-6 inline-flex items-center gap-1 text-[13px] font-medium text-brand-normal hover:text-brand-normal-hover">
                            Pelajari Lebih Lanjut
                            <x-icons.arrow-right class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-brand-light/60 py-16 text-center md:py-20">
        <div data-animate class="mx-auto max-w-2xl px-5">
            <h2 class="font-heading text-2xl font-semibold text-brand-dark md:text-[30px]">Tidak Yakin Layanan Mana yang Anda Butuhkan?</h2>
            <p class="mt-3 text-brand-dark/80">Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menentukan solusi yang paling tepat.</p>
            <div class="mt-8">
                <x-button :href="route('kontak')">Konsultasi Gratis</x-button>
            </div>
        </div>
    </section>

</x-layout>
