<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public const ICONS = [
        'code' => 'Software / kode',
        'palette' => 'Desain grafis',
        'megaphone' => 'Marketing',
        'uiux' => 'UI/UX',
        'consulting' => 'Konsultasi',
        'qa' => 'QA & Testing',
        'maintenance' => 'Maintenance',
    ];

    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::withCount('projects')->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.services.form', [
            'service' => new Service(['sort_order' => Service::max('sort_order') + 1, 'icon' => 'code']),
            'icons' => self::ICONS,
        ]);
    }

    public function store(Request $request)
    {
        $service = Service::create($this->validated($request));

        return redirect()->route('admin.services.edit', $service)->with('status', 'Layanan berhasil dibuat.');
    }

    public function edit(Service $service)
    {
        $service->loadCount('projects')->load(['projects' => fn ($q) => $q->orderBy('sort_order')]);

        return view('admin.services.form', ['service' => $service, 'icons' => self::ICONS]);
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validated($request, $service));

        return redirect()->route('admin.services.edit', $service)->with('status', 'Perubahan disimpan.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Layanan dihapus.');
    }

    private function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('services')->ignore($service?->id)],
            'icon' => ['required', Rule::in(array_keys(self::ICONS))],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tech_tags' => ['nullable', 'string', 'max:1000'],
            'steps' => ['nullable', 'array'],
            'steps.*.title' => ['nullable', 'string', 'max:100'],
            'steps.*.description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'about_title' => ['nullable', 'string', 'max:255'],
            'meta' => ['nullable', 'array'],
            'meta.*.label' => ['nullable', 'string', 'max:60'],
            'meta.*.value' => ['nullable', 'string', 'max:255'],
            'capabilities' => ['nullable', 'array'],
            'capabilities.*.title' => ['nullable', 'string', 'max:100'],
            'capabilities.*.description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama layanan wajib diisi.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'short_description.max' => 'Maksimal 255 karakter.',
            'description.required' => 'Deskripsi lengkap wajib diisi.',
            'slug.unique' => 'Slug sudah dipakai layanan lain.',
        ]);

        $data['slug'] = Str::slug(($data['slug'] ?? null) ?: $data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['tech_tags'] = collect(explode(',', (string) ($data['tech_tags'] ?? '')))
            ->map(fn ($t) => trim($t))->filter()->unique()->values()->all();
        $data['process_steps'] = collect($data['steps'] ?? [])
            ->filter(fn ($s) => filled($s['title'] ?? null))
            ->map(fn ($s) => ['title' => $s['title'], 'description' => $s['description'] ?? ''])
            ->values()
            ->all();
        $data['meta'] = collect($data['meta'] ?? [])
            ->filter(fn ($m) => filled($m['label'] ?? null) && filled($m['value'] ?? null))
            ->map(fn ($m) => ['label' => $m['label'], 'value' => $m['value']])->values()->all();
        $data['capabilities'] = collect($data['capabilities'] ?? [])
            ->filter(fn ($c) => filled($c['title'] ?? null))
            ->map(fn ($c) => ['title' => $c['title'], 'description' => $c['description'] ?? ''])->values()->all();
        unset($data['steps']);

        return $data;
    }
}
