# Analisis & Rencana Perbaikan — Laporan Bug Tim Testing (17/09/2026)

Sumber: `laporan bug redesign.pdf` (2 halaman, 10 temuan). Setiap temuan dianalisis akar masalahnya di kode, diberi prioritas, dan rencana perbaikan konkret.

Prioritas: **P1** = menghambat fungsi/alur utama · **P2** = fungsional tapi salah/tidak konsisten · **P3** = polesan tampilan.

| # | Temuan tim testing | Area | Prioritas | Estimasi |
|---|---|---|---|---|
| 1 | Alamat di footer tidak bisa diklik (di halaman Kontak bisa) | Publik — Footer | P3 | 10 mnt |
| 2 | Section logo partner/klien terasa kosong di kanan; referensi: logo berjalan (marquee) seperti interlacestudies.id | Publik — Tentang | P2 | 1 jam |
| 3 | Validasi form kontak memakai popup bawaan browser ("Harap isi bidang ini"); ingin pesan inline sederhana seperti login admin; aturan: email wajib `@` + `.com`, telepon wajib angka | Publik — Kontak | P2 | 1 jam |
| 4 | "Balas via Email" tidak langsung membuka Gmail seperti tombol WhatsApp | Admin — Pesan | P2 | 20 mnt |
| 5 | Validasi di admin masih campur (popup browser vs inline) | Admin — semua form | P2 | 45 mnt |
| 6 | "Lupa kata sandi" di admin belum berfungsi | Admin — Login | P1 | 2 jam |
| 7 | Setelah ubah sandi lalu logout → **419 Page Expired**, bukan form login; "sering" terjadi saat logout | Admin — Auth | P1 | 30 mnt |
| 8 | Label "Baru" kurang cocok untuk pesan 23 jam; ganti "Belum dibaca", samakan Dashboard & halaman Pesan | Admin — Pesan/Dashboard | P3 | 15 mnt |
| 9 | Waktu di admin salah (tampil 06:46 WITA padahal siang) | Admin — Pesan | P1 | 15 mnt |
| 10 | Teks kartu "Hasil & Outcome" di detail proyek meluber keluar kotak (mis. "1000000") | Publik — Detail Proyek | P2 | 30 mnt |

Total estimasi: ±7 jam kerja (1 hari).

---

## Analisis per temuan

### 1. Alamat footer tidak bisa diklik
- **Kode**: `resources/views/components/footer.blade.php:26` merender alamat sebagai `<li>` teks biasa, sedangkan kartu Kontak membungkusnya dengan `<a href="{maps_url}">`.
- **Akar masalah**: inkonsistensi markup — footer dibuat sebelum field *Tautan Google Maps* ada di admin.
- **Perbaikan**: bungkus alamat dengan `<a href="{{ site('umum.brand.maps_url') }}" target="_blank" rel="noopener">` (fallback teks biasa jika URL kosong); email/telepon di footer juga dipastikan `mailto:`/`tel:`.

### 2. Section logo partner/klien kosong di kanan → marquee
- **Kode**: `pages/tentang.blade.php` menampilkan dua kotak (Partner 2 logo, Klien 5 logo) rata kiri; sisa lebar kosong.
- **Akar masalah**: layout kotak statis tidak cocok untuk jumlah logo sedikit/berubah-ubah.
- **Perbaikan**: ganti dengan **marquee** satu baris penuh lebar: logo diulang (duplikasi list) dan digeser dengan animasi CSS `@keyframes marquee` (translateX −50 %), jeda saat hover, fade di tepi kiri/kanan (mask-image), dua kelompok tetap diberi label kecil "Partner" / "Klien" atau digabung satu baris berlabel "Dipercaya oleh". Mati pada *reduced motion* (tampil grid biasa). Sinkronkan ke Figma.

