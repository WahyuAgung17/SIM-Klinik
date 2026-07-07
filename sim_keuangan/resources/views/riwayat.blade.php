@extends('adminlte::page')

@section('title', 'Riwayat Transaksi Pasien')

@section('content_header')
    <h1>Riwayat Transaksi Pasien</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Data Transaksi Lunas
        </h3>

        <div class="card-tools">

            <a href="{{ route('tagihan.index') }}"
               class="btn btn-secondary btn-sm">

                <i class="fas fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <div class="card-body">

        <table id="tableRiwayat"
               class="table table-bordered table-striped">

            <thead>

            <tr>

                <th>No</th>

                <th>Nama Pasien</th>
<th>No. Rekam Medis</th>
<th>Tanggal Kunjungan</th>
<th>Total Biaya</th>
<th>Tanggal Pembayaran</th>

                <th>Lihat Invoice</th>

            </tr>

            </thead>

            <tbody>

            @foreach($listTagihan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->mahasiswa?->nama }}</td>

                    <td>{{ $item->nim }}</td>

                    <td>{{ $item->periode }}</td>

                    <td>

                        Rp {{ number_format($item->total_tagihan,0,',','.') }}

                    </td>

                    <td>

                        {{ $item->paid_at ?? '-' }}

                    </td>

                    <td>

                        <a href="{{ route('tagihan.invoice',$item->id) }}"
                           class="btn btn-success btn-sm">

                            <i class="fas fa-file-invoice"></i>

                            Lihat Invoice

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        <div class="mt-3">

            {{ $listTagihan->links() }}

        </div>

    </div>

</div>

@stop

@section('js')

<script>

$(function(){

    $('#tableRiwayat').DataTable({

        responsive:true,

        autoWidth:false,

        language:{

            url:'//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'

        }

    });

});

</script>

@stop