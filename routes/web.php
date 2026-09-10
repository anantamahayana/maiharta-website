<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [PageController::class, 'layananIndex'])->name('index');
    Route::get('/{service}', [PageController::class, 'layananShow'])->name('show');
});

Route::prefix('portofolio')->name('portofolio.')->group(function () {
    Route::get('/', [PageController::class, 'portofolioIndex'])->name('index');
    Route::get('/{project}', [PageController::class, 'portofolioShow'])->name('show');
});

Route::get('/sertifikasi', [PageController::class, 'sertifikasi'])->name('sertifikasi');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');

Route::get('/kontak', [ContactController::class, 'show'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');

/*
|--------------------------------------------------------------------------
| Panel Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'show'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', ProjectController::class)->except('show');
        Route::resource('services', ServiceController::class)->except('show');

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/toggle', [MessageController::class, 'toggle'])->name('messages.toggle');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [SettingsController::class, 'edit'])->name('settings');
        Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    });
});
