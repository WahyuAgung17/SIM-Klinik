@extends('layouts.app')

@section('title','Edit Layanan')
@section('breadcrumb','Master Data / Layanan / Edit')

@section('content')

<div class="card" style="max-width:820px;">

    <div class="card-body">

        <form
            action="{{ route('layanan.update',$layanan) }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('layanan.form')

            <div class="d-flex gap-2">

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan Perubahan
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
