<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenWaliMahasiswaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get("/", [MahasiswaController::class, "index"]);

// =========================
// MAHASISWA
// =========================
Route::get("/mahasiswa", [MahasiswaController::class, "tampil"]);
Route::post("/mahasiswa/simpan", [MahasiswaController::class, "simpan"]);
Route::get("/mahasiswa/{id}", [MahasiswaController::class, "show"]);
Route::put("/mahasiswa/{id}", [MahasiswaController::class, "update"]);
Route::delete("/mahasiswa/hapus/{id}", [MahasiswaController::class, "hapus"]);

// =========================
// DOSEN
// =========================
Route::get("/dosen", [DosenController::class, "tampil"])
    ->name("dosen.tampil");

// =========================
// MATA KULIAH
// =========================
Route::get("/mata-kuliah", [MataKuliahController::class, "tampil"])
    ->name("mata-kuliah.tampil");
Route::post("/mata-kuliah/simpan", [MataKuliahController::class, "simpan"]);
Route::get("/mata-kuliah/{id}", [MataKuliahController::class, "show"]);
Route::put("/mata-kuliah/{id}", [MataKuliahController::class, "update"]);
Route::delete("/mata-kuliah/hapus/{id}", [MataKuliahController::class, "hapus"]);

// =========================
// DOSEN WALI
// =========================
Route::get("/dosen-wali-mahasiswa", [DosenWaliMahasiswaController::class, "tampil"])
    ->name("dosen-wali-mahasiswa.tampil");
Route::post("/dosen-wali-mahasiswa/simpan", [DosenWaliMahasiswaController::class, "simpan"]);
Route::get("/dosen-wali-mahasiswa/{id}", [DosenWaliMahasiswaController::class, "show"]);
Route::put("/dosen-wali-mahasiswa/{id}", [DosenWaliMahasiswaController::class, "update"]);
Route::delete("/dosen-wali-mahasiswa/hapus/{id}", [DosenWaliMahasiswaController::class, "hapus"]);

// =========================
// SIKEU (TAGIHAN & PEMBAYARAN)
// =========================
Route::get("/pay", [PaymentController::class, "tagihan"])
    ->name("tagihan.index");

Route::post("/simpantagihan", [PaymentController::class, "simpan"])
    ->name("tagihan.simpan");

Route::post("/bayartagihan/{id}", [PaymentController::class, "bayar"])
    ->name("tagihan.bayar");

Route::get("/pay/{bill}", [PaymentController::class, "pay"]);

Route::post("/midtrans/callback", [PaymentController::class, "callback"])
    ->name("midtrans.callback");

Route::get("/cekstatus/{id}", [PaymentController::class, "cekStatus"])
    ->name("tagihan.cek-status");

// ===== FITUR BARU =====

// Detail Tagihan
Route::get("/detailtagihan/{id}", [PaymentController::class, "detail"])
    ->name("tagihan.detail");

// Invoice
Route::get("/invoice/{id}", [PaymentController::class, "invoice"])
    ->name("tagihan.invoice");

// Cetak PDF
Route::get("/invoice/{id}/cetak", [PaymentController::class, "cetak"])
    ->name("tagihan.cetak");

// Edit Tagihan
Route::get("/edittagihan/{id}", [PaymentController::class, "edit"])
    ->name("tagihan.edit");

// Update Tagihan
Route::put("/updatetagihan/{id}", [PaymentController::class, "update"])
    ->name("tagihan.update");

// Hapus Tagihan
Route::delete("/hapustagihan/{id}", [PaymentController::class, "destroy"])
    ->name("tagihan.destroy");

// Riwayat Pembayaran
Route::get("/riwayat", [PaymentController::class, "riwayat"])
    ->name("tagihan.riwayat");
    