<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * Pengaman: tes memakai RefreshDatabase (migrate:fresh), jadi wajib berjalan di SQLite in-memory.
     * Jika config ter-cache (php artisan config:cache) di server, phpunit.xml diabaikan dan tes akan
     * mengosongkan database sungguhan — hentikan sebelum itu terjadi.
     */
    public function createApplication()
    {
        $app = parent::createApplication();

        $default = $app['config']->get('database.default');
        $database = $app['config']->get("database.connections.{$default}.database");

        if ($default !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException("Tes dihentikan: koneksi database \"{$default}\" ({$database}) bukan SQLite in-memory. Jalankan `php artisan config:clear` dulu; jangan menjalankan tes dengan config produksi.");
        }

        return $app;
    }
}
