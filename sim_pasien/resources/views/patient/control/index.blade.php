{{-- resources/views/patient/control/index.blade.php --}}
{{-- FIX: badge status baru (Sudah Datang / Terlewat), tampilkan dokter dan jam --}}

@extends('adminlte::page')
@section('title', 'Jadwal Kontrol')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Jadwal Kontrol Pasien</h1>
    <a href="{{ route('patient.controls.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jadwal
    </a>
</div>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari No RM / Nama"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="control_date" class="form-control"
                        value="{{ request('control_date') }}">
                </div>
                {{-- FIX: filter status dengan nilai baru --}}
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        @foreach(['Menunggu', 'Sudah Datang', 'Terlewat'] as $st)
                            <option value="{{ $st }}"
                                {{ request('status') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('patient.controls.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="50">No</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Dokter</th>          {{-- FIX: tambah kolom dokter --}}
                    <th>Tanggal Kontrol</th>
                    <th>Jam</th>             {{-- FIX: tambah kolom jam --}}
                    <th width="130">Status</th>
                    <th width="110">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($controls as $control)
                <tr>
                    <td>{{ $controls->firstItem() + $loop->index }}</td>
                    <td>{{ $control->patient->medical_record_number }}</td>
                    <td>{{ $control->patient->full_name }}</td>
                    <td>{{ $control->doctor->full_name ?? '-' }}</td>  {{-- FIX --}}
                    <td>{{ \Carbon\Carbon::parse($control->control_date)->format('d-m-Y') }}</td>
                    <td>
                        {{-- FIX: tampilkan jam jika ada --}}
                        {{ $control->control_time ? substr($control->control_time, 0, 5) : '-' }}
                    </td>
                    <td>
                        {{-- FIX: badge sesuai status baru --}}
                        @switch($control->status)
                            @case('Menunggu')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                                @break
                            @case('Sudah Datang')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Sudah Datang
                                </span>
                                @break
                            @case('Terlewat')
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Terlewat
                                </span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ $control->status }}</span>
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('patient.controls.show', $control->id) }}"
                            class="btn btn-info btn-sm" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('patient.controls.edit', $control->id) }}"
                            class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                        Belum ada jadwal kontrol.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $controls->links() }}
        </div>
    </div>
</div>

@stop
