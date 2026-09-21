# Modul Testing Manual — Website MaiHarta

Dokumen ini berisi skenario pengujian manual (black-box) untuk website publik dan panel admin MaiHarta. Gunakan sebelum serah-terima ke klien dan setiap kali ada perubahan besar.

## 1. Informasi Umum

| Item | Nilai |
|---|---|
| Aplikasi | Website Company Profile MaiHarta (Laravel 12, Tailwind v4, Alpine.js) |
| Lingkungan uji | Lokal `http://localhost:8000` / tunnel ngrok / staging |
| Akun admin uji | `admin@maiharta.com` (kata sandi sesuai `ADMIN_PASSWORD`, default `password`) |
| Perangkat minimum | Desktop Chrome/Edge/Firefox terbaru · Android Chrome · iOS Safari |
| Viewport uji | 1440, 1280, 768, 390 px |

**Cara mengisi:** setiap kasus diberi status **Pass / Fail / Blocked / Skip**. Untuk Fail, catat langkah, hasil aktual, dan lampirkan tangkapan layar di kolom Catatan.

**Prasyarat:** `php artisan migrate --seed`, `npm run build`, `php artisan storage:link`, server berjalan.

---

## 2. Ringkasan Cakupan

| Modul | Jumlah kasus | Kode |
|---|---|---|
| Navigasi & layout global | 10 | NAV |
| Beranda | 8 | HOME |
| Layanan & Detail Layanan | 6 | SVC |
| Portofolio & Detail Proyek | 7 | PORT |
| Blog (publik) | 7 | BLOG |
| Tentang | 4 | ABOUT |
| Kontak (form) | 8 | CONTACT |
| Tombol WhatsApp melayang | 5 | WA |
| Responsif & mobile | 8 | RESP |
| Aksesibilitas & performa | 6 | A11Y |
| Admin — Autentikasi | 7 | AUTH |
| Admin — Dashboard | 2 | DASH |
| Admin — Proyek | 9 | APRJ |
| Admin — Layanan | 6 | ASVC |
| Admin — Blog | 8 | ABLOG |
| Admin — Pesan Kontak | 5 | AMSG |
| Admin — Konten Website | 11 | ACNT |
| Admin — Pengaturan | 5 | ASET |
| Halaman error & state | 4 | ERR |
| **Total** | **127** | |

---

## 3. Skenario Pengujian — Website Publik

### NAV — Navigasi & Layout Global

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| NAV-01 | Navbar tampil sebagai pill melayang | Buka halaman apa pun di desktop | Navbar berbentuk kapsul rounded, mengambang ±20 px dari atas, latar putih transparan + blur, tidak menutupi konten | | |
| NAV-02 | Navbar mengecil saat scroll | Scroll ke bawah > 8 px | Tinggi pill berkurang (76→68 px), logo mengecil, latar lebih pekat, bayangan lebih kuat; kembali saat scroll ke atas | | |
| NAV-03 | Link aktif | Buka tiap halaman utama | Link halaman aktif berbentuk pill putih dengan teks biru; link lain abu-abu, hover memutih | | |
| NAV-04 | Semua link navbar berfungsi | Klik Beranda, Solusi Kita, Portofolio, Blog, Tentang, Kontak Kami | Setiap link membuka halaman yang benar tanpa error | | |
| NAV-05 | Logo mengarah ke Beranda | Klik logo dari halaman lain | Kembali ke `/` | | |
| NAV-06 | Footer lengkap | Scroll ke footer semua halaman | Logo putih, deskripsi, navigasi, email/telepon/alamat sesuai admin, tahun copyright benar | | |
| NAV-07 | Link footer berfungsi | Klik semua link footer | Halaman sesuai; email = `mailto:`, telepon = `tel:` | | |
| NAV-08 | Tidak ada garis di atas label subjudul | Periksa label kecil kapital (eyebrow) di semua section | Tidak ada garis/underline/overline pada label | | |
| NAV-09 | Warna brand konsisten | Bandingkan warna utama tombol/link dengan logo | Biru #2155CD; tidak ada sisa warna cyan lama | | |
| NAV-10 | Favicon & judul tab | Lihat tab browser | Favicon logo MaiHarta; judul `<Halaman> — MaiHarta` | | |

