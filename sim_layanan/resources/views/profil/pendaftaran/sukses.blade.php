@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<section class="py-5" style="margin-top:3rem;">
    <div class="container" style="max-width:640px;">

        <div class="card soft-card text-center">
            <div class="card-body p-5">
                <i class="bi bi-check-circle-fill" style="font-size:56px;color:var(--pine);"></i>
                <h3 class="fw-bold mt-3 mb-2">Pendaftaran Berhasil!</h3>
                <p class="text-muted">
                    Terima kasih, {{ $kunjungan->pasien->nama }}. Simpan nomor kunjungan Anda
                    dan tunjukkan saat check-in di loket pendaftaran klinik.
                </p>

                <div class="my-4 p-3 rounded" style="background:var(--pine-soft);">
                    <small class="text-muted d-block">Nomor Kunjungan</small>
                    <span class="fw-bold" style="font-size:24px;color:var(--pine);">
                        {{ $kunjungan->no_kunjungan }}
                    </span>
                </div>

                <div class="row text-start g-3 mb-4">
                    <div class="col-6">
                        <small class="text-muted d-block">Poli Tujuan</small>
                        <strong>{{ $kunjungan->poli->nama_poli }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Dokter</small>
                        <strong>{{ $kunjungan->dokter->nama }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Tanggal Berobat</small>
                        <strong>{{ $kunjungan->tanggal_kunjungan->translatedFormat('d F Y') }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status</small>
                        <strong>{{ $kunjungan->statusLabel() }}</strong>
                    </div>
                </div>

                <a href="{{ route('profil.index') }}" class="btn btn-primary">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
