<?php

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
