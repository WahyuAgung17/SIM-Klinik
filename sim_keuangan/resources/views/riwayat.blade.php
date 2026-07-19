@extends('adminlte::page')

@section('title', 'Riwayat Transaksi Lunas')

@section('content_header')
    <h1>Riwayat Transaksi Lunas Klinik</h1>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <style>.action-buttons { white-space: nowrap; }</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3 class="card-title">Arsip Pembayaran Pasien (Lunas)</h3>
        </div>

        <div class="card-body table-responsive">
            <table id="tableRiwayat" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. Tagihan</th>
                        <th>Nama Pasien</th>
                        <th>No. Rekam Medis</th>
                        <th>Tanggal Lunas</th>
                        <th>Metode</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listTagihan as $item)
                        <tr>
                            <td>{{ $item->no_tagihan }}</td>
                            <td>{{ $item->kunjungan->pasien->nama_pasien ?? '-' }}</td>
                            <td>{{ $item->kunjungan->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y H:i') : '-' }}</td>
                            <td><span class="badge badge-info">{{ $item->metode_pembayaran ?? 'Midtrans' }}</span></td>
                            <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                            <td class="action-buttons text-center">
                                <a href="{{ url('/detailtagihan/'.$item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tableRiwayat').DataTable({
                responsive: true,
                language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' }
            });
        });
    </script>
@endsection