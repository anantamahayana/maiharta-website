@props(['service'])
{{-- Kartu layanan — dipakai di halaman Layanan dan section Solusi Kita di Beranda agar tampilannya identik --}}
<x-card {{ $attributes }} :href="route('layanan.show', $service)" class="flex h-full flex-col">
    <span class="flex h-[52px] w-[52px] items-center justify-center rounded-xl bg-brand-light transition-colors group-hover:bg-brand-light-hover"><x-service-icon :icon="$service->icon" /></span>
    <h3 class="mt-5 font-heading text-[19px] font-medium leading-7 text-brand-dark">{{ $service->name }}</h3>
    <p class="mt-3 flex-1 text-body-sm text-brand-muted">{{ $service->short_description }}</p>
    <span class="mt-5 inline-flex items-center gap-1.5 text-label font-medium text-brand-normal">Pelajari Lebih Lanjut <x-heroicon-o-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" /></span>
</x-card>