### 3. Validasi form kontak
- **Kode**: `pages/kontak.blade.php` memakai atribut `required` dan `type="email"` → browser memunculkan tooltip bawaan sebelum request sampai ke Laravel, sehingga pesan inline (`@error`) yang sudah ada tidak pernah tampil. Aturan server: `email` (RFC) dan `phone` regex longgar (boleh `+ ( ) . -`).
- **Akar masalah**: validasi HTML5 mendahului validasi server; aturan server berbeda dari yang diminta.
- **Perbaikan**:
  1. Tambah `novalidate` pada `<form>`; hapus `required`/`type=email` sebagai pemicu (tetap pakai `inputmode`/`autocomplete`).
  2. Validasi **client-side ringan** dengan Alpine saat submit/blur: nama wajib, email wajib pola `x@y.z` (mengandung `@` dan domain bertitik — lebih aman dari sekadar `.com`, karena klien pemerintah memakai `.go.id`), telepon hanya angka (boleh awalan `+`), pesan wajib. Pesan error inline dengan ikon ⓘ merah — komponen yang sama dengan login admin.
  3. Samakan aturan server: `phone` → `regex:/^\+?[0-9]{8,15}$/`, pesan error Bahasa Indonesia; tetap jadi jaring pengaman.
- **Catatan ke tim**: "wajib `.com`" tidak dipakai literal — alasan di atas; email `nama@perusahaan.go.id` harus tetap valid.

### 4. "Balas via Email" tidak membuka Gmail
- **Kode**: `admin/messages/index.blade.php:72` memakai `mailto:` → membuka aplikasi email default OS (di Windows sering Mail/Outlook atau tidak ada), bukan Gmail di browser.
- **Perbaikan**: ubah ke tautan compose Gmail: `https://mail.google.com/mail/?view=cm&fs=1&to={email}&su={subjek}&body={salam}` dengan `target="_blank"`, konsisten dengan tombol WhatsApp. Sediakan opsi kecil "Buka di aplikasi email" (mailto) sebagai alternatif.

### 5. Validasi admin belum konsisten
- **Kode**: form admin (Proyek, Layanan, Pengaturan, Login) sebagian memakai `required` (popup browser), sebagian mengandalkan `@error` server.
- **Perbaikan**: standar tunggal — semua `<form>` admin `novalidate`, komponen `x-admin.field` menampilkan error inline (sudah ada), tambah validasi Alpine untuk field wajib agar feedback instan tanpa reload. Audit: `admin/login`, `projects/form`, `services/form`, `settings`, `content/edit`.

### 6. Lupa kata sandi belum berfungsi
- **Kode**: `admin/login.blade.php:40` — tautan hanya `mailto:info@maiharta.com`; tidak ada rute reset.
- **Perbaikan**: implementasi alur reset standar Laravel (tabel `password_reset_tokens` sudah ada dari migrasi bawaan):
  1. Rute `admin/lupa-sandi` (form email) → `Password::sendResetLink` → email berisi tautan.
  2. Rute `admin/reset-sandi/{token}` (form sandi baru) → `Password::reset`.
  3. Notifikasi email berbahasa Indonesia, bergaya brand.
  4. Prasyarat: konfigurasi `MAIL_*` di `.env` (SMTP Gmail/Brevo). Untuk lokal pakai `MAIL_MAILER=log`. Tanpa SMTP, tautan tidak akan sampai — **perlu keputusan klien: akun SMTP apa yang dipakai.**
  5. Tes fitur: kirim link, token valid/kedaluwarsa, sandi berubah.

