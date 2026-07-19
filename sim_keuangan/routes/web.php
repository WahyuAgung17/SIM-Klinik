<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagihanController;

Route::get('/', [TagihanController::class, 'dashboard']);

// rute modul Keuangan Kasir
Route::get('/tagihan', [TagihanController::class, 'index']);
Route::post('/simpantagihan', [TagihanController::class, 'simpan']);
Route::post('/bayar/{id}', [TagihanController::class, 'bayar']);
Route::get('/cetak-invoice/{id}', [TagihanController::class, 'cetakInvoice']);

// rute cekstatus midtrans
Route::get('/cekstatus/{id}', [TagihanController::class, 'cekStatus']);

// Rute Midtrans
Route::post('/midtrans/callback', [TagihanController::class, 'callback']);

// Rute Dashboard
Route::get('/', [TagihanController::class, 'dashboard'])->name('dashboard');
Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
Route::post('/simpantagihan', [TagihanController::class, 'simpan']);
Route::post('/bayar/{id}', [TagihanController::class, 'bayar']);
Route::get('/cekstatus/{id}', [TagihanController::class, 'cekStatus']);
Route::get('/cetak-invoice/{id}', [TagihanController::class, 'cetakInvoice']);
Route::get('/detailtagihan/{id}', [TagihanController::class, 'detail']);
Route::get('/invoice/{id}', [TagihanController::class, 'lihatInvoice']);

// rute halaman Riwayat
Route::get('/riwayat', [TagihanController::class, 'riwayat'])->name('tagihan.riwayat');

