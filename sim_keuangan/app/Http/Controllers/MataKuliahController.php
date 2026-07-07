<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMataKuliahRequest;
use App\Http\Requests\UpdateMataKuliahRequest;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Pegawai;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function tampil(): View
    {
        $data = MataKuliah::query()
            ->with('dosenPengampu')
            ->orderBy('semester')
            ->orderBy('nama')
            ->get();

        return view('mata-kuliah', [
            'data' => $data,
            'dosenOptions' => Pegawai::query()->dosen()->orderBy('nama')->get(),
            'prodiOptions' => Mahasiswa::PRODI_OPTIONS,
        ]);
    }

    public function simpan(CreateMataKuliahRequest $request)
    {
        $validated = $request->validated();

        MataKuliah::create([
            'kode' => strtoupper($validated['kode']),
            'nama' => $validated['nama'],
            'sks' => $validated['sks'],
            'semester' => $validated['semester'],
            'id_prodi' => $validated['prodi'],
            'dosen_pengampu_id' => $validated['dosen_pengampu_id'],
            'status_aktif' => $request->boolean('status_aktif'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data mata kuliah berhasil ditambahkan');
    }

    public function show($id): JsonResponse
    {
        return response()->json(MataKuliah::findOrFail($id));
    }

    public function update(UpdateMataKuliahRequest $request, $id)
    {
        $validated = $request->validated();
        $mataKuliah = MataKuliah::findOrFail($id);

        $mataKuliah->update([
            'kode' => strtoupper($validated['kode']),
            'nama' => $validated['nama'],
            'sks' => $validated['sks'],
            'semester' => $validated['semester'],
            'id_prodi' => $validated['prodi'],
            'dosen_pengampu_id' => $validated['dosen_pengampu_id'],
            'status_aktif' => $request->boolean('status_aktif'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data mata kuliah berhasil diperbarui');
    }

    public function hapus($id)
    {
        MataKuliah::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Data mata kuliah berhasil dihapus');
    }
}
