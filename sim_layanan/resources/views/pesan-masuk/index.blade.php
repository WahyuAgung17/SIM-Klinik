@extends('layouts.app')

@section('title','Pesan Masuk')
@section('breadcrumb','Website / Pesan Masuk')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <form method="GET" class="d-flex" style="max-width:360px;width:100%;">

        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="Cari nama / subjek..."
            value="{{ $search }}">

        <button class="btn btn-outline-primary flex-shrink-0">
            <i class="bi bi-search"></i>
        </button>

    </form>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Subjek</th>
                    <th width="160">Tanggal</th>
                    <th width="120">Status</th>
                    <th width="90">Aksi</th>
                </tr>
                </thead>

                <tbody>

                @forelse($pesan as $item)

                    <tr>
                        <td class="text-mono">
                            {{ $loop->iteration + ($pesan->currentPage()-1)*$pesan->perPage() }}
                        </td>
                        <td class="fw-semibold">
                            {{ $item->nama }}
                        </td>
                        <td class="text-mono">
                            {{ $item->no_telp }}
                        </td>
                        <td class="text-muted">
                            {{ $item->subjek }}
                        </td>
                        <td class="text-muted">
                            {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td>
                            @if($item->status == 'belum_dibaca')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-envelope-fill"></i>
                                    Belum Dibaca
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-envelope-open-fill"></i>
                                    Sudah Dibaca
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pesan-masuk.show',$item->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <x-ui.empty-state
                                title="Belum ada pesan masuk"
                                subtitle="Pesan dari form Kontak di halaman company profile akan muncul di sini."
                            />
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $pesan->links() }}
        </div>

    </div>

</div>

@endsection
