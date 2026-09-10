<?php

use App\Models\Setting;

if (! function_exists('site')) {
    /**
     * Konten website yang bisa diedit dari admin, dengan notasi titik:
     *   site('beranda.hero.headline')  → string
     *   site('tentang.nilai.items')    → array
     */
    function site(string $path, mixed $default = null): mixed
    {
        return Setting::get($path, $default);
    }
}

if (! function_exists('site_list')) {
    /** Nilai bertipe "a, b, c" menjadi array yang sudah di-trim & difilter. */
    function site_list(string $path): array
    {
        return collect(explode(',', (string) site($path, '')))->map(fn ($v) => trim($v))->filter()->values()->all();
    }
}
