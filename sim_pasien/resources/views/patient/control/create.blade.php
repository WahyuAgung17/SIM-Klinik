@extends('adminlte::page')

@section('title','Tambah Jadwal Kontrol')

@section('content_header')

<h1>Tambah Jadwal Kontrol</h1>

@stop

@section('content')

<form action="{{ route('patient.controls.store') }}"
      method="POST">

    @csrf

    @include('patient.control.form')

    <div class="card">

        <div class="card-footer text-right">

            <button class="btn btn-primary">

                <i class="fas fa-save"></i>

                Simpan

            </button>

        </div>

    </div>

</form>

@stop