### HOME — Beranda

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| HOME-01 | Hero tampil lengkap | Buka `/` | Badge "Dipercaya N instansi & bisnis", judul dengan kata bergradien, deskripsi, 2 tombol CTA, daftar keunggulan | | |
| HOME-02 | Animasi hero | Muat ulang halaman | Judul shimmer, kartu melayang naik-turun, bar chart tumbuh dari bawah, angka berhitung naik (counter), garis putus-putus tergambar | | |
| HOME-03 | Isi kartu hero dari admin | Ubah teks kartu di Admin → Konten Website → Beranda, simpan | Teks di kartu hero berubah sesuai input | | |
| HOME-04 | Angka perusahaan | Bandingkan angka Proyek/Instansi/Tahun dengan Admin → Umum & Kontak | Sama; `{tahun}` diganti tahun berjalan | | |
| HOME-04b | Strip "Dipercaya oleh" | Scroll tepat di bawah hero | Satu baris logo partner+klien berjalan (abu-abu, berhenti saat hover); hilang bila tidak ada logo | | |
| HOME-05 | Section Solusi | Scroll ke "Satu Mitra untuk Seluruh Kebutuhan Digital Anda" | 3 kartu layanan unggulan, link "Pelajari Lebih Lanjut" ke detail layanan | | |
| HOME-06 | Section Portofolio | Scroll ke "Bukti Nyata Kapabilitas Kami" | 3 proyek unggulan dengan gambar, kategori, link ke detail; "Lihat Semua Proyek" ke `/portofolio` | | |
| HOME-07 | Section Blog & Tentang | Scroll lanjut | 3 artikel terbaru + "Lihat Semua Artikel" (section hilang bila belum ada artikel), 3 nilai kerja, tombol "Kenali Kami Lebih Dekat" | | |
| HOME-08 | CTA akhir | Klik "Hubungi Kami Sekarang" dan "Lihat Layanan" | Menuju `/kontak` dan `/layanan` | | |

### SVC — Layanan

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| SVC-01 | Daftar layanan | Buka `/layanan` | Hero dengan statistik, layanan utama (kartu gelap), grid layanan lain bernomor | | |
| SVC-02 | Filter kategori | Klik chip kategori (Pengembangan, Desain, dll.) | Daftar terfilter tanpa reload; chip aktif berwarna gelap; "Semua" menampilkan semuanya | | |
| SVC-03 | Detail layanan | Klik "Pelajari Lebih Lanjut" pada salah satu layanan | `/layanan/{slug}` terbuka: breadcrumb, judul, deskripsi, kapabilitas, proses/durasi, proyek terkait | | |
| SVC-04 | Layanan nonaktif tersembunyi | Nonaktifkan layanan di admin | Tidak tampil di daftar; URL langsung → 404 | | |
| SVC-05 | Section "Empat Langkah" | Scroll di `/layanan` | 4 kartu langkah tampil dengan nomor dan deskripsi | | |
| SVC-06 | Slug tidak ada | Buka `/layanan/tidak-ada` | Halaman 404 bergaya MaiHarta | | |

### PORT — Portofolio

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| PORT-01 | Daftar proyek | Buka `/portofolio` | Hero dengan statistik, proyek unggulan besar, grid proyek lain | | |
| PORT-02 | Filter kategori + hitungan | Klik chip kategori | Jumlah di chip sesuai; grid terfilter; teks "Menampilkan …" berubah | | |
| PORT-03 | Filter kosong | Pilih kategori yang tidak punya proyek (jika ada) | Tampil state "belum ada proyek" dengan tombol reset, bukan halaman kosong | | |
| PORT-04 | Detail proyek | Klik proyek | `/portofolio/{slug}`: galeri, ringkasan, tantangan/solusi/hasil, tech stack, klien, link live (jika ada) | | |
| PORT-05 | Galeri gambar | Klik thumbnail / navigasi galeri | Gambar utama berganti; gambar tidak pecah/terpotong | | |
| PORT-06 | Proyek unggulan | Tandai proyek sebagai unggulan di admin | Muncul di Beranda & kartu besar Portofolio | | |
| PORT-07 | Proyek draft tersembunyi | Set status draft di admin | Tidak tampil publik; URL langsung → 404 | | |

