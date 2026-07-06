@extends('layouts.app')

@section('title','Antrian Pemeriksaan')
@section('breadcrumb','Pelayanan / Pemeriksaan')

@section('content')

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
                    <th>Jam Daftar</th>
                    <th width="100">Aksi</th>
                </tr>
                </thead>

                <tbody>

                @forelse($kunjungan as $item)

                    <tr>
                        <td class="text-mono fw-semibold">
                            {{ $item->no_kunjungan }}
                        </td>
                        <td>{{ $item->pasien->nama }}</td>
                        <td>{{ $item->poli->nama_poli }}</td>
                        <td class="text-muted">{{ $item->dokter->nama }}</td>
                        <td class="text-mono text-muted">
                            {{ $item->tanggal_kunjungan->format('H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('pemeriksaan.create',$item) }}"
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-heart-pulse"></i>
                                Periksa
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            <x-ui.empty-state
                                title="Tidak ada antrian"
                                subtitle="Semua pasien sudah diperiksa. Kerja bagus!"
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
