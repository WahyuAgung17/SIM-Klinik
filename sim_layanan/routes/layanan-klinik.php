<?php

use App\Http\Controllers\PoliController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PesanMasukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Modul SIM Layanan Klinik
|--------------------------------------------------------------------------
| File ini di-include dari routes/web.php
*/

// Route publik (Company Profile) - tidak perlu login
// Catatan: halaman utama profil ('/') didaftarkan di routes/web.php,
// bukan di sini, supaya company profile bisa jadi halaman depan situs.
Route::prefix('profil')->name('profil.')->group(function () {

    // Pendaftaran berobat mandiri oleh pengunjung (publik, TANPA login).
    // Ini terpisah dari route resource `kunjungan` di bawah yang khusus
    // untuk petugas/admin di dashboard.
    Route::get('/daftar-berobat', [PendaftaranController::class, 'create'])
        ->name('pendaftaran.create');
    Route::post('/daftar-berobat', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');
    Route::get('/daftar-berobat/{kunjungan}/sukses', [PendaftaranController::class, 'sukses'])
        ->name('pendaftaran.sukses');

});

// Form Kontak di company profile (publik, TANPA login)
Route::post('/pesan-masuk', [PesanMasukController::class, 'store'])
    ->name('pesan-masuk.store');

// Route yang butuh login
//Route::middleware(['auth'])->group(function () {

    // Master data - Poli & Layanan (biasanya diakses Admin)
    Route::resource('poli', PoliController::class)
        ->except(['show', 'destroy']);
    Route::resource('layanan', LayananController::class);

    // Pendaftaran Kunjungan (Petugas Pendaftaran)
    Route::resource('kunjungan', KunjunganController::class)->only([
        'index', 'create', 'store', 'show',
    ]);

    // Pemeriksaan (Dokter)
    Route::prefix('pemeriksaan')->name('pemeriksaan.')->group(function () {
        Route::get('/', [PemeriksaanController::class, 'index'])->name('index');
        Route::get('/{kunjungan}', [PemeriksaanController::class, 'create'])->name('create');
        Route::post('/{kunjungan}', [PemeriksaanController::class, 'store'])->name('store');
    });

    // Pesan Masuk dari form Kontak (Admin)
    Route::get('/pesan-masuk', [PesanMasukController::class, 'index'])->name('pesan-masuk.index');
    Route::get('/pesan-masuk/{pesanMasuk}', [PesanMasukController::class, 'show'])->name('pesan-masuk.show');
    Route::delete('/pesan-masuk/{pesanMasuk}', [PesanMasukController::class, 'destroy'])->name('pesan-masuk.destroy');

//});
