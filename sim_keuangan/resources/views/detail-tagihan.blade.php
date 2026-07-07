@extends('adminlte::page')

@section('title', 'Detail Transaksi Pasien')

@section('content_header')
    <h1>Detail Transaksi Pasien</h1>
@stop

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            Informasi Transaksi Pasien
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Nama Pasien</th>
                <td>{{ $tagihan->mahasiswa->nama ?? '-' }}</td>
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
                    <strong>
                        Rp {{ number_format($tagihan->total_tagihan,0,',','.') }}
                    </strong>
                </td>
            </tr>

            <tr>
                <th>Status Pembayaran</th>
                <td>
                    <span class="badge {{ $tagihan->status_badge_class }}">
                        {{ $tagihan->status_bayar }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>ID Transaksi</th>
                <td>
                    {{ $tagihan->order_id ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Token Pembayaran</th>
                <td style="word-break:break-all">
                    {{ $tagihan->snap_token ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Pembayaran</th>
                <td>
                    {{ $tagihan->paid_at ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Dibuat</th>
                <td>
                    {{ $tagihan->created_at }}
                </td>
            </tr>

        </table>

    </div>

    <div class="card-footer">

        <a href="{{ route('tagihan.index') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

        <a href="{{ route('tagihan.invoice',$tagihan->id) }}"
           class="btn btn-success">

            <i class="fas fa-file-invoice"></i>
Lihat Invoice

        </a>

    </div>

</div>

@stop