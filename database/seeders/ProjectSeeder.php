<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Data proyek disusun dari dokumen modul/user guide resmi MaiHarta.
     */
    public function run(): void
    {
        $softwareDev = Service::where('slug', 'software-development')->first();
        $konsultasi = Service::where('slug', 'konsultasi-sistem-digital')->first();

        $projects = [
            [
                'service_id' => $softwareDev?->id,
                'name' => 'Lais Market — Marketplace Kerajinan & Ikan Hias Indonesia',
                'slug' => 'lais-market',
                'category' => 'Website Development',
                'client_type' => 'E-Commerce — Lais Market, Bali',
                'short_description' => 'Platform e-commerce multi-seller yang menghubungkan pengrajin dan peternak ikan hias Indonesia dengan pembeli di seluruh dunia — katalog multi-kategori, dua mata uang, panel penjual, dan aplikasi mobile.',
                'description' => 'Sejak diluncurkan, Lais Market beroperasi penuh sebagai marketplace lintas negara. Puluhan toko dari Bali, Jawa, hingga Kalimantan menjual karya seni, tekstil, dan ikan hias bernilai jutaan rupiah kepada pembeli global — semuanya dikelola mandiri lewat panel penjual.',
                'challenge' => 'Pengrajin dan peternak ikan hias Indonesia memiliki produk berkualitas ekspor, namun akses ke pembeli global terhambat: belum ada etalase digital terpusat, harga hanya dalam Rupiah, dan setiap penjual mengelola pesanan secara manual.',
                'solution' => 'Kami membangun marketplace multi-seller dengan katalog delapan kategori, konversi harga IDR/USD otomatis, keranjang & checkout terpadu, serta panel penjual untuk mengelola produk, pesanan, dan pesan pembeli dari satu tempat.',
                'tech_summary' => 'Frontend web responsif dengan pencarian real-time, backend PHP/Laravel & MySQL, integrasi payment gateway, sistem multi-currency, dan aplikasi mobile iOS & Android — dikembangkan mengikuti standar keamanan ISO/IEC 27001.',
                'outcome_stats' => [
                    ['value' => '8', 'label' => 'Kategori Produk'],
                    ['value' => '2', 'label' => 'Mata Uang (IDR/USD)'],
                    ['value' => 'Multi', 'label' => 'Seller Onboarding'],
                    ['value' => 'iOS + Android', 'label' => 'Aplikasi Mobile'],
                ],
                'cover_image' => 'images/projects/lais-market/cover.jpg',
                'gallery' => [
                    ['src' => 'images/projects/lais-market/gallery-1.jpg', 'caption' => 'Halaman produk & kategori'],
                    ['src' => 'images/projects/lais-market/gallery-2.jpg', 'caption' => 'Login & dashboard toko'],
                    ['src' => 'images/projects/lais-market/gallery-3.jpg', 'caption' => 'Galeri lukisan & kerajinan'],
                    ['src' => 'images/projects/lais-market/gallery-4.jpg', 'caption' => 'Katalog ikan hias'],
                    ['src' => 'images/projects/lais-market/gallery-5.jpg', 'caption' => 'Keranjang & pesanan'],
                    ['src' => 'images/projects/lais-market/gallery-6.jpg', 'caption' => 'Pesan pembeli & dukungan'],
                ],
                'external_url' => 'https://laismarket.com',
                'sort_order' => 0,
            ],
            [
                'service_id' => $softwareDev?->id,
                'name' => 'Single Sign On (SSO) Bank BPD Bali',
                'slug' => 'sso-bpd-bali',
                'category' => 'Apps Development',
                'client_type' => 'Perbankan — Bank BPD Bali',
                'short_description' => 'Gerbang autentikasi terpusat dengan 2FA dan verifikasi known channel untuk seluruh aplikasi internal Bank BPD Bali.',
                'description' => 'Aplikasi Single Sign On (SSO) menjadi satu pintu masuk untuk seluruh aplikasi internal Bank BPD Bali. Pengguna cukup satu kali login untuk mengakses semua aplikasi klien yang terdaftar, dengan lapisan keamanan berupa autentikasi dua faktor (2FA Authenticator) serta verifikasi known channel melalui email dan Telegram. Sisi administrator dilengkapi manajemen aplikasi klien, kontrol pengguna, dan audit trail lengkap.',
                'challenge' => 'Setiap aplikasi internal bank memiliki kredensial dan mekanisme login sendiri. Kondisi ini menyulitkan pengelolaan akses, memperbesar risiko kebocoran kredensial, dan membuat penelusuran aktivitas pengguna sulit dilakukan lintas aplikasi.',
                'solution' => 'Kami membangun gerbang autentikasi terpusat dengan dua lapis verifikasi: 2FA berbasis authenticator dan known channel (email/Telegram). Administrator dapat mendaftarkan aplikasi klien beserta secret-nya, melakukan generate ulang secret, mengaktifkan mode maintenance per aplikasi, hingga mereset 2FA dan known channel pengguna. Seluruh aktivitas login dan akses aplikasi terekam pada audit trail.',
                'tech_summary' => 'PHP/Laravel, MySQL, protokol SSO dengan client ID & secret, TOTP 2FA, integrasi Telegram Bot API dan SMTP, manajemen sesi terpusat, serta audit trail. Pengembangan mengikuti standar keamanan ISO/IEC 27001.',
                'outcome_stats' => [
                    ['value' => '1', 'label' => 'Pintu Login untuk Semua Aplikasi'],
                    ['value' => '2FA', 'label' => 'Lapisan Autentikasi Tambahan'],
                    ['value' => '100%', 'label' => 'Aktivitas Terekam Audit Trail'],
                ],
                'cover_image' => 'images/projects/sso-bpd-bali.jpg',
                'gallery' => [],
                'external_url' => null,
                'sort_order' => 1,
            ],
            [
                'service_id' => $softwareDev?->id,
                'name' => 'Helpdesk Bank BPD Bali',
                'slug' => 'helpdesk-bpd-bali',
                'category' => 'Apps Development',
                'client_type' => 'Perbankan — Bank BPD Bali',
                'short_description' => 'Sistem penanganan pengaduan nasabah dengan alur berjenjang, pemetaan unit kerja, dan pemantauan SLA.',
                'description' => 'Helpdesk Bank BPD Bali mengelola siklus penuh pengaduan nasabah — dari pencatatan oleh Customer Service, tindak lanjut oleh supervisi unit, hingga penanganan dan penyelesaian akhir. Sistem mencakup sebelas modul master (unit kerja, departemen, SLA, jenis produk, kategori dan klasifikasi permasalahan, media transaksi, data ATM/CRM, hingga kalender hari libur) yang menjadi dasar perhitungan waktu penanganan.',
                'challenge' => 'Pengaduan nasabah datang dari banyak kanal dan harus melewati beberapa tingkat penanganan. Tanpa sistem, status pengaduan sulit dilacak, penugasan antarunit tidak jelas, dan kepatuhan terhadap SLA tidak dapat diukur secara objektif.',
                'solution' => 'Kami merancang alur kerja berjenjang dari Customer Service ke supervisi unit hingga departemen terkait, lengkap dengan pemetaan operator per unit kerja. Perhitungan SLA memperhitungkan kalender hari libur sehingga durasi penanganan terukur secara adil, dan setiap pengaduan menghasilkan bukti penerimaan yang dapat diunduh nasabah.',
                'tech_summary' => 'PHP/Laravel, MySQL, sistem role & permission berjenjang, integrasi data SDM Bank BPD Bali, mesin perhitungan SLA berbasis kalender kerja, dan pembuatan dokumen bukti pengaduan.',
                'outcome_stats' => [
                    ['value' => '11', 'label' => 'Modul Master Terintegrasi'],
                    ['value' => '3', 'label' => 'Tingkat Alur Penanganan'],
                    ['value' => 'SLA', 'label' => 'Termonitor Otomatis'],
                ],
                'cover_image' => 'images/projects/helpdesk-bpd-bali.jpg',
                'gallery' => [],
                'external_url' => null,
                'sort_order' => 2,
            ],
            [
                'service_id' => $softwareDev?->id,
                'name' => 'E-PBBKB Provinsi Bali',
                'slug' => 'e-pbbkb-bali',
                'category' => 'Apps Development',
                'client_type' => 'Pemerintah Provinsi Bali',
                'short_description' => 'Sistem pelaporan dan pembayaran Pajak Bahan Bakar Kendaraan Bermotor secara digital bagi Wajib Pungut.',
                'description' => 'E-PBBKB memfasilitasi Wajib Pungut (Wapu) untuk melaporkan data pembelian dan penjualan bahan bakar, menyusun SPTPD, hingga menerbitkan SSPD dan melakukan pembayaran secara digital. Sisi admin menyediakan master data sektor dan jenis BBM, verifikasi akun serta penginputan, pengaturan sistem, dan pelaporan.',
                'challenge' => 'Pelaporan pajak bahan bakar sebelumnya dilakukan secara manual dengan volume transaksi yang besar. Proses ini memakan waktu, rawan salah hitung, dan menyulitkan petugas dalam memverifikasi kebenaran data yang dilaporkan.',
                'solution' => 'Kami membangun sistem pelaporan mandiri dengan fitur impor data pembelian dan penjualan secara massal, penyusunan SPTPD otomatis dari data yang dilaporkan, serta alur verifikasi bertingkat pada sisi admin sebelum SSPD diterbitkan dan pembayaran diproses.',
                'tech_summary' => 'PHP/Laravel, MySQL, impor data massal berbasis spreadsheet, perhitungan pajak otomatis, alur verifikasi bertingkat, serta pembuatan dokumen SPTPD dan SSPD.',
                'outcome_stats' => [
                    ['value' => '100%', 'label' => 'Pelaporan Secara Digital'],
                    ['value' => 'Massal', 'label' => 'Impor Data Transaksi'],
                    ['value' => 'Auto', 'label' => 'Penyusunan SPTPD'],
                ],
                'cover_image' => 'images/projects/e-pbbkb-bali.jpg',
                'gallery' => [],
                'external_url' => null,
                'sort_order' => 3,
            ],
            [
                'service_id' => $softwareDev?->id,
                'name' => 'LoveBali Checker',
                'slug' => 'lovebali-checker',
                'category' => 'Mobile App',
                'client_type' => 'Pariwisata — Pemerintah Provinsi Bali',
                'short_description' => 'Aplikasi mobile untuk petugas lapangan memverifikasi pembayaran retribusi wisatawan melalui QR code dan nomor paspor.',
                'description' => 'LoveBali Checker digunakan petugas di titik pemeriksaan untuk memverifikasi status pembayaran retribusi wisatawan. Petugas dapat memindai QR code menggunakan kamera perangkat maupun pemindai perangkat keras, atau melakukan pengecekan manual dengan nomor paspor. Setiap pemeriksaan tercatat pada riwayat, dan akun super admin dapat mengatur endpoint layanan langsung dari aplikasi.',
                'challenge' => 'Verifikasi retribusi harus berlangsung cepat di titik pemeriksaan dengan antrean wisatawan yang padat. Kondisi lapangan bervariasi — sebagian pos menggunakan pemindai perangkat keras, sebagian hanya mengandalkan kamera ponsel, dan sebagian wisatawan tidak membawa QR code sama sekali.',
                'solution' => 'Kami menyediakan tiga jalur verifikasi dalam satu aplikasi: pindai QR via kamera, pindai QR via perangkat keras, dan pengecekan manual berbasis nomor paspor. Konfigurasi URL layanan dapat diubah oleh super admin tanpa perlu memasang ulang aplikasi, sehingga penyesuaian di lapangan menjadi jauh lebih cepat.',
                'tech_summary' => 'Aplikasi mobile dengan pemindai QR berbasis kamera dan integrasi perangkat keras, konsumsi REST API layanan LoveBali, penyimpanan riwayat pemindaian, serta konfigurasi endpoint dinamis berbasis peran.',
                'outcome_stats' => [
                    ['value' => '3', 'label' => 'Metode Verifikasi'],
                    ['value' => 'Real-time', 'label' => 'Pengecekan di Lapangan'],
                    ['value' => 'Mobile', 'label' => 'Siap Digunakan Petugas'],
                ],
                'cover_image' => 'images/projects/lovebali-checker.jpg',
                'gallery' => [],
                'external_url' => null,
                'sort_order' => 4,
            ],
            [
                'service_id' => $konsultasi?->id ?? $softwareDev?->id,
                'name' => 'Website Pariwisata Klungkung',
                'slug' => 'pariwisata-klungkung',
                'category' => 'Website Development',
                'client_type' => 'Pemerintah Kabupaten Klungkung',
                'short_description' => 'Portal pariwisata daerah dengan eksplorasi destinasi, rekomendasi, agenda event, dan wishlist pengunjung.',
                'description' => 'Website Pariwisata Klungkung memperkenalkan destinasi wisata daerah kepada wisatawan lokal maupun mancanegara. Pengunjung dapat menjelajah destinasi, melihat rekomendasi dan destinasi populer, mengikuti agenda event serta berita terbaru, dan menyimpan destinasi favorit ke wishlist melalui akun pribadi. Sisi admin mengelola konten destinasi, event, dan berita secara mandiri.',
                'challenge' => 'Informasi wisata Kabupaten Klungkung tersebar di berbagai kanal dan tidak diperbarui secara berkala, sehingga wisatawan kesulitan menemukan informasi destinasi maupun agenda kegiatan yang tepercaya dan terkini.',
                'solution' => 'Kami membangun portal pariwisata dengan pengelolaan konten mandiri oleh dinas terkait, ditambah fitur akun pengunjung dengan wishlist destinasi. Struktur halaman disusun agar destinasi populer dan rekomendasi tampil di awal perjalanan pengguna, sementara agenda event dan berita menjaga situs tetap relevan sepanjang tahun.',
                'tech_summary' => 'PHP/Laravel, MySQL, manajemen konten destinasi dan event, autentikasi serta registrasi pengunjung, fitur wishlist, dan tampilan responsif untuk perangkat mobile.',
                'outcome_stats' => [
                    ['value' => '1', 'label' => 'Portal Wisata Terpusat'],
                    ['value' => 'Mandiri', 'label' => 'Pengelolaan Konten Dinas'],
                    ['value' => 'Responsif', 'label' => 'Di Semua Perangkat'],
                ],
                'cover_image' => 'images/projects/pariwisata-klungkung.jpg',
                'gallery' => [],
                'external_url' => null,
                'sort_order' => 5,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }

        // Bersihkan proyek contoh lama yang sudah tidak dipakai.
        Project::whereNotIn('slug', array_column($projects, 'slug'))->delete();
    }
}
