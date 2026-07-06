@extends('layouts.app')

@section('title','Kunjungan Baru')
@section('breadcrumb','Pelayanan / Kunjungan / Daftar Baru')

@section('content')

<div class="card" style="max-width:720px;">

    <div class="card-body">

        <form action="{{ route('kunjungan.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Pasien
                    <span class="text-danger">*</span>
                </label>

                <select
                    name="pasien_id"
                    class="form-select @error('pasien_id') is-invalid @enderror">

                    <option value="">-- Cari / Pilih Pasien --</option>

                    @foreach($pasien as $item)
                        <option value="{{ $item->id }}"
                            @selected(old('pasien_id') == $item->id)>
                            {{ $item->nama }} — {{ $item->no_rm }}
                        </option>
                    @endforeach

                </select>

                @error('pasien_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Poli
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="poli_id"
                        class="form-select @error('poli_id') is-invalid @enderror">

                        <option value="">-- Pilih Poli --</option>

                        @foreach($poli as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('poli_id') == $item->id)>
                                {{ $item->nama_poli }}
                            </option>
                        @endforeach

                    </select>

                    @error('poli_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Dokter
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="dokter_id"
                        class="form-select @error('dokter_id') is-invalid @enderror">

                        <option value="">-- Pilih Dokter --</option>

                        @foreach($dokter as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('dokter_id') == $item->id)>
                                {{ $item->nama }}
                            </option>
                        @endforeach

                    </select>

                    @error('dokter_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Keluhan Awal
                </label>

                <textarea
                    name="keluhan"
                    rows="3"
                    class="form-control"
                    placeholder="Keluhan yang disampaikan pasien saat mendaftar (opsional)">{{ old('keluhan') }}</textarea>

            </div>

            <div class="d-flex gap-2">

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i>
                    Daftarkan Kunjungan
                </button>

                <a href="{{ route('kunjungan.index') }}" class="btn btn-light">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