### BLOG — Blog (Publik)

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| BLOG-01 | Halaman daftar | Buka `/blog` | Hero "MaiHarta Insights" + statistik, filter kategori dengan jumlah, kartu unggulan berlabel *Pilihan* (3:1), grid kartu 16:9 (kategori, judul, ringkasan, tanggal · menit baca), teks "Menampilkan a–b dari N artikel" | | |
| BLOG-02 | Filter kategori | Klik tiap chip kategori | URL `?kategori=…`, daftar terfilter, chip aktif gelap; kategori tanpa artikel → state "Belum ada artikel di kategori ini" + tombol kembali | | |
| BLOG-03 | Paginasi | Buat > 9 artikel tayang | Paginasi tampil (9/halaman), halaman 2 tidak menampilkan kartu unggulan | | |
| BLOG-04 | Detail artikel | Klik kartu | `/blog/{slug}`: breadcrumb, kategori, judul, ringkasan, meta (tanggal · menit baca · penulis), sampul, isi dengan sub-judul/daftar/kutipan/gambar rapi, tag, tombol bagikan, sidebar Artikel Terkait + CTA | | |
| BLOG-05 | Bagikan | Klik WhatsApp / LinkedIn / Salin tautan | WA & LinkedIn buka tab baru dengan judul+URL; Salin → tulisan "Tersalin" | | |
| BLOG-06 | Draft & terjadwal tersembunyi | Set artikel draft / tanggal mendatang di admin | Tidak ada di daftar & Beranda; URL langsung → 404 (kecuali admin login: tampil banner Pratinjau) | | |
| BLOG-07 | Tautan lama | Buka `/sertifikasi` | Redirect 301 ke `/blog`; tidak ada teks ISO/sertifikasi di seluruh website | | |

### ABOUT — Tentang

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ABOUT-01 | Halaman tentang | Buka `/tentang` | Hero + statistik, "Siapa Kami", kutipan, nilai kerja, logo partner & klien, CTA | | |
| ABOUT-02 | Logo partner/klien (marquee) | Lihat section "Dipercaya oleh…" | Dua baris logo berjalan otomatis (partner ke kiri, klien ke kanan), loop mulus tanpa lompatan, tepi memudar, berhenti saat hover, logo abu-abu → berwarna saat hover; nama muncul saat hover; kelompok kosong disembunyikan | | |
| ABOUT-03 | Kutipan opsional | Kosongkan kutipan di admin | Blok kutipan hilang tanpa merusak layout | | |
| ABOUT-04 | Statistik | Ubah angka di Umum & Kontak | Kartu statistik ikut berubah | | |

### CONTACT — Kontak

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| CONTACT-01 | Halaman kontak | Buka `/kontak` | Form, kartu info kontak, jam operasional, peta tersemat, tombol WhatsApp | | |
| CONTACT-02 | Validasi kosong | Kirim form kosong | Pesan error per field, data tidak tersimpan | | |
| CONTACT-03 | Validasi format | Email `abc`, telepon huruf | Error format; input lain tetap terisi (old input) | | |
| CONTACT-04 | Kirim valid | Isi lengkap lalu kirim | Halaman "Pesan Terkirim"; pesan muncul di Admin → Pesan Kontak dengan badge baru | | |
| CONTACT-05 | Anti-spam | Isi field honeypot (via devtools) lalu kirim | Diterima diam-diam / ditolak, tidak masuk admin | | |
| CONTACT-06 | Info kontak dinamis | Ubah email/telepon/alamat/jam di admin | Kartu info & footer berubah | | |
| CONTACT-07 | Peta | Ubah "Kueri Peta Tersemat" | Peta menampilkan lokasi baru; link "Buka di Google Maps" sesuai | | |
| CONTACT-08 | Tombol WhatsApp halaman kontak | Klik | Membuka `wa.me/<nomor>` dengan pesan pembuka | | |

