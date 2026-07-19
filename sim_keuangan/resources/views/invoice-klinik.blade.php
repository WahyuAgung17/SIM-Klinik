@extends('adminlte::page')

@section('title', 'Invoice Klinik')

@section('content_header')
    <h1>Invoice Klinik</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title font-weight-bold">Invoice #{{ $tagihan->id }}</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr><td width="40%"><strong>Nama Pasien</strong></td><td>{{ $tagihan->kunjungan->pasien->nama_pasien ?? '-' }}</td></tr>
                            <tr><td><strong>No. Rekam Medis</strong></td><td>{{ $tagihan->kunjungan->pasien->no_rm ?? '-' }}</td></tr>
                            <tr><td><strong>Tanggal Kunjungan</strong></td><td>{{ \Carbon\Carbon::parse($tagihan->created_at)->format('Y-m-d') }}</td></tr>
                            <tr><td><strong>Total Biaya</strong></td><td class="font-weight-bold">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td></tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td><span class="badge badge-success">Lunas</span></td>
                            </tr>
                            <tr><td><strong>ID Transaksi</strong></td><td>{{ $tagihan->midtrans_order_id ?? '-' }}</td></tr>
                            <tr><td><strong>Snap Token</strong></td><td>{{ $tagihan->snap_token ?? '-' }}</td></tr>
                            <tr><td><strong>Tanggal Pembayaran</strong></td><td>{{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('Y-m-d H:i') }}</td></tr>
                            <tr><td><strong>Dibuat Pada</strong></td><td>{{ \Carbon\Carbon::parse($tagihan->created_at)->format('d-m-Y H:i') }}</td></tr>
                            <tr>
                                <td class="align-middle"><strong>QR Code Bukti Pembayaran</strong></td>
                                <td>
                                    <div class="mt-2 mb-2">
                                        {!! QrCode::size(120)->generate(url('/cetak-invoice/'.$tagihan->id)) !!}
                                    </div>
                                    <small class="text-muted">Scan untuk memverifikasi keaslian dokumen PDF.</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('/cetak-invoice/'.$tagihan->id) }}" target="_blank" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                    <a href="{{ url('/detailtagihan/'.$tagihan->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection