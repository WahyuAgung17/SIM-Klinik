@extends('adminlte::page')

@section('title', 'Tambah Pasien')

@section('content_header')
    <h1>Tambah Data Pasien</h1>
@stop

@section('content')

<form action="{{ route('patient.patients.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @include('patient.patients.form')

    <div class="card">
        <div class="card-footer text-right">

            <a href="{{ route('patient.patients.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

            <button type="submit"
                    class="btn btn-primary">

                Simpan Data

            </button>

        </div>
    </div>

</form>

@stop