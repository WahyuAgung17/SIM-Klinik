@extends('layouts.app')

@section('title','Data Poli')
@section('breadcrumb','Master Data / Poli')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <form method="GET" class="d-flex" style="max-width:360px;width:100%;">

        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari nama poli..."
            value="{{ $search }}">

        <button class="btn btn-outline-primary flex-shrink-0">
            <i class="bi bi-search"></i>
        </button>

    </form>

    <a href="{{ route('poli.create') }}"
       class="btn btn-primary flex-shrink-0 ms-3">

        <i class="bi bi-plus-circle"></i>

        Tambah Poli

    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Poli</th>
                    <th>Deskripsi</th>
                    <th width="120">Status</th>
                    <th width="90">Aksi</th>
                </tr>
                </thead>

                <tbody>

                @forelse($poli as $item)

                    <tr>
                        <td class="text-mono">
                            {{ $loop->iteration + ($poli->currentPage()-1)*$poli->perPage() }}
                        </td>
                        <td class="fw-semibold">
                            {{ $item->nama_poli }}
                        </td>
                        <td class="text-muted">
                            {{ $item->deskripsi ?: '—' }}
                        </td>
                        <td>
                            <x-ui.status-badge :status="$item->status"/>
                        </td>
                        <td>
                            <a href="{{ route('poli.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">
                            <x-ui.empty-state
                                title="Belum ada data poli"
                                subtitle="Klik tombol Tambah Poli untuk mulai menambahkan."
                            />
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $poli->links() }}
        </div>

    </div>

</div>

@endsection
