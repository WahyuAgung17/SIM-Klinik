@extends('layouts.public')

@section('title', 'Daftar Berobat')

@section('content')
<section class="py-5" style="margin-top:2rem;">
    <div class="container" style="max-width:760px;">

        <div class="text-center mb-4">
            <span class="hero-badge mb-3">
                <i class="bi bi-calendar-check"></i>
                Pendaftaran Online
            </span>
            <h2 class="section-title mt-3">Daftar Berobat</h2>
            <span class="pulse-rule mx-auto"></span>
            <p class="text-muted mt-2">
                Isi formulir berikut untuk mendaftarkan kunjungan berobat Anda.
                Petugas kami akan memverifikasi pendaftaran Anda saat check-in di klinik.
            </p>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">

    <a href="{{ route('profil.index') }}#beranda"
       class="btn btn-outline-success rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>
        Kembali ke Beranda
    </a>

    <span class="text-muted">
        <i class="bi bi-calendar-check"></i>
        Form Pendaftaran Berobat
    </span>

</div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Mohon periksa kembali data Anda:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card soft-card">
            <div class="card-body p-4">
                <form action="{{ route('profil.pendaftaran.store') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold mb-3" style="color:var(--pine);">
                        <i class="bi bi-person-vcard me-1"></i> Data Diri
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" maxlength="20" class="form-control"
                                   value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan" required>
                            <small class="text-muted">Jika Anda pernah berobat di sini, gunakan NIK yang sama.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                   value="{{ old('tanggal_lahir') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="2" class="form-control" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3" style="color:var(--pine);">
                        <i class="bi bi-hospital me-1"></i> Detail Kunjungan
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Poli Tujuan <span class="text-danger">*</span></label>
                            <select name="poli_id" class="form-select" required>
                                <option value="">-- Pilih Poli --</option>
                                @foreach ($poli as $item)
                                    <option value="{{ $item->id }}" {{ (int) old('poli_id') === $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dokter <span class="text-danger">*</span></label>
                            <select name="dokter_id" class="form-select" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($dokter as $item)
                                    <option value="{{ $item->id }}" {{ (int) old('dokter_id') === $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} — {{ $item->spesialisasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Berobat <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kunjungan" class="form-control"
                                   min="{{ now()->toDateString() }}"
                                   value="{{ old('tanggal_kunjungan', now()->toDateString()) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keluhan (opsional)</label>
                            <textarea name="keluhan" rows="3" class="form-control"
                                      placeholder="Ceritakan keluhan Anda secara singkat">{{ old('keluhan') }}</textarea>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send-check me-1"></i> Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
