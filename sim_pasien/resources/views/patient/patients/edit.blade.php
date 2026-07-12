@extends('adminlte::page')

@section('title', 'Edit Data Pasien')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Edit Data Pasien</h1>

    <a href="{{ route('patient.patients.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@stop

@section('content')

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">
            Form Edit Pasien
        </h3>
    </div>

    <form action="{{ route('patient.patients.update',$patient->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body">

            @include('patient.patients.form',[
                'patient'=>$patient
            ])

        </div>

        <div class="card-footer text-right">

            <a href="{{ route('patient.patients.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-times"></i>
                Batal

            </a>

            <button type="submit"
                    class="btn btn-warning">

                <i class="fas fa-save"></i>
                Update Data

            </button>

        </div>

    </form>

</div>

@stop