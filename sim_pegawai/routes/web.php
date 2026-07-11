<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalDokterController;

Route::get('/', function () {
    return redirect('/login');
});

// Route Login Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ROUTE WAJIB LOGIN
Route::middleware(['auth'])->group(function () {
    // AKSES UMUM
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

    // AKSES KHUSUS ADMIN
    Route::middleware(['can:admin'])->group(function () {
        
        // Modul Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index']);
        Route::post('/pegawai', [PegawaiController::class, 'store']);
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update']);
        
        // Modul Poli
        Route::get('/poli', [PoliController::class, 'index']);
        Route::post('/poli', [PoliController::class, 'store']);
        Route::put('/poli/{id}', [PoliController::class, 'update']);

        // Modul Dokter
        Route::get('/dokter', [DokterController::class, 'index']);
        Route::post('/dokter', [DokterController::class, 'store']);
        Route::put('/dokter/{id}', [DokterController::class, 'update']);

        // Modul Jadwal Dokter
        Route::get('/jadwal', [JadwalDokterController::class, 'index']);
        Route::post('/jadwal', [JadwalDokterController::class, 'store']);
        Route::put('/jadwal/{id}', [JadwalDokterController::class, 'update']);

        // Modul Manajemen User
        Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
        Route::post('/user', [App\Http\Controllers\UserController::class, 'store']);
        Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update']);
    });

    // AKSES KHUSUS DOKTER
    Route::middleware(['can:dokter'])->group(function () {
        // Route::get('/pemeriksaan', [PemeriksaanController::class, 'index']);
    });

    // AKSES KHUSUS KASIR
    Route::middleware(['can:kasir'])->group(function () {
        // Route::get('/pembayaran', [PembayaranController::class, 'index']);
    });

});