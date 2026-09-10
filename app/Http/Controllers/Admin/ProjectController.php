<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public const CATEGORIES = ['Apps Development', 'Website Development', 'Mobile App', 'UI/UX Design'];

    public function index(Request $request)
    {
        $category = $request->query('kategori', 'Semua');
        $search = trim((string) $request->query('q', ''));

        $projects = Project::with('service')
            ->when($category !== 'Semua', fn ($q) => $q->where('category', $category))
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")->orWhere('client_type', 'like', "%{$search}%");
            }))
            ->orderBy('sort_order')
            ->get();

        $counts = ['Semua' => Project::count()] + Project::query()->selectRaw('category, count(*) as c')->groupBy('category')->pluck('c', 'category')->all();

        return view('admin.projects.index', compact('projects', 'category', 'search', 'counts'));
    }

    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(['sort_order' => Project::max('sort_order') + 1]),
            'services' => Service::orderBy('sort_order')->get(),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['cover_image'] = $this->storeCover($request) ?? null;
        $data['gallery'] = $this->syncGallery($request, []);

        $project = Project::create($data);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Proyek berhasil dibuat.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', [
            'project' => $project,
            'services' => Service::orderBy('sort_order')->get(),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request, $project);

        if ($request->boolean('remove_cover')) {
            $this->deleteFile($project->cover_image);
            $data['cover_image'] = null;
        }
        if ($cover = $this->storeCover($request)) {
            $this->deleteFile($project->cover_image);
            $data['cover_image'] = $cover;
        }
        $data['gallery'] = $this->syncGallery($request, $project->gallery ?? []);

        $project->update($data);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Perubahan disimpan.');
    }

    public function destroy(Project $project)
    {
        $this->deleteFile($project->cover_image);
        foreach ($project->gallery ?? [] as $img) {
            $this->deleteFile(is_array($img) ? $img['src'] : $img);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Proyek dihapus.');
    }

    // ---------------------------------------------------------------------

    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('projects')->ignore($project?->id)],
            'category' => ['required', 'string', 'max:100'],
            'service_id' => ['nullable', 'exists:services,id'],
            'client_type' => ['nullable', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'tech_summary' => ['nullable', 'string'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['nullable', 'string', 'max:50'],
            'stats.*.label' => ['nullable', 'string', 'max:100'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'max:2048'],
            'gallery_keep' => ['nullable', 'array'],
            'gallery_keep.*.src' => ['required', 'string'],
            'gallery_keep.*.caption' => ['nullable', 'string', 'max:120'],
        ], [
            'name.required' => 'Nama proyek wajib diisi.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'short_description.max' => 'Maksimal 255 karakter.',
            'description.required' => 'Deskripsi lengkap wajib diisi.',
            'external_url.url' => 'URL harus diawali http:// atau https://.',
            'cover.image' => 'Sampul harus berupa gambar.',
            'cover.max' => 'Ukuran sampul maksimal 2 MB.',
            'gallery_files.*.max' => 'Ukuran tiap gambar galeri maksimal 2 MB.',
            'slug.unique' => 'Slug sudah dipakai proyek lain.',
        ]);

        $data['slug'] = Str::slug(($data['slug'] ?? null) ?: $data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['outcome_stats'] = collect($data['stats'] ?? [])
            ->filter(fn ($s) => filled($s['value'] ?? null) && filled($s['label'] ?? null))
            ->map(fn ($s) => ['value' => $s['value'], 'label' => $s['label']])
            ->values()
            ->all();

        unset($data['stats'], $data['cover'], $data['gallery_files'], $data['gallery_keep']);

        return $data;
    }

    private function storeCover(Request $request): ?string
    {
        if (! $request->hasFile('cover')) {
            return null;
        }

        return 'storage/' . $request->file('cover')->store('projects', 'public');
    }

    private function syncGallery(Request $request, array $existing): array
    {
        $kept = collect($request->input('gallery_keep', []))
            ->map(fn ($g) => ['src' => $g['src'], 'caption' => $g['caption'] ?? null])
            ->values();

        // delete files that were removed from the gallery
        $keptSrcs = $kept->pluck('src')->all();
        foreach ($existing as $img) {
            $src = is_array($img) ? $img['src'] : $img;
            if (! in_array($src, $keptSrcs, true)) {
                $this->deleteFile($src);
            }
        }

        foreach ($request->file('gallery_files', []) as $file) {
            $kept->push(['src' => 'storage/' . $file->store('projects/gallery', 'public'), 'caption' => null]);
        }

        return $kept->all();
    }

    private function deleteFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(Str::after($path, 'storage/'));
        }
    }
}
