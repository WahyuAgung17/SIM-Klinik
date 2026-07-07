@extends('adminlte::page')

@section('title', 'Edit Tagihan')

@section('content_header')
<h1>Edit Tagihan</h1>
@stop

@section('content')

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">Edit Data Tagihan</h3>
    </div>

    <form action="{{ route('tagihan.update',$tagihan->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Mahasiswa</label>

                <select name="student_id" class="form-control">

                    @foreach($data as $mhs)

                        <option value="{{ $mhs->id }}"
                            {{ $tagihan->nim == $mhs->id ? 'selected' : '' }}>

                            {{ $mhs->nim }} - {{ $mhs->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Periode</label>

                <input
                    type="text"
                    name="semester"
                    class="form-control"
                    value="{{ $tagihan->periode }}"
                >

            </div>

            <div class="form-group">

                <label>Total Tagihan</label>

                <input
                    type="number"
                    name="amount"
                    class="form-control"
                    value="{{ $tagihan->total_tagihan }}"
                >

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-warning">

                <i class="fas fa-save"></i>

                Update

            </button>

            <a href="{{ route('tagihan.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop