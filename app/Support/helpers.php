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
