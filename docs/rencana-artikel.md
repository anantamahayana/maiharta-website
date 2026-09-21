# Rencana: Hapus Fitur Sertifikasi → Ganti Fitur Artikel

Tanggal: 21/09/2026 · Status: **disetujui, dikerjakan**

**Keputusan (21/09):** A = hapus **semua** klaim ISO/sertifikasi (MaiHarta belum memiliki sertifikasi apa pun) · B = editor **Quill** · C = nama menu **"Blog"**, rute `/blog`, referensi tata letak https://kerjaindo.co.id/blog (hero + badge, filter chip, kartu unggulan 3:1 berlabel "Pilihan", grid 16:9 dengan tanggal · menit baca, "Menampilkan 1–9 dari N"; detail: breadcrumb, ringkasan, meta penulis/bagikan, sidebar Artikel Terkait + CTA).

## 1. Apa yang dihapus (Sertifikasi)

Inventaris dari grep di seluruh codebase:

| Lokasi | Isi | Tindakan |
|---|---|---|
| `routes/web.php:27` | `GET /sertifikasi` | Hapus; tambah redirect 301 `/sertifikasi → /blog` agar tautan lama tidak 404 |
| `app/Http/Controllers/PageController.php@sertifikasi` | Method halaman | Hapus |
| `resources/views/pages/sertifikasi.blade.php` | Halaman (panel ISO, kartu praktik keamanan, sertifikasi lain) | Hapus |
| `config/content.php` → tab `sertifikasi` (grup `praktik`, `lainnya`) | Konten yang bisa diedit admin | Hapus tab; data `Setting` lama dibiarkan (tidak dibaca, tidak merusak) |
| `resources/views/components/navbar.blade.php` | Link "Sertifikasi" | Ganti → "Artikel" |
| `resources/views/components/footer.blade.php:16` | Link "Sertifikasi" | Ganti → "Artikel" |
| `resources/views/pages/home.blade.php` § *Kredibilitas & Keamanan* | Section 3 poin keamanan + kartu ISO gelap, link ke `/sertifikasi` | Ganti → section **"Artikel Terbaru"** (3 artikel terakhir) |
| `resources/views/pages/layanan/index.blade.php:26` | Stat hero `['ISO', '27001']` | Ganti stat menjadi jumlah artikel / hapus |
| `tests/Feature/ContentEditorTest.php` | Tes kartu sertifikasi | Hapus tes tsb |
| `docs/*.md`, `README.md` | Dokumentasi | Perbarui |
| Figma: frame *Sertifikasi (Desktop)*, *Mobile → Sertifikasi*, *Content Stack (Sertifikasi)*, *Admin — Konten Website — Sertifikasi* | Desain | Ganti dengan frame Artikel (daftar + detail + admin) |

**Ikut dihapus (keputusan A — perusahaan belum tersertifikasi):**
- Badge hero Beranda "Bersertifikasi ISO/IEC 27001" + kartu ISO melayang di hero (teksnya diedit di admin → Beranda).
- Tagline footer "Dibuat dengan standar keamanan ISO/IEC 27001".
- Meta layanan "Standar: ISO 27001" di seeder layanan.

## 2. Apa yang dibangun (Artikel)

### Data
Tabel `articles`:

| Kolom | Tipe | Keterangan |
|---|---|---|
| id, timestamps | | |
| title | string | wajib |
| slug | string unique | otomatis dari judul, bisa diubah |
| excerpt | string 300 | ringkasan untuk kartu & meta description |
| body | longtext | konten HTML dari editor |
| cover | string nullable | path gambar sampul (`storage/content/…`) |
| category | string | Berita · Tips & Wawasan · Studi Kasus · Pengumuman (daftar di `config/content.php` agar bisa ditambah) |
| tags | json nullable | chip kecil |
| status | enum draft/published | draft tidak tampil publik |
| published_at | datetime nullable | jadwal tayang; publik hanya bila ≤ sekarang |
| is_featured | bool | tampil sebagai kartu besar di halaman Artikel & Beranda |
| user_id | FK users | penulis (nama tampil "Oleh …") |
| views | unsigned int | penghitung baca sederhana |

Seeder: 4 artikel contoh (1 unggulan) dengan sampul dari `public/images/articles/`.

### Publik
| Rute | Halaman | Isi |
|---|---|---|
| `GET /blog` | Daftar | Hero (eyebrow "Artikel", judul, stat jumlah artikel), kartu unggulan besar, chip filter kategori (pola sama dengan Portofolio, tanpa reload), grid kartu (sampul 16:9, kategori, judul, ringkasan, tanggal · waktu baca), paginasi 9/halaman, state kosong |
| `GET /blog/{slug}` | Detail | Breadcrumb, kategori, judul, meta (penulis · tanggal · X menit baca), sampul, isi artikel dengan tipografi baca (`prose` kustom brand), chip tag, tombol bagikan (WhatsApp · salin tautan), 3 "Artikel Terkait" (kategori sama), CTA konsultasi |
| Beranda | Section "Artikel Terbaru" | 3 artikel terbaru + tombol "Lihat Semua Artikel"; section disembunyikan bila belum ada artikel |
| SEO | | `<title>`, meta description dari excerpt, Open Graph image dari sampul, `article:published_time` |

Komponen baru: `x-article-card`, `x-prose` (gaya isi artikel). Navbar & bottom nav: "Sertifikasi" → "Artikel" (ikon `newspaper`).

### Admin
| Rute | Fungsi |
|---|---|
| `admin/articles` | Daftar: sampul mini, judul, kategori, status (chip Draft/Tayang/Terjadwal), tanggal, views; pencarian judul; filter status & kategori; urut terbaru |
| `admin/articles/create`, `/{id}/edit` | Form: judul (slug otomatis), kategori, tag, ringkasan (hitung karakter), **editor teks kaya** (Quill via CDN: heading, bold/italic, list, link, kutipan, gambar via unggah), sampul (unggah + preview + hapus), status, jadwal tayang, unggulan; tombol "Pratinjau" membuka halaman publik dengan token draft |
| `DELETE admin/articles/{id}` | Hapus dengan modal konfirmasi (pola yang ada); sampul & gambar isi ikut dihapus |
| Sidebar | "Sertifikasi" tidak ada di sidebar (dulu di Konten Website); tambah menu **Artikel** (ikon newspaper) di atas Pesan Kontak |
| Dashboard | Kartu ringkasan "Artikel tayang / draft" + daftar 3 artikel terakhir |
| Konten Website | Tab Sertifikasi dihapus → 3 tab: Umum & Kontak, Beranda, Tentang |

Unggah gambar di editor: endpoint `POST admin/articles/upload` (validasi gambar ≤ 2 MB, simpan ke `storage/content/articles`).

### Pengujian
- `tests/Feature/ArticleTest.php`: daftar & detail publik, draft/terjadwal tersembunyi (404), CRUD admin, unggah sampul, hapus membersihkan file, redirect `/sertifikasi → /blog`, section Beranda muncul/hilang.
- `docs/testing-manual.md`: hapus CERT-01..03, tambah modul **ART** (publik, 6 kasus) dan **AART** (admin, 8 kasus); log defect tidak berubah.

## 3. Urutan pengerjaan

| Langkah | Isi | Estimasi |
|---|---|---|
| 1 | Migrasi, model, factory, seeder, config kategori | 45 mnt |
| 2 | Admin: controller, daftar, form (editor Quill, sampul), hapus, upload, sidebar, dashboard | 2,5 jam |
| 3 | Publik: daftar + filter + paginasi, detail + prose + terkait + bagikan, komponen kartu | 2 jam |
| 4 | Ganti section Beranda, navbar/bottom nav/footer, stat layanan, redirect | 45 mnt |
| 5 | Hapus semua kode/konfigurasi/tes sertifikasi | 30 mnt |
| 6 | Tes fitur + verifikasi browser desktop & mobile | 1 jam |
| 7 | Dokumentasi (README, arsitektur, panduan admin, testing manual) | 30 mnt |
| 8 | Figma: frame Artikel (daftar, detail, mobile, admin daftar & form), hapus frame Sertifikasi, tambah ke sistem desain | 1,5 jam |

Total ±9,5 jam (≈1,5 hari). Satu commit per langkah.

## 4. Keputusan yang dibutuhkan

**A. Klaim ISO/IEC 27001 di luar halaman Sertifikasi** — badge hero Beranda, kartu ISO melayang, tagline footer, meta layanan. Rekomendasi: **tetap dipertahankan** (itu identitas brand, bukan fitur; teksnya bisa diubah admin). Alternatif: hapus semuanya sekalian.

**B. Editor isi artikel** — Rekomendasi: **Quill** (ringan, dari CDN, tanpa build tambahan, mendukung gambar). Alternatif: textarea Markdown sederhana (lebih ringan, tapi kurang ramah untuk admin non-teknis).

**C. Nama menu** — "Artikel" (rekomendasi) atau "Blog" / "Berita"?
