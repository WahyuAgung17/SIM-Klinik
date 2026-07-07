@extends('adminlte::page')

@section('title', 'Data Dosen')

@section('content_header')
    <h1>Manajemen Dosen (SIAKAD)</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Dosen</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-default btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="tableDosen" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $unitKerjaOptions[(int) $item->unit_kerja] ?? '-' }}</td>
                            <td>{{ $item->jenis_pegawai }}</td>
                            <td>
                                @if ($item->status_kepegawaian === 'Tetap')
                                    <span class="badge badge-success">Tetap</span>
                                @else
                                    <span class="badge badge-danger">Kontrak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#tableDosen').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
            },
        });
    </script>
@endsection
