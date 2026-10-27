<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Akun admin awal. Ganti kata sandi lewat Pengaturan setelah login pertama.
     */
    public function run(): void
    {
        // firstOrCreate: seeding ulang tidak mengembalikan kata sandi yang sudah diganti
        User::firstOrCreate(
            ['email' => 'admin@maiharta.com'],
            ['name' => 'Admin Maiharta', 'password' => Hash::make(env('ADMIN_PASSWORD', 'password'))],
        );
    }
}
