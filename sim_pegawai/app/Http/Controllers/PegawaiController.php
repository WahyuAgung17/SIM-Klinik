<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::latest()->paginate(10);
        return view('pegawai', compact('pegawais'));
    }

    // Menyimpan data pegawai baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required'
        ]);

        Pegawai::create($request->all());
        
        return redirect()->back()->with('success', 'Data Pegawai berhasil ditambahkan!');
    }

    // Mengubah data pegawai
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        
        return redirect()->back()->with('success', 'Data Pegawai berhasil diperbarui!');
    }
}   