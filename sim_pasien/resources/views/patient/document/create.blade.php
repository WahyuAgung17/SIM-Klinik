@extends('adminlte::page')

@section('title','Upload Dokumen Pasien')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Upload Dokumen Pasien</h1>

    <a href="{{ route('patient.documents.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<form action="{{ route('patient.documents.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @include('patient.document.form')

    <div class="card">

        <div class="card-footer text-right">

            <button class="btn btn-primary">

                <i class="fas fa-save"></i>

                Upload Dokumen

            </button>

        </div>

    </div>

</form>

@stop