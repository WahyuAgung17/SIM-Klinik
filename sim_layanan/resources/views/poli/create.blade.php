@extends('layouts.app')

@section('title','Tambah Poli')
@section('breadcrumb','Master Data / Poli / Tambah')

@section('content')

<div class="card" style="max-width:640px;">

    <div class="card-body">

        <form
            action="{{ route('poli.store') }}"
            method="POST">

            @csrf

            @include('poli.form')

        </form>

    </div>

</div>

@endsection
