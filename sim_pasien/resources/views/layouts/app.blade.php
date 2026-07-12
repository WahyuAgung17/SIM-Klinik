@extends('adminlte::page')

@section('title', $title ?? 'SIM PASIEN')

@section('content_header')

    @include('layouts.breadcrumb')

@stop

@section('content')

    @yield('content')

@stop

@section('css')

    @stack('css')

@stop

@section('js')

    @include('layouts.scripts')

    @stack('js')

@stop