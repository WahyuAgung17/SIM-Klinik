<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Layanan;
use App\Models\Dokter;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function index()
{
    $poli = Poli::where('status', 'aktif')->get();

    $layanan = Layanan::with('poli')
        ->where('status', 'aktif')
        ->get()
        ->groupBy(function ($item) {
            return $item->poli->nama_poli;
        });

    $dokter = Dokter::where('status', 'aktif')
        ->orderBy('nama')
        ->get();

    return view('profil.index', compact(
        'poli',
        'layanan',
        'dokter'
    ));
}

    public function tentang(): View
    {
        return view('profil.tentang');
    }

    public function layanan(): View
    {
        $layanan = Layanan::with('poli')
            ->where('status', 'aktif')
            ->orderBy('poli_id')
            ->get()
            ->groupBy('poli.nama_poli');

        return view('profil.layanan', compact('layanan'));
    }

    public function dokter(): View
    {
        $dokter = Dokter::where('status', 'aktif')->orderBy('nama')->get();

        return view('profil.dokter', compact('dokter'));
    }

    public function galeri(): View
    {
        return view('profil.galeri');
    }

    public function faq(): View
    {
        return view('profil.faq');
    }

    public function kontak(): View
    {
        return view('profil.kontak');
    }
}
