@extends('adminlte::page')

@section('title', 'Detail Pasien')

@section('content_header')
<h1>Detail Data Pasien</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between">

            <h3 class="card-title">

                Informasi Pasien

            </h3>

            <a href="{{ route('patient.patients.edit', $patient->id) }}"
               class="btn btn-warning">

                <i class="fas fa-edit"></i>

                Edit

            </a>

        </div>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 text-center">

                @if($patient->photo)

                    <img src="{{ asset('storage/'.$patient->photo) }}"
                         class="img-fluid img-thumbnail mb-3"
                         width="180">

                @else

                    <img src="{{ asset('images/default-user.png') }}"
                         class="img-fluid img-thumbnail mb-3"
                         width="180">

                @endif

            </div>

            <div class="col-md-9">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">No Rekam Medis</th>
                        <td>{{ $patient->medical_record_number }}</td>
                    </tr>

                    <tr>
                        <th>NIK</th>
                        <td>{{ $patient->nik }}</td>
                    </tr>

                    <tr>
                        <th>No KK</th>
                        <td>{{ $patient->family_card_number }}</td>
                    </tr>

                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $patient->full_name }}</td>
                    </tr>

                    <tr>
                        <th>Nama Panggilan</th>
                        <td>{{ $patient->nickname }}</td>
                    </tr>

                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $patient->gender }}</td>
                    </tr>

                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>
                            {{ $patient->birth_place }},
                            {{ optional($patient->birth_date)->format('d-m-Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th>Umur</th>
                        <td>{{ $patient->age }} Tahun</td>
                    </tr>

                    <tr>
                        <th>Golongan Darah</th>
                        <td>{{ $patient->blood_type }}</td>
                    </tr>

                    <tr>
                        <th>Agama</th>
                        <td>{{ $patient->religion }}</td>
                    </tr>

                    <tr>
                        <th>Status Pernikahan</th>
                        <td>{{ $patient->marital_status }}</td>
                    </tr>

                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $patient->occupation }}</td>
                    </tr>

                    <tr>
                        <th>No HP</th>
                        <td>{{ $patient->phone }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $patient->email }}</td>
                    </tr>

                    <tr>
                        <th>Alamat</th>
                        <td>{{ $patient->full_address }}</td>
                    </tr>

                    <tr>
                        <th>Jenis Asuransi</th>
                        <td>{{ $patient->insurance_type }}</td>
                    </tr>

                    <tr>
                        <th>No BPJS</th>
                        <td>{{ $patient->bpjs_number }}</td>
                    </tr>

                    <tr>
                        <th>No Asuransi</th>
                        <td>{{ $patient->insurance_number }}</td>
                    </tr>

                    <tr>
                        <th>Tekanan Darah</th>
                        <td>{{ $patient->blood_pressure }}</td>
                    </tr>

                    <tr>
                        <th>Alergi</th>
                        <td>{{ $patient->allergy }}</td>
                    </tr>

                    <tr>
                        <th>Catatan Medis</th>
                        <td>{{ $patient->medical_notes }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
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
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Riwayat Kunjungan Pasien

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

            <tr>

                <th>No</th>
                <th>No Kunjungan</th>
                <th>Tanggal</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Status</th>

            </tr>

            </thead>

            <tbody>

            @forelse($patient->visits as $visit)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $visit->visit_number }}</td>

                    <td>{{ $visit->visit_date }}</td>

                    <td>{{ optional($visit->doctor)->nama_dokter ?? '-' }}</td>

                    <td>{{ optional($visit->clinic)->nama_poli ?? '-' }}</td>

                    <td>{{ $visit->status }}</td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Belum ada riwayat kunjungan.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="text-right">

    <a href="{{ route('patient.patients.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>

        Kembali

    </a>

</div>

@stop