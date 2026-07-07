@extends('adminlte::page')

@section('title', 'Invoice Klinik')

@section('content_header')
<h1>Invoice Klinik</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-8 offset-md-2">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">
                    Invoice #{{ $tagihan->id }}
                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="250">Nama Pasien</th>
                        <td>{{ $tagihan->mahasiswa?->nama ?? '-' }}</td>
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
                        <th>Status</th>
                        <td>

                            @if($tagihan->status_bayar == 'Lunas')
                                <span class="badge badge-success">
                                    {{ $tagihan->status_bayar }}
                                </span>
                            @elseif($tagihan->status_bayar == 'Pending')
                                <span class="badge badge-warning">
                                    {{ $tagihan->status_bayar }}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    {{ $tagihan->status_bayar }}
                                </span>
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>ID Transaksi</th>
                        <td>{{ $tagihan->order_id ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Snap Token</th>
                        <td style="word-break: break-all;">
                            {{ $tagihan->snap_token ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal Pembayaran</th>
                        <td>
                            {{ $tagihan->paid_at ? $tagihan->paid_at->format('d-m-Y H:i') : '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Dibuat Pada</th>
                        <td>
                            {{ $tagihan->created_at->format('d-m-Y H:i') }}
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

                <a href="{{ route('tagihan.cetak', $tagihan->id) }}"
                   class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i>
                    Cetak PDF
                </a>

            </div>

        </div>

    </div>

</div>

@stop