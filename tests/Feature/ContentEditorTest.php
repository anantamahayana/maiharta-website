<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentEditorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_defaults_are_used_when_nothing_is_saved(): void
    {
        $this->assertSame('info@maiharta.com', site('umum.brand.email'));
        $this->assertSame('199+', site('umum.stats.projects'));
        $this->assertCount(2, site('tentang.partner.partners'));
    }

    public function test_content_tabs_render(): void
    {
        $this->assertSame(['umum', 'beranda', 'sertifikasi', 'tentang'], array_keys(config('content.pages')));
        $this->get('/admin/content')->assertOk()->assertSee('Identitas & Kontak')->assertSee('Logo');
        $this->get('/admin/content/sertifikasi')->assertOk()->assertSee('Kartu Praktik Keamanan');
        $this->get('/admin/content/tentang')->assertOk()->assertSee('Narasi Perusahaan')->assertSee('Logo Partner');
        $this->get('/admin/content/tidak-ada')->assertNotFound();
    }

    public function test_logo_upload_replaces_and_reset_returns_default(): void
    {
        $png = UploadedFile::fake()->createWithContent('logo.png', file_get_contents(public_path('images/logo-maiharta.png')));

        $this->put('/admin/content/umum', ['brand' => ['logo' => $png, 'email' => 'a@b.c', 'phone' => '1', 'whatsapp' => '62', 'address' => 'x', 'hours' => 'y', 'instagram' => '', 'facebook' => '', 'linkedin' => ''], 'stats' => ['years' => '1', 'projects' => '2', 'clients' => '3']])->assertRedirect();
        $logo = site('umum.brand.logo');
        $this->assertStringStartsWith('storage/content/', $logo);
        $this->get('/')->assertOk()->assertSee($logo, false);
        $this->get('/admin/login')->assertRedirect(); // logged in → dashboard
        $this->get('/admin')->assertOk()->assertSee($logo, false);

        $this->put('/admin/content/umum', ['brand' => ['logo_remove' => 1, 'email' => 'a@b.c', 'phone' => '1', 'whatsapp' => '62', 'address' => 'x', 'hours' => 'y', 'instagram' => '', 'facebook' => '', 'linkedin' => ''], 'stats' => ['years' => '1', 'projects' => '2', 'clients' => '3']]);
        $this->assertSame('images/logo-maiharta.png', site('umum.brand.logo'));
        Storage::disk('public')->assertMissing(str_replace('storage/', '', $logo));
    }

    public function test_hero_composition_is_editable(): void
    {
        $this->get('/')->assertOk()->assertSee('Ringkasan Proyek')->assertSee('SSO + 2FA aktif');
        $photo = UploadedFile::fake()->createWithContent('tim.jpg', file_get_contents(public_path('images/hero-team.jpg')));
        $this->put('/admin/content/beranda', ['hero' => ['card_title' => 'Statistik Klien', 'card_sub' => 'Update {tahun}', 'card_badge' => '', 'card_note' => 'n', 'iso_title' => 'i', 'iso_sub' => 'is', 'bubble_title' => 'Tiket 7', 'bubble_sub' => 'bs', 'bubble_status' => 'bst', 'bubble_text' => 'bt', 'sso_title' => 'Login Tunggal', 'sso_sub' => 'ss', 'photo_1' => $photo]])->assertRedirect();
        $this->get('/')->assertOk()->assertSee('Statistik Klien')->assertSee('Update ' . date('Y'))->assertSee('Login Tunggal')->assertDontSee('Ringkasan Proyek')->assertSee('storage/content/', false);
    }

    public function test_certification_cards_and_story_are_editable(): void
    {
        $this->get('/sertifikasi')->assertOk()->assertSee('AES-256')->assertSee('ISO 9001:2015');

        $this->put('/admin/content/sertifikasi', [
            'praktik' => ['items' => [['title' => 'Backup Harian', 'description' => 'd', 'tag' => '']]],
            'lain' => ['items' => []],
        ])->assertRedirect();
        $this->get('/sertifikasi')->assertOk()->assertSee('Backup Harian')->assertDontSee('AES-256')->assertDontSee('ISO 9001:2015')->assertDontSee('Standar Lain yang Kami Penuhi');

        $this->put('/admin/content/tentang', ['cerita' => ['title' => 'Judul Cerita Baru', 'description' => 'Narasi baru.', 'quote' => '', 'quote_by' => '']]);
        $this->get('/tentang')->assertOk()->assertSee('Judul Cerita Baru')->assertSee('Narasi baru.')->assertDontSee('Ngga ada habisnya');
    }

    public function test_service_step_duration_is_editable(): void
    {
        Service::create(['name' => 'S', 'slug' => 's', 'icon' => 'code', 'short_description' => 'x', 'description' => 'y']);
        $this->put('/admin/services/s', ['name' => 'S', 'icon' => 'code', 'short_description' => 'x', 'description' => 'y',
            'steps' => [['title' => 'Kickoff', 'description' => 'k', 'duration' => '3 hari'], ['title' => 'Rilis', 'description' => 'r', 'duration' => '']]])->assertRedirect();
        $this->assertSame('3 hari', Service::where('slug', 's')->first()->process_steps[0]['duration']);
        $this->get('/layanan/s')->assertOk()->assertSee('3 hari');
    }

    public function test_brand_and_stats_flow_to_public_pages(): void
    {
        $this->put('/admin/content/umum', [
            'brand' => ['email' => 'halo@contoh.id', 'phone' => '0800', 'whatsapp' => '62800', 'address' => 'Alamat Baru 123', 'hours' => 'Jam', 'instagram' => 'https://instagram.com/x', 'facebook' => '', 'linkedin' => ''],
            'stats' => ['years' => '9+', 'projects' => '250+', 'clients' => '50+'],
        ])->assertRedirect('/admin/content/umum')->assertSessionHas('status');

        $this->get('/kontak')->assertOk()->assertSee('halo@contoh.id')->assertSee('Alamat Baru 123')->assertSee('wa.me/62800', false)->assertSee('instagram.com/x', false)->assertDontSee('LinkedIn');
        $this->get('/tentang')->assertOk()->assertSee('250+')->assertSee('9+');
        $this->get('/layanan')->assertOk()->assertSee('250+');
        // footer + home hero counters
        $this->get('/')->assertOk()->assertSee('halo@contoh.id')->assertSee('data-count="250"', false);
        // page copy stays static
        $this->get('/')->assertSee('Ngga ada habisnya');
    }

    public function test_logo_upload_keep_and_remove(): void
    {
        $file = UploadedFile::fake()->createWithContent('logo.png', file_get_contents(public_path('images/partners/partner-1.png')));

        $this->put('/admin/content/tentang', [
            'partner' => [
                'partners_keep' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Mitra Satu']],
                'partners_files' => [$file],
                'clients_keep' => [],
            ],
        ])->assertRedirect();

        $partners = site('tentang.partner.partners');
        $this->assertCount(2, $partners);
        $this->assertSame('Mitra Satu', $partners[0]['caption']);
        $this->assertStringStartsWith('storage/content/', $partners[1]['src']);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $partners[1]['src']));
        $this->assertSame([], site('tentang.partner.clients'));

        $this->get('/tentang')->assertOk()->assertSee('Partner Kami')->assertSee('Mitra Satu')->assertDontSee('Client Kami');

        $this->put('/admin/content/tentang', [
            'partner' => ['partners_keep' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Mitra Satu']]],
        ]);
        Storage::disk('public')->assertMissing(str_replace('storage/', '', $partners[1]['src']));

        // both groups empty → section hidden entirely
        $this->put('/admin/content/tentang', ['partner' => []]);
        $this->get('/tentang')->assertOk()->assertDontSee('Dipercaya oleh Instansi');
    }

    public function test_service_meta_and_capabilities_are_editable_and_rendered(): void
    {
        $service = Service::create(['name' => 'Desain', 'slug' => 'desain', 'icon' => 'palette', 'short_description' => 'x', 'description' => 'y']);

        $this->get('/layanan/desain')->assertOk()->assertDontSee('Cocok untuk');

        $this->put('/admin/services/desain', [
            'name' => 'Desain', 'icon' => 'palette', 'short_description' => 'x', 'description' => 'y',
            'about_title' => 'Judul Tentang Khusus',
            'meta' => [['label' => 'Cocok untuk', 'value' => 'Brand UMKM'], ['label' => '', 'value' => 'diabaikan']],
            'capabilities' => [['title' => 'Logo & Identitas', 'description' => 'Sistem visual']],
        ])->assertRedirect();

        $service->refresh();
        $this->assertSame([['label' => 'Cocok untuk', 'value' => 'Brand UMKM']], $service->meta);
        $this->get('/layanan/desain')->assertOk()->assertSee('Cocok untuk')->assertSee('Brand UMKM')->assertSee('Logo & Identitas')->assertSee('Judul Tentang Khusus');
    }

    /** Regression: suffixed names must nest inside the group (PHP drops anything after a closing bracket). */
    public function test_image_field_names_are_nested_inside_group(): void
    {
        $html = $this->get('/admin/content/tentang')->assertOk()->getContent();

        $this->assertStringContainsString('partner[partners_keep][${i}][src]', $html);
        $this->assertStringContainsString('name="partner[partners_files][]"', $html);
        $this->assertStringNotContainsString('partner[partners]_keep', $html);

        $html = $this->get('/admin/content/umum')->assertOk()->getContent();
        $this->assertStringContainsString('name="brand[logo_remove]"', $html);
    }
}
