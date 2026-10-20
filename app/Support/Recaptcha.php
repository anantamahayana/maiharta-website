<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Recaptcha
{
    /**
     * Google reCAPTCHA v2 — hanya dicek bila kunci sudah diisi di .env.
     * Gagal → ValidationException dengan key "captcha".
     */
    public static function verify(Request $request): void
    {
        $secret = config('services.recaptcha.secret_key');

        if (! $secret) {
            return;
        }

        $passed = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => (string) $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ])->json('success') === true;

        if (! $passed) {
            throw ValidationException::withMessages(['captcha' => 'Silakan centang "Saya bukan robot" terlebih dahulu.']);
        }
    }
}
