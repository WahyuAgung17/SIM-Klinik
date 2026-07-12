@extends('adminlte::page')

@section('title','Detail Dokumen Pasien')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Detail Dokumen Pasien</h1>

    <a href="{{ route('patient.documents.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<div class="row">

    {{-- ========================= --}}
    {{-- DATA PASIEN --}}
    {{-- ========================= --}}

    <div class="col-md-5">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">

                    Data Pasien

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>

                        <th width="35%">No RM</th>

                        <td>{{ $document->patient->medical_record_number }}</td>

                    </tr>

                    <tr>

                        <th>Nama</th>

                        <td>{{ $document->patient->full_name }}</td>

                    </tr>

                    <tr>

                        <th>NIK</th>

                        <td>{{ $document->patient->nik }}</td>

                    </tr>

                    <tr>

                        <th>Jenis Kelamin</th>

                        <td>{{ $document->patient->gender }}</td>

                    </tr>

                    <tr>

                        <th>No HP</th>

                        <td>{{ $document->patient->phone }}</td>

                    </tr>

                    <tr>

                        <th>Alamat</th>

                        <td>{{ $document->patient->address }}</td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- ========================= --}}
    {{-- DATA DOKUMEN --}}
    {{-- ========================= --}}

    <div class="col-md-7">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">

                    Informasi Dokumen

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>

                        <th width="35%">Jenis Dokumen</th>

                        <td>{{ $document->document_type }}</td>

                    </tr>

                    <tr>

                        <th>Nama File</th>

                        <td>{{ $document->file_name }}</td>

                    </tr>

                    <tr>

                        <th>Tanggal Upload</th>

                        <td>{{ $document->created_at->format('d-m-Y H:i') }}</td>

                    </tr>

                    <tr>

                        <th>Lokasi File</th>

                        <td>

                            <small>{{ $document->file_path }}</small>

                        </td>

                    </tr>

                </table>

                <hr>

                <div class="text-center">

                    <a href="{{ asset('storage/'.$document->file_path) }}"
                       target="_blank"
                       class="btn btn-info">

                        <i class="fas fa-eye"></i>

                        Preview

                    </a>

                    <a href="{{ asset('storage/'.$document->file_path) }}"
                       download
                       class="btn btn-success">

                        <i class="fas fa-download"></i>

                        Download

                    </a>

                    <a href="{{ route('patient.documents.edit',$document->id) }}"
                       class="btn btn-warning">

                        <i class="fas fa-edit"></i>

                        Edit

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@stop