# Panduan Panel Admin MaiHarta

Untuk pengelola konten (non-teknis). Alamat panel: `https://<domain>/admin`.

## Masuk & keluar

1. Buka `/admin/login`, isi email dan kata sandi. Centang **Ingat saya** agar tidak perlu login ulang di perangkat yang sama.
2. Salah kata sandi 5× dalam satu menit → tunggu sebentar sebelum mencoba lagi.
3. Keluar: ikon ⏻ di pojok kiri bawah sidebar.
4. **Ganti kata sandi** pertama kali lewat menu **Pengaturan → Ubah Kata Sandi** (kata sandi awal dari seeder adalah `password`).

## Dashboard

Ringkasan: jumlah proyek, layanan, pesan belum dibaca; 5 pesan terbaru; aksi cepat; proyek yang terakhir diubah. Klik pesan untuk membukanya di Inbox.

## Proyek (Portofolio)

Menu **Proyek** → tabel semua proyek. Filter per kategori (Apps / Website / Mobile), kolom pencarian nama/klien.

**Tambah / Edit proyek**

| Bagian | Isi |
|---|---|
| Informasi Dasar | Nama (slug URL terisi otomatis, bisa diubah), kategori, layanan terkait, tipe klien, deskripsi singkat (tampil di kartu, maks 255 karakter) |
| Studi Kasus | Deskripsi lengkap (tampil di panel *Hasil & Outcome*), tantangan, solusi, ringkasan teknologi — bagian yang kosong tidak ditampilkan |
| Statistik Hasil | Pasangan nilai–label (mis. `8` — `Kategori Produk`). Tampil sebagai strip angka. Baris kosong diabaikan |
| Publikasi | URL eksternal (memunculkan tombol *Kunjungi* dan badge *Live*), urutan tampil (angka kecil = lebih dulu; proyek urutan pertama jadi *Proyek Unggulan* di halaman Portofolio) |
| Gambar Sampul | PNG/JPG maks 2 MB, rasio 4:3. Dipakai di kartu dan mock browser |
| Galeri | Beberapa gambar sekaligus; beri caption; hapus dengan ikon tempat sampah. Galeri kosong = section galeri disembunyikan |

Tombol **Pratinjau** membuka halaman publiknya di tab baru. Hapus proyek ada di kartu merah paling bawah (ada konfirmasi; sampul & galeri ikut terhapus).

## Layanan

Menu **Layanan** → kartu tiap layanan. Layanan dengan urutan terkecil tampil sebagai *Layanan Utama* di halaman Layanan.

**Tambah / Edit layanan**

| Bagian | Isi |
|---|---|
| Informasi Dasar | Nama, slug, deskripsi singkat & lengkap |
| Kartu Meta | Pasangan label–nilai di kartu kanan hero detail (mis. *Cocok untuk — Instansi pemerintah*). Kosong = kartu disembunyikan |
| Tentang Layanan & Kapabilitas | Judul section (opsional) dan daftar kapabilitas bernomor. Kosong = kolom kanan disembunyikan |
| Teknologi & Skillset | Ketik lalu Enter/koma untuk menambah tag; dikelompokkan otomatis Backend/Frontend/Lainnya |
| Proses Kerja | Tahap bernomor: judul, deskripsi, **durasi** (mis. `1–2 minggu`; kosongkan bila tidak ingin ditampilkan) |
| Ikon & Tampilan | Pilih salah satu dari 7 ikon |
| Publikasi | Urutan tampil; daftar proyek yang terhubung (relasi diatur dari form Proyek) |

Menghapus layanan **tidak** menghapus proyeknya — proyek hanya kehilangan relasi.

## Pesan Kontak

Menu **Pesan Kontak** → daftar di kiri, isi pesan di kanan.

- Angka biru di sidebar = jumlah belum dibaca. Membuka pesan otomatis menandainya *sudah dibaca*; bisa dibalik dengan **Tandai belum dibaca**.
- Filter: Semua / Belum Dibaca / Sudah Dibaca; kotak cari mencocokkan nama, email, perusahaan, dan isi.
- Chip biru di atas isi pesan = layanan yang dipilih pengirim.
- **Balas via Email** membuka aplikasi email dengan subjek terisi. **Balas via WhatsApp** hanya muncul bila pengirim mengisi nomor WA di form; nomor `08xx` otomatis diubah ke `62xx`.
- Hapus permanen lewat ikon tempat sampah (ada konfirmasi).

## Konten Website

Menu **Konten Website** → 4 tab. Semua field punya nilai bawaan; kosongkan/hapus untuk kembali ke bawaan hanya bila dijelaskan di labelnya.

### Umum & Kontak
- **Logo** — unggah PNG/SVG transparan (tinggi ±40 px). Dipakai di navbar, halaman login, sidebar admin. *Kembali ke default* memakai logo bawaan.
- **Email, Telepon (tampil), Nomor WhatsApp** — nomor WA ditulis angka saja diawali `62` (mis. `6281236300562`); dipakai tombol *Chat via WhatsApp*.
- **Alamat, Jam operasional** — tampil di halaman Kontak dan footer.
- **Tautan Google Maps** — tombol *Buka di Maps*. **Kueri peta tersemat** — nama tempat/koordinat untuk peta di halaman Kontak (bawaan: pin *Kantor MaiHarta*).
- **URL Instagram / Facebook / LinkedIn** — kosong = ikonnya tidak tampil.
- **Angka Perusahaan** — tahun berkarya, proyek selesai, instansi terlayani; dipakai di hero Beranda (angka berhitung), Layanan, Portofolio, Tentang. Tulis dengan tanda `+` bila perlu (`199+`).

### Beranda
**Komposisi Hero** — teks pada kartu-kartu melayang: kartu dashboard (judul, sub-judul — `{tahun}` otomatis jadi tahun berjalan, badge *Live*, catatan progres), badge ISO, gelembung helpdesk (judul, sub-judul, chip status, isi kutipan), kartu SSO, serta dua foto (tim & dashboard). Angka di kartu dashboard mengikuti *Angka Perusahaan*.

### Sertifikasi
- **Kartu Praktik Keamanan** — maks 4 kartu: judul, deskripsi, tag teknis (mis. `AES-256 · TLS 1.3`). Isi tag hanya dengan yang benar-benar diterapkan.
- **Sertifikasi & Penghargaan Lain** — daftar sertifikat (nama, keterangan, deskripsi). Hapus baris yang belum dimiliki, mis. ISO 9001, agar tidak tampil; angka di hero halaman ikut menyesuaikan.

### Tentang
- **Narasi Perusahaan** — judul dan cerita "Siapa Kami", kutipan (kosongkan untuk menyembunyikan) dan sumbernya.
- **Logo Partner & Klien** — unggah beberapa logo sekaligus, beri nama (tampil saat hover), hapus per logo. Kelompok kosong disembunyikan.

Tombol **Lihat Halaman** di kanan atas membuka halaman publik terkait.

## Pengaturan
Ubah nama & email admin, ganti kata sandi (perlu kata sandi lama, minimal 8 karakter), dan lihat info sistem.

## Tips
- Semua unggahan maks **2 MB**. Kompres gambar besar dulu (JPEG kualitas 80 sudah cukup).
- Perubahan langsung tampil di website; tidak ada tombol "publish" terpisah.
- Jika halaman publik tampak belum berubah, muat ulang dengan Ctrl+F5.
