<?php

/*
|--------------------------------------------------------------------------
| Konten website yang bisa diedit dari panel admin
|--------------------------------------------------------------------------
| Setiap "page" menjadi satu tab di Admin → Konten Website. Setiap "group"
| disimpan sebagai satu baris di tabel `settings` (key = "page.group").
| Nilai default di sini = teks yang tampil bila admin belum mengubahnya.
|
| Tipe field: text | textarea | repeater (fields + max) | images (logo list)
*/

$stat = fn () => [['key' => 'value', 'label' => 'Nilai', 'type' => 'text'], ['key' => 'label', 'label' => 'Keterangan', 'type' => 'text']];
$titleDesc = fn () => [['key' => 'title', 'label' => 'Judul', 'type' => 'text'], ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea']];
$cta = fn (string $eyebrow, string $title, string $desc, string $p, string $s) => [
    'label' => 'Panel Ajakan (CTA)',
    'fields' => [
        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => $eyebrow],
        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => $title],
        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => $desc],
        ['key' => 'primary', 'label' => 'Tombol utama', 'type' => 'text', 'default' => $p],
        ['key' => 'secondary', 'label' => 'Tombol kedua', 'type' => 'text', 'default' => $s],
    ],
];

return [
    'pages' => [

        'umum' => [
            'label' => 'Umum & Kontak',
            'icon' => 'globe-alt',
            'groups' => [
                'brand' => [
                    'label' => 'Identitas & Kontak',
                    'help' => 'Dipakai di footer, halaman Kontak, dan tombol WhatsApp.',
                    'fields' => [
                        ['key' => 'tagline', 'label' => 'Tagline footer', 'type' => 'text', 'default' => 'Mitra pengembangan produk digital yang profesional, aman, dan terpercaya.'],
                        ['key' => 'email', 'label' => 'Email', 'type' => 'text', 'default' => 'info@maiharta.com'],
                        ['key' => 'phone', 'label' => 'Telepon / WhatsApp (tampil)', 'type' => 'text', 'default' => '+62 812-3630-0562'],
                        ['key' => 'whatsapp', 'label' => 'Nomor WhatsApp (angka saja, awali 62)', 'type' => 'text', 'default' => '6281236300562'],
                        ['key' => 'address', 'label' => 'Alamat kantor', 'type' => 'textarea', 'default' => 'Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali'],
                        ['key' => 'hours', 'label' => 'Jam operasional', 'type' => 'text', 'default' => 'Senin–Jumat, 09.00–17.00 WITA'],
                        ['key' => 'instagram', 'label' => 'URL Instagram', 'type' => 'text', 'default' => ''],
                        ['key' => 'facebook', 'label' => 'URL Facebook', 'type' => 'text', 'default' => ''],
                        ['key' => 'linkedin', 'label' => 'URL LinkedIn', 'type' => 'text', 'default' => ''],
                        ['key' => 'footer_note', 'label' => 'Catatan footer kanan', 'type' => 'text', 'default' => 'Dibuat dengan standar keamanan ISO/IEC 27001'],
                    ],
                ],
                'stats' => [
                    'label' => 'Angka Perusahaan',
                    'help' => 'Dipakai di hero Beranda (kartu dashboard), Layanan, Portofolio, dan Tentang.',
                    'fields' => [
                        ['key' => 'years', 'label' => 'Tahun berkarya', 'type' => 'text', 'default' => '8+'],
                        ['key' => 'projects', 'label' => 'Proyek selesai', 'type' => 'text', 'default' => '199+'],
                        ['key' => 'clients', 'label' => 'Instansi terlayani', 'type' => 'text', 'default' => '40+'],
                    ],
                ],
            ],
        ],

        'beranda' => [
            'label' => 'Beranda',
            'icon' => 'home',
            'groups' => [
                'hero' => [
                    'label' => 'Hero',
                    'fields' => [
                        ['key' => 'badge', 'label' => 'Badge', 'type' => 'text', 'default' => 'Bersertifikasi ISO/IEC 27001'],
                        ['key' => 'headline_gradient', 'label' => 'Judul baris bergradien', 'type' => 'text', 'default' => 'Ngga ada habisnya'],
                        ['key' => 'headline', 'label' => 'Judul lanjutan', 'type' => 'text', 'default' => 'membangun produk digital untuk bisnis Anda'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'MaiHarta membantu bisnis Anda berkembang cepat melalui jasa dan produk digital — dari sistem internal, aplikasi mobile, hingga marketplace — dengan standar keamanan internasional.'],
                        ['key' => 'primary', 'label' => 'Tombol utama', 'type' => 'text', 'default' => 'Mulai Konsultasi Gratis'],
                        ['key' => 'secondary', 'label' => 'Tombol kedua', 'type' => 'text', 'default' => 'Lihat Portofolio'],
                        ['key' => 'bullets', 'label' => 'Poin kecil di bawah tombol', 'type' => 'repeater', 'max' => 4, 'fields' => [['key' => 'text', 'label' => 'Teks', 'type' => 'text']], 'default' => [['text' => 'Konsultasi gratis'], ['text' => 'Tanpa biaya tersembunyi'], ['text' => 'Dukungan pascarilis']]],
                        ['key' => 'card_title', 'label' => 'Kartu dashboard: judul', 'type' => 'text', 'default' => 'Ringkasan Proyek'],
                        ['key' => 'card_note', 'label' => 'Kartu dashboard: catatan bawah', 'type' => 'text', 'default' => '12 proyek aktif'],
                        ['key' => 'bubble_title', 'label' => 'Gelembung helpdesk: judul', 'type' => 'text', 'default' => 'Helpdesk · Tiket #1042'],
                        ['key' => 'bubble_sub', 'label' => 'Gelembung helpdesk: sub-judul', 'type' => 'text', 'default' => 'Nasabah · 2 jam lalu'],
                        ['key' => 'bubble_text', 'label' => 'Gelembung helpdesk: isi', 'type' => 'textarea', 'default' => '“Pengaduan sudah ditindaklanjuti unit terkait dan diselesaikan dalam 2 jam. Terima kasih!”'],
                        ['key' => 'sso_title', 'label' => 'Kartu SSO: judul', 'type' => 'text', 'default' => 'SSO + 2FA aktif'],
                        ['key' => 'sso_sub', 'label' => 'Kartu SSO: sub-judul', 'type' => 'text', 'default' => 'Bank BPD Bali · 1 pintu login'],
                    ],
                ],
                'solusi' => [
                    'label' => 'Section Solusi Kita',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Solusi Kita'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Satu Mitra untuk Seluruh Kebutuhan Digital Anda'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Solusi digital yang disesuaikan dengan kebutuhan bisnis Anda — dari sistem internal hingga identitas brand dan pemasaran.'],
                    ],
                ],
                'portofolio' => [
                    'label' => 'Section Portofolio',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Portofolio'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Bukti Nyata Kapabilitas Kami'],
                    ],
                ],
                'sertifikasi' => [
                    'label' => 'Section Sertifikasi',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Kredibilitas & Keamanan'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Standar Keamanan yang Terjamin'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Kami mengikuti standar keamanan informasi internasional ISO/IEC 27001 untuk memastikan data dan sistem klien kami terlindungi di setiap tahap kerja sama.'],
                        ['key' => 'points', 'label' => 'Poin keamanan', 'type' => 'repeater', 'max' => 5, 'fields' => $titleDesc(), 'default' => [
                            ['title' => 'Perlindungan data terenkripsi', 'description' => 'Data klien dienkripsi saat disimpan maupun ditransmisikan.'],
                            ['title' => 'Akses sistem yang terkontrol', 'description' => 'Hak akses berjenjang dan tercatat pada audit trail.'],
                            ['title' => 'Penilaian risiko berkala', 'description' => 'Evaluasi keamanan rutin di setiap siklus pengembangan.'],
                        ]],
                        ['key' => 'panel_title', 'label' => 'Panel: nama sertifikasi', 'type' => 'text', 'default' => 'ISO/IEC 27001'],
                        ['key' => 'panel_sub', 'label' => 'Panel: sub-judul', 'type' => 'text', 'default' => 'Information Security Management System'],
                        ['key' => 'panel_tags', 'label' => 'Panel: tag (pisahkan koma)', 'type' => 'text', 'default' => 'Tersertifikasi, Audit Berkala, Standar Internasional'],
                    ],
                ],
                'tentang' => [
                    'label' => 'Section Tentang',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Tentang Maiharta'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Mitra Transformasi Digital Bisnis Anda'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem.'],
                        ['key' => 'button', 'label' => 'Tombol', 'type' => 'text', 'default' => 'Kenali Kami Lebih Dekat'],
                    ],
                ],
                'cta' => $cta('Mulai Sekarang', 'Siap Membangun Produk Digital Anda?', 'Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menemukan solusi digital yang tepat.', 'Hubungi Kami Sekarang', 'Lihat Layanan'),
            ],
        ],

        'layanan' => [
            'label' => 'Layanan',
            'icon' => 'squares-2x2',
            'groups' => [
                'hero' => [
                    'label' => 'Hero',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Layanan Kami'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Solusi Digital untuk Setiap Kebutuhan Bisnis'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Kami membantu bisnis Anda merancang, membangun, dan mengembangkan produk digital — dari website hingga sistem internal yang kompleks.'],
                        ['key' => 'featured_extra', 'label' => 'Kalimat tambahan pada kartu Layanan Utama', 'type' => 'text', 'default' => 'Termasuk sistem internal, portal publik, e-commerce, dan integrasi API.'],
                    ],
                ],
                'proses' => [
                    'label' => 'Proses Kerja (4 langkah)',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Cara Kami Bekerja'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Empat Langkah dari Ide ke Produk'],
                        ['key' => 'steps', 'label' => 'Langkah', 'type' => 'repeater', 'max' => 6, 'fields' => $titleDesc(), 'default' => [
                            ['title' => 'Konsultasi', 'description' => 'Memahami kebutuhan, tujuan bisnis, dan batasan proyek Anda.'],
                            ['title' => 'Perencanaan & Desain', 'description' => 'Menyusun arsitektur sistem, alur pengguna, dan desain antarmuka.'],
                            ['title' => 'Pengembangan & QA', 'description' => 'Membangun produk secara iteratif dengan pengujian berkelanjutan.'],
                            ['title' => 'Peluncuran & Support', 'description' => 'Rilis ke produksi, pelatihan pengguna, dan pemeliharaan.'],
                        ]],
                    ],
                ],
                'detail' => [
                    'label' => 'Halaman Detail Layanan',
                    'help' => 'Teks yang sama untuk semua layanan. Kartu meta & kapabilitas per layanan diatur di Layanan → Edit.',
                    'fields' => [
                        ['key' => 'about_eyebrow', 'label' => 'Label “Tentang layanan”', 'type' => 'text', 'default' => 'Tentang Layanan Ini'],
                        ['key' => 'process_title', 'label' => 'Judul proses kerja', 'type' => 'text', 'default' => 'Lima Tahap Menuju Sistem yang Siap Pakai'],
                        ['key' => 'durations', 'label' => 'Durasi tiap tahap (pisahkan koma)', 'type' => 'text', 'default' => '1–2 minggu, 2–3 minggu, 4–12 minggu, 1–2 minggu, Berkelanjutan'],
                        ['key' => 'tech_title', 'label' => 'Judul teknologi', 'type' => 'text', 'default' => 'Stack yang Terbukti di Produksi'],
                        ['key' => 'related_title', 'label' => 'Judul proyek terkait', 'type' => 'text', 'default' => 'Yang Sudah Kami Bangun dengan Layanan Ini'],
                    ],
                ],
                'cta' => $cta('Konsultasi Gratis', 'Tidak Yakin Layanan Mana yang Anda Butuhkan?', 'Ceritakan kebutuhan bisnis Anda, tim kami akan membantu menentukan solusi yang paling tepat.', 'Konsultasi Gratis', 'Lihat Portofolio'),
            ],
        ],

        'portofolio' => [
            'label' => 'Portofolio',
            'icon' => 'rectangle-stack',
            'groups' => [
                'hero' => [
                    'label' => 'Hero',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Portofolio Kami'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Bukti Nyata Kapabilitas Kami'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Kumpulan proyek yang telah kami kerjakan bersama klien dari berbagai industri — perbankan, pemerintahan, pariwisata, hingga e-commerce.'],
                        ['key' => 'note', 'label' => 'Catatan kecil di bawah grid', 'type' => 'text', 'default' => '*Tautan proyek akan diperbarui sesuai URL resmi masing-masing aplikasi.'],
                    ],
                ],
                'cta' => $cta('Mari Berkolaborasi', 'Punya Proyek Serupa?', 'Mari diskusikan bagaimana kami bisa membantu mewujudkan proyek digital Anda.', 'Konsultasi Gratis', 'Lihat Layanan'),
            ],
        ],

        'sertifikasi' => [
            'label' => 'Sertifikasi',
            'icon' => 'shield-check',
            'groups' => [
                'hero' => [
                    'label' => 'Hero',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Sertifikasi & Keamanan'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Komitmen Kami pada Keamanan Data'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Kepercayaan klien dibangun di atas standar keamanan yang ketat dan dapat diverifikasi — bukan sekadar janji.'],
                        ['key' => 'stats', 'label' => 'Angka di hero', 'type' => 'repeater', 'max' => 3, 'fields' => $stat(), 'default' => [['value' => 'ISO', 'label' => '27001'], ['value' => 'ISO', 'label' => '9001:2015'], ['value' => '100%', 'label' => 'Proyek Terstandar']]],
                    ],
                ],
                'iso' => [
                    'label' => 'Panel ISO 27001',
                    'fields' => [
                        ['key' => 'name', 'label' => 'Nama sertifikasi', 'type' => 'text', 'default' => 'ISO/IEC 27001'],
                        ['key' => 'sub', 'label' => 'Sub-judul', 'type' => 'text', 'default' => 'Information Security Management System'],
                        ['key' => 'status', 'label' => 'Status', 'type' => 'text', 'default' => 'Tersertifikasi & Aktif'],
                        ['key' => 'eyebrow', 'label' => 'Label kecil kanan', 'type' => 'text', 'default' => 'Apa Artinya Bagi Anda'],
                        ['key' => 'title', 'label' => 'Judul kanan', 'type' => 'text', 'default' => 'Standar internasional untuk melindungi data Anda di setiap tahap'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'ISO/IEC 27001 adalah standar internasional untuk sistem manajemen keamanan informasi. Sertifikasi ini menegaskan bahwa Maiharta menerapkan kontrol keamanan yang konsisten dalam mengelola data dan sistem klien di setiap tahap kerja sama — dari perencanaan hingga pascapeluncuran.'],
                        ['key' => 'points', 'label' => 'Poin centang', 'type' => 'repeater', 'max' => 5, 'fields' => [['key' => 'text', 'label' => 'Teks', 'type' => 'text']], 'default' => [['text' => 'Kebijakan keamanan informasi terdokumentasi'], ['text' => 'Kontrol akses & manajemen insiden'], ['text' => 'Audit internal dan tinjauan manajemen berkala']]],
                    ],
                ],
                'praktik' => [
                    'label' => 'Praktik Keamanan',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Praktik Keamanan Kami'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Keamanan yang Diterapkan, Bukan Hanya Ditulis'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Tiga pilar yang kami jalankan di setiap proyek, dari sistem perbankan hingga portal publik.'],
                        ['key' => 'items', 'label' => 'Kartu praktik', 'type' => 'repeater', 'max' => 4, 'fields' => [['key' => 'title', 'label' => 'Judul', 'type' => 'text'], ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'], ['key' => 'tag', 'label' => 'Tag', 'type' => 'text']], 'default' => [
                            ['title' => 'Data Terenkripsi', 'description' => 'Seluruh data klien dienkripsi baik saat disimpan maupun saat dikirim antar sistem, menggunakan protokol standar industri.', 'tag' => 'AES-256 · TLS 1.3'],
                            ['title' => 'Akses Terkontrol', 'description' => 'Akses ke sistem dan data dibatasi berdasarkan peran, dengan autentikasi berlapis dan pencatatan aktivitas.', 'tag' => 'RBAC · 2FA · Audit Trail'],
                            ['title' => 'Audit Risiko Berkala', 'description' => 'Penilaian risiko keamanan dilakukan secara rutin untuk mengidentifikasi celah sebelum menjadi ancaman.', 'tag' => 'Penetration Test · Review'],
                        ]],
                    ],
                ],
                'lain' => [
                    'label' => 'Sertifikasi Lain',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Sertifikasi & Penghargaan Lain'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Standar Lain yang Kami Penuhi'],
                        ['key' => 'items', 'label' => 'Daftar sertifikasi', 'type' => 'repeater', 'max' => 6, 'fields' => [['key' => 'name', 'label' => 'Nama', 'type' => 'text'], ['key' => 'sub', 'label' => 'Sub-judul', 'type' => 'text'], ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'text']], 'default' => [
                            ['name' => 'ISO 9001:2015', 'sub' => 'Quality Management System', 'description' => 'Menjamin proses kerja yang konsisten dan berorientasi pada kepuasan klien.'],
                            ['name' => 'ISO/IEC 27001', 'sub' => 'Information Security Management', 'description' => 'Perlindungan data dan sistem informasi klien di seluruh siklus proyek.'],
                        ]],
                    ],
                ],
                'cta' => $cta('Hubungi Kami', 'Ingin Tahu Lebih Lanjut Tentang Standar Keamanan Kami?', 'Tim kami siap menjelaskan bagaimana standar ini diterapkan pada proyek Anda.', 'Hubungi Tim Kami', 'Lihat Layanan'),
            ],
        ],

        'tentang' => [
            'label' => 'Tentang',
            'icon' => 'user-group',
            'groups' => [
                'hero' => [
                    'label' => 'Hero',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Tentang Maiharta'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Mitra Transformasi Digital Bisnis Anda'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Maiharta adalah tim yang berfokus membantu bisnis bertransformasi secara digital melalui solusi teknologi yang aman, scalable, dan berorientasi pada hasil — mulai dari perencanaan, desain, hingga pengembangan sistem.'],
                    ],
                ],
                'cerita' => [
                    'label' => 'Cerita Perusahaan',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Siapa Kami'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Dibangun di Bali, melayani instansi di seluruh Indonesia'],
                        ['key' => 'description', 'label' => 'Cerita', 'type' => 'textarea', 'default' => 'Berawal dari tim kecil pengembang di Denpasar, Maiharta tumbuh menjadi mitra teknologi bagi perbankan daerah, pemerintah provinsi dan kabupaten, hingga pelaku usaha kreatif. Kami percaya produk digital yang baik lahir dari pemahaman mendalam terhadap proses bisnis klien — bukan sekadar kode.'],
                        ['key' => 'quote', 'label' => 'Kutipan', 'type' => 'text', 'default' => '“Ngga ada habisnya” — semangat kami untuk terus berinovasi bersama setiap klien.'],
                        ['key' => 'quote_by', 'label' => 'Sumber kutipan', 'type' => 'text', 'default' => 'Tim Maiharta'],
                        ['key' => 'button', 'label' => 'Tombol', 'type' => 'text', 'default' => 'Hubungi Tim Kami'],
                    ],
                ],
                'nilai' => [
                    'label' => 'Nilai Kerja',
                    'help' => 'Dipakai di halaman Tentang dan section Tentang di Beranda (3 nilai pertama).',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Nilai Kerja Kami'],
                        ['key' => 'items', 'label' => 'Nilai', 'type' => 'repeater', 'max' => 4, 'fields' => $titleDesc(), 'default' => [
                            ['title' => 'Profesional', 'description' => 'Bekerja dengan standar dan proses yang konsisten di setiap proyek.'],
                            ['title' => 'Kolaboratif', 'description' => 'Melibatkan klien secara aktif dari perencanaan hingga peluncuran.'],
                            ['title' => 'Berorientasi Hasil', 'description' => 'Setiap solusi dirancang untuk memberi dampak nyata pada bisnis Anda.'],
                        ]],
                    ],
                ],
                'partner' => [
                    'label' => 'Partner & Klien',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Partner & Klien'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Dipercaya oleh Instansi dan Mitra Terkemuka'],
                        ['key' => 'partners', 'label' => 'Logo partner', 'type' => 'images', 'default' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Partner 1'], ['src' => 'images/partners/partner-2.png', 'caption' => 'Partner 2']]],
                        ['key' => 'clients', 'label' => 'Logo klien', 'type' => 'images', 'default' => [['src' => 'images/partners/client-1.png', 'caption' => 'Klien 1'], ['src' => 'images/partners/client-2.png', 'caption' => 'Klien 2'], ['src' => 'images/partners/client-3.png', 'caption' => 'Klien 3'], ['src' => 'images/partners/client-4.png', 'caption' => 'Klien 4'], ['src' => 'images/partners/client-5.png', 'caption' => 'Klien 5']]],
                    ],
                ],
                'cta' => $cta('Bergabung / Kolaborasi', 'Tertarik Bergabung atau Berkolaborasi?', 'Kami selalu terbuka untuk talenta baru dan kemitraan strategis.', 'Hubungi Kami', 'Lihat Portofolio'),
            ],
        ],

        'kontak' => [
            'label' => 'Kontak',
            'icon' => 'envelope',
            'groups' => [
                'hero' => [
                    'label' => 'Hero & Form',
                    'fields' => [
                        ['key' => 'eyebrow', 'label' => 'Label kecil', 'type' => 'text', 'default' => 'Kontak'],
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Hubungi Kami'],
                        ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'default' => 'Ceritakan kebutuhan bisnis Anda — tim kami akan merespons dalam 1×24 jam kerja.'],
                        ['key' => 'online', 'label' => 'Badge status online', 'type' => 'text', 'default' => 'Tim kami online · Senin–Jumat 09.00–17.00 WITA'],
                        ['key' => 'form_title', 'label' => 'Judul form', 'type' => 'text', 'default' => 'Kirim Pesan'],
                        ['key' => 'form_sub', 'label' => 'Sub-judul form', 'type' => 'text', 'default' => 'Isi formulir di bawah, kami akan menghubungi Anda kembali.'],
                        ['key' => 'services', 'label' => 'Pilihan layanan (pisahkan koma)', 'type' => 'text', 'default' => 'Software Development, Graphics Design, Digital Marketing, UI/UX Design, Konsultasi, Lainnya'],
                        ['key' => 'privacy', 'label' => 'Catatan privasi', 'type' => 'text', 'default' => 'Dengan mengirim, Anda menyetujui kebijakan privasi kami.'],
                        ['key' => 'success', 'label' => 'Pesan sukses setelah kirim', 'type' => 'textarea', 'default' => 'Pesan Anda telah terkirim. Tim kami akan merespons dalam 1x24 jam kerja.'],
                        ['key' => 'map_query', 'label' => 'Kueri Google Maps (alamat/nama tempat)', 'type' => 'text', 'default' => 'Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali'],
                    ],
                ],
            ],
        ],
    ],
];
