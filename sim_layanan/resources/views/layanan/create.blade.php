@extends('layouts.app')

@section('title','Tambah Layanan')
@section('breadcrumb','Master Data / Layanan / Tambah')

@section('content')

<div class="card" style="max-width:820px;">

    <div class="card-body">

        <form
            action="{{ route('layanan.store') }}"
            method="POST">

            @csrf

            @include('layanan.form')

            <div class="d-flex gap-2">

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan Data
                </button>

                <a
                    href="{{ route('layanan.index') }}"
                    class="btn btn-light">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
