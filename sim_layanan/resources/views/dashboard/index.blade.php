@extends('layouts.app')

@section('title','Dashboard')
@section('breadcrumb','Home / Dashboard')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card bg-primary-soft border-0">
            <div class="card-body">
                <h6>Total Poli</h6>
                <h2>{{ $totalPoli }}</h2>
                <small>Data Master Poli</small>
                <i class="bi bi-hospital-fill icon"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card bg-success-soft border-0">
            <div class="card-body">
                <h6>Total Layanan</h6>
                <h2>{{ $totalLayanan }}</h2>
                <small>Data Layanan Klinik</small>
                <i class="bi bi-clipboard2-pulse-fill icon"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card bg-warning-soft border-0">
            <div class="card-body">
                <h6>Total Kunjungan</h6>
                <h2>{{ $totalKunjungan }}</h2>
                <small>Total Kunjungan</small>
                <i class="bi bi-people-fill icon"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card dashboard-card bg-danger-soft border-0">
            <div class="card-body">
                <h6>Total Pemeriksaan</h6>
                <h2>{{ $totalPemeriksaan }}</h2>
                <small>Total Pemeriksaan</small>
                <i class="bi bi-heart-pulse-fill icon"></i>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-lg-6">

        <div class="card card-dashboard">

            <div class="card-header bg-white border-0">
                <h5 class="mb-0">
                    <i class="bi bi-lightning-charge-fill" style="color:var(--amber);"></i>
                    Menu Cepat
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-6">
                        <a href="{{ route('poli.create') }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-hospital me-2"></i>
                            Tambah Poli
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('layanan.create') }}" class="btn btn-success w-100 py-3">
                            <i class="bi bi-clipboard2-pulse me-2"></i>
                            Tambah Layanan
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('kunjungan.create') }}" class="btn btn-warning w-100 py-3">
                            <i class="bi bi-person-plus me-2"></i>
                            Kunjungan Baru
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('profil.index') }}" class="btn btn-info w-100 py-3">
                            <i class="bi bi-globe me-2"></i>
                            Company Profile
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

    <div class="card card-dashboard">

        <div class="card-header bg-white border-0">
            <h5 class="mb-0">
                <i class="bi bi-clock-history" style="color:var(--pine);"></i>
                Aktivitas Terbaru
            </h5>
        </div>

        <div class="card-body">

            @forelse($activities as $activity)

                <div class="d-flex align-items-start mb-3">

                    <div class="me-3">

                        @switch($activity->module)

                            @case('Poli')
                                <i class="bi bi-hospital text-primary fs-4"></i>
                                @break

                            @case('Layanan')
                                <i class="bi bi-clipboard2-pulse text-success fs-4"></i>
                                @break

                            @case('Kunjungan')
                                <i class="bi bi-people text-warning fs-4"></i>
                                @break

                            @case('Pemeriksaan')
                                <i class="bi bi-heart-pulse text-danger fs-4"></i>
                                @break

                            @default
                                <i class="bi bi-info-circle fs-4"></i>

                        @endswitch

                    </div>

                    <div class="flex-grow-1">

                        <strong>{{ $activity->action }}</strong>

                        <div>{{ $activity->description }}</div>

                        <small class="text-muted">
                            {{ $activity->created_at->diffForHumans() }}
                        </small>

                    </div>

                </div>

                @if(!$loop->last)
                    <hr>
                @endif

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-inbox display-4 text-muted"></i>

                    <h5 class="mt-3">
                        Belum Ada Aktivitas
                    </h5>

                    <p class="text-muted mb-0">
                        Aktivitas terbaru akan muncul setelah data ditambahkan.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
