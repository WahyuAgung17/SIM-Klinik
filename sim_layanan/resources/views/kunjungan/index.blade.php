@extends('layouts.app')

@section('title','Data Kunjungan')
@section('breadcrumb','Pelayanan / Kunjungan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <form method="GET" class="d-flex" style="max-width:360px;width:100%;">

        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari no. kunjungan / nama pasien..."
            value="{{ $search }}">

        <button class="btn btn-outline-primary flex-shrink-0">
            <i class="bi bi-search"></i>
        </button>

    </form>

    <a href="{{ route('kunjungan.create') }}"
       class="btn btn-primary flex-shrink-0 ms-3">

        <i class="bi bi-person-plus"></i>

        Kunjungan Baru

    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                <tr>
                    <th>No. Kunjungan</th>
                    <th>Pasien</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th width="160">Status</th>
                    <th width="70">Aksi</th>
                </tr>
                </thead>

                <tbody>

                @forelse($kunjungan as $item)

                    <tr>
                        <td class="text-mono fw-semibold">
                            {{ $item->no_kunjungan }}
                        </td>
                        <td>
                            {{ $item->pasien->nama }}
                        </td>
                        <td>
                            {{ $item->poli->nama_poli }}
                        </td>
                        <td class="text-muted">
                            {{ $item->dokter->nama }}
                        </td>
                        <td class="text-mono text-muted">
                            {{ $item->tanggal_kunjungan->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <x-ui.status-kunjungan-badge :status="$item->status_kunjungan"/>
                        </td>
                        <td>
                            <a href="{{ route('kunjungan.show',$item) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <x-ui.empty-state
                                title="Belum ada data kunjungan"
                                subtitle="Klik tombol Kunjungan Baru untuk mendaftarkan pasien."
                            />
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $kunjungan->links() }}
        </div>

    </div>

</div>

@endsection
