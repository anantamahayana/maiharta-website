@php
    $values = [
        ['check', 'Profesional', 'Bekerja dengan standar dan proses yang konsisten di setiap proyek.'],
        ['value-collab', 'Kolaboratif', 'Melibatkan klien secara aktif dari perencanaan hingga peluncuran.'],
        ['value-result', 'Berorientasi Hasil', 'Setiap solusi dirancang untuk memberi dampak nyata pada bisnis Anda.'],
    ];
    $partners = collect(glob(public_path('images/partners/partner-*.png')))->map(fn ($p) => 'images/partners/' . basename($p));
    $clients = collect(glob(public_path('images/partners/client-*.png')))->map(fn ($p) => 'images/partners/' . basename($p));
@endphp

<x-layout title="Tentang — MaiHarta" description="Maiharta adalah tim yang berfokus membantu bisnis bertransformasi digital melalui solusi teknologi yang aman, scalable, dan berorientasi hasil.">

    <x-page-hero eyebrow="Tentang Maiharta" title="Mitra Transformasi Digital Bisnis Anda" description="Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem." :stats="[['8+', 'Tahun'], ['199+', 'Proyek'], ['40+', 'Instansi']]" />

    {{-- Cerita + nilai --}}
    <section class="container-site grid grid-cols-1 gap-10 pb-16 md:pb-20 lg:grid-cols-[1fr_560px] lg:gap-16">
        <div data-animate-group="0.07">
            <p data-animate class="overline">Siapa Kami</p>
            <h2 data-animate class="mt-2.5 font-heading text-h3 font-semibold text-brand-dark md:text-[32px] md:leading-[42px]">Dibangun di Bali, melayani instansi di seluruh Indonesia</h2>
            <p data-animate class="mt-4 text-body-sm text-brand-muted md:text-[15px] md:leading-6">Berawal dari tim kecil pengembang di Denpasar, Maiharta tumbuh menjadi mitra teknologi bagi perbankan daerah, pemerintah provinsi dan kabupaten, hingga pelaku usaha kreatif. Kami percaya produk digital yang baik lahir dari pemahaman mendalam terhadap proses bisnis klien — bukan sekadar kode.</p>
            <blockquote data-animate class="mt-6 rounded-[14px] border-l-[3px] border-brand-normal bg-brand-light px-6 py-5">
                <p class="font-heading text-body font-medium text-brand-dark">“Ngga ada habisnya” — semangat kami untuk terus berinovasi bersama setiap klien.</p>
                <footer class="mt-2 text-label text-brand-muted">Tim Maiharta</footer>
            </blockquote>
            <div data-animate class="mt-6"><x-button :href="route('kontak')" icon="arrow-right">Hubungi Tim Kami</x-button></div>
        </div>
        <div data-animate-group class="space-y-3.5">
            <p data-animate class="overline">Nilai Kerja Kami</p>
            @foreach ($values as [$icon, $t, $d])
                <x-card data-animate :interactive="false" padding="px-5 py-5" class="flex items-center gap-4 !rounded-[14px]">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-light text-brand-normal"><x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" /></span>
                    <span><span class="block font-heading text-[17px] font-medium leading-6 text-brand-dark">{{ $t }}</span><span class="block text-body-sm text-brand-muted">{{ $d }}</span></span>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- Partner & klien --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site">
            <x-section-head eyebrow="Partner & Klien" title="Dipercaya oleh Instansi dan Mitra Terkemuka" align="center" />
            <div data-animate-group class="mt-9 flex flex-col gap-6 md:flex-row">
                @foreach ([['Partner Kami', $partners], ['Client Kami', $clients]] as [$label, $logos])
                    <x-card data-animate :interactive="false" padding="p-7" class="{{ $loop->last ? 'flex-1' : '' }}">
                        <p class="font-heading text-body font-medium text-brand-dark">{{ $label }}</p>
                        <div class="mt-5 flex flex-wrap gap-4">
                            @foreach ($logos as $logo)
                                <span class="flex h-[88px] w-[88px] items-center justify-center rounded-xl bg-brand-light p-3 transition-transform hover:-translate-y-1"><img src="{{ asset($logo) }}" alt="" class="max-h-full max-w-full object-contain" loading="lazy"></span>
                            @endforeach
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    <div class="bg-brand-light">
        <x-cta-panel eyebrow="Bergabung / Kolaborasi" title="Tertarik Bergabung atau Berkolaborasi?" description="Kami selalu terbuka untuk talenta baru dan kemitraan strategis." primary-label="Hubungi Kami" :primary-href="route('kontak')" secondary-label="Lihat Portofolio" :secondary-href="route('portofolio.index')" />
    </div>
</x-layout>
