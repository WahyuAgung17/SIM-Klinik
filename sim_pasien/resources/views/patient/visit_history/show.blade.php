@extends('adminlte::page')

@section('title', 'Detail Riwayat Kunjungan')

@section('content_header')
<h1>Detail Riwayat Kunjungan</h1>
@stop

@section('content')

<div class="row">

    {{-- Data Pasien --}}
    <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Data Pasien</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">Nomor Rekam Medis</th>
                        <td>{{ $visit->patient->medical_record_number }}</td>
                    </tr>

                    <tr>
                        <th>Nama Pasien</th>
                        <td>{{ $visit->patient->full_name }}</td>
                    </tr>

                    <tr>
                        <th>NIK</th>
                        <td>{{ $visit->patient->nik }}</td>
                    </tr>

                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $visit->patient->gender }}</td>
                    </tr>

                    <tr>
                        <th>No. HP</th>
                        <td>{{ $visit->patient->phone }}</td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $visit->patient->address }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- Data Kunjungan --}}
    <div class="col-md-6">

        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Data Kunjungan</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">Nomor Kunjungan</th>
                        <td>{{ $visit->visit_number }}</td>
                    </tr>

                    <tr>
                        <th>Nomor Antrian</th>
                        <td>{{ $visit->queue_number }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <td>{{ $visit->visit_date->format('d-m-Y') }}</td>
                    </tr>

                    <tr>
                        <th>Jam Kunjungan</th>
                        <td>{{ substr($visit->visit_time,0,5) }}</td>
                    </tr>

                    <tr>
                        <th>Poli</th>
                        <td>{{ $visit->poly->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Dokter</th>
                        <td>{{ $visit->doctor->full_name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Pembayaran</th>
                        <td>{{ $visit->payment_type }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>

                        <td>

                            @switch($visit->status)

                                @case('Menunggu Pemeriksaan')

                                    <span class="badge badge-warning">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Sedang Diperiksa')

                                    <span class="badge badge-info">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Selesai')

                                    <span class="badge badge-success">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Batal')

                                    <span class="badge badge-danger">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @default

                                    <span class="badge badge-secondary">
                                        {{ $visit->status }}
                                    </span>

                            @endswitch

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="row">

    {{-- Keluhan --}}
    <div class="col-md-6">

        <div class="card card-warning">

            <div class="card-header">
                <h3 class="card-title">Keluhan Pasien</h3>
            </div>

            <div class="card-body">

                {!! $visit->complaint
                    ? nl2br(e($visit->complaint))
                    : '<i>Tidak ada keluhan.</i>' !!}

            </div>

        </div>

    </div>

    {{-- Diagnosa --}}
    <div class="col-md-6">

        <div class="card card-info">

            <div class="card-header">
                <h3 class="card-title">Diagnosa</h3>
            </div>

            <div class="card-body">

                {!! $visit->diagnosis
                    ? nl2br(e($visit->diagnosis))
                    : '<i>Belum ada diagnosa.</i>' !!}

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-footer">

        <a
            href="{{ route('patient.visit-history.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

    </div>

</div>

@stop