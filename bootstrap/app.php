<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Di balik reverse proxy / tunnel (ngrok, load balancer) agar url() & asset() memakai https
        $middleware->trustProxies(at: '*');
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Logout dengan token CSRF basi (tab lama / sesi kedaluwarsa) tidak perlu 419 —
        // niatnya keluar, jadi keluarkan saja lalu arahkan ke form login.
        $exceptions->render(function (TokenMismatchException $e, $request) {
            if ($request->routeIs('admin.logout')) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->with('status', 'Anda telah keluar.');
            }
        });
    })->create();
