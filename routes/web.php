<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\ClickController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/api/clicks', [ClickController::class, 'store']);
    Route::get('/api/stats', [ClickController::class, 'stats']);
    Route::get('/pdf/download', [PdfController::class, 'download'])->name('pdf.download');
});

require __DIR__.'/settings.php';
