<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Software Development',
                'slug' => 'software-development',
                'icon' => 'code',
                'short_description' => 'Pengembangan sistem, aplikasi web, dan aplikasi mobile yang disesuaikan dengan kebutuhan bisnis — mulai dari perencanaan hingga peluncuran.',
                'description' => 'Kami membangun aplikasi dan sistem informasi custom yang tidak hanya fungsional, tetapi juga aman, efisien, dan mudah dikelola. Setiap proyek dimulai dengan memahami proses bisnis dan kebutuhan spesifik instansi Anda, dilanjutkan dengan perancangan sistem dan basis data, hingga pengembangan teknis yang mengikuti standar keamanan ISO/IEC 27001. Cocok untuk sistem kepegawaian, persuratan digital, hingga sistem informasi terintegrasi lainnya.',
                'tech_tags' => ['PHP / Laravel', 'MySQL', 'JavaScript', 'Bootstrap', 'REST API', 'Sistem Informasi'],
                'process_steps' => [
                    ['title' => 'Discovery', 'description' => 'Memahami kebutuhan, target pengguna, dan tujuan bisnis Anda.', 'duration' => '1–2 minggu'],
                    ['title' => 'Design', 'description' => 'Merancang struktur informasi dan tampilan visual sesuai brand.', 'duration' => '2–3 minggu'],
                    ['title' => 'Development', 'description' => 'Membangun sistem dengan kode yang bersih dan performa optimal.', 'duration' => '4–12 minggu'],
                    ['title' => 'Testing', 'description' => 'Menguji fungsi, performa, dan keamanan di berbagai perangkat.', 'duration' => '1–2 minggu'],
                    ['title' => 'Launch', 'description' => 'Peluncuran sistem beserta dukungan pascarilis.', 'duration' => 'Berkelanjutan'],
                ],
                'meta' => [
                    ['label' => 'Cocok untuk', 'value' => 'Instansi pemerintah, perbankan, UMKM'],
                    ['label' => 'Deliverable', 'value' => 'Web app, mobile app, API, dokumentasi'],
                    ['label' => 'Durasi tipikal', 'value' => '2 — 6 bulan'],
                    ['label' => 'Model kerja', 'value' => 'Fixed-scope atau retainer'],
                    ['label' => 'Standar', 'value' => 'ISO/IEC 27001'],
                ],
                'capabilities' => [
                    ['title' => 'Aplikasi Web & Portal', 'description' => 'Sistem internal, portal publik, dashboard'],
                    ['title' => 'Aplikasi Mobile', 'description' => 'Android & iOS, native maupun hybrid'],
                    ['title' => 'Integrasi & API', 'description' => 'Host-to-host, payment gateway, SSO'],
                    ['title' => 'Migrasi & Modernisasi', 'description' => 'Peremajaan sistem lama ke arsitektur baru'],
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Graphics Design',
                'slug' => 'graphics-design',
                'icon' => 'palette',
                'short_description' => 'Desain visual yang membangun identitas brand Anda, mulai dari logo dan materi promosi hingga tampilan antarmuka produk digital.',
                'description' => 'Kami merancang identitas visual yang konsisten dan mudah dikenali, mulai dari logo, materi promosi, hingga tampilan antarmuka (UI) produk digital Anda. Setiap desain dibangun berdasarkan riset brand dan target audiens agar benar-benar merepresentasikan bisnis Anda.',
                'tech_tags' => ['Figma', 'Adobe Illustrator', 'Adobe Photoshop', 'Brand Identity', 'UI Design'],
                'process_steps' => [
                    ['title' => 'Discovery', 'description' => 'Memahami brand, target pengguna, dan tujuan visual Anda.', 'duration' => '1–2 minggu'],
                    ['title' => 'Concept', 'description' => 'Eksplorasi konsep visual dan moodboard.'],
                    ['title' => 'Design', 'description' => 'Produksi aset desain final yang siap pakai.', 'duration' => '2–3 minggu'],
                    ['title' => 'Review', 'description' => 'Revisi bersama klien hingga hasil sesuai.'],
                    ['title' => 'Delivery', 'description' => 'Penyerahan aset dalam berbagai format.'],
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'icon' => 'megaphone',
                'short_description' => 'Strategi pemasaran digital untuk memperluas jangkauan bisnis Anda melalui media sosial, SEO, dan kampanye online yang terukur.',
                'description' => 'Kami membantu bisnis Anda menjangkau lebih banyak pelanggan melalui strategi pemasaran digital yang terukur — mencakup pengelolaan media sosial, optimasi SEO, hingga kampanye iklan online yang ditargetkan sesuai audiens Anda.',
                'tech_tags' => ['SEO', 'Social Media Ads', 'Google Ads', 'Content Strategy', 'Analytics'],
                'process_steps' => [
                    ['title' => 'Audit', 'description' => 'Menganalisis kondisi digital bisnis Anda saat ini.'],
                    ['title' => 'Strategy', 'description' => 'Menyusun strategi dan target kampanye.'],
                    ['title' => 'Execution', 'description' => 'Menjalankan kampanye di kanal yang relevan.'],
                    ['title' => 'Monitoring', 'description' => 'Memantau performa secara berkala.'],
                    ['title' => 'Reporting', 'description' => 'Laporan hasil dan rekomendasi lanjutan.'],
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'icon' => 'uiux',
                'short_description' => 'Riset pengguna, wireframing, hingga high-fidelity design system yang konsisten dan mudah digunakan.',
                'description' => 'Kami merancang pengalaman pengguna yang intuitif melalui riset mendalam, wireframing, hingga high-fidelity design system yang konsisten — memastikan produk digital Anda mudah digunakan dan enak dipandang.',
                'tech_tags' => ['Figma', 'User Research', 'Wireframing', 'Design System', 'Prototyping'],
                'process_steps' => [
                    ['title' => 'Research', 'description' => 'Memahami kebutuhan dan perilaku pengguna Anda.'],
                    ['title' => 'Wireframe', 'description' => 'Menyusun struktur dan alur informasi produk.'],
                    ['title' => 'UI Design', 'description' => 'Merancang tampilan visual yang konsisten dan mudah digunakan.'],
                    ['title' => 'Prototype', 'description' => 'Membangun prototipe interaktif untuk pengujian.'],
                    ['title' => 'Handoff', 'description' => 'Menyerahkan design system siap pakai untuk tim developer.'],
                ],
                'sort_order' => 4,
            ],
            [
                'name' => 'Konsultasi & Sistem Digital',
                'slug' => 'konsultasi-sistem-digital',
                'icon' => 'consulting',
                'short_description' => 'Analisis kebutuhan bisnis dan pengembangan sistem custom untuk mengotomatisasi proses operasional perusahaan.',
                'description' => 'Kami membantu Anda menganalisis proses bisnis yang ada dan merancang sistem custom yang mengotomatisasi operasional perusahaan — mengurangi pekerjaan manual dan meningkatkan efisiensi tim Anda.',
                'tech_tags' => ['Business Analysis', 'System Architecture', 'Process Automation', 'PHP / Laravel'],
                'process_steps' => [
                    ['title' => 'Konsultasi', 'description' => 'Diskusi mendalam tentang tantangan bisnis Anda.'],
                    ['title' => 'Analisis', 'description' => 'Memetakan proses bisnis dan peluang otomatisasi.'],
                    ['title' => 'Perancangan', 'description' => 'Merancang arsitektur sistem yang sesuai kebutuhan.'],
                    ['title' => 'Implementasi', 'description' => 'Membangun dan mengintegrasikan sistem custom.'],
                    ['title' => 'Evaluasi', 'description' => 'Meninjau hasil dan menyesuaikan sesuai kebutuhan.'],
                ],
                'sort_order' => 5,
            ],
            [
                'name' => 'QA & Testing',
                'slug' => 'qa-testing',
                'icon' => 'qa',
                'short_description' => 'Pengujian menyeluruh terhadap fungsi, performa, dan keamanan untuk memastikan kualitas produk sebelum dirilis.',
                'description' => 'Tim kami melakukan pengujian menyeluruh terhadap fungsi, performa, dan keamanan produk digital Anda sebelum dirilis — memastikan pengalaman pengguna yang mulus dan bebas dari bug kritis.',
                'tech_tags' => ['Manual Testing', 'Automated Testing', 'Performance Testing', 'Security Testing'],
                'process_steps' => [
                    ['title' => 'Test Planning', 'description' => 'Menyusun skenario dan rencana pengujian.'],
                    ['title' => 'Functional Testing', 'description' => 'Menguji setiap fitur berjalan sesuai harapan.'],
                    ['title' => 'Performance Testing', 'description' => 'Menguji kecepatan dan stabilitas sistem.'],
                    ['title' => 'Security Testing', 'description' => 'Memeriksa celah keamanan potensial.'],
                    ['title' => 'Report', 'description' => 'Laporan hasil pengujian dan rekomendasi perbaikan.'],
                ],
                'sort_order' => 6,
            ],
            [
                'name' => 'Maintenance & Support',
                'slug' => 'maintenance-support',
                'icon' => 'maintenance',
                'short_description' => 'Dukungan teknis dan pemeliharaan berkelanjutan pascapeluncuran agar produk digital Anda tetap berjalan optimal.',
                'description' => 'Kami menyediakan dukungan teknis dan pemeliharaan berkelanjutan pascapeluncuran — mencakup pembaruan sistem, perbaikan bug, dan pemantauan performa agar produk digital Anda tetap berjalan optimal.',
                'tech_tags' => ['Server Monitoring', 'Bug Fixing', 'System Updates', 'Technical Support'],
                'process_steps' => [
                    ['title' => 'Monitoring', 'description' => 'Memantau performa dan ketersediaan sistem.'],
                    ['title' => 'Bug Fixing', 'description' => 'Menangani laporan bug secara responsif.'],
                    ['title' => 'Update', 'description' => 'Memperbarui sistem sesuai kebutuhan keamanan.'],
                    ['title' => 'Backup', 'description' => 'Menjaga cadangan data secara berkala.'],
                    ['title' => 'Support', 'description' => 'Dukungan teknis siap membantu tim Anda.'],
                ],
                'sort_order' => 7,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
