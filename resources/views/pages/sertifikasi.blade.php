@php
    $practices = [
        ['lock-closed', 'Data Terenkripsi', 'Seluruh data klien dienkripsi baik saat disimpan maupun saat dikirim antar sistem, menggunakan protokol standar industri.', 'AES-256 · TLS 1.3'],
        ['key', 'Akses Terkontrol', 'Akses ke sistem dan data dibatasi berdasarkan peran, dengan autentikasi berlapis dan pencatatan aktivitas.', 'RBAC · 2FA · Audit Trail'],
        ['clipboard-document-check', 'Audit Risiko Berkala', 'Penilaian risiko keamanan dilakukan secara rutin untuk mengidentifikasi celah sebelum menjadi ancaman.', 'Penetration Test · Review'],
    ];
    $certs = [
        ['ISO 9001:2015', 'Quality Management System', 'Menjamin proses kerja yang konsisten dan berorientasi pada kepuasan klien.'],
        ['ISO/IEC 27001', 'Information Security Management', 'Perlindungan data dan sistem informasi klien di seluruh siklus proyek.'],
    ];
@endphp

<x-layout title="Sertifikasi — MaiHarta" description="Komitmen Maiharta pada keamanan data: ISO/IEC 27001 dan praktik keamanan yang diterapkan di setiap proyek.">

    <x-page-hero eyebrow="Sertifikasi & Keamanan" title="Komitmen Kami pada Keamanan Data" description="Kepercayaan klien dibangun di atas standar keamanan yang ketat dan dapat diverifikasi — bukan sekadar janji." :stats="[['ISO', '27001'], ['ISO', '9001:2015'], ['100%', 'Proyek Terstandar']]" />

    {{-- ISO panel --}}
    <section class="container-site pb-16 md:pb-20">
        <div data-animate="scale" class="grid overflow-hidden rounded-cta bg-brand-dark text-white lg:grid-cols-[440px_1fr]">
            <div class="flex flex-col items-center justify-center bg-brand-surface-on-dark p-10 text-center md:p-14">
                <span class="flex h-32 w-32 items-center justify-center rounded-full border border-brand-border-on-dark bg-brand-surface-on-dark"><x-icons.shield class="h-14 w-14" /></span>
                <p class="mt-5 font-heading text-[28px] font-semibold leading-9">ISO/IEC 27001</p>
                <p class="mt-1 text-body-sm text-brand-on-dark">Information Security Management System</p>
                <span class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-success/50 bg-success/20 px-3 py-1.5 text-label-sm font-medium"><span class="h-1.5 w-1.5 rounded-full bg-[#5ee59a]"></span>Tersertifikasi &amp; Aktif</span>
            </div>
            <div class="p-8 md:p-14">
                <p class="overline text-brand-accent-on-dark">Apa Artinya Bagi Anda</p>
                <h2 class="mt-3 font-heading text-h3 font-semibold md:text-[28px] md:leading-[38px]">Standar internasional untuk melindungi data Anda di setiap tahap</h2>
                <p class="mt-4 text-body-sm text-brand-on-dark md:text-[15px] md:leading-6">ISO/IEC 27001 adalah standar internasional untuk sistem manajemen keamanan informasi. Sertifikasi ini menegaskan bahwa Maiharta menerapkan kontrol keamanan yang konsisten dalam mengelola data dan sistem klien di setiap tahap kerja sama — dari perencanaan hingga pascapeluncuran.</p>
                <ul class="mt-6 space-y-2.5">
                    @foreach (['Kebijakan keamanan informasi terdokumentasi', 'Kontrol akses & manajemen insiden', 'Audit internal dan tinjauan manajemen berkala'] as $p)
                        <li class="flex items-center gap-2.5 text-body-sm font-medium"><span class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full bg-brand-normal"><x-heroicon-o-check class="h-3 w-3" /></span>{{ $p }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Praktik --}}
    <section class="bg-brand-light py-16 md:py-20">
        <div class="container-site">
            <x-section-head eyebrow="Praktik Keamanan Kami" title="Keamanan yang Diterapkan, Bukan Hanya Ditulis" description="Tiga pilar yang kami jalankan di setiap proyek, dari sistem perbankan hingga portal publik." />
            <div data-animate-group class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-6">
                @foreach ($practices as [$icon, $t, $d, $tag])
                    <x-card data-animate :interactive="false" padding="p-7">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-light text-brand-normal"><x-dynamic-component :component="'heroicon-o-' . $icon" class="h-5 w-5" /></span>
                        <h3 class="mt-4 font-heading text-[19px] font-medium leading-7 text-brand-dark">{{ $t }}</h3>
                        <p class="mt-3 text-body-sm text-brand-muted">{{ $d }}</p>
                        <x-chip class="mt-4 bg-brand-light">{{ $tag }}</x-chip>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Sertifikasi lain --}}
    <section class="container-site py-16 md:py-20">
        <x-section-head eyebrow="Sertifikasi & Penghargaan Lain" title="Standar Lain yang Kami Penuhi" />
        <div data-animate-group class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2 md:gap-6">
            @foreach ($certs as [$n, $s, $d])
                <x-card data-animate :interactive="false" padding="p-6" class="flex items-center gap-5">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[14px] bg-brand-light font-heading text-body font-semibold text-brand-dark">ISO</span>
                    <span class="flex-1"><span class="block font-heading text-h4 font-medium text-brand-dark">{{ $n }}</span><span class="block text-label font-medium text-brand-normal">{{ $s }}</span><span class="mt-1 block text-label text-brand-muted">{{ $d }}</span></span>
                    <x-chip variant="success">Aktif</x-chip>
                </x-card>
            @endforeach
        </div>
    </section>

    <x-cta-panel eyebrow="Hubungi Kami" title="Ingin Tahu Lebih Lanjut Tentang Standar Keamanan Kami?" description="Tim kami siap menjelaskan bagaimana standar ini diterapkan pada proyek Anda." primary-label="Hubungi Tim Kami" :primary-href="route('kontak')" secondary-label="Lihat Layanan" :secondary-href="route('layanan.index')" />
</x-layout>
