<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
// Nanti teman Anda akan menambahkan: use App\Models\Pasien;
// Nanti teman Anda akan menambahkan: use App\Models\Kunjungan;
// Nanti teman Anda akan menambahkan: use App\Models\Pembayaran;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $total_dokter = Dokter::count();

        // DATA DUMMY
        $total_pasien = 0; 
        $kunjungan_hari_ini = 0; 
        $transaksi_hari_ini = 0; 
        $pemasukan_hari_ini = 0; 

        return view('dashboard', compact(
            'total_dokter', 
            'total_pasien', 
            'kunjungan_hari_ini', 
            'transaksi_hari_ini', 
            'pemasukan_hari_ini'
        ));
    }
}