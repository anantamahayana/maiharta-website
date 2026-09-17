<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/** Alur "Lupa kata sandi" admin: kirim tautan via email -> form sandi baru -> simpan. */
class PasswordResetController extends Controller
{
    public function request()
    {
        return view('admin.auth.forgot-password');
    }

    public function email(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        // Jangan bocorkan apakah email terdaftar: pesan sukses generik untuk semua kasus
        // kecuali throttle (terlalu sering meminta).
        if ($status === Password::RESET_THROTTLED) {
            return back()->withErrors(['email' => 'Tautan baru saja dikirim. Cek kotak masuk/spam, atau coba lagi beberapa menit lagi.']);
        }

        return back()->with('status', 'Jika email terdaftar, tautan reset sudah dikirim. Cek kotak masuk (dan folder spam).');
    }

    public function reset(Request $request, string $token)
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->query('email', '')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill(['password' => Hash::make($password), 'remember_token' => Str::random(60)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.')
            : back()->withInput($request->only('email'))->withErrors(['email' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Minta tautan baru.']);
    }
}
