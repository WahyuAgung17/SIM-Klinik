<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwals = JadwalDokter::with('dokter')->latest()->paginate(10);
        
        $dokters = Dokter::where('status', 'aktif')->get();
        
        return view('jadwal', compact('jadwals', 'dokters'));
    }

    // Menyimpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        JadwalDokter::create($request->all());
        
        return redirect()->back()->with('success', 'Jadwal Praktik berhasil ditambahkan!');
    }

    // Mengubah jadwal
    public function update(Request $request, $id)
    {
        $request->validate([
            'dokter_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        $jadwal = JadwalDokter::findOrFail($id);
        $jadwal->update($request->all());
        
        return redirect()->back()->with('success', 'Jadwal Praktik berhasil diperbarui!');
    }
}