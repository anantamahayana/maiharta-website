<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Setting;
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
        $this->assertSame('Ngga ada habisnya', site('beranda.hero.headline_gradient'));
        $this->assertCount(3, site('tentang.nilai.items'));
        $this->assertSame(['Konsultasi gratis', 'Tanpa biaya tersembunyi', 'Dukungan pascarilis'], collect(site('beranda.hero.bullets'))->pluck('text')->all());
    }

    public function test_every_content_tab_renders(): void
    {
        foreach (array_keys(config('content.pages')) as $page) {
            $this->get("/admin/content/{$page}")->assertOk()->assertSee(config("content.pages.{$page}.label"));
        }
        $this->get('/admin/content/tidak-ada')->assertNotFound();
    }

    public function test_saving_text_and_repeater_updates_public_pages(): void
    {
        $this->put('/admin/content/beranda', [
            'hero' => [
                'badge' => 'Badge Baru',
                'headline_gradient' => 'Judul Gradien Baru',
                'headline' => 'lanjutan judul',
                'description' => 'Deskripsi baru',
                'primary' => 'Tombol A', 'secondary' => 'Tombol B',
                'bullets' => [['text' => 'Satu'], ['text' => ''], ['text' => 'Dua']],
                'card_title' => 'Kartu', 'card_note' => 'catatan', 'bubble_title' => 'x', 'bubble_sub' => 'y', 'bubble_text' => 'z', 'sso_title' => 'a', 'sso_sub' => 'b',
            ],
            'solusi' => ['eyebrow' => 'E', 'title' => 'Judul Solusi Baru', 'description' => 'D'],
            'portofolio' => ['eyebrow' => 'E', 'title' => 'T'],
            'sertifikasi' => ['eyebrow' => 'E', 'title' => 'T', 'description' => 'D', 'points' => [['title' => 'Poin Unik', 'description' => 'd']], 'panel_title' => 'ISO', 'panel_sub' => 'S', 'panel_tags' => 'A, B'],
            'tentang' => ['eyebrow' => 'E', 'title' => 'T', 'description' => 'D', 'button' => 'B'],
            'cta' => ['eyebrow' => 'E', 'title' => 'CTA Baru', 'description' => 'D', 'primary' => 'P', 'secondary' => 'S'],
        ])->assertRedirect('/admin/content/beranda')->assertSessionHas('status');

        $this->assertSame([['text' => 'Satu'], ['text' => 'Dua']], site('beranda.hero.bullets'));
        $this->assertSame('Judul Gradien Baru', Setting::find('beranda.hero')->value['headline_gradient']);

        Service::create(['name' => 'S', 'slug' => 's', 'icon' => 'code', 'short_description' => 'x', 'description' => 'y']);
        $this->get('/')->assertOk()
            ->assertSee('Judul Gradien Baru')->assertSee('Judul Solusi Baru')->assertSee('Poin Unik')->assertSee('CTA Baru')
            ->assertDontSee('Ngga ada habisnya');
    }

    public function test_contact_and_footer_read_brand_settings(): void
    {
        $this->put('/admin/content/umum', [
            'brand' => ['tagline' => 'Tagline Baru', 'email' => 'halo@contoh.id', 'phone' => '0800', 'whatsapp' => '62800', 'address' => 'Alamat Baru 123', 'hours' => 'Jam', 'instagram' => 'https://instagram.com/x', 'facebook' => '', 'linkedin' => '', 'footer_note' => 'Catatan'],
            'stats' => ['years' => '9+', 'projects' => '250+', 'clients' => '50+'],
        ])->assertRedirect();

        $this->get('/kontak')->assertOk()->assertSee('halo@contoh.id')->assertSee('Alamat Baru 123')->assertSee('wa.me/62800', false)->assertSee('instagram.com/x', false)->assertDontSee('LinkedIn');
        $this->get('/tentang')->assertOk()->assertSee('Tagline Baru')->assertSee('250+');
    }

    public function test_logo_upload_keep_and_remove(): void
    {
        $file = UploadedFile::fake()->createWithContent('logo.png', file_get_contents(public_path('images/partners/partner-1.png')));

        $this->put('/admin/content/tentang', [
            'hero' => ['eyebrow' => 'E', 'title' => 'T', 'description' => 'D'],
            'cerita' => ['eyebrow' => 'E', 'title' => 'T', 'description' => 'D', 'quote' => '', 'quote_by' => '', 'button' => 'B'],
            'nilai' => ['eyebrow' => 'E', 'items' => [['title' => 'Nilai X', 'description' => 'd']]],
            'partner' => [
                'eyebrow' => 'E', 'title' => 'T',
                'partners_keep' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Mitra Satu']],
                'partners_files' => [$file],
                'clients_keep' => [],
            ],
            'cta' => ['eyebrow' => 'E', 'title' => 'T', 'description' => 'D', 'primary' => 'P', 'secondary' => 'S'],
        ])->assertRedirect();

        $partners = site('tentang.partner.partners');
        $this->assertCount(2, $partners);
        $this->assertSame('Mitra Satu', $partners[0]['caption']);
        $this->assertStringStartsWith('storage/content/', $partners[1]['src']);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $partners[1]['src']));
        $this->assertSame([], site('tentang.partner.clients'));

        $this->get('/tentang')->assertOk()->assertSee('Nilai X')->assertSee('Partner Kami')->assertDontSee('Client Kami');

        // removing the uploaded file deletes it from disk
        $this->put('/admin/content/tentang', [
            'partner' => ['eyebrow' => 'E', 'title' => 'T', 'partners_keep' => [['src' => 'images/partners/partner-1.png', 'caption' => 'Mitra Satu']]],
        ]);
        Storage::disk('public')->assertMissing(str_replace('storage/', '', $partners[1]['src']));
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
}
