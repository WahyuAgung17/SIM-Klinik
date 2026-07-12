@extends('adminlte::page')

@section('title', 'Riwayat Kunjungan')

@section('content_header')
<h1>Riwayat Kunjungan Pasien</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <form method="GET" action="{{ route('patient.visit-history.index') }}">

            <div class="row">

                <div class="col-md-4">

                    <input
                        type="text"
                        name="patient"
                        class="form-control"
                        placeholder="Cari Nama Pasien"
                        value="{{ request('patient') }}"
                    >

                </div>

                <div class="col-md-3">

                    <input
                        type="date"
                        name="date"
                        class="form-control"
                        value="{{ request('date') }}"
                    >

                </div>

                <div class="col-md-3">

                    <select
                        name="poly_id"
                        class="form-control"
                    >

                        <option value="">-- Semua Poli --</option>

                        @foreach($polies as $poly)

                            <option
                                value="{{ $poly->id }}"
                                {{ request('poly_id') == $poly->id ? 'selected' : '' }}
                            >
                                {{ $poly->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary"
                        type="submit"
                    >
                        <i class="fas fa-search"></i>
                        Cari
                    </button>

                    <a
                        href="{{ route('patient.visit-history.index') }}"
                        class="btn btn-secondary"
                    >
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

                    <th width="50">No</th>
                    <th>Nomor Kunjungan</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Diagnosa</th>
                    <th width="90">Aksi</th>

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
                            {{ $visit->visit_date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $visit->patient->full_name }}
                        </td>

                        <td>
                            {{ $visit->poly->name ?? '-' }}
                        </td>

                        <td>
                            {{ $visit->doctor->full_name ?? '-' }}
                        </td>

                        <td>

                            @switch($visit->status)

                                @case('Menunggu Pemeriksaan')

                                    <span class="badge badge-warning">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Sedang Diperiksa')

                                    <span class="badge badge-info">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Selesai')

                                    <span class="badge badge-success">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @case('Batal')

                                    <span class="badge badge-danger">
                                        {{ $visit->status }}
                                    </span>

                                    @break

                                @default

                                    <span class="badge badge-secondary">
                                        {{ $visit->status }}
                                    </span>

                            @endswitch

                        </td>

                        <td>

                            {{ $visit->diagnosis ?? '-' }}

                        </td>

                        <td>

                            <a
                                href="{{ route('patient.visit-history.show',$visit->id) }}"
                                class="btn btn-info btn-sm"
                            >
                                <i class="fas fa-eye"></i>
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center">

                            Belum ada data riwayat kunjungan.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer clearfix">

        {{ $visits->links() }}

    </div>

</div>

@stop