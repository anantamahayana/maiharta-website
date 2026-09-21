<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Empat artikel contoh untuk halaman Blog — ganti/hapus lewat panel admin. */
class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->orderBy('id')->first();

        $articles = [
            [
                'title' => 'Mengapa Instansi Pemerintah Perlu Beralih ke Sistem Informasi Terintegrasi',
                'category' => 'wawasan',
                'excerpt' => 'Data yang tersebar di banyak aplikasi memperlambat layanan publik. Integrasi sistem membuat proses lebih cepat, transparan, dan mudah diaudit.',
                'cover' => 'images/articles/sistem-terintegrasi.jpg',
                'tags' => ['pemerintahan', 'integrasi', 'layanan publik'],
                'is_featured' => true,
                'days_ago' => 3,
                'body' => <<<'HTML'
<p>Banyak instansi masih menjalankan layanan dengan aplikasi yang berdiri sendiri: satu untuk kepegawaian, satu untuk keuangan, satu lagi untuk pengaduan. Akibatnya data yang sama diinput berulang, laporan butuh waktu berhari-hari, dan pimpinan sulit melihat gambaran utuh.</p>
<h2>Apa itu sistem terintegrasi?</h2>
<p>Sistem terintegrasi menyatukan proses dan data lintas unit dalam satu platform (atau beberapa platform yang saling terhubung lewat API). Pengguna cukup masuk sekali, data cukup diinput sekali, dan setiap perubahan langsung terlihat di modul lain yang membutuhkannya.</p>
<h2>Manfaat yang langsung terasa</h2>
<ul>
<li><strong>Layanan lebih cepat</strong> — verifikasi data tidak lagi manual antar bagian.</li>
<li><strong>Transparan dan mudah diaudit</strong> — setiap aksi tercatat dengan jejak waktu dan pengguna.</li>
<li><strong>Keputusan berbasis data</strong> — dashboard menampilkan indikator real-time.</li>
</ul>
<h2>Dari mana memulainya?</h2>
<p>Mulailah dari proses yang paling sering bersinggungan antar unit — biasanya kepegawaian dan keuangan — lalu perluas bertahap. Pendekatan bertahap menekan risiko dan membuat pengguna beradaptasi tanpa mengganggu layanan yang berjalan.</p>
<blockquote>Integrasi bukan soal teknologi semata, tetapi menyepakati satu sumber kebenaran untuk setiap data.</blockquote>
HTML,
            ],
            [
                'title' => '5 Hal yang Perlu Disiapkan Sebelum Membangun Aplikasi Internal',
                'category' => 'tips',
                'excerpt' => 'Checklist praktis agar proyek aplikasi internal tidak molor: dari pemetaan proses sampai rencana pelatihan pengguna.',
                'cover' => 'images/articles/persiapan-aplikasi.jpg',
                'tags' => ['perencanaan', 'aplikasi internal'],
                'days_ago' => 9,
                'body' => <<<'HTML'
<p>Proyek aplikasi internal sering terlambat bukan karena teknologinya, melainkan karena persiapan di sisi organisasi. Berikut lima hal yang kami minta disiapkan klien sebelum pengembangan dimulai.</p>
<h2>1. Peta proses yang berjalan saat ini</h2>
<p>Tuliskan alur kerja apa adanya — termasuk langkah yang "tidak resmi". Aplikasi yang baik lahir dari proses yang dipahami, bukan dari proses ideal di atas kertas.</p>
<h2>2. Satu penanggung jawab keputusan</h2>
<p>Tentukan siapa yang berhak memutuskan bila ada perbedaan kebutuhan antar bagian. Tanpa ini, setiap revisi menjadi rapat panjang.</p>
<h2>3. Data awal yang bersih</h2>
<p>Data master (pegawai, unit, kode anggaran) perlu dirapikan lebih dulu. Migrasi data kotor menghasilkan aplikasi yang tidak dipercaya penggunanya.</p>
<h2>4. Infrastruktur dan akses</h2>
<p>Server, domain, akun email pengirim, hingga kebijakan akses jaringan — pastikan tersedia sebelum tahap uji coba.</p>
<h2>5. Rencana pelatihan dan pendampingan</h2>
<p>Sisihkan waktu untuk pelatihan bertahap. Aplikasi terbaik pun gagal bila pengguna merasa ditinggalkan di minggu pertama.</p>
HTML,
            ],
            [
                'title' => 'Studi Kasus: Menyatukan Login 6 Aplikasi dengan Single Sign-On',
                'category' => 'studi-kasus',
                'excerpt' => 'Bagaimana satu akun dengan autentikasi dua faktor menggantikan enam kata sandi berbeda, dan apa dampaknya pada tiket helpdesk.',
                'cover' => 'images/articles/sso.jpg',
                'tags' => ['sso', 'keamanan', 'perbankan'],
                'days_ago' => 21,
                'body' => <<<'HTML'
<p>Klien kami di sektor perbankan daerah mengelola enam aplikasi internal dengan enam sistem login terpisah. Lupa kata sandi menjadi tiket helpdesk terbanyak, dan penonaktifan akun pegawai yang pindah tugas kerap tertinggal di salah satu aplikasi.</p>
<h2>Pendekatan</h2>
<p>Kami membangun layanan Single Sign-On (SSO) sebagai pusat identitas. Setiap aplikasi didaftarkan sebagai klien dengan <em>client ID</em> dan <em>secret</em>, lalu autentikasi diperkuat dengan kode TOTP (2FA) dari aplikasi authenticator.</p>
<h2>Hasil</h2>
<ul>
<li>Satu akun untuk enam aplikasi; penonaktifan cukup dilakukan sekali.</li>
<li>Tiket "lupa kata sandi" turun signifikan dalam bulan pertama.</li>
<li>Log akses terpusat memudahkan audit internal.</li>
</ul>
<p>Pelajaran terbesar: migrasi dilakukan per aplikasi, bukan sekaligus, sehingga tim helpdesk siap menangani pertanyaan pengguna secara bertahap.</p>
HTML,
            ],
            [
                'title' => 'MaiHarta Hadirkan Layanan Pemeliharaan & Dukungan Berlangganan',
                'category' => 'berita',
                'excerpt' => 'Paket pemeliharaan bulanan untuk memastikan aplikasi tetap aman, terbarui, dan responsif terhadap kebutuhan baru setelah peluncuran.',
                'cover' => 'images/articles/maintenance.jpg',
                'tags' => ['layanan', 'pemeliharaan'],
                'days_ago' => 35,
                'body' => <<<'HTML'
<p>Peluncuran bukan akhir dari sebuah produk digital. Pembaruan keamanan, perubahan regulasi, hingga permintaan fitur kecil terus datang. Karena itu MaiHarta kini menyediakan layanan pemeliharaan dan dukungan berlangganan.</p>
<h2>Yang termasuk dalam paket</h2>
<ul>
<li>Pemantauan ketersediaan dan pencadangan data terjadwal.</li>
<li>Pembaruan keamanan framework dan dependensi.</li>
<li>Kuota jam pengembangan untuk penyesuaian kecil setiap bulan.</li>
<li>Dukungan prioritas melalui helpdesk pada jam kerja.</li>
</ul>
<p>Hubungi tim kami untuk menyesuaikan cakupan paket dengan kebutuhan aplikasi Anda.</p>
HTML,
            ],
        ];

        foreach ($articles as $a) {
            $daysAgo = $a['days_ago'];
            unset($a['days_ago']);
            Article::updateOrCreate(['slug' => Article::uniqueSlug($a['title'])], $a + [
                'user_id' => $author?->id,
                'status' => 'published',
                'published_at' => now()->subDays($daysAgo)->setTime(9, 0),
            ]);
        }
    }
}
