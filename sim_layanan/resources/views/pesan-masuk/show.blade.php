@extends('layouts.app')

@section('title','Detail Pesan')
@section('breadcrumb','Website / Pesan Masuk / Detail')

@section('content')

<div class="mb-3">
    <a href="{{ route('pesan-masuk.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-start mb-4">

            <div>
                <h5 class="fw-bold mb-1">{{ $pesan->subjek }}</h5>
                <small class="text-muted">
                    Dikirim {{ $pesan->created_at->translatedFormat('d F Y, H:i') }} WIB
                </small>
            </div>

            <form action="{{ route('pesan-masuk.destroy',$pesan->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash"></i>
                    Hapus
                </button>
            </form>

        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <small class="text-muted d-block">Nama Pengirim</small>
                <strong>{{ $pesan->nama }}</strong>
            </div>

            <div class="col-md-6">
                <small class="text-muted d-block">No. Telepon</small>
                <strong class="text-mono">{{ $pesan->no_telp }}</strong>
            </div>

        </div>

        <hr>

        <small class="text-muted d-block mb-2">Isi Pesan</small>
        <p class="mb-0" style="white-space: pre-line;">{{ $pesan->pesan }}</p>

    </div>

</div>

@endsection
