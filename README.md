# MaiHarta — Website Perusahaan & Panel Admin

Website profil perusahaan MaiHarta ("Ngga Ada Habisnya") beserta panel admin untuk mengelola proyek, layanan, pesan kontak, dan konten tertentu. Dibangun dari desain Figma **MAIHARTA-REDESIGN** (halaman *UI Design — High Fidelity* dan *Sistem Desain*).

| | |
|---|---|
| Framework | Laravel 12 (PHP 8.2) |
| Front end | Blade + Tailwind CSS v4 + Alpine.js 3, Vite 7 |
| Ikon | Heroicons (blade-heroicons), Simple Icons / Bootstrap Icons untuk logo medsos |
| Database | MySQL (dev: Laragon), SQLite in-memory untuk test |
| Repo | https://github.com/anantamahayana/maiharta-website |

Dokumen terkait:
- [docs/panduan-admin.md](docs/panduan-admin.md) — panduan pemakaian panel admin untuk pengelola konten.
- [docs/arsitektur.md](docs/arsitektur.md) — struktur kode, skema data, sistem desain, dan cara memperluas.

---

## 1. Menjalankan secara lokal

Prasyarat: PHP ≥ 8.2 (ekstensi `fileinfo`, `pdo_mysql`), Composer, Node ≥ 20, MySQL.

```bash
git clone https://github.com/anantamahayana/maiharta-website.git
cd maiharta-website
composer install
npm install
cp .env.example .env          # lalu isi DB_DATABASE / DB_USERNAME / DB_PASSWORD
php artisan key:generate
php artisan migrate --seed    # tabel + 7 layanan + 6 proyek + akun admin
php artisan storage:link      # untuk file unggahan (sampul, galeri, logo)
```

Jalankan dua proses:

```bash
php artisan serve --port=8000
```

```bash
npm run dev
```

Buka http://localhost:8000. Untuk produksi ganti `npm run dev` dengan `npm run build`.

**Akun admin awal** (dibuat oleh `UserSeeder`): `admin@maiharta.com` / `password` — atau set `ADMIN_PASSWORD` di `.env` sebelum seeding. **Ganti kata sandi** lewat *Pengaturan* setelah login pertama.

## 2. Peta halaman

### Publik

| Rute | Halaman | Sumber data |
|---|---|---|
| `/` | Beranda | 3 layanan & 3 proyek teratas, angka perusahaan, komposisi hero |
| `/layanan` | Daftar layanan + filter | `services` |
| `/layanan/{slug}` | Detail layanan | `services` (meta, kapabilitas, proses, tag), proyek terkait |
| `/portofolio` | Daftar proyek + filter kategori | `projects` |
| `/portofolio/{slug}` | Studi kasus | `projects` (sampul, stats, tantangan/solusi/teknologi, galeri + lightbox) |
| `/sertifikasi` | Sertifikasi & keamanan | `settings` (praktik, sertifikasi lain) |
| `/tentang` | Tentang | `settings` (narasi, logo partner/klien), angka perusahaan |
| `/kontak` | Form kontak + info | `settings` (identitas, peta, medsos); POST → `contact_submissions` |
| `404` | Halaman tidak ditemukan | — |

### Admin (`/admin`, wajib login)

| Rute | Fungsi |
|---|---|
| `/admin/login` | Masuk (throttle 5×/menit, "ingat saya") |
| `/admin` | Dashboard: ringkasan angka, pesan terbaru, aksi cepat |
| `/admin/projects` | CRUD proyek: sampul, galeri + caption, statistik hasil, slug otomatis |
| `/admin/services` | CRUD layanan: ikon, tag teknologi, tahap proses (+durasi), kartu meta, kapabilitas |
| `/admin/messages` | Inbox pesan kontak: filter/cari, tandai dibaca, hapus, balas via email/WhatsApp |
| `/admin/content/{tab}` | Konten Website: *Umum & Kontak*, *Beranda*, *Sertifikasi*, *Tentang* |
| `/admin/settings` | Profil & kata sandi admin |

Daftar lengkap: `php artisan route:list`.

## 3. Apa yang bisa diedit dari admin, apa yang tidak

**Dari admin** — data yang memang berubah dari waktu ke waktu:
- Proyek dan layanan (seluruh kolomnya).
- Pesan kontak.
- Identitas: logo, email, telepon/WA, alamat, jam, tautan Maps, medsos; angka perusahaan (tahun / proyek / instansi).
- Komposisi kartu melayang di hero Beranda (teks kartu & dua foto).
- Kartu praktik keamanan dan daftar sertifikasi lain.
- Narasi "Siapa Kami" dan logo partner/klien.

**Di kode (Blade)** — teks halaman yang jarang berubah: judul/deskripsi hero, judul section, CTA, poin sertifikasi ISO 27001, nilai kerja, teks form kontak. File: `resources/views/pages/*.blade.php`.

Menambah field baru yang bisa diedit hanya perlu satu baris di `config/content.php` (lihat [docs/arsitektur.md](docs/arsitektur.md#konten-yang-bisa-diedit-settings)).

## 4. Pengujian

```bash
php artisan test
```

20 feature test (SQLite in-memory): auth admin, CRUD proyek termasuk unggah & pembersihan file, parsing tag/tahap layanan, inbox, pengaturan, editor konten (default, upload logo, repeater, gambar), form kontak + normalisasi nomor WhatsApp.

Catatan: PHP CLI di mesin pengembangan tidak memuat ekstensi GD, sehingga tes memakai file gambar asli dari `public/images` alih-alih `UploadedFile::fake()->image()`.

## 5. Deploy (ringkas)

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan db:seed --class=ServiceSeeder --force   # opsional, data awal
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Pastikan `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://…`, kredensial DB, dan `ADMIN_PASSWORD` kuat sebelum `UserSeeder` dijalankan. Direktori `storage/` dan `bootstrap/cache/` harus bisa ditulis web server. Belum ada pengiriman email untuk pesan kontak masuk (pesan hanya tersimpan di DB dan tampil di admin).

## 6. Struktur singkat

```
app/
  Http/Controllers/PageController.php       halaman publik
  Http/Controllers/ContactController.php    form kontak
  Http/Controllers/Admin/*                  Auth, Dashboard, Project, Service, Message, Content, Settings
  Models/{Project,Service,ContactSubmission,Setting,User}.php
  Support/helpers.php                       site('umum.brand.email') → konten dari settings
config/content.php                          skema konten yang bisa diedit + nilai default
database/migrations, seeders                Service/Project/User seeder = data awal
resources/css/app.css                       token desain (@theme), utilitas, animasi
resources/js/app.js                         scroll-reveal, count-up
resources/views/components/*                komponen publik (button, chip, card, page-hero, …)
resources/views/components/admin/*          komponen admin (layout, field, button, confirm-delete, …)
resources/views/pages/*                     halaman publik
resources/views/admin/*                     halaman admin
public/images/                              aset statis (logo, foto hero, proyek seeder, logo partner)
storage/app/public/{projects,content}/      unggahan dari admin (di-symlink ke public/storage)
tests/Feature/*                             AdminPanelTest, ContentEditorTest
```
