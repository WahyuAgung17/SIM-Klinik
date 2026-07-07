@extends('adminlte::page')

@section('title', 'Dashboard Integrasi')

@section('content_header')
    <h1>Dashboard Integrasi Akademik</h1>
@endsection

@section('css')
    <style>
        .dashboard-summary .info-box {
            min-height: 110px;
        }

        .dashboard-summary .info-box .info-box-text {
            white-space: normal;
        }

        .dashboard-table td,
        .dashboard-table th {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    @php
        $badgeClass = fn (bool $value) => $value ? 'badge badge-success' : 'badge badge-secondary';
        $statusLabel = fn (bool $value) => $value ? 'Aktif' : 'Tidak Aktif';
    @endphp

    @if (! $simpegAvailable)
        <div class="alert alert-warning">
            Data dashboard lokal tetap ditampilkan, tetapi koneksi ke <strong>SIMPEG</strong> sedang tidak tersedia sehingga statistik dosen bisa belum lengkap.
        </div>
    @endif

    <div class="row dashboard-summary">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Total Mahasiswa"
                :text="number_format($stats['totalMahasiswa'])"
                icon="fas fa-lg fa-graduation-cap"
                theme="info"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Mahasiswa Aktif"
                :text="number_format($stats['mahasiswaAktif'])"
                icon="fas fa-lg fa-user-check"
                theme="success"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Total Dosen SIMPEG"
                :text="number_format($stats['totalDosen'])"
                icon="fas fa-lg fa-chalkboard-teacher"
                theme="warning"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Total Mata Kuliah"
                :text="number_format($stats['totalMataKuliah'])"
                icon="fas fa-lg fa-book"
                theme="primary"
            />
        </div>
    </div>

    <div class="row dashboard-summary">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Relasi Dosen Wali"
                :text="number_format($stats['totalDosenWali'])"
                icon="fas fa-lg fa-user-tie"
                theme="teal"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Mahasiswa Belum Punya Wali"
                :text="number_format($stats['mahasiswaTanpaWali'])"
                icon="fas fa-lg fa-user-clock"
                theme="danger"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Mata Kuliah Aktif"
                :text="number_format($stats['mataKuliahAktif'])"
                icon="fas fa-lg fa-check-circle"
                theme="success"
            />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-adminlte-info-box
                title="Sudah Ada Pengampu"
                :text="number_format($stats['mataKuliahDenganPengampu'])"
                icon="fas fa-lg fa-link"
                theme="secondary"
            />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Mahasiswa Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ url('/mahasiswa') }}" class="btn btn-tool text-info">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped dashboard-table mb-0">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentMahasiswa as $item)
                                <tr>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <span class="{{ $badgeClass((bool) $item->status_keaktifan) }}">
                                            {{ $statusLabel((bool) $item->status_keaktifan) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Mata Kuliah Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ url('/mata-kuliah') }}" class="btn btn-tool text-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped dashboard-table mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>Pengampu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentMataKuliah as $item)
                                <tr>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->dosenPengampu?->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data mata kuliah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Relasi Dosen Wali Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ url('/dosen-wali-mahasiswa') }}" class="btn btn-tool text-success">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped dashboard-table mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Dosen Wali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentDosenWali as $item)
                                <tr>
                                    <td>{{ $item->mahasiswa?->nama ?? '-' }}</td>
                                    <td>{{ $item->dosenWali?->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada relasi dosen wali.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ringkasan Integrasi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p class="mb-2">
                        Dashboard ini sekarang mengambil data aktual dari modul <strong>Mahasiswa</strong>, <strong>Mata Kuliah</strong>,
                        dan <strong>Dosen Wali Mahasiswa</strong>, serta statistik dosen dari koneksi <strong>SIMPEG</strong>.
                    </p>
                    <p class="mb-0 text-muted">
                        Jika ada data baru ditambahkan dari menu terkait, angka pada dashboard akan ikut berubah setelah halaman direfresh.
                    </p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <a href="{{ url('/mahasiswa') }}" class="btn btn-outline-info btn-sm mb-2">
                        <i class="fas fa-user-graduate"></i> Kelola Mahasiswa
                    </a>
                    <a href="{{ url('/mata-kuliah') }}" class="btn btn-outline-primary btn-sm mb-2">
                        <i class="fas fa-book"></i> Kelola Mata Kuliah
                    </a>
                    <a href="{{ url('/dosen-wali-mahasiswa') }}" class="btn btn-outline-success btn-sm mb-2">
                        <i class="fas fa-user-tie"></i> Kelola Dosen Wali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