### WA — Tombol WhatsApp Melayang

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| WA-01 | Muncul di semua halaman publik | Buka 5+ halaman | Tombol hijau bulat di kanan bawah, muncul ±1 detik dengan animasi pop | | |
| WA-02 | Animasi idle | Diamkan 10 detik | Cincin berdenyut terus; ikon bergoyang singkat tiap ±7 detik | | |
| WA-03 | Hover (desktop) | Arahkan kursor | Tombol memanjang menampilkan "Chat via WhatsApp"; cincin berhenti | | |
| WA-04 | Bubble ajakan | Tunggu ±4 detik setelah load | Kartu "Tim MaiHarta — Halo! …" muncul; klik ✕ menutup; setelah ditutup tidak muncul lagi di tab yang sama; muncul lagi di tab baru | | |
| WA-05 | Tautan | Klik tombol | Tab baru `https://wa.me/<nomor admin>?text=…`; nomor sesuai Admin → Umum & Kontak | | |

### RESP — Responsif & Mobile

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| RESP-01 | Navbar mobile | Buka di ≤ 1024 px | Pill atas berisi logo + tombol bulat chat; tidak ada link teks | | |
| RESP-02 | Bottom nav pill | Lihat bawah layar | Pill melayang dengan 5 tab (Beranda · Solusi · Portofolio · Blog · Tentang); tab aktif ikon solid + glow + titik | | |
| RESP-03 | Bottom nav auto-hide | Scroll ke bawah lalu ke atas | Sembunyi saat scroll turun (>120 px), muncul saat scroll naik, transisi halus | | |
| RESP-04 | Bottom nav navigasi | Ketuk tiap tab | Halaman berpindah; tab aktif berubah | | |
| RESP-05 | FAB tidak bertabrakan | Lihat kanan bawah mobile | Tombol WhatsApp berada di atas bottom nav, tidak menutupi tab | | |
| RESP-06 | Tidak ada scroll horizontal | Geser ke samping di semua halaman pada 390 px | Halaman tidak bergeser horizontal; gambar/tabel tidak meluber | | |
| RESP-07 | Konten tidak tertutup | Scroll ke paling bawah | Footer terbaca penuh di atas bottom nav (padding bawah cukup) | | |
| RESP-08 | Tablet 768 px | Buka semua halaman | Grid turun menjadi 2 kolom / 1 kolom dengan rapi | | |

### A11Y — Aksesibilitas & Performa

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| A11Y-01 | Reduced motion | Aktifkan "Reduce motion" di OS, muat ulang | Semua animasi mati; konten langsung terlihat; tombol/nav tetap berfungsi | | |
| A11Y-02 | Navigasi keyboard | Tab melalui navbar, form, tombol | Fokus terlihat (ring), urutan logis, Enter mengaktifkan | | |
| A11Y-03 | Alt text | Periksa gambar dengan devtools | Semua `<img>` punya `alt` bermakna; ikon dekoratif `aria-hidden` | | |
| A11Y-04 | Kontras | Cek teks abu-abu pada latar terang & teks pada kartu gelap | Rasio ≥ 4.5:1 untuk teks normal | | |
| A11Y-05 | Lighthouse | Jalankan Lighthouse (mobile) di `/` | Performa ≥ 80, Aksesibilitas ≥ 90, Best Practices ≥ 90, SEO ≥ 90 | | |
| A11Y-06 | Konsol bersih | Buka devtools Console di semua halaman | Tidak ada error JS / 404 aset | | |

---

## 4. Skenario Pengujian — Panel Admin

