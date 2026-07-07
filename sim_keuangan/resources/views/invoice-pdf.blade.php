<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Klinik</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
            color:#333;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        h4{
            text-align:center;
            margin-top:0;
            color:#666;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
        }

        table th{
            background:#f2f2f2;
            width:35%;
            text-align:left;
        }

        .footer{
            margin-top:50px;
            text-align:right;
        }

        .status{
            font-weight:bold;
            color:green;
        }
    </style>
</head>

<body>

<h2>KLINIK SEHAT</h2>
<h4>Invoice Pembayaran Pasien</h4>

<table>

    <tr>
        <th>No Invoice</th>
        <td>TRX-{{ str_pad($tagihan->id,5,'0',STR_PAD_LEFT) }}</td>
    </tr>

    <tr>
        <th>Nama Pasien</th>
        <td>{{ $tagihan->mahasiswa?->nama }}</td>
    </tr>

    <tr>
        <th>No. Rekam Medis</th>
        <td>{{ $tagihan->nim }}</td>
    </tr>

    <tr>
        <th>Tanggal Kunjungan</th>
        <td>{{ $tagihan->periode }}</td>
    </tr>

    <tr>
        <th>Total Biaya</th>
        <td>
            Rp {{ number_format($tagihan->total_tagihan,0,',','.') }}
        </td>
    </tr>

    <tr>
        <th>Status</th>
        <td class="status">
            {{ $tagihan->status_bayar }}
        </td>
    </tr>

    <tr>
        <th>Tanggal Pembayaran</th>
        <td>
            {{ $tagihan->paid_at ?? '-' }}
        </td>
    </tr>

    <tr>
        <th>ID Transaksi</th>
        <td>
            {{ $tagihan->order_id }}
        </td>
    </tr>

</table>

<div class="footer">

    <p>
        Dicetak pada :
        {{ now()->format('d-m-Y H:i') }}
    </p>

</div>

</body>

</html>