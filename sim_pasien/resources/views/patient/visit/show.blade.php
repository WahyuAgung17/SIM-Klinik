@extends('adminlte::page')

@section('title','Detail Registrasi')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Detail Registrasi</h1>

    <a href="{{ route('patient.visits.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<div class="row">

    <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">

                    Data Pasien

                </h3>

            </div>

            <div class="card-body">

                <table class="table">

                    <tr>

                        <th>No RM</th>

                        <td>

                            {{ $visit->patient->medical_record_number }}

                        </td>

                    </tr>

                    <tr>

                        <th>Nama</th>

                        <td>

                            {{ $visit->patient->full_name }}

                        </td>

                    </tr>

                    <tr>

                        <th>NIK</th>

                        <td>

                            {{ $visit->patient->nik }}

                        </td>

                    </tr>

                    <tr>

                        <th>Jenis Kelamin</th>

                        <td>

                            {{ $visit->patient->gender }}

                        </td>

                    </tr>

                    <tr>

                        <th>No HP</th>

                        <td>

                            {{ $visit->patient->phone }}

                        </td>

                    </tr>

                    <tr>

                        <th>Alamat</th>

                        <td>

                            {{ $visit->patient->address }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">

                    Informasi Registrasi

                </h3>

            </div>

            <div class="card-body">

                <table class="table">

                    <tr>

                        <th>No Kunjungan</th>

                        <td>

                            {{ $visit->visit_number }}

                        </td>

                    </tr>

                    <tr>

                        <th>Antrian</th>

                        <td>

                            {{ $visit->queue_number }}

                        </td>

                    </tr>

                    <tr>

                        <th>Tanggal</th>

                        <td>

                            {{ $visit->visit_date->format('d-m-Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>Jam</th>

                        <td>

                            {{ $visit->visit_time }}

                        </td>

                    </tr>

                    <tr>

                        <th>Pembayaran</th>

                        <td>

                            {{ $visit->payment_type }}

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            <span class="badge badge-success">

                                {{ $visit->status }}

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>Keluhan</th>

                        <td>

                            {{ $visit->complaint }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@stop