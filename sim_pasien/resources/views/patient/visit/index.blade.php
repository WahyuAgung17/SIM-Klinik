@extends('adminlte::page')

@section('title', 'Registrasi Pasien')

@section('content_header')
<h1>Registrasi Pasien</h1>
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
                Daftar Registrasi Pasien
            </h3>

            <a href="{{ route('patient.visits.create') }}"
               class="btn btn-primary">

                <i class="fas fa-plus"></i>
                Registrasi Baru

            </a>

        </div>

    </div>

    <div class="card-body">

        <form action="{{ route('patient.visits.index') }}"
              method="GET">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari No Kunjungan / No RM / Nama Pasien">

                </div>

                <div class="col-md-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="fas fa-search"></i>
                        Cari

                    </button>

                    <a href="{{ route('patient.visits.index') }}"
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
                <th>No Kunjungan</th>
                <th>Antrian</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th width="15%">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @forelse($visits as $visit)

                <tr>

                    <td>
                        {{ $visits->firstItem() + $loop->index }}
                    </td>

                    <td>
                        {{ $visit->visit_number }}
                    </td>

                    <td>
                        {{ $visit->queue_number }}
                    </td>

                    <td>
                        {{ $visit->patient->medical_record_number }}
                    </td>

                    <td>
                        {{ $visit->patient->full_name }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}
                    </td>

                    <td>

                        @if($visit->payment_type=='Umum')

                            <span class="badge badge-primary">
                                Umum
                            </span>

                        @elseif($visit->payment_type=='BPJS')

                            <span class="badge badge-success">
                                BPJS
                            </span>

                        @else

                            <span class="badge badge-info">
                                Asuransi
                            </span>

                        @endif

                    </td>

                    <td>

                        @switch($visit->status)

                            @case('Terdaftar')
                                <span class="badge badge-primary">
                                    Terdaftar
                                </span>
                            @break

                            @case('Menunggu Pemeriksaan')
                                <span class="badge badge-warning">
                                    Menunggu Pemeriksaan
                                </span>
                            @break

                            @case('Sedang Diperiksa')
                                <span class="badge badge-info">
                                    Sedang Diperiksa
                                </span>
                            @break

                            @case('Selesai')
                                <span class="badge badge-success">
                                    Selesai
                                </span>
                            @break

                            @default
                                <span class="badge badge-secondary">
                                    {{ $visit->status }}
                                </span>

                        @endswitch

                    </td>

                    <td>

                        <a href="{{ route('patient.visits.show',$visit->id) }}"
                           class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('patient.visits.edit',$visit->id) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10"
                        class="text-center text-muted">

                        <i class="fas fa-folder-open"></i>

                        Belum ada data registrasi pasien.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3 d-flex justify-content-end">

            {{ $visits->links() }}

        </div>

    </div>

</div>

@stop