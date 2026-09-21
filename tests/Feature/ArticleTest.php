<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    private function jpg(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, file_get_contents(public_path('images/hero-team.jpg')));
    }

    public function test_blog_index_lists_only_live_articles_with_featured_and_filter(): void
    {
        $featured = Article::factory()->create(['title' => 'Artikel Unggulan', 'is_featured' => true, 'category' => 'wawasan']);
        Article::factory()->create(['title' => 'Artikel Tips', 'category' => 'tips']);
        Article::factory()->draft()->create(['title' => 'Artikel Draft']);
        Article::factory()->scheduled()->create(['title' => 'Artikel Terjadwal']);

        $this->get('/blog')->assertOk()
            ->assertSee('Artikel Unggulan')->assertSee('Pilihan')->assertSee('Artikel Tips')
            ->assertDontSee('Artikel Draft')->assertDontSee('Artikel Terjadwal')
            ->assertSee('Menampilkan 1–2 dari 2 artikel');

        $this->get('/blog?kategori=tips')->assertOk()->assertSee('Artikel Tips')->assertDontSee('Artikel Unggulan');
        $this->get('/blog?kategori=tidak-ada')->assertOk()->assertSee('Artikel Unggulan');
    }

    public function test_blog_show_renders_and_hides_unpublished_from_guests(): void
    {
        $live = Article::factory()->create(['title' => 'Judul Tayang', 'body' => '<h2>Sub Judul</h2><p>Isi.</p>', 'tags' => ['laravel']]);
        $draft = Article::factory()->draft()->create();
        Article::factory()->create(['title' => 'Artikel Lain Terkait']);

        $this->get("/blog/{$live->slug}")->assertOk()->assertSee('Judul Tayang')->assertSee('Sub Judul')->assertSee('#laravel')->assertSee('Artikel Terkait')->assertSee('Artikel Lain Terkait');
        $this->assertSame(1, $live->fresh()->views);

        $this->get("/blog/{$draft->slug}")->assertNotFound();
        $this->actingAs($this->admin)->get("/blog/{$draft->slug}")->assertOk()->assertSee('Pratinjau');
        $this->assertSame(0, $draft->fresh()->views);
    }

    public function test_home_shows_latest_articles_and_hides_section_when_empty(): void
    {
        $this->get('/')->assertOk()->assertDontSee('Lihat Semua Artikel');

        Article::factory()->count(4)->create();
        $this->get('/')->assertOk()->assertSee('Lihat Semua Artikel');
    }

    public function test_old_certification_url_redirects_to_blog(): void
    {
        $this->get('/sertifikasi')->assertRedirect('/blog');
        $this->get('/')->assertOk()->assertDontSee('ISO/IEC 27001')->assertDontSee('Sertifikasi');
    }

    public function test_admin_article_crud_with_cover_and_upload(): void
    {
        $this->actingAs($this->admin);

        $this->get('/admin/articles')->assertOk()->assertSee('Belum ada artikel');
        $this->get('/admin/articles/create')->assertOk();

        $this->post('/admin/articles', [
            'title' => 'Artikel Baru Saya', 'category' => 'tips', 'excerpt' => 'Ringkasan.', 'body' => '<p>Isi artikel.</p>',
            'tags' => 'satu, dua', 'status' => 'published', 'cover' => $this->jpg('cover.jpg'),
        ])->assertRedirect();

        $a = Article::firstOrFail();
        $this->assertSame('artikel-baru-saya', $a->slug);
        $this->assertSame(['satu', 'dua'], $a->tags);
        $this->assertNotNull($a->published_at);
        $this->assertSame($this->admin->id, $a->user_id);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $a->cover));

        // update: ganti status ke draft + hapus sampul
        $this->put("/admin/articles/{$a->slug}", [
            'title' => 'Artikel Baru Saya', 'category' => 'tips', 'excerpt' => 'Ringkasan.', 'body' => '<p>Isi.</p>', 'status' => 'draft', 'remove_cover' => 1,
        ])->assertRedirect();
        $this->assertNull($a->fresh()->cover);
        $this->get('/blog')->assertDontSee('Artikel Baru Saya');

        // validasi: body kosong dari editor
        $this->post('/admin/articles', ['title' => 'X', 'category' => 'tips', 'excerpt' => 'r', 'body' => '<p><br></p>', 'status' => 'draft'])
            ->assertSessionHasErrors('body');

        // unggah gambar editor
        $res = $this->post('/admin/articles/upload', ['image' => $this->jpg('inline.jpg')])->assertOk()->json();
        $this->assertStringContainsString('/storage/articles/', $res['url']);

        // hapus artikel membersihkan gambar isi
        $a->update(['body' => '<p><img src="' . $res['url'] . '"></p>']);
        $this->delete("/admin/articles/{$a->slug}")->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseMissing('articles', ['id' => $a->id]);
        Storage::disk('public')->assertMissing(str_replace(asset('storage/'), '', $res['url']));
    }

    public function test_admin_pages_without_certification_tab(): void
    {
        $this->actingAs($this->admin);
        $this->get('/admin')->assertOk()->assertSee('Artikel Tayang');
        $this->get('/admin/content/sertifikasi')->assertNotFound();
        $this->get('/admin/content')->assertOk()->assertDontSee('Sertifikasi');
    }
}
