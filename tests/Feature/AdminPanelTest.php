<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    /** Real JPEG from public/images — the CLI PHP here has no GD for fake()->image(). */
    private function jpg(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, file_get_contents(public_path('images/hero-team.jpg')));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['email' => 'admin@maiharta.com']);
        Storage::fake('public');
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_logout(): void
    {
        $this->post('/admin/login', ['email' => $this->admin->email, 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_wrong_password_shows_error(): void
    {
        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $this->admin->email, 'password' => 'salah'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');
    }

    public function test_all_admin_pages_render(): void
    {
        $service = Service::create(['name' => 'Software Development', 'slug' => 'software-development', 'icon' => 'code', 'short_description' => 'x', 'description' => 'y', 'sort_order' => 1]);
        $project = Project::create(['name' => 'Proyek A', 'slug' => 'proyek-a', 'category' => 'Apps Development', 'short_description' => 'x', 'description' => 'y', 'service_id' => $service->id]);
        $message = ContactSubmission::create(['name' => 'Budi', 'email' => 'budi@example.com', 'message' => '[Layanan: UI/UX] Halo']);

        $this->actingAs($this->admin);
        foreach ([
            '/admin', '/admin/projects', '/admin/projects/create', "/admin/projects/{$project->slug}/edit",
            '/admin/services', '/admin/services/create', "/admin/services/{$service->slug}/edit",
            '/admin/messages', '/admin/messages?filter=belum-dibaca&q=Budi', '/admin/settings',
        ] as $url) {
            $this->get($url)->assertOk();
        }

        $this->get("/admin/messages/{$message->id}")->assertRedirect();
        $this->assertTrue($message->fresh()->is_read);
        $this->get("/admin/messages?open={$message->id}")->assertOk()->assertSee('UI/UX')->assertSee('Halo');
    }

    public function test_project_crud_with_cover_and_gallery(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/projects', [
            'name' => 'Website Baru',
            'category' => 'Website Development',
            'short_description' => 'Singkat',
            'description' => 'Lengkap',
            'external_url' => 'https://contoh.com',
            'stats' => [['value' => '10', 'label' => 'Fitur'], ['value' => '', 'label' => 'kosong diabaikan']],
            'cover' => $this->jpg('cover.jpg'),
            'gallery_files' => [$this->jpg('g1.jpg'), $this->jpg('g2.jpg')],
        ]);

        $project = Project::where('slug', 'website-baru')->firstOrFail();
        $response->assertRedirect(route('admin.projects.edit', $project));
        $this->assertSame([['value' => '10', 'label' => 'Fitur']], $project->outcome_stats);
        $this->assertStringStartsWith('storage/projects/', $project->cover_image);
        $this->assertCount(2, $project->gallery);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $project->cover_image));

        // update: keep one gallery image with caption, remove cover
        $keep = $project->gallery[0];
        $this->put("/admin/projects/{$project->slug}", [
            'name' => 'Website Baru',
            'category' => 'Website Development',
            'short_description' => 'Singkat',
            'description' => 'Lengkap',
            'remove_cover' => 1,
            'gallery_keep' => [['src' => $keep['src'], 'caption' => 'Beranda']],
        ])->assertRedirect();

        $project->refresh();
        $this->assertNull($project->cover_image);
        $this->assertSame([['src' => $keep['src'], 'caption' => 'Beranda']], $project->gallery);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $keep['src']));

        // public page renders with these data
        $this->get('/portofolio/website-baru')->assertOk()->assertSee('Beranda');

        $this->delete("/admin/projects/{$project->slug}")->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseMissing('projects', ['slug' => 'website-baru']);
        Storage::disk('public')->assertMissing(str_replace('storage/', '', $keep['src']));
    }

    public function test_service_crud_parses_tags_and_steps(): void
    {
        $this->actingAs($this->admin);

        $this->post('/admin/services', [
            'name' => 'QA & Testing',
            'icon' => 'qa',
            'short_description' => 'Uji',
            'description' => 'Uji lengkap',
            'tech_tags' => 'Playwright, PHPUnit, , Playwright',
            'steps' => [['title' => 'Rencana', 'description' => 'a'], ['title' => '', 'description' => 'diabaikan']],
        ])->assertRedirect();

        $service = Service::where('slug', 'qa-testing')->firstOrFail();
        $this->assertSame(['Playwright', 'PHPUnit'], $service->tech_tags);
        $this->assertSame([['title' => 'Rencana', 'description' => 'a', 'duration' => '']], $service->process_steps);

        $this->post('/admin/services', ['name' => 'Lain', 'icon' => 'tidak-ada', 'short_description' => 'x', 'description' => 'y'])
            ->assertSessionHasErrors('icon');

        $this->delete("/admin/services/{$service->slug}")->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseMissing('services', ['slug' => 'qa-testing']);
    }

    public function test_settings_update_profile_and_password(): void
    {
        $this->actingAs($this->admin);

        $this->put('/admin/settings/profile', ['name' => 'Admin Baru', 'email' => 'baru@maiharta.com'])->assertSessionHas('status');
        $this->assertSame('baru@maiharta.com', $this->admin->fresh()->email);

        $this->put('/admin/settings/password', ['current_password' => 'salah', 'password' => 'rahasia123', 'password_confirmation' => 'rahasia123'])
            ->assertSessionHasErrors('current_password');
        $this->put('/admin/settings/password', ['current_password' => 'password', 'password' => 'rahasia123', 'password_confirmation' => 'rahasia123'])
            ->assertSessionHas('status');
        $this->assertTrue(\Hash::check('rahasia123', $this->admin->fresh()->password));
    }

    public function test_message_toggle_and_delete(): void
    {
        $this->actingAs($this->admin);
        $m = ContactSubmission::create(['name' => 'Ani', 'email' => 'ani@example.com', 'message' => 'Hai', 'is_read' => true]);

        $this->patch("/admin/messages/{$m->id}/toggle")->assertRedirect();
        $this->assertFalse($m->fresh()->is_read);

        $this->delete("/admin/messages/{$m->id}")->assertRedirect(route('admin.messages.index'));
        $this->assertDatabaseMissing('contact_submissions', ['id' => $m->id]);
    }

    public function test_contact_phone_enables_whatsapp_reply(): void
    {
        $this->post('/kontak', ['name' => 'Wayan', 'email' => 'w@example.com', 'phone' => '0812-3456-7890', 'message' => 'Halo', 'website' => ''])->assertSessionHas('status');
        $m = ContactSubmission::latest()->first();
        $this->assertSame('081234567890', $m->phone); // dinormalisasi ke angka saja
        $this->assertSame('6281234567890', $m->whatsapp_number);

        $this->post('/kontak', ['name' => 'X', 'email' => 'x@example.com', 'phone' => 'abc', 'message' => 'Halo', 'website' => ''])->assertSessionHasErrors('phone');

        $this->actingAs($this->admin);
        $this->get("/admin/messages?open={$m->id}")->assertOk()->assertSee('wa.me/6281234567890', false);
        $noPhone = ContactSubmission::create(['name' => 'Tanpa', 'email' => 't@example.com', 'message' => 'Hi']);
        $this->get("/admin/messages?open={$noPhone->id}")->assertOk()->assertSee('Tanpa nomor WhatsApp')->assertDontSee('wa.me/', false);
    }

    /** Laporan bug #7: logout dengan token CSRF basi harus tetap keluar, bukan 419. */
    public function test_logout_with_stale_csrf_token_still_logs_out(): void
    {
        $this->actingAs($this->admin);

        $response = $this->withoutExceptionHandling()->withMiddleware()
            ->call('POST', '/admin/logout', ['_token' => 'basi']);

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    /** Laporan bug #9: waktu admin ditampilkan dalam WITA, bukan UTC. */
    public function test_admin_times_are_shown_in_wita(): void
    {
        $this->assertSame('Asia/Makassar', config('app.timezone'));
        $this->actingAs($this->admin);
        $m = ContactSubmission::create(['name' => 'Ani', 'email' => 'ani@example.com', 'message' => 'Hai']);

        $this->get('/admin')->assertOk()->assertSee('Belum dibaca');
        $this->get("/admin/messages?open={$m->id}")->assertOk()
            ->assertSee($m->created_at->translatedFormat('H:i') . ' WITA');
    }
}
