<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function tampil(): View
    {
        $data = Pegawai::query()
            ->dosen()
            ->orderBy('nama')
            ->get();

        return view('dosen', [
            'data' => $data,
            'unitKerjaOptions' => Pegawai::UNIT_KERJA_OPTIONS,
        ]);
    }
}
