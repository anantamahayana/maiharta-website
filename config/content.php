<?php

/*
|--------------------------------------------------------------------------
| Konten website yang bisa diedit dari panel admin
|--------------------------------------------------------------------------
| Setiap "page" menjadi satu tab di Admin → Konten Website. Setiap "group"
| disimpan sebagai satu baris di tabel `settings` (key = "page.group").
| Nilai default di sini = yang tampil bila admin belum mengubahnya.
| Teks halaman (judul, deskripsi, CTA) sengaja TIDAK di sini — itu diedit
| langsung di file Blade.
|
| Tipe field: text | textarea | images (daftar logo)
*/

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
                        ['key' => 'email', 'label' => 'Email', 'type' => 'text', 'default' => 'info@maiharta.com'],
                        ['key' => 'phone', 'label' => 'Telepon / WhatsApp (tampil)', 'type' => 'text', 'default' => '+62 812-3630-0562'],
                        ['key' => 'whatsapp', 'label' => 'Nomor WhatsApp (angka saja, awali 62)', 'type' => 'text', 'default' => '6281236300562'],
                        ['key' => 'address', 'label' => 'Alamat kantor', 'type' => 'textarea', 'default' => 'Jl. Tukad Ayung No.5, Denpasar Selatan, Kota Denpasar, Bali'],
                        ['key' => 'hours', 'label' => 'Jam operasional', 'type' => 'text', 'default' => 'Senin–Jumat, 09.00–17.00 WITA'],
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

        'tentang' => [
            'label' => 'Partner & Klien',
            'icon' => 'user-group',
            'groups' => [
                'partner' => [
                    'label' => 'Logo Partner & Klien',
                    'help' => 'Tampil di halaman Tentang. Kelompok yang kosong otomatis disembunyikan.',
                    'fields' => [
                        ['key' => 'partners', 'label' => 'Logo partner', 'type' => 'images', 'default' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Partner 1'], ['src' => 'images/partners/partner-2.png', 'caption' => 'Partner 2']]],
                        ['key' => 'clients', 'label' => 'Logo klien', 'type' => 'images', 'default' => [['src' => 'images/partners/client-1.png', 'caption' => 'Klien 1'], ['src' => 'images/partners/client-2.png', 'caption' => 'Klien 2'], ['src' => 'images/partners/client-3.png', 'caption' => 'Klien 3'], ['src' => 'images/partners/client-4.png', 'caption' => 'Klien 4'], ['src' => 'images/partners/client-5.png', 'caption' => 'Klien 5']]],
                    ],
                ],
            ],
        ],
    ],
];
