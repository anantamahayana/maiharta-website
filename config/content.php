<?php

/*
|--------------------------------------------------------------------------
| Konten website yang bisa diedit dari panel admin
|--------------------------------------------------------------------------
| Setiap "page" menjadi satu tab di Admin → Konten Website. Setiap "group"
| disimpan sebagai satu baris di tabel `settings` (key = "page.group").
| Nilai default di sini = yang tampil bila admin belum mengubahnya.
| Teks halaman lain (hero, judul section, CTA) sengaja tetap statis di Blade.
|
| Tipe field: text | textarea | image (satu gambar) | images (daftar logo)
|             | repeater (fields + max)
*/

return [
    'pages' => [

        'umum' => [
            'label' => 'Umum & Kontak',
            'icon' => 'globe-alt',
            'groups' => [
                'brand' => [
                    'label' => 'Identitas & Kontak',
                    'help' => 'Logo dipakai di navbar, halaman login, dan sidebar admin. Kontak dipakai di footer, halaman Kontak, dan tombol WhatsApp.',
                    'fields' => [
                        ['key' => 'logo', 'label' => 'Logo', 'type' => 'image', 'default' => 'images/logo-maiharta.png'],
                        ['key' => 'email', 'label' => 'Email', 'type' => 'text', 'default' => 'info@maiharta.com'],
                        ['key' => 'phone', 'label' => 'Telepon / WhatsApp (tampil)', 'type' => 'text', 'default' => '+62 812-3630-0562'],
                        ['key' => 'whatsapp', 'label' => 'Nomor WhatsApp (angka saja, awali 62)', 'type' => 'text', 'default' => '6281236300562'],
                        ['key' => 'address', 'label' => 'Alamat kantor', 'type' => 'textarea', 'default' => 'Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali'],
                        ['key' => 'hours', 'label' => 'Jam operasional', 'type' => 'text', 'default' => 'Senin–Jumat, 09.00–17.00 WITA'],
                        ['key' => 'maps_link', 'label' => 'Tautan Google Maps (tombol “Buka di Maps”)', 'type' => 'text', 'default' => 'https://maps.app.goo.gl/d65RkJQM85h3SzYeA'],
                        ['key' => 'maps_embed', 'label' => 'Kueri peta tersemat (nama tempat / koordinat)', 'type' => 'text', 'default' => 'Kantor MaiHarta@-8.6748883,115.2328203'],
                        ['key' => 'instagram', 'label' => 'URL Instagram', 'type' => 'text', 'default' => ''],
                        ['key' => 'facebook', 'label' => 'URL Facebook', 'type' => 'text', 'default' => ''],
                        ['key' => 'linkedin', 'label' => 'URL LinkedIn', 'type' => 'text', 'default' => ''],
                    ],
                ],
                'stats' => [
                    'label' => 'Angka Perusahaan',
                    'help' => 'Dipakai di hero Beranda, Layanan, Portofolio, dan Tentang.',
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
                    'label' => 'Komposisi Hero (kartu melayang)',
                    'help' => 'Angka proyek/instansi/tahun di kartu dashboard mengikuti “Angka Perusahaan” di tab Umum.',
                    'fields' => [
                        ['key' => 'card_title', 'label' => 'Kartu dashboard — judul', 'type' => 'text', 'default' => 'Ringkasan Proyek'],
                        ['key' => 'card_sub', 'label' => 'Kartu dashboard — sub-judul ({tahun} = tahun berjalan)', 'type' => 'text', 'default' => 'Semua klien · {tahun}'],
                        ['key' => 'card_badge', 'label' => 'Kartu dashboard — badge (kosongkan untuk sembunyikan)', 'type' => 'text', 'default' => 'Live'],
                        ['key' => 'card_note', 'label' => 'Kartu dashboard — catatan progres', 'type' => 'text', 'default' => '12 proyek aktif'],
                        ['key' => 'iso_title', 'label' => 'Badge ISO — judul', 'type' => 'text', 'default' => 'ISO/IEC 27001'],
                        ['key' => 'iso_sub', 'label' => 'Badge ISO — keterangan', 'type' => 'text', 'default' => 'Keamanan informasi tersertifikasi'],
                        ['key' => 'bubble_title', 'label' => 'Gelembung helpdesk — judul', 'type' => 'text', 'default' => 'Helpdesk · Tiket #1042'],
                        ['key' => 'bubble_sub', 'label' => 'Gelembung helpdesk — sub-judul', 'type' => 'text', 'default' => 'Nasabah · 2 jam lalu'],
                        ['key' => 'bubble_status', 'label' => 'Gelembung helpdesk — chip status', 'type' => 'text', 'default' => 'Selesai · SLA'],
                        ['key' => 'bubble_text', 'label' => 'Gelembung helpdesk — isi', 'type' => 'textarea', 'default' => '“Pengaduan sudah ditindaklanjuti unit terkait dan diselesaikan dalam 2 jam. Terima kasih!”'],
                        ['key' => 'sso_title', 'label' => 'Kartu SSO — judul', 'type' => 'text', 'default' => 'SSO + 2FA aktif'],
                        ['key' => 'sso_sub', 'label' => 'Kartu SSO — keterangan', 'type' => 'text', 'default' => 'Bank BPD Bali · 1 pintu login'],
                        ['key' => 'photo_1', 'label' => 'Foto kiri atas (tim)', 'type' => 'image', 'default' => 'images/hero-team.jpg'],
                        ['key' => 'photo_2', 'label' => 'Foto kanan bawah (dashboard)', 'type' => 'image', 'default' => 'images/hero-dashboard.jpg'],
                    ],
                ],
            ],
        ],

        'sertifikasi' => [
            'label' => 'Sertifikasi',
            'icon' => 'shield-check',
            'groups' => [
                'praktik' => [
                    'label' => 'Kartu Praktik Keamanan',
                    'help' => 'Tag teknis (mis. AES-256 · TLS 1.3) tampil sebagai chip di bawah kartu — pastikan sesuai praktik nyata.',
                    'fields' => [
                        ['key' => 'items', 'label' => 'Kartu', 'type' => 'repeater', 'max' => 4, 'fields' => [
                            ['key' => 'title', 'label' => 'Judul', 'type' => 'text'],
                            ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'],
                            ['key' => 'tag', 'label' => 'Tag teknis', 'type' => 'text'],
                        ], 'default' => [
                            ['title' => 'Data Terenkripsi', 'description' => 'Seluruh data klien dienkripsi baik saat disimpan maupun saat dikirim antar sistem, menggunakan protokol standar industri.', 'tag' => 'AES-256 · TLS 1.3'],
                            ['title' => 'Akses Terkontrol', 'description' => 'Akses ke sistem dan data dibatasi berdasarkan peran, dengan autentikasi berlapis dan pencatatan aktivitas.', 'tag' => 'RBAC · 2FA · Audit Trail'],
                            ['title' => 'Audit Risiko Berkala', 'description' => 'Penilaian risiko keamanan dilakukan secara rutin untuk mengidentifikasi celah sebelum menjadi ancaman.', 'tag' => 'Penetration Test · Review'],
                        ]],
                    ],
                ],
                'lain' => [
                    'label' => 'Sertifikasi & Penghargaan Lain',
                    'help' => 'Hapus baris yang belum dimiliki (mis. ISO 9001) agar tidak tampil.',
                    'fields' => [
                        ['key' => 'items', 'label' => 'Sertifikasi', 'type' => 'repeater', 'max' => 6, 'fields' => [
                            ['key' => 'name', 'label' => 'Nama (mis. ISO 9001:2015)', 'type' => 'text'],
                            ['key' => 'sub', 'label' => 'Keterangan', 'type' => 'text'],
                            ['key' => 'description', 'label' => 'Deskripsi', 'type' => 'text'],
                        ], 'default' => [
                            ['name' => 'ISO 9001:2015', 'sub' => 'Quality Management System', 'description' => 'Menjamin proses kerja yang konsisten dan berorientasi pada kepuasan klien.'],
                            ['name' => 'ISO/IEC 27001', 'sub' => 'Information Security Management', 'description' => 'Perlindungan data dan sistem informasi klien di seluruh siklus proyek.'],
                        ]],
                    ],
                ],
            ],
        ],

        'tentang' => [
            'label' => 'Tentang',
            'icon' => 'user-group',
            'groups' => [
                'cerita' => [
                    'label' => 'Narasi Perusahaan',
                    'help' => 'Tampil di section “Siapa Kami” halaman Tentang.',
                    'fields' => [
                        ['key' => 'title', 'label' => 'Judul', 'type' => 'text', 'default' => 'Dibangun di Bali, melayani instansi di seluruh Indonesia'],
                        ['key' => 'description', 'label' => 'Cerita', 'type' => 'textarea', 'default' => 'Berawal dari tim kecil pengembang di Denpasar, Maiharta tumbuh menjadi mitra teknologi bagi perbankan daerah, pemerintah provinsi dan kabupaten, hingga pelaku usaha kreatif. Kami percaya produk digital yang baik lahir dari pemahaman mendalam terhadap proses bisnis klien — bukan sekadar kode.'],
                        ['key' => 'quote', 'label' => 'Kutipan (kosongkan untuk sembunyikan)', 'type' => 'text', 'default' => '“Ngga ada habisnya” — semangat kami untuk terus berinovasi bersama setiap klien.'],
                        ['key' => 'quote_by', 'label' => 'Sumber kutipan', 'type' => 'text', 'default' => 'Tim Maiharta'],
                    ],
                ],
                'partner' => [
                    'label' => 'Logo Partner & Klien',
                    'help' => 'Kelompok yang kosong otomatis disembunyikan.',
                    'fields' => [
                        ['key' => 'partners', 'label' => 'Logo partner', 'type' => 'images', 'default' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Partner 1'], ['src' => 'images/partners/partner-2.png', 'caption' => 'Partner 2']]],
                        ['key' => 'clients', 'label' => 'Logo klien', 'type' => 'images', 'default' => [['src' => 'images/partners/client-1.png', 'caption' => 'Klien 1'], ['src' => 'images/partners/client-2.png', 'caption' => 'Klien 2'], ['src' => 'images/partners/client-3.png', 'caption' => 'Klien 3'], ['src' => 'images/partners/client-4.png', 'caption' => 'Klien 4'], ['src' => 'images/partners/client-5.png', 'caption' => 'Klien 5']]],
                    ],
                ],
            ],
        ],
    ],
];
