@extends('adminlte::page')
@section('content')

<div class="row">

    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>{{ $data['totalPatient'] }}</h3>

                <p>Total Pasien</p>

            </div>

            <div class="icon">

                <i class="fas fa-users"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>{{ $data['activePatient'] }}</h3>

                <p>Pasien Aktif</p>

            </div>

            <div class="icon">

                <i class="fas fa-user-check"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>{{ $data['todayVisit'] }}</h3>

                <p>Kunjungan Hari Ini</p>

            </div>

            <div class="icon">

                <i class="fas fa-notes-medical"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ $data['todayControl'] }}</h3>

                <p>Kontrol Hari Ini</p>

            </div>

            <div class="icon">

                <i class="fas fa-calendar-check"></i>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Pasien Terbaru

                </h3>

            </div>

            <div class="card-body p-0">

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th>No RM</th>

                            <th>Nama</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($data['latestPatients'] as $patient)

                        <tr>

                            <td>{{ $patient->medical_record_number }}</td>

                            <td>{{ $patient->full_name }}</td>

                            <td>

                                <span class="badge badge-success">

                                    {{ $patient->status }}

                                </span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Kunjungan Terbaru

                </h3>

            </div>

            <div class="card-body p-0">

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th>No Visit</th>

                            <th>Status</th>

                            <th>Tanggal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($data['latestVisits'] as $visit)

                        <tr>

                            <td>{{ $visit->visit_number }}</td>

                            <td>

                                {{ $visit->status }}

                            </td>

                            <td>

                                {{ $visit->visit_date }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection