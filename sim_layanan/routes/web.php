<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LoginController;

// Halaman publik
Route::get('/', [ProfilController::class, 'index'])
    ->name('profil.index');

// Login Admin
Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard Admin
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

require __DIR__.'/layanan-klinik.php';