### 7. Logout → 419 Page Expired
- **Kode**: tombol logout di sidebar = form POST + `@csrf`. `AuthController@logout` sudah `invalidate()` + `regenerateToken()`. Ubah sandi (`SettingsController@updatePassword`) **tidak** meregenerasi sesi.
- **Akar masalah**: token CSRF pada halaman yang sudah lama terbuka (atau tab lain) tidak lagi cocok setelah sesi berubah/kedaluwarsa (`SESSION_LIFETIME` 120 mnt) → Laravel menolak POST logout dengan 419. Ini juga terjadi bila halaman admin dibuka > 2 jam lalu klik logout.
- **Perbaikan**:
  1. Tangani `TokenMismatchException`/419 khusus rute logout: di `bootstrap/app.php` → jika 419 dan path `admin/logout`, langsung logout & redirect ke login (sesi sudah tidak valid, tidak ada risiko CSRF).
  2. Setelah ubah sandi: `$request->session()->regenerate()` agar token/sesi segar.
  3. Halaman 419 umum diganti tampilan brand dengan tombol "Muat ulang" (bukan layar hitam Laravel).

### 8. Label "Baru" → "Belum dibaca"
- **Kode**: `dashboard.blade.php:34` chip "Baru"; `messages/index.blade.php:68` "Baru"/"Sudah dibaca".
- **Perbaikan**: satu helper/komponen `x-admin.read-status` dengan teks "Belum dibaca" / "Sudah dibaca" dan warna sama, dipakai di Dashboard, daftar Pesan, dan detail Pesan.

### 9. Waktu admin salah
- **Kode**: `config/app.php` `timezone => 'UTC'`, tetapi view menulis label "WITA" secara hardcode → jam tampil UTC (mundur 8 jam).
- **Perbaikan**: set `APP_TIMEZONE=Asia/Makassar` (`.env` + `config/app.php` membaca env), ganti label hardcode dengan `->timezone(config('app.timezone'))` + `->translatedFormat(...)` dan singkatan zona dari konfigurasi. Cek semua `created_at` di admin (dashboard, pesan, proyek). Data lama tersimpan UTC — tidak perlu migrasi, konversi terjadi saat tampil.

### 10. Teks kartu Outcome meluber
- **Kode**: `portofolio/show.blade.php:130-133` — kartu `md:w-[150px]` dengan angka `text-[32px]`; nilai panjang ("1000000", "Responsif") tidak dibungkus/dikecilkan.
- **Perbaikan**:
  1. Hapus lebar tetap; grid 3 kolom `minmax(0,1fr)` + `min-w-0`, `break-words`.
  2. Ukuran angka adaptif: `text-[clamp(20px,2.2vw,32px)]` dan/atau kecilkan otomatis bila panjang > 6 karakter (kelas `text-2xl`).
  3. Di admin form proyek: batasi nilai stat maks 8 karakter + hint "gunakan singkatan, mis. 1 jt / 100%" agar konten tetap rapi.
  4. Terapkan pola yang sama di kartu statistik hero Beranda/Tentang.

---

## Urutan pengerjaan (1 hari)

| Sesi | Item | Alasan |
|---|---|---|
| Pagi 1 | **#9** timezone → **#7** logout 419 → **#8** label | Cepat, P1, saling berdekatan (admin) |
| Pagi 2 | **#10** kartu outcome → **#1** footer → **#4** Gmail | Perbaikan tampilan publik yang terlihat klien |
| Siang 1 | **#3** validasi kontak → **#5** validasi admin | Satu komponen validasi inline dipakai keduanya |
| Siang 2 | **#2** marquee logo (+ Figma) | Butuh desain & animasi |
| Sore | **#6** lupa sandi | Paling besar; butuh SMTP dari klien — bisa selesai dengan `MAIL_MAILER=log` dulu |

Setiap item: perbaiki → tes otomatis (`php artisan test`, tambah tes untuk #3, #6, #7, #9) → cek di browser desktop & mobile → commit terpisah dengan referensi nomor temuan → update log defect di `docs/testing-manual.md`.

## Keputusan yang dibutuhkan dari klien/tim
1. **SMTP** untuk email reset sandi & (opsional) notifikasi pesan kontak masuk — alamat pengirim dan kredensial.
2. Aturan email di form kontak: **menerima semua domain valid** (rekomendasi) atau hanya `.com`?
3. Marquee logo: satu baris gabungan "Dipercaya oleh" atau tetap dua kelompok Partner/Klien?
