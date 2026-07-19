<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran - {{ $tagihan->no_tagihan }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; }
        .header-klinik { border-bottom: 3px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .lunas-stamp { color: #28a745; border: 3px solid #28a745; display: inline-block; padding: 5px 20px; font-size: 24px; font-weight: bold; text-transform: uppercase; transform: rotate(-10deg); margin-top: 10px; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="invoice-box">
    <div class="header-klinik text-center">
        <h2><strong>KLINIK SEHAT BERSAMA</strong></h2>
        <p class="mb-0">Jl. Pahlawan No. 123, Kota Surakarta, Jawa Tengah</p>
        <p class="mb-0">Telp: (0271) 123456 | Email: info@kliniksehat.com</p>
    </div>

    <div class="row mb-4">
        <div class="col-sm-12 text-center">
            <h4 class="mb-0"><strong>KUITANSI PEMBAYARAN</strong></h4>
            <p class="text-muted">No. {{ $tagihan->no_tagihan }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-sm-6">
            <table class="table-borderless table-sm">
                <tr><td width="120">Nama Pasien</td><td>: <strong>{{ $tagihan->kunjungan->pasien->nama_pasien ?? 'Pasien Tidak Ditemukan' }}</strong></td></tr>
                <tr><td>No. Rekam Medis</td><td>: {{ $tagihan->kunjungan->pasien->no_rm ?? '-' }}</td></tr>
                <tr><td>ID Kunjungan</td><td>: KJN-{{ $tagihan->kunjungan_id }}</td></tr>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table-borderless table-sm float-right">
                <tr><td width="140">Tanggal Tagihan</td><td>: {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->format('d/m/Y') }}</td></tr>
                <tr><td>Tanggal Lunas</td><td>: {{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d/m/Y H:i') : '-' }}</td></tr>
                <tr><td>Metode</td><td>: {{ $tagihan->metode_pembayaran ?? 'Midtrans Payment Gateway' }}</td></tr>
            </table>
        </div>
    </div>

    <table class="table table-bordered mb-4">
        <thead class="thead-light">
            <tr>
                <th class="text-center" width="50">No</th>
                <th>Deskripsi Layanan / Tindakan Medis</th>
                <th class="text-right" width="200">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Biaya Registrasi, Pemeriksaan Dokter, & Tindakan Klinik</td>
                <td class="text-right">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">TOTAL KESELURUHAN:</th>
                <th class="text-right">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5">
        <div class="col-sm-6 text-center">
            @if($tagihan->status_pembayaran == 'Berhasil Dibayar')
                <div class="lunas-stamp">LUNAS</div>
            @endif
        </div>
        <div class="col-sm-6 text-center">
            <p>Petugas Kasir,</p>
            <br><br><br>
            <p><strong>( ______________________ )</strong></p>
        </div>
    </div>

    <div class="text-center mt-5 btn-print">
        <button class="btn btn-primary" onclick="window.print()">Cetak Ulang Dokumen</button>
        <button class="btn btn-secondary" onclick="window.close()">Tutup Halaman</button>
    </div>
</div>

</body>
</html>