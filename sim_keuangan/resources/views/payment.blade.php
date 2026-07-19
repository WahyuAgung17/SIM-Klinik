@extends('adminlte::page')

@section('title', 'Manajemen Pembayaran Klinik')

@section('content_header')
    <h1>Manajemen Pembayaran Klinik</h1>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css">
    <style>
        .action-buttons { white-space: nowrap; }
        .modal .invalid-feedback { display: block; }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi Pasien</h3>
            <div class="card-tools">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTagihan">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
                <button type="button" class="btn btn-default btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card-body table-responsive">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan validasi.</strong>
                    <ul class="mb-0 mt-2 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table id="tableTagihan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. Tagihan</th>
                        <th>Nama Pasien</th>
                        <th>No. Rekam Medis</th>
                        <th>Tanggal Tagihan</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listTagihan as $item)
                        <tr>
                            <td>{{ $item->no_tagihan }}</td>
                            <td>{{ $item->kunjungan->pasien->nama_pasien ?? 'Pasien Tidak Ditemukan' }}</td>
                            <td>{{ $item->kunjungan->pasien->no_rm ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_tagihan)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status_pembayaran == 'Berhasil Dibayar')
                                    <span class="badge badge-success">{{ $item->status_pembayaran }}</span>
                                @elseif($item->status_pembayaran == 'Menunggu Pembayaran')
                                    <span class="badge badge-warning">{{ $item->status_pembayaran }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $item->status_pembayaran }}</span>
                                @endif
                            </td>
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

    {{-- TAMBAH TRANSAKSI --}}
    <div class="modal fade" id="modalTagihan" tabindex="-1" role="dialog" aria-labelledby="modalTagihanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ url('/simpantagihan') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTagihanLabel">Buat Tagihan Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="kunjungan_id">Data Kunjungan / Pasien</label>
                                <select name="kunjungan_id" id="kunjungan_id" class="form-control" required>
                                    <option value="">-- Pilih Pasien yang Selesai Diperiksa --</option>
                                    @foreach ($dataKunjungan as $kjn)
                                        <option value="{{ $kjn->id }}">
                                            Kunjungan #{{ $kjn->id }} - {{ $kjn->pasien->nama_pasien ?? 'Nama Pasien' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="amount">Total Tagihan (Rp)</label>
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Buat Tagihan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#tableTagihan').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                },
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: true
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: "{{ session('info') }}",
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                });
            @endif

            @if ($errors->any())
                $('#modalTagihan').modal('show');
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Silakan periksa kembali form input Anda.',
                });
            @endif
        });
    </script>
@endsection