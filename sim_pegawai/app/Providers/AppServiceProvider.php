<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        // hak akses
        Gate::define('admin', fn(User $user) => $user->role === 'Admin');
        Gate::define('petugas', fn(User $user) => $user->role === 'Petugas Pendaftaran');
        Gate::define('dokter', fn(User $user) => $user->role === 'Dokter');
        Gate::define('kasir', fn(User $user) => $user->role === 'Kasir');
        Gate::define('kepala', fn(User $user) => $user->role === 'Kepala Klinik');
    }
}