### AUTH — Autentikasi

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| AUTH-01 | Halaman login | Buka `/admin/login` | Kartu login dengan logo, field email & sandi, "Ingat saya" | | |
| AUTH-02 | Login gagal | Sandi salah | Pesan error; tetap di login; field email terisi | | |
| AUTH-03 | Login berhasil | Kredensial benar | Redirect ke `/admin` (Dashboard) | | |
| AUTH-04 | Proteksi rute | Logout lalu buka `/admin/projects` | Redirect ke login | | |
| AUTH-05 | Logout | Klik ikon power di sidebar | Sesi berakhir, kembali ke login | | |
| AUTH-06 | Ingat saya | Login dengan centang, tutup & buka browser | Masih login | | |
| AUTH-07 | Lupa kata sandi | Klik "Lupa kata sandi?" → isi email → buka tautan di email → isi sandi baru | Email terkirim (cek `storage/logs` bila MAIL_MAILER=log); sandi baru bisa dipakai login; tautan salah/kedaluwarsa ditolak | | |

### DASH — Dashboard

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| DASH-01 | Ringkasan | Buka `/admin` | Kartu jumlah proyek, layanan, pesan baru; daftar pesan terbaru | | |
| DASH-02 | Sidebar | Periksa menu | Dashboard, Proyek, Layanan, Pesan Kontak (badge jumlah baru), Konten Website, Pengaturan, Lihat Website | | |

### APRJ — Proyek

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| APRJ-01 | Daftar proyek | Buka `/admin/projects` | Tabel/kartu dengan thumbnail, kategori, status, unggulan; pencarian & filter | | |
| APRJ-02 | Tambah — validasi | Simpan form kosong | Error pada field wajib; toast/alert error | | |
| APRJ-03 | Tambah — valid | Isi semua field + unggah cover & galeri | Tersimpan; slug otomatis dari nama; muncul di daftar & publik | | |
| APRJ-04 | Ubah | Edit nama, deskripsi, tech stack, klien | Perubahan tampil di publik; slug tetap/berubah sesuai aturan | | |
| APRJ-05 | Ganti cover | Unggah cover baru | Cover lama diganti (file lama terhapus di `storage/app/public`) | | |
| APRJ-06 | Galeri | Tambah beberapa gambar, hapus satu | Urutan & jumlah sesuai; file yang dihapus hilang dari storage | | |
| APRJ-07 | Toggle unggulan & status | Ubah lalu simpan | Tercermin di Beranda/Portofolio | | |
| APRJ-08 | Hapus | Klik hapus → modal konfirmasi → ya | Proyek hilang dari daftar dan publik; batal tidak menghapus | | |
| APRJ-09 | Ukuran/tipe file | Unggah file > batas atau bukan gambar | Ditolak dengan pesan jelas | | |

### ASVC — Layanan

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ASVC-01 | Daftar layanan | Buka `/admin/services` | Daftar dengan ikon, kategori, status, urutan | | |
| ASVC-02 | Tambah/ubah | Isi nama, ringkasan, deskripsi, kapabilitas, durasi langkah, ikon | Tersimpan dan tampil di `/layanan` & detail | | |
| ASVC-03 | Layanan utama | Tandai sebagai utama | Menjadi kartu gelap besar di `/layanan` | | |
| ASVC-04 | Urutan | Ubah nomor urut | Urutan grid publik berubah | | |
| ASVC-05 | Nonaktifkan | Set nonaktif | Hilang dari publik, tetap di admin | | |
| ASVC-06 | Hapus | Hapus layanan yang punya proyek terkait | Dikonfirmasi; proyek tidak ikut terhapus / relasi ditangani | | |

### ABLOG — Blog (Admin)

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ABLOG-01 | Daftar | Buka `/admin/articles` | Tabel: sampul mini, judul (+ bintang unggulan), kategori, status (Draft/Terjadwal/Tayang), tanggal, dilihat; pencarian, filter status & kategori, paginasi | | |
| ABLOG-02 | Tulis — validasi | Simpan form kosong / isi editor kosong | Error inline judul, ringkasan, isi; tidak tersimpan | | |
| ABLOG-03 | Tulis — valid | Isi judul, ringkasan, isi (H2, tebal, daftar, kutipan), kategori, tag, sampul; status Tayang | Redirect ke edit dengan pesan sukses; slug otomatis; tampil di `/blog` dan Beranda | | |
| ABLOG-04 | Gambar di isi | Klik ikon gambar di editor, pilih file | Gambar terunggah & tersisip; tersimpan setelah Simpan; file > 2 MB ditolak | | |
| ABLOG-05 | Jadwal tayang | Status Tayang + tanggal mendatang | Status "Terjadwal"; tidak tampil publik sampai waktunya | | |
| ABLOG-06 | Unggulan | Centang unggulan pada 2 artikel | Yang terbaru jadi kartu Pilihan di `/blog` | | |
| ABLOG-07 | Ganti/hapus sampul | Ganti sampul lalu hapus | Preview berubah; file lama terhapus dari storage | | |
| ABLOG-08 | Hapus | Hapus artikel dengan gambar di isi | Modal konfirmasi; artikel, sampul, dan gambar isi terhapus | | |

