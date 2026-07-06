@extends('layouts.app')

@section('title','Data Layanan')
@section('breadcrumb','Master Data / Layanan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <form method="GET" class="d-flex" style="max-width:360px;width:100%;">

        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari nama / kategori layanan..."
            value="{{ $search }}">

        <button class="btn btn-outline-primary flex-shrink-0">
            <i class="bi bi-search"></i>
        </button>

    </form>

    <a href="{{ route('layanan.create') }}"
       class="btn btn-primary flex-shrink-0 ms-3">

        <i class="bi bi-plus-circle"></i>

        Tambah Layanan

    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Poli</th>
                    <th>Harga</th>
                    <th width="120">Status</th>
                    <th width="90">Aksi</th>
                </tr>
                </thead>

                <tbody>

                @forelse($layanan as $item)

                    <tr>
                        <td class="text-mono">
                            {{ $loop->iteration + ($layanan->currentPage()-1)*$layanan->perPage() }}
                        </td>
                        <td class="fw-semibold">
                            {{ $item->nama_layanan }}
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $item->kategori }}</span>
                        </td>
                        <td class="text-muted">
                            {{ $item->poli->nama_poli }}
                        </td>
                        <td class="text-mono fw-semibold">
                            {{ $item->harga_format }}
                        </td>
                        <td>
                            <x-ui.status-badge :status="$item->status"/>
                        </td>
                        <td>
                            <a
                                href="{{ route('layanan.edit',$item) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <x-ui.empty-state
                                title="Belum ada data layanan"
                                subtitle="Silakan klik tombol Tambah Layanan."
                            />
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $layanan->links() }}
        </div>

    </div>

</div>

@endsection
