@extends('adminlte::page')

@section('title', 'Edit Registrasi')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Edit Registrasi</h1>

    <a href="{{ route('patient.visits.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop

@section('content')

<form action="{{ route('patient.visits.update',$visit->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    @include('patient.visit.form')

    <div class="card">

        <div class="card-footer text-right">

            <button type="submit"
                    class="btn btn-warning">

                <i class="fas fa-save"></i>

                Update Registrasi

            </button>

        </div>

    </div>

</form>

@stop