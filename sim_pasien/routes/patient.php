<?php
// routes/patient.php — VERSI LENGKAP SETELAH FIX
// Tambahan: route AJAX dokter-per-poli, route settings

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\DashboardController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\VisitController;
use App\Http\Controllers\Patient\VisitHistoryController;
use App\Http\Controllers\Patient\PatientDocumentController;
use App\Http\Controllers\Patient\PatientControlController;
use App\Http\Controllers\Patient\SettingController;

Route::prefix('patient')
    ->name('patient.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Data Pasien
        Route::resource('patients', PatientController::class);

        // Registrasi / Kunjungan
        Route::resource('visits', VisitController::class);

        // FIX: AJAX route — dokter berdasarkan poli
        Route::get('/visits/doctors-by-poly', [VisitController::class, 'getDoctorsByPoly'])
            ->name('visits.doctors-by-poly');

        // Riwayat Kunjungan
        Route::get('/visit-history',         [VisitHistoryController::class, 'index'])
            ->name('visit-history.index');
        Route::get('/visit-history/{visit}', [VisitHistoryController::class, 'show'])
            ->name('visit-history.show');

        // Dokumen Pasien
        Route::resource('documents', PatientDocumentController::class)->except('destroy');
        Route::get('/documents/{document}/preview',
            [PatientDocumentController::class, 'preview'])->name('documents.preview');
        Route::get('/documents/{document}/download',
            [PatientDocumentController::class, 'download'])->name('documents.download');

        // Kontrol Pasien
        Route::resource('controls', PatientControlController::class)->except('destroy');
        Route::patch('/controls/{control}/status',
            [PatientControlController::class, 'updateStatus'])->name('controls.status');

        // FIX: Pengaturan
        Route::get('/settings',         [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings',        [SettingController::class, 'update'])->name('settings.update');
    });
