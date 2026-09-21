@props(['service'])
{{-- Kartu layanan utama (gelap) — dipakai di halaman Layanan dan Beranda --}}
<div {{ $attributes->merge(['class' => 'flex flex-col gap-8 rounded-panel bg-brand-dark p-7 text-white md:flex-row md:items-center md:p-9']) }}>
    <div class="flex-1">
        <x-chip variant="accent">Layanan Utama</x-chip>
        <div class="mt-4 flex items-center gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-brand-surface-on-dark [&_svg]:text-white"><x-service-icon :icon="$service->icon" class="h-7 w-7" /></span>
            <h2 class="font-heading text-h3 font-semibold md:text-[28px] md:leading-9">{{ $service->name }}</h2>
        </div>
        <p class="mt-4 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">{{ $service->short_description }} Termasuk sistem internal, portal publik, e-commerce, dan integrasi API.</p>
    </div>
    <div class="flex flex-col gap-3 md:items-end">
        <x-button :href="route('layanan.show', $service)" icon="arrow-right">Pelajari Lebih Lanjut</x-button>
        <div class="rounded-xl border border-brand-border-on-dark bg-brand-surface-on-dark px-5 py-4 md:text-right">
            <p class="text-body-sm font-semibold">{{ $service->projects_count ?? 5 }} proyek unggulan</p>
            <p class="text-caption text-brand-on-dark">SSO, Helpdesk, E-PBBKB, LoveBali, Klungkung</p>
        </div>
    </div>
</div>
