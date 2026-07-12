{{-- resources/views/patient/setting/index.blade.php --}}
{{-- BARU: Halaman Pengaturan Modul Pasien --}}

@extends('adminlte::page')
@section('title', 'Pengaturan')

@section('content_header')
<h1>Pengaturan Modul Pasien</h1>
@stop

@section('content')

<form action="{{ route('patient.settings.update') }}" method="POST">
    @csrf

    {{-- ======================================================= --}}
    {{-- 1. PENGATURAN NOMOR REKAM MEDIS                          --}}
    {{-- ======================================================= --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card"></i> Nomor Rekam Medis
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Mode Nomor RM</label>
                        <select name="rm_mode" class="form-control" id="rm_mode"
                            onchange="toggleRmPrefix(this.value)">
                            <option value="manual"
                                {{ ($settings['rm_mode'] ?? 'manual') == 'manual' ? 'selected' : '' }}>
                                Manual (input bebas)
                            </option>
                            <option value="auto"
                                {{ ($settings['rm_mode'] ?? 'manual') == 'auto' ? 'selected' : '' }}>
                                Otomatis (prefix + urutan)
                            </option>
                        </select>
                        <small class="text-muted">
                            Otomatis: No RM di-generate sistem saat tambah pasien baru.
                        </small>
                    </div>
                </div>
                <div class="col-md-4" id="rm_prefix_group">
                    <div class="form-group">
                        <label>Prefix No RM</label>
                        <input type="text" name="rm_prefix" class="form-control"
                            value="{{ $settings['rm_prefix'] ?? 'RM' }}"
                            maxlength="10" placeholder="Contoh: RM">
                        <small class="text-muted">
                            Contoh: prefix "RM" → RM000001, RM000002 ...
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- 2. PENGATURAN KUNJUNGAN                                  --}}
    {{-- ======================================================= --}}
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-notes-medical"></i> Nomor Kunjungan
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Prefix Nomor Kunjungan</label>
                        <input type="text" name="visit_prefix" class="form-control"
                            value="{{ $settings['visit_prefix'] ?? 'VST' }}"
                            maxlength="10" placeholder="Contoh: VST">
                        <small class="text-muted">
                            Prefix + tanggal + urutan. Contoh: <strong>VST</strong>20260709<strong>0001</strong>
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Metode Pembayaran Default</label>
                        <select name="default_payment" class="form-control">
                            @foreach(['Umum', 'BPJS', 'Asuransi'] as $pay)
                                <option value="{{ $pay }}"
                                    {{ ($settings['default_payment'] ?? 'Umum') == $pay ? 'selected' : '' }}>
                                    {{ $pay }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- 3. TAMPILAN / UI                                         --}}
    {{-- ======================================================= --}}
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-desktop"></i> Tampilan
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Jumlah Data per Halaman</label>
                        <select name="per_page" class="form-control">
                            @foreach([5, 10, 15, 25, 50, 100] as $n)
                                <option value="{{ $n }}"
                                    {{ ($settings['per_page'] ?? 10) == $n ? 'selected' : '' }}>
                                    {{ $n }} data
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Berlaku untuk semua daftar di modul ini.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Format Tanggal</label>
                        <select name="date_format" class="form-control">
                            @php
                                $formats = [
                                    'd-m-Y' => '31-12-2026  (DD-MM-YYYY)',
                                    'Y-m-d' => '2026-12-31  (YYYY-MM-DD)',
                                    'm/d/Y' => '12/31/2026  (MM/DD/YYYY)',
                                ];
                            @endphp
                            @foreach($formats as $val => $label)
                                <option value="{{ $val }}"
                                    {{ ($settings['date_format'] ?? 'd-m-Y') == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- 4. INFORMASI KLINIK                                      --}}
    {{-- ======================================================= --}}
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-hospital"></i> Informasi Klinik
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Klinik</label>
                        <input type="text" name="hospital_name" class="form-control"
                            value="{{ $settings['hospital_name'] ?? '' }}"
                            placeholder="Nama klinik / puskesmas">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text" name="hospital_phone" class="form-control"
                            value="{{ $settings['hospital_phone'] ?? '' }}"
                            placeholder="0271-123456">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="hospital_email" class="form-control"
                            value="{{ $settings['hospital_email'] ?? '' }}"
                            placeholder="admin@klinik.id">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="hospital_address" class="form-control" rows="2"
                            placeholder="Alamat lengkap klinik">{{ $settings['hospital_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol simpan --}}
    <div class="card">
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </div>

</form>

@stop

@push('js')
<script>
function toggleRmPrefix(mode) {
    const group = document.getElementById('rm_prefix_group');
    group.style.display = (mode === 'auto') ? 'block' : 'none';
}
// init on load
toggleRmPrefix('{{ $settings["rm_mode"] ?? "manual" }}');
</script>
@endpush
