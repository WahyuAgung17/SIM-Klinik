@extends('adminlte::page')

@section('title', 'Detail Transaksi Pasien')

@section('content_header')
    <h1><i class="fas fa-file-invoice text-primary"></i> Detail Transaksi Pasien</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="card-title font-weight-bold">Informasi Pembayaran</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                        <tbody>
                            <tr><td width="30%"><strong>Nama Pasien</strong></td><td>{{ $tagihan->kunjungan->pasien->nama_pasien ?? '-' }}</td></tr>
                            <tr><td><strong>No. Rekam Medis</strong></td><td>{{ $tagihan->kunjungan->pasien->no_rm ?? '-' }}</td></tr>
                            <tr><td><strong>Tanggal Kunjungan</strong></td><td>{{ \Carbon\Carbon::parse($tagihan->created_at)->format('Y-m-d') }}</td></tr>
                            <tr><td><strong>Total Biaya</strong></td><td class="text-success font-weight-bold">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td></tr>
                            <tr>
                                <td><strong>Status Pembayaran</strong></td>
                                <td>
                                    @if($tagihan->status_pembayaran == 'Berhasil Dibayar')
                                        <span class="badge badge-success">{{ $tagihan->status_pembayaran }}</span>
                                    @elseif($tagihan->status_pembayaran == 'Menunggu Pembayaran')
                                        <span class="badge badge-warning">{{ $tagihan->status_pembayaran }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $tagihan->status_pembayaran }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td><strong>ID Transaksi</strong></td><td>{{ $tagihan->midtrans_order_id ?? '-' }}</td></tr>
                            <tr><td><strong>Snap Token</strong></td><td>{{ $tagihan->snap_token ?? '-' }}</td></tr>
                            <tr><td><strong>Tanggal Pembayaran</strong></td><td>{{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d-m-Y H:i') : '-' }}</td></tr>
                            <tr><td><strong>Dibuat Pada</strong></td><td>{{ \Carbon\Carbon::parse($tagihan->created_at)->format('d-m-Y H:i') }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title font-weight-bold">Ringkasan</h3>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-success font-weight-bold mb-4">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</h2>
                    <div class="text-left mb-4">
                        <strong>Status :</strong><br>
                        @if($tagihan->status_pembayaran == 'Berhasil Dibayar')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-secondary">Belum Lunas</span>
                        @endif
                    </div>

                    <div class="d-flex flex-column">
                        @if($tagihan->status_pembayaran != 'Berhasil Dibayar')
                            <form action="{{ url('/bayar/'.$tagihan->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-credit-card"></i> Bayar Sekarang</button>
                            </form>
                            @if($tagihan->midtrans_order_id)
                                <a href="{{ url('/cekstatus/'.$tagihan->id) }}" class="btn btn-warning btn-block mb-2"><i class="fas fa-sync"></i> Cek Status Pembayaran</a>
                            @endif
                        @else
                            <a href="{{ url('/invoice/'.$tagihan->id) }}" class="btn btn-success btn-block mb-2"><i class="fas fa-file-invoice"></i> Lihat Invoice</a>
                            <a href="{{ url('/cetak-invoice/'.$tagihan->id) }}" target="_blank" class="btn btn-danger btn-block mb-2"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                        @endif
                        
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
    <script>
        $(document).ready(function () {
            @if (session('success')) Swal.fire('Berhasil!', "{{ session('success') }}", 'success'); @endif
            @if (session('error')) Swal.fire('Oops...', "{{ session('error') }}", 'error'); @endif
            @if (session('info')) Swal.fire('Info', "{{ session('info') }}", 'info'); @endif

            const snapToken = "{{ session('snapToken') }}";
            if (snapToken && snapToken !== "") {
                window.snap.pay(snapToken, {
                    onSuccess: function (result) {
                        Swal.fire('Sukses!', 'Uang berhasil ditransfer. Silakan klik Cek Status.', 'success');
                    },
                    onPending: function (result) {
                        Swal.fire('Pending', 'Selesaikan pembayaran di simulator.', 'info');
                    },
                    onError: function (result) {
                        Swal.fire('Gagal', 'Transaksi dibatalkan Midtrans.', 'error');
                    },
                    onClose: function () {
                        Swal.fire('Batal', 'Anda menutup popup.', 'warning');
                    }
                });
            }
        });
    </script>
@endsection