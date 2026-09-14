# Arsitektur & Panduan Pengembang

## Alur permintaan

```
Browser ─▶ routes/web.php
            ├─ PageController        → resources/views/pages/*            (publik, Blade)
            ├─ ContactController     → simpan ContactSubmission
            └─ /admin (middleware auth)
                 ├─ Admin\AuthController        login/logout (session)
                 ├─ Admin\DashboardController
                 ├─ Admin\ProjectController     resource (index/create/store/edit/update/destroy)
                 ├─ Admin\ServiceController     resource
                 ├─ Admin\MessageController     index/show/toggle/destroy
                 ├─ Admin\ContentController     edit/update per tab (skema config/content.php)
                 └─ Admin\SettingsController    profil & kata sandi
```

Tidak ada API JSON; semua server-rendered. Interaksi kecil (filter, repeater, lightbox, modal) memakai Alpine.js inline.

Guest yang membuka `/admin/*` diarahkan ke `admin.login`, user yang sudah login membuka `/admin/login` diarahkan ke dashboard (`bootstrap/app.php` → `redirectGuestsTo` / `redirectUsersTo`).

## Skema data

| Tabel | Kolom penting |
|---|---|
| `services` | `name, slug (unik), icon (code\|palette\|megaphone\|uiux\|consulting\|qa\|maintenance), short_description, description, tech_tags JSON[], process_steps JSON[{title,description,duration}], meta JSON[{label,value}], capabilities JSON[{title,description}], about_title, sort_order` |
| `projects` | `service_id FK nullable, name, slug (unik), category, client_type, short_description, description, challenge, solution, tech_summary, outcome_stats JSON[{value,label}], cover_image, gallery JSON[{src,caption}], external_url, sort_order` |
| `contact_submissions` | `name, email, phone, company, message, is_read` — pilihan layanan disimpan sebagai prefix `[Layanan: …]` di `message` |
| `settings` | `key (PK, "tab.grup"), value JSON` — hanya grup yang pernah disimpan admin |
| `users` | admin (satu akun dari `UserSeeder`) |

Model `Project` dan `Service` memakai `slug` sebagai route key. Path gambar disimpan relatif terhadap `public/` (`images/...` untuk aset seeder, `storage/...` untuk unggahan) sehingga `asset($path)` bekerja untuk keduanya.

## Konten yang bisa diedit (`settings`)

`config/content.php` adalah **satu-satunya sumber kebenaran**: mendefinisikan tab → grup → field beserta tipe dan nilai default. Dari file ini:

- `ContentController@edit` + `resources/views/admin/content/edit.blade.php` membangkitkan form (tipe `text`, `textarea`, `image`, `images`, `repeater`).
- `ContentController@update` memproses per tipe (repeater membuang baris kosong; `image`/`images` mengunggah ke `storage/app/public/content` dan menghapus file lama yang tak dipakai).
- `Setting::content()` menggabungkan default + baris tersimpan, di-cache selamanya dengan kunci yang menyertakan **hash skema** (`Setting::cacheKey()`), jadi mengubah config tidak pernah menyajikan data basi. Cache dihapus otomatis saat baris `settings` disimpan/dihapus.
- Helper global `site('tab.grup.field', $default)` (`app/Support/helpers.php`) dipakai di Blade.

**Menambah field**: tambahkan array field ke grup yang sesuai, lalu baca dengan `site()` di view. **Menghapus field/grup**: hapus dari config; view yang masih memanggilnya akan menerima `null`, jadi rapikan view-nya juga. Baris `settings` yatim tidak berbahaya (diabaikan) tetapi bisa dihapus manual.

Prinsip lingkup: yang masuk `settings` adalah **data** (identitas, angka, logo, daftar kartu). Teks halaman (hero, judul section, CTA) tetap di Blade — keputusan ini disengaja agar admin tidak dipenuhi ratusan field.

## Sistem desain → kode

`resources/css/app.css` memindahkan token dari halaman Figma *Sistem Desain* ke `@theme` Tailwind v4:

| Figma | Tailwind |
|---|---|
| `color/dark`, `color/normal`, `color/light`, `color/border`, … | `bg-brand-dark`, `text-brand-normal`, `bg-brand-light`, `border-brand-border`, … |
| `color/text-muted`, `text-on-dark`, `success*`, `error*` | `text-brand-muted`, `text-brand-on-dark`, `bg-success-bg`, `text-error`, … |
| Text style `Display Small … Chip` | `text-display-sm`, `text-h1-hero`, `text-h2-lg`, `text-h2`, `text-h3`, `text-h4`, `text-h5`, `text-body`, `text-body-sm`, `text-caption`, `text-label`, `text-label-sm`, `text-chip`, `text-nav` |
| Effect style `Shadow Card / Elevated / Floating / Hero / Showcase` | `shadow-card`, `shadow-elevated`, `shadow-floating`, `shadow-hero`, `shadow-showcase` |
| Radius 16 / 20 / 24 | `rounded-card`, `rounded-panel`, `rounded-cta` |

Utilitas tambahan: `container-site` (maks 1440 px, padding 20/80), `bg-hero-gradient`, `bg-cta-gradient`, `bg-button-gradient`, `text-gradient-brand` (judul bergradien dengan ruang descender), `overline`.

Komponen Blade publik (`resources/views/components/`): `button` (primary/outline/gradient/white/ghost × sm/md/lg + ikon), `chip` (light/outline/accent/success/error/on-dark), `card`, `section-head`, `page-hero`, `cta-panel`, `stat` (count-up), `filter-tabs` (Alpine), `project-card`, `service-icon`, `empty-state`. Komponen admin di `components/admin/` (`layouts.app`, `card`, `field`, `button`, `confirm-delete`, `empty`).

## Animasi

Semua di `app.css` + `app.js`, tanpa library:

- `[data-animate]` — muncul (fade + slide) sekali saat masuk viewport via IntersectionObserver; `[data-animate="scale"]` varian skala. Di dalam `[data-animate-group="0.08"]` delay dihitung otomatis per anak (stagger).
- `animate-float` (loop melayang; `--float-dur`, `--float-delay`, `--float-amp`), `animate-shimmer` (gradien judul), `animate-bar` (bar chart tumbuh, `--bar-delay`), `animate-fill`, `animate-draw` (garis putus-putus), `animate-typing`, `animate-glow`.
- `[data-count="199"][data-suffix="+"]` — angka berhitung saat terlihat.
- Semua dimatikan pada `prefers-reduced-motion: reduce`.

Nama layer di Figma (`Float → Dashboard Card`, dst.) sama dengan komentar di `home.blade.php` untuk memudahkan penelusuran.

## Unggahan file

- Disk `public` (`storage/app/public`), disajikan lewat symlink `public/storage` (`php artisan storage:link`).
- Proyek: `projects/` (sampul) dan `projects/gallery/`; konten: `content/`. Maks 2 MB, validasi `image`.
- Saat mengganti/menghapus, file lama yang berawalan `storage/` dihapus; aset seeder di `images/` tidak pernah dihapus.

## Pengujian

`tests/Feature/AdminPanelTest.php` (auth, CRUD, inbox, pengaturan, nomor WA) dan `tests/Feature/ContentEditorTest.php` (default, tab, logo, hero, sertifikasi/narasi, durasi tahap, angka & identitas, logo partner, meta/kapabilitas layanan). Konfigurasi `phpunit.xml`: SQLite `:memory:`, `Storage::fake('public')` di `setUp`.

## Konvensi

- Bahasa antarmuka & pesan validasi: Indonesia. Nama variabel/kode: Inggris.
- Route admin diberi nama `admin.*`; route publik `home`, `layanan.*`, `portofolio.*`, `sertifikasi`, `tentang`, `kontak`.
- Commit: pesan berbahasa Indonesia dengan prefix `feat/fix/chore/refactor(scope)`.
- File dari Windows memakai CRLF; Git akan menormalkan ke LF (peringatan `CRLF will be replaced` aman diabaikan).

## Pekerjaan yang belum ada

- Notifikasi email untuk pesan kontak masuk.
- Sitemap/robots/Open Graph image, halaman Kebijakan Privasi.
- Multi-user / peran admin (saat ini satu akun).
- API (belum ada konsumen eksternal).