### AMSG — Pesan Kontak

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| AMSG-01 | Daftar | Buka `/admin/messages` | Pesan terbaru di atas; badge "Baru" pada yang belum dibaca; filter baru/dibaca | | |
| AMSG-02 | Detail | Klik pesan | Nama, email, telepon, isi, waktu; tombol balas via email/WhatsApp | | |
| AMSG-03 | Tandai dibaca/belum | Klik toggle | Status berubah; badge di sidebar ikut berkurang/bertambah | | |
| AMSG-04 | Hapus | Hapus pesan | Konfirmasi; pesan hilang | | |
| AMSG-05 | State kosong | Hapus semua pesan | Tampil ilustrasi/teks "belum ada pesan" | | |

### ACNT — Konten Website

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ACNT-01 | Tab | Buka `/admin/content` | 3 tab: Umum & Kontak, Beranda, Tentang; tab aktif jelas | | |
| ACNT-02 | Simpan tanpa perubahan | Buka tiap tab, langsung Simpan | Tidak ada data yang hilang (khususnya logo partner/klien & logo brand) | | |
| ACNT-03 | Ganti logo | Unggah PNG/SVG | Preview berubah; navbar, login, sidebar memakai logo baru | | |
| ACNT-04 | Kembali ke default logo | Klik "Kembali ke default" lalu Simpan | Logo default kembali; file unggahan lama terhapus | | |
| ACNT-05 | Kontak & sosial | Ubah email, telepon, WhatsApp (angka saja), alamat, jam, Instagram/Facebook/LinkedIn | Footer, halaman kontak, FAB WhatsApp mengikuti; sosial kosong disembunyikan | | |
| ACNT-06 | Angka perusahaan | Ubah 3 angka | Hero, Layanan, Portofolio, Tentang berubah | | |
| ACNT-07 | Komposisi hero | Ubah teks kartu, unggah 2 foto hero | Hero Beranda berubah; foto rasio 4:3 tidak terdistorsi | | |
| ACNT-09 | Logo partner — tambah | Unggah beberapa logo sekaligus | Semua muncul dengan caption dari nama file; hitungan `(n)` benar | | |
| ACNT-10 | Logo partner — ubah nama & hapus | Ubah caption, hapus satu, Simpan | Caption tersimpan; hanya yang dihapus yang hilang; sisanya tetap | | |
| ACNT-11 | Narasi tentang | Ubah judul, cerita, kutipan, sumber | `/tentang` berubah | | |
| ACNT-12 | Tombol "Lihat Halaman" | Klik di tiap tab | Membuka halaman publik terkait di tab baru | | |

### ASET — Pengaturan

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ASET-01 | Ubah profil | Ganti nama & email | Sidebar menampilkan nama/email baru; login dengan email baru berhasil | | |
| ASET-02 | Ganti sandi — validasi | Sandi lama salah / konfirmasi tidak cocok / terlalu pendek | Error jelas, sandi tidak berubah | | |
| ASET-03 | Ganti sandi — valid | Isi benar | Berhasil; logout lalu login dengan sandi baru | | |
| ASET-04 | Email duplikat | Ubah ke email admin lain (jika ada) | Ditolak | | |
| ASET-05 | Sandi default diganti | Pastikan sandi bukan `password` sebelum produksi | Login `password` gagal | | |

