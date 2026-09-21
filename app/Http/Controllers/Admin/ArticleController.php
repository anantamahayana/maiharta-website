<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');     // semua | tayang | terjadwal | draft
        $category = $request->query('kategori', 'semua');
        $search = trim((string) $request->query('q', ''));

        $articles = Article::with('author')
            ->when($status === 'draft', fn ($q) => $q->where('status', 'draft'))
            ->when($status === 'tayang', fn ($q) => $q->published())
            ->when($status === 'terjadwal', fn ($q) => $q->where('status', 'published')->where('published_at', '>', now()))
            ->when($category !== 'semua', fn ($q) => $q->where('category', $category))
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'semua' => Article::count(),
            'tayang' => Article::published()->count(),
            'terjadwal' => Article::where('status', 'published')->where('published_at', '>', now())->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'status', 'category', 'search', 'counts'));
    }

    public function create()
    {
        return view('admin.articles.form', [
            'article' => new Article(['status' => 'draft', 'category' => array_key_first(Article::categories())]),
            'categories' => Article::categories(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['cover'] = $this->storeCover($request);

        $article = Article::create($data);

        return redirect()->route('admin.articles.edit', $article)->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', ['article' => $article, 'categories' => Article::categories()]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request, $article);

        if ($request->hasFile('cover')) {
            $this->deleteUpload($article->cover);
            $data['cover'] = $this->storeCover($request);
        } elseif ($request->boolean('remove_cover')) {
            $this->deleteUpload($article->cover);
            $data['cover'] = null;
        }

        $article->update($data);

        return back()->with('status', 'Artikel disimpan.');
    }

    public function destroy(Article $article)
    {
        $this->deleteUpload($article->cover);
        $this->deleteBodyImages($article->body);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Artikel dihapus.');
    }

    /** Unggah gambar dari editor Quill; balasan JSON { url }. */
    public function upload(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'max:2048']], ['image.max' => 'Ukuran gambar maksimal 2 MB.']);

        $path = $request->file('image')->store('articles', 'public');

        return response()->json(['url' => asset('storage/' . $path)]);
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('articles')->ignore($article?->id)],
            'category' => ['required', Rule::in(array_keys(Article::categories()))],
            'excerpt' => ['required', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ], [
            'title.required' => 'Judul wajib diisi.',
            'excerpt.required' => 'Ringkasan wajib diisi.',
            'excerpt.max' => 'Ringkasan maksimal 300 karakter.',
            'body.required' => 'Isi artikel wajib diisi.',
            'category.in' => 'Kategori tidak dikenal.',
            'cover.image' => 'Sampul harus berupa gambar.',
            'cover.max' => 'Ukuran sampul maksimal 2 MB.',
            'slug.unique' => 'Slug sudah dipakai artikel lain.',
        ]);

        // Editor Quill mengirim "<p><br></p>" saat kosong
        if (trim(strip_tags($data['body'])) === '' && ! str_contains($data['body'], '<img')) {
            throw \Illuminate\Validation\ValidationException::withMessages(['body' => 'Isi artikel wajib diisi.']);
        }

        $data['slug'] = filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Article::uniqueSlug($data['title'], $article?->id);
        $data['tags'] = collect(explode(',', (string) ($data['tags'] ?? '')))->map(fn ($t) => trim($t))->filter()->unique()->values()->all();
        $data['is_featured'] = $request->boolean('is_featured');
        // Tayang tanpa tanggal = tayang sekarang; draft tetap menyimpan jadwal bila diisi
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        unset($data['cover']);

        return $data;
    }

    private function storeCover(Request $request): ?string
    {
        return $request->hasFile('cover') ? 'storage/' . $request->file('cover')->store('articles', 'public') : null;
    }

    private function deleteUpload(?string $src): void
    {
        if ($src && str_starts_with($src, 'storage/')) {
            Storage::disk('public')->delete(Str::after($src, 'storage/'));
        }
    }

    /** Gambar yang diunggah lewat editor ikut dihapus bersama artikelnya. */
    private function deleteBodyImages(string $body): void
    {
        preg_match_all('#/storage/(articles/[^"\'\s>]+)#', $body, $m);
        foreach ($m[1] ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}
