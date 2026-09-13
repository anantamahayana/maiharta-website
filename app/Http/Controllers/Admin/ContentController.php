<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function edit(string $page = 'umum')
    {
        $pages = config('content.pages');
        abort_unless(isset($pages[$page]), 404);

        return view('admin.content.edit', [
            'pages' => $pages,
            'page' => $page,
            'def' => $pages[$page],
            'values' => Setting::content()[$page],
        ]);
    }

    public function update(Request $request, string $page)
    {
        $pages = config('content.pages');
        abort_unless(isset($pages[$page]), 404);

        foreach ($pages[$page]['groups'] as $group => $groupDef) {
            $current = Setting::content()[$page][$group];
            $value = [];

            foreach ($groupDef['fields'] as $field) {
                $key = $field['key'];
                $input = $request->input("{$group}.{$key}");

                $value[$key] = match ($field['type']) {
                    'text', 'textarea' => trim((string) $input),
                    'repeater' => collect($input ?? [])
                        ->map(fn ($row) => collect($field['fields'])->mapWithKeys(fn ($f) => [$f['key'] => trim((string) ($row[$f['key']] ?? ''))])->all())
                        ->filter(fn ($row) => collect($row)->contains(fn ($v) => $v !== ''))
                        ->take($field['max'] ?? 50)
                        ->values()
                        ->all(),
                    'images' => $this->syncImages($request, "{$group}.{$key}", $current[$key] ?? []),
                    'image' => $this->syncImage($request, "{$group}.{$key}", $current[$key] ?? '', $field['default'] ?? ''),
                    default => $input,
                };
            }

            Setting::put("{$page}.{$group}", $value);
        }

        return redirect()->route('admin.content.edit', $page)->with('status', 'Konten ' . $pages[$page]['label'] . ' disimpan.');
    }

    /** Single image: new upload replaces (and deletes) the previous upload; "remove" falls back to the default file. */
    private function syncImage(Request $request, string $path, string $current, string $default): string
    {
        $file = $request->file($path);
        if ($file && $file->isValid()) {
            $this->deleteUpload($current);

            return 'storage/' . $file->store('content', 'public');
        }
        if ($request->boolean("{$path}_remove")) {
            $this->deleteUpload($current);

            return $default;
        }

        return $current ?: $default;
    }

    private function deleteUpload(?string $src): void
    {
        if ($src && str_starts_with($src, 'storage/')) {
            Storage::disk('public')->delete(Str::after($src, 'storage/'));
        }
    }

    /** Keep rows the admin left in place (with edited captions), delete removed uploads, append new files. */
    private function syncImages(Request $request, string $path, array $existing): array
    {
        $kept = collect($request->input("{$path}_keep", []))
            ->filter(fn ($r) => filled($r['src'] ?? null))
            ->map(fn ($r) => ['src' => $r['src'], 'caption' => trim((string) ($r['caption'] ?? ''))])
            ->values();

        $keptSrcs = $kept->pluck('src')->all();
        foreach ($existing as $img) {
            $src = is_array($img) ? $img['src'] : $img;
            if (! in_array($src, $keptSrcs, true) && str_starts_with($src, 'storage/')) {
                Storage::disk('public')->delete(Str::after($src, 'storage/'));
            }
        }

        $files = $request->file("{$path}_files") ?? [];
        foreach ((array) $files as $file) {
            if ($file && $file->isValid()) {
                $kept->push(['src' => 'storage/' . $file->store('content', 'public'), 'caption' => Str::of($file->getClientOriginalName())->beforeLast('.')->title()->toString()]);
            }
        }

        return $kept->all();
    }
}
