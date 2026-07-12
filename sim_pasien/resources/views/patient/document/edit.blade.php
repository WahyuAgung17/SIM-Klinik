@extends('adminlte::page')

@section('title','Edit Dokumen Pasien')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Edit Dokumen Pasien</h1>

    <a href="{{ route('patient.documents.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<form action="{{ route('patient.documents.update',$document->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('patient.document.form')

    <div class="card">

        <div class="card-footer text-right">

            <button class="btn btn-warning">

                <i class="fas fa-save"></i>

                Update Dokumen

            </button>

        </div>

    </div>

</form>

@stop