@extends('adminlte::page')

@section('title', 'Registrasi Pasien')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Registrasi Pasien</h1>

    <a href="{{ route('patient.visits.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<form action="{{ route('patient.visits.store') }}"
      method="POST">

    @csrf

    @include('patient.visit.form')

    <div class="card">

        <div class="card-footer text-right">

            <button type="submit"
                    class="btn btn-primary">

                <i class="fas fa-save"></i>

                Simpan Registrasi

            </button>

        </div>

    </div>

</form>

@stop