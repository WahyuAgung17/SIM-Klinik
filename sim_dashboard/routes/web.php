<?php

use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\InformasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Bebas Akses / Tanpa Wajib Login)
|--------------------------------------------------------------------------
*/

// Halaman Dashboard (Bisa langsung diakses tanpa login)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Jika kamu butuh halaman utama "/" langsung mengarah ke dashboard
Route::get('/', [DashboardController::class, 'index']);