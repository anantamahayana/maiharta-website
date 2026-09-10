<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.kontak');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            // honeypot field — real users never fill this in
            'website' => ['size:0'],
        ]);

        ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'message' => $validated['message'],
        ]);

        return back()->with('status', 'Pesan Anda telah terkirim. Tim kami akan merespons dalam 1x24 jam kerja.');
    }
}
