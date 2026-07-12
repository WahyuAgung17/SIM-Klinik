@extends('adminlte::page')

@section('title','Edit Jadwal Kontrol')

@section('content_header')

<h1>Edit Jadwal Kontrol</h1>

@stop

@section('content')

<form action="{{ route('patient.controls.update',$control->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    @include('patient.control.form')

    <div class="card">

        <div class="card-footer text-right">

            <button class="btn btn-primary">

                Update

            </button>

        </div>

    </div>

</form>

@stop