@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'stats' => [],      // [[value, label], …]
    'crumbs' => [],     // [[label, href|null], …]
])

<section {{ $attributes->merge(['class' => 'bg-hero-gradient']) }}>
    <div class="container-site pt-8 pb-8 md:pt-10 md:pb-10">
        @if ($crumbs)
            <nav data-animate aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center justify-center gap-2 text-caption lg:justify-start">
                @foreach ($crumbs as [$label, $href])
                    @if ($href)
                        <a href="{{ $href }}" class="text-brand-normal hover:text-brand-normal-hover">{{ $label }}</a>
                        <span class="text-brand-muted">/</span>
                    @else
                        <span class="text-brand-dark">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif

        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between lg:gap-16">
            <div data-animate-group="0.07" class="mx-auto max-w-[760px] text-center lg:mx-0 lg:text-left">
                @if ($eyebrow)<p data-animate class="eyebrow">{{ $eyebrow }}</p>@endif
                @if ($title)<h1 data-animate class="mt-3 font-heading text-h2 font-semibold text-brand-dark md:text-h1-hero">{{ $title }}</h1>@endif
                @if ($description)<p data-animate class="mt-4 text-body-sm text-brand-muted md:text-body">{{ $description }}</p>@endif
                {{ $slot }}
            </div>

            @if ($stats)
                <div data-animate-group class="flex gap-3">
                    @foreach ($stats as [$value, $label])
                        <div data-animate class="flex-1 rounded-[14px] border border-brand-border bg-white px-4 py-3.5 lg:flex-none lg:px-5 lg:py-4">
                            <p class="font-heading text-h4 font-semibold text-brand-normal lg:text-[24px] lg:leading-8">{{ $value }}</p>
                            <p class="text-caption text-brand-muted">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (isset($aside))
                <div data-animate="scale">{{ $aside }}</div>
            @endif
        </div>

        @if (isset($footer))
            <div data-animate class="mt-8">{{ $footer }}</div>
        @endif
    </div>
</section>
