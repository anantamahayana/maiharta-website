<x-layout title="Halaman Tidak Ditemukan — MaiHarta">
    <section class="bg-hero-gradient">
        <div class="container-site flex flex-col items-center py-24 text-center md:py-32" data-animate-group>
            <p data-animate class="font-heading text-[96px] font-semibold leading-none text-brand-light-active md:text-[140px]">404</p>
            <h1 data-animate class="mt-4 font-heading text-h2 font-semibold text-brand-dark md:text-h1">Halaman Tidak Ditemukan</h1>
            <p data-animate class="mt-3 max-w-[460px] text-body-sm text-brand-muted md:text-body">Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau tautannya salah.</p>
            <div data-animate class="mt-8 flex flex-col gap-3 sm:flex-row">
                <x-button :href="route('home')" icon="arrow-right">Kembali ke Beranda</x-button>
                <x-button :href="route('portofolio.index')" variant="outline">Lihat Portofolio</x-button>
            </div>
        </div>
    </section>
</x-layout>
