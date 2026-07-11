<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib dipanggil untuk fitur hapus/simpan gambar

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('poli')->latest()->paginate(10);
        $polis = Poli::where('status', 'aktif')->get();
        
        return view('dokter', compact('dokters', 'polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required',
            'kode_dokter' => 'required|unique:dokters',
            'poli_id' => 'required',
            'spesialisasi' => 'required',
            'no_hp' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi: Harus gambar & Maksimal 2MB
        ]);

        $data = $request->all();

        // Jika user mengunggah file foto
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder public/storage/foto_dokter
            $data['foto'] = $request->file('foto')->store('foto_dokter', 'public');
        }

        Dokter::create($data);
        
        return redirect()->back()->with('success', 'Data Dokter beserta Foto berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_dokter' => 'required|unique:dokters,kode_dokter,'.$id,
            'nama_dokter' => 'required',
            'poli_id' => 'required',
            'spesialisasi' => 'required',
            'no_hp' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dokter = Dokter::findOrFail($id);
        $data = $request->all();

        // Jika user mengganti foto dengan yang baru
        if ($request->hasFile('foto')) {
            // Hapus foto yang lama (agar penyimpanan server tidak bengkak)
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            // Simpan foto yang baru
            $data['foto'] = $request->file('foto')->store('foto_dokter', 'public');
        }

        $dokter->update($data);
        
        return redirect()->back()->with('success', 'Data Dokter berhasil diperbarui!');
    }
}