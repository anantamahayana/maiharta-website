<x-layout title="Sesi Kedaluwarsa — MaiHarta">
    <section class="bg-hero-gradient">
        <div class="container-site flex flex-col items-center py-24 text-center md:py-32" data-animate-group>
            <p data-animate class="font-heading text-[96px] font-semibold leading-none text-brand-light-active md:text-[140px]">419</p>
            <h1 data-animate class="mt-4 font-heading text-h2 font-semibold text-brand-dark md:text-h1">Sesi Anda Sudah Kedaluwarsa</h1>
            <p data-animate class="mt-3 max-w-[460px] text-body-sm text-brand-muted md:text-body">Halaman ini terbuka terlalu lama sehingga formulir tidak bisa dikirim. Muat ulang halaman lalu coba lagi.</p>
            <div data-animate class="mt-8 flex flex-col gap-3 sm:flex-row">
                <x-button href="javascript:history.back()" icon="arrow-right">Kembali &amp; Coba Lagi</x-button>
                <x-button :href="request()->is('admin*') ? route('admin.login') : route('home')" variant="outline">{{ request()->is('admin*') ? 'Ke Halaman Login' : 'Ke Beranda' }}</x-button>
            </div>
        </div>
    </section>
</x-layout>