### ERR — Halaman Error & State

| ID | Skenario | Langkah | Hasil yang diharapkan | Status | Catatan |
|---|---|---|---|---|---|
| ERR-01 | 404 publik | Buka `/halaman-tidak-ada` | Halaman 404 bergaya MaiHarta dengan tombol ke Beranda | | |
| ERR-02 | 404 admin | Buka `/admin/projects/99999/edit` | 404 (setelah login) | | |
| ERR-03 | CSRF | Kirim form dengan token kedaluwarsa (biarkan form terbuka > sesi) | Pesan 419 ramah / diminta muat ulang | | |
| ERR-04 | APP_DEBUG=false | Set di `.env` produksi, picu error | Tidak ada stack trace ke pengguna | | |

---

## 5. Matriks Perangkat

| Perangkat / Browser | Beranda | Layanan | Portofolio | Sertifikasi | Tentang | Kontak | Admin |
|---|---|---|---|---|---|---|---|
| Windows — Chrome | | | | | | | |
| Windows — Edge | | | | | | | |
| Windows — Firefox | | | | | | | |
| macOS — Safari | | | | | | | |
| Android — Chrome | | | | | | | — |
| iOS — Safari | | | | | | | — |

---

## 6. Log Defect

| No | ID Kasus | Deskripsi | Severity (Kritis/Mayor/Minor) | Status | Penemu | Tanggal | Perbaikan (commit) |
|---|---|---|---|---|---|---|---|
| 1 | ACNT-02 | Logo partner/klien hilang saat Simpan tanpa perubahan (nama field `group[key]_keep` dipotong PHP) | Kritis | Fixed | Pengembang | 16/09/2026 | `1b50833` |
| 2 | NAV-08 | Garis muncul di atas label subjudul (bentrok utilitas `overline` Tailwind) | Minor | Fixed | Klien | 16/09/2026 | `5292ba8` |
| 3 | NAV-06 | Alamat di footer tidak bisa diklik | Minor | Fixed | Tim testing | 17/09/2026 | `bb50099` |
| 4 | ABOUT-02 | Section logo partner/klien kosong di kanan; diminta marquee | Minor | Fixed | Tim testing | 21/09/2026 | lihat log |
| 5 | CONTACT-02/03 | Validasi form kontak memakai popup browser | Mayor | Fixed | Tim testing | 17/09/2026 | `2685e6f` |
| 6 | AMSG-02 | "Balas via Email" tidak membuka Gmail | Minor | Fixed | Tim testing | 17/09/2026 | `bb50099` |
| 7 | APRJ-02 dkk | Validasi admin tidak konsisten | Minor | Fixed | Tim testing | 17/09/2026 | `2685e6f` |
| 8 | AUTH-07 | Lupa kata sandi belum berfungsi | Kritis | Fixed (perlu SMTP produksi) | Tim testing | 17/09/2026 | lihat log |
| 9 | AUTH-05 | Logout → 419 Page Expired | Kritis | Fixed | Tim testing | 17/09/2026 | `3ae38ca` |
| 10 | AMSG-01 | Label "Baru" → "Belum dibaca" | Minor | Fixed | Tim testing | 17/09/2026 | `3ae38ca` |
| 11 | AMSG-02 | Waktu admin tampil UTC dengan label WITA | Kritis | Fixed | Tim testing | 17/09/2026 | `3ae38ca` |
| 12 | PORT-04 | Teks kartu Hasil & Outcome meluber | Mayor | Fixed | Tim testing | 17/09/2026 | `bb50099` |
| | | | | | | | |

---

## 7. Kriteria Lulus

- Semua kasus **Kritis/Mayor** berstatus Pass.
- Tidak ada error di konsol browser dan `storage/logs/laravel.log` selama sesi uji.
- `php artisan test` hijau (saat ini 30 tes / 239 assertion).
- Diuji minimal pada 1 desktop + 1 Android + 1 iOS.

| Peran | Nama | Tanda tangan | Tanggal |
|---|---|---|---|
| Penguji | | | |
| Pengembang | | | |
| Klien / PIC | | | |
