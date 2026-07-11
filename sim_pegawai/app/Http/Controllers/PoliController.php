<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    // Menampilkan halaman data poli
    public function index()
    {
        $polis = Poli::latest()->paginate(10);
        return view('poli', compact('polis'));
    }

    // Menyimpan data poli baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
        ]);

        Poli::create($request->all());
        
        return redirect()->back()->with('success', 'Data Poli berhasil ditambahkan!');
    }

    // Mengubah data poli
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($request->all());
        
        return redirect()->back()->with('success', 'Data Poli berhasil diperbarui!');
    }
}