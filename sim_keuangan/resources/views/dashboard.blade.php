@extends('adminlte::page')

@section('title', 'Dashboard SIM Klinik')

@section('content_header')
    <h1>Selamat Datang, Admin </h1>
    <p>Sistem Informasi Manajemen Klinik Terintegrasi</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-info-box title="Total Pasien" text="12" icon="fas fa-lg fa-users" theme="info" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-info-box title="Total Pendapatan" text="Rp 2.780.000" icon="fas fa-lg fa-wallet" theme="warning" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-info-box title="Pembayaran Lunas" text="9" icon="fas fa-lg fa-check-circle" theme="success" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-info-box title="Belum Lunas" text="2" icon="fas fa-lg fa-times-circle" theme="danger" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Informasi Sistem</h3>
                </div>
                <div class="card-body">
                    <p>Aplikasi ini digunakan untuk mengelola data pasien, transaksi pendaftaran, rekam medis dokter, pembuatan tagihan, dan laporan pemasukan klinik. Pembayaran telah terintegrasi penuh dengan <strong>Midtrans Payment Gateway</strong>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection