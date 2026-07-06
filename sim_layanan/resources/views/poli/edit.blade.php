@extends('layouts.app')

@section('title','Edit Poli')
@section('breadcrumb','Master Data / Poli / Edit')

@section('content')

<div class="card" style="max-width:640px;">

    <div class="card-body">

        <form
            action="{{ route('poli.update',$poli) }}"
            method="POST">

            @csrf

            @method('PUT')

            @include('poli.form')

        </form>

    </div>

</div>

@endsection
