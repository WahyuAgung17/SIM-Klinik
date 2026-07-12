@extends('adminlte::page')

@section('title', 'Master Data Pasien')

@section('content_header')
<h1>Master Data Pasien</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
    {{ session('error') }}
</div>
@endif

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                Daftar Pasien
            </h3>

            <a href="{{ route('patient.patients.create') }}"
               class="btn btn-primary">

                <i class="fas fa-plus"></i>
                Tambah Pasien

            </a>

        </div>

    </div>

    <div class="card-body">

        <form action="{{ route('patient.patients.index') }}"
              method="GET">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Cari Nama / NIK / No RM">

                </div>

                <div class="col-md-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="fas fa-search"></i>

                        Cari

                    </button>

                    <a href="{{ route('patient.patients.index') }}"
                       class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

        <table class="table table-bordered table-hover">

            <thead class="thead-light">

            <tr>

                <th width="5%">No</th>
                <th>No RM</th>
                <th>NIK</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Status</th>
                <th width="15%">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($patients as $patient)

                <tr>

                    <td>

                        {{ $patients->firstItem() + $loop->index }}

                    </td>

                    <td>

                        {{ $patient->medical_record_number }}

                    </td>

                    <td>

                        {{ $patient->nik }}

                    </td>

                    <td>

                        {{ $patient->full_name }}

                    </td>

                    <td>

                        {{ $patient->gender }}

                    </td>

                    <td>

                        {{ $patient->phone }}

                    </td>

                    <td>

                        @if($patient->status == 'Aktif')

                            <span class="badge badge-success">

                                Aktif

                            </span>

                        @else

                            <span class="badge badge-danger">

                                Nonaktif

                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('patient.patients.show',$patient->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('patient.patients.edit',$patient->id) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8"
                        class="text-center text-muted">

                        <i class="fas fa-folder-open"></i>

                        Belum ada data pasien.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3 d-flex justify-content-end">

            {{ $patients->links() }}

        </div>

    </div>

</div>

@stop