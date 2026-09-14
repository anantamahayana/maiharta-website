@props([
    'eyebrow' => 'Mulai Sekarang',
    'title',
    'description' => null,
    'primaryLabel' => 'Hubungi Kami',
    'primaryHref',
    'secondaryLabel' => null,
    'secondaryHref' => null,
])

<section {{ $attributes->merge(['class' => 'container-site pb-16 md:pb-20']) }}>
    <div data-animate="scale" class="bg-cta-gradient flex flex-col items-center rounded-panel px-6 py-10 text-center md:rounded-cta md:px-16 md:py-16">
        <p class="eyebrow text-brand-accent-on-dark">{{ $eyebrow }}</p>
        <h2 class="mt-3 max-w-[760px] font-heading text-h3 font-semibold text-white md:text-[36px] md:leading-[46px]">{{ $title }}</h2>
        @if ($description)
            <p class="mt-3 max-w-[560px] text-body-sm text-brand-on-dark md:text-body">{{ $description }}</p>
        @endif
        <div class="mt-7 flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
            <x-button :href="$primaryHref" icon="arrow-right">{{ $primaryLabel }}</x-button>
            @if ($secondaryLabel)
                <x-button :href="$secondaryHref" variant="white">{{ $secondaryLabel }}</x-button>
            @endif
        </div>
    </div>
</section>
