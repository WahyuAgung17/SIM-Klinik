<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Layanan;
use App\Models\Kunjungan;
use App\Models\Pemeriksaan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalPoli' => Poli::count(),
            'totalLayanan' => Layanan::count(),
            'totalKunjungan' => Kunjungan::count(),
            'totalPemeriksaan' => Pemeriksaan::count(),
        ]);
    }
}