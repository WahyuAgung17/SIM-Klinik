@extends('layouts.app')

@section('title','Detail Kunjungan')
@section('breadcrumb','Pelayanan / Kunjungan / Detail')

@section('content')

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card">

            <div class="card-body">

                <div class="text-center mb-3">
                    <span class="text-mono fw-bold" style="font-size:18px;color:var(--pine);">
                        {{ $kunjungan->no_kunjungan }}
                    </span>
                    <div class="mt-2">
                        <x-ui.status-kunjungan-badge :status="$kunjungan->status_kunjungan"/>
                    </div>
                </div>

                <hr>

                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="40%">Pasien</td>
                        <td class="fw-semibold">{{ $kunjungan->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. RM</td>
                        <td class="text-mono">{{ $kunjungan->pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Poli</td>
                        <td>{{ $kunjungan->poli->nama_poli }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dokter</td>
                        <td>{{ $kunjungan->dokter->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td class="text-mono">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keluhan</td>
                        <td>{{ $kunjungan->keluhan ?: '—' }}</td>
                    </tr>
                </table>

                @if($kunjungan->status_kunjungan == 'terdaftar')

                    <div class="alert alert-warning py-2 mt-3 mb-2 small">
                        <i class="bi bi-info-circle"></i>
                        Pasien ini mendaftar mandiri lewat website. Lakukan check-in
                        setelah pasien datang ke klinik agar masuk antrian pemeriksaan.
                    </div>

                    <form action="{{ route('kunjungan.checkin',$kunjungan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i>
                            Check-in Pasien
                        </button>
                    </form>

                @endif

                @if($kunjungan->status_kunjungan == 'menunggu_pemeriksaan')

                    <a href="{{ route('pemeriksaan.create',$kunjungan) }}"
                       class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-heart-pulse"></i>
                        Mulai Pemeriksaan
                    </a>

                @endif

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header bg-white border-0">
                <h5 class="mb-0">Hasil Pemeriksaan</h5>
            </div>

            <div class="card-body">

                @if($kunjungan->pemeriksaan)

                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Diagnosa</label>
                        <p class="mb-0">{{ $kunjungan->pemeriksaan->diagnosa }}</p>
                    </div>

                    @if($kunjungan->pemeriksaan->catatan_pemeriksaan)
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Catatan</label>
                            <p class="mb-0">{{ $kunjungan->pemeriksaan->catatan_pemeriksaan }}</p>
                        </div>
                    @endif

                    @if($kunjungan->pemeriksaan->resep)
                        <div class="mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Resep</label>
                            <p class="mb-0">{{ $kunjungan->pemeriksaan->resep }}</p>
                        </div>
                    @endif

                    <label class="text-muted small text-uppercase fw-bold">Layanan & Tindakan</label>

                    <div class="table-responsive mt-2">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>Layanan</th>
                                <th width="100">Jumlah</th>
                                <th width="150">Harga</th>
                                <th width="150">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kunjungan->pemeriksaan->detailLayanan as $detail)
                                <tr>
                                    <td>{{ $detail->layanan->nama_layanan }}</td>
                                    <td class="text-mono">{{ $detail->jumlah }}</td>
                                    <td class="text-mono">Rp {{ number_format($detail->harga,0,',','.') }}</td>
                                    <td class="text-mono fw-semibold">Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Biaya</td>
                                <td class="text-mono fw-bold" style="color:var(--pine);">
                                    Rp {{ number_format($kunjungan->pemeriksaan->totalBiaya(),0,',','.') }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                @else

                    <x-ui.empty-state
                        title="Belum diperiksa"
                        subtitle="Pasien ini belum menjalani pemeriksaan dokter."
                    />

                @endif

            </div>

        </div>

    </div>

</div>

@endsection
