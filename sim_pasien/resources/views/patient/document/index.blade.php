@extends('adminlte::page')

@section('title', 'Dokumen Pasien')

@section('content_header')

<div class="d-flex justify-content-between">

    <h1>Dokumen Pasien</h1>

    <a href="{{ route('patient.documents.create') }}"
       class="btn btn-primary">

        <i class="fas fa-upload"></i>
        Upload Dokumen

    </a>

</div>

@stop

@section('content')

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>&times;</span>

    </button>

    {{ session('success') }}

</div>

@endif

<div class="card">

    <div class="card-header">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari No RM / Nama / NIK / Jenis Dokumen"
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-3">

                    <button class="btn btn-primary">

                        <i class="fas fa-search"></i>

                        Cari

                    </button>

                    <a href="{{ route('patient.documents.index') }}"
                       class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead class="thead-light">

            <tr>

                <th width="5%">No</th>

                <th>No RM</th>

                <th>Nama Pasien</th>

                <th>Jenis Dokumen</th>

                <th>Nama File</th>

                <th>Tanggal Upload</th>

                <th width="18%">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($documents as $document)

            <tr>

                <td>

                    {{ $documents->firstItem()+$loop->index }}

                </td>

                <td>

                    {{ $document->patient->medical_record_number }}

                </td>

                <td>

                    {{ $document->patient->full_name }}

                </td>

                <td>

                    <span class="badge badge-info">

                        {{ $document->document_type }}

                    </span>

                </td>

                <td>

                    {{ $document->file_name }}

                </td>

                <td>

                    {{ $document->created_at->format('d-m-Y H:i') }}

                </td>

                <td>

                    <a href="{{ route('patient.documents.show',$document->id) }}"
                       class="btn btn-info btn-sm">

                        <i class="fas fa-eye"></i>

                    </a>

                    <a href="{{ route('patient.documents.edit',$document->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fas fa-edit"></i>

                    </a>

                    <a href="{{ route('patient.documents.download',$document->id) }}"
                       class="btn btn-success btn-sm">

                        <i class="fas fa-download"></i>

                    </a>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7"
                    class="text-center text-muted">

                    <i class="fas fa-folder-open fa-2x mb-2"></i>

                    <br>

                    Belum ada dokumen pasien.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3 d-flex justify-content-end">

            {{ $documents->links() }}

        </div>

    </div>

</div>

@stop