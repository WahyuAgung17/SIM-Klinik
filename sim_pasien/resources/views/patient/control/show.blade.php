{{-- resources/views/patient/control/show.blade.php --}}
{{-- FIX: tampilkan dokter, jam kontrol, dan badge status baru --}}

@extends('adminlte::page')
@section('title', 'Detail Kontrol')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Detail Jadwal Kontrol</h1>
    <div>
        <a href="{{ route('patient.controls.edit', $control->id) }}"
            class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('patient.controls.index') }}"
            class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">

    {{-- Data Pasien --}}
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> Data Pasien</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="40%" class="bg-light">No RM</th>
                        <td>{{ $control->patient->medical_record_number }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama Pasien</th>
                        <td>{{ $control->patient->full_name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">No HP</th>
                        <td>{{ $control->patient->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Alamat</th>
                        <td>{{ $control->patient->address ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Detail Jadwal --}}
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Detail Jadwal Kontrol</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    {{-- FIX: Dokter --}}
                    <tr>
                        <th width="40%" class="bg-light">Dokter</th>
                        <td>
                            @if($control->doctor)
                                {{ $control->doctor->full_name }}
                                @if($control->doctor->specialist)
                                    <br><small class="text-muted">{{ $control->doctor->specialist }}</small>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Kontrol</th>
                        <td>
                            {{ \Carbon\Carbon::parse($control->control_date)->format('d F Y') }}
                        </td>
                    </tr>
                    {{-- FIX: Jam Kontrol --}}
                    <tr>
                        <th class="bg-light">Jam Kontrol</th>
                        <td>
                            {{ $control->control_time
                                ? substr($control->control_time, 0, 5) . ' WIB'
                                : '<span class="text-muted">—</span>' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Status</th>
                        <td>
                            {{-- FIX: badge status baru --}}
                            @switch($control->status)
                                @case('Menunggu')
                                    <span class="badge badge-warning badge-lg">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>
                                    @break
                                @case('Sudah Datang')
                                    <span class="badge badge-success badge-lg">
                                        <i class="fas fa-check-circle"></i> Sudah Datang
                                    </span>
                                    @break
                                @case('Terlewat')
                                    <span class="badge badge-danger badge-lg">
                                        <i class="fas fa-times-circle"></i> Terlewat
                                    </span>
                                    @break
                                @default
                                    <span class="badge badge-secondary">{{ $control->status }}</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Kunjungan Terkait</th>
                        <td>{{ $control->visit->visit_number ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Catatan --}}
@if($control->notes)
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sticky-note"></i> Catatan Kontrol</h3>
    </div>
    <div class="card-body">
        {!! nl2br(e($control->notes)) !!}
    </div>
</div>
@endif

{{-- Update Status cepat --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sync-alt"></i> Update Status</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patient.controls.status', $control->id) }}" method="POST"
            class="d-inline">
            @csrf
            @method('PATCH')
            <div class="input-group" style="max-width: 400px;">
                <select name="status" class="form-control">
                    @foreach(['Menunggu', 'Sudah Datang', 'Terlewat'] as $st)
                        <option value="{{ $st }}"
                            {{ $control->status == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
