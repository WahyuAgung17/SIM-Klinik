@extends('adminlte::page')

@section('title', 'Manajemen Pembayaran Klinik')

@section('content_header')
    <h1>Manajemen Pembayaran Klinik</h1>
@endsection

@section('css')
    <style>
        .action-buttons {
            white-space: nowrap;
        }

        .modal .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi Pasien</h3>
       <div class="card-tools">

    <a href="{{ route('tagihan.riwayat') }}"
       class="btn btn-success btn-sm">

        <i class="fas fa-history"></i>

        Riwayat Transaksi

    </a>

    <a href="#"
       class="btn btn-primary btn-sm"
       data-toggle="modal"
       data-target="#modalTagihan">

        <i class="fas fa-plus"></i>

        Tambah Transaksi

    </a>

    <button type="button"
            class="btn btn-default btn-sm"
            onclick="window.location.reload()">

        <i class="fas fa-sync"></i>

        Refresh

    </button>

</div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
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
    <th>Nama Pasien</th>
    <th>No. Rekam Medis</th>
    <th>Tanggal Kunjungan</th>
    <th>Total Biaya</th>
    <th>Status Pembayaran</th>
    <th>Aksi</th>
</tr>
</thead>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listTagihan as $item)
                        <tr>
                            <td>{{ $item->mahasiswa?->nama ?? 'Pasien Tidak Ditemukan' }}</td>
<td>{{ $item->mahasiswa?->nim ?? $item->nim }}</td>
                            <td>{{ $item->periode }}</td>
                            <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->status_badge_class }}">
                                    {{ $item->status_bayar }}
                                </span>
                            </td>
    <td class="action-buttons">

    {{-- Detail --}}
    <a href="{{ route('tagihan.detail', $item->id) }}"
       class="btn btn-xs btn-info"
       title="Detail">
        <i class="fas fa-eye"></i>
    </a>
    
<a href="{{ route('tagihan.edit', $item->id) }}"
   class="btn btn-xs btn-warning"
   title="Edit">
    <i class="fas fa-edit"></i>
</a>
    {{-- Bayar --}}
    @if ($item->status_bayar != 'Lunas')
        <form action="{{ route('tagihan.bayar', $item->id) }}"
              method="POST"
              class="d-inline">
            @csrf
            <button type="submit"
                    class="btn btn-xs btn-primary"
                    title="Bayar">
                <i class="fas fa-credit-card"></i>
            </button>
        </form>
    @else
        <button class="btn btn-xs btn-success"
                disabled
                title="Sudah Lunas">
            <i class="fas fa-check-circle"></i>
        </button>
    @endif

    {{-- Cek Status --}}
    @if ($item->order_id)
        <a href="{{ route('tagihan.cek-status', $item->id) }}"
           class="btn btn-xs btn-warning"
           title="Cek Status">
            <i class="fas fa-sync"></i>
        </a>
    @endif

    {{-- Invoice --}}
    @if ($item->status_bayar == 'Lunas')
    <a href="{{ route('tagihan.cetak', $item->id) }}"
       class="btn btn-xs btn-danger"
       target="_blank"
       title="Cetak PDF">
        <i class="fas fa-file-pdf"></i>
    </a>
@endif

<form action="{{ route('tagihan.destroy', $item->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Yakin ingin menghapus tagihan ini?')">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-xs btn-danger"
            title="Hapus">
        <i class="fas fa-trash"></i>
    </button>

</form>

</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTagihan" tabindex="-1" role="dialog" aria-labelledby="modalTagihanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('tagihan.simpan') }}">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTagihanLabel">Tambah Transaksi Pasien</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="student_id">Pasien</label>
                                <select
                                    name="student_id"
                                    id="student_id"
                                    class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}"
                                    required
                                >
                                    <option value="">Pilih pasien</option>
                                    @foreach ($data as $mhs)
                                        <option value="{{ $mhs->id }}" @selected((int) old('student_id') === (int) $mhs->id)>
                                            {{ $mhs->nim }} - {{ $mhs->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="semester">Tanggal Kunjungan</label>
                                <input
    type="date"
    name="semester"
    id="semester"
    class="form-control"
    required
>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Total Tagihan (Rp)</label>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    min="1000"
                                    step="1000"
                                    class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                    value="{{ old('amount') }}"
                                    required
                                >
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Transaksi
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    @if (session('snapToken') && $midtransClientKey)
        <script src="{{ config('midtrans.isProduction') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $midtransClientKey }}"></script>
    @endif

    <script>
        (function () {
            $('#tableTagihan').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                },
            });

            @if ($errors->any())
                $('#modalTagihan').modal('show');
            @endif

            const snapToken = @json(session('snapToken'));
            const checkStatusUrl = @json(session('paymentTagihanId') ? route('tagihan.cek-status', session('paymentTagihanId')) : null);

            function refreshPaymentStatus() {
                if (checkStatusUrl) {
                    window.location.href = checkStatusUrl;
                    return;
                }

                window.location.reload();
            }

            function notify(type, title, message, callback) {
                if (window.Swal) {
                    Swal.fire(title, message, type).then(callback || function () {});
                    return;
                }

                alert(`${title}\n${message}`);

                if (callback) {
                    callback();
                }
            }

            if (snapToken && window.snap) {
                window.snap.pay(snapToken, {
                    onSuccess: function () {
                        notify('success', 'Sukses', 'Pembayaran berhasil.', function () {
                            refreshPaymentStatus();
                        });
                    },
                    onPending: function () {
                        notify('info', 'Menunggu Pembayaran', 'Pembayaran masih diproses.', function () {
                            refreshPaymentStatus();
                        });
                    },
                    onError: function () {
                        notify('error', 'Gagal', 'Pembayaran gagal diproses.');
                    },
                    onClose: function () {
                        notify('warning', 'Dibatalkan', 'Popup pembayaran ditutup sebelum transaksi selesai.');
                    },
                });
            }
        })();
    </script>
@endsection
