<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDosenWaliMahasiswaRequest;
use App\Http\Requests\UpdateDosenWaliMahasiswaRequest;
use App\Models\DosenWaliMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Pegawai;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DosenWaliMahasiswaController extends Controller
{
    public function tampil(): View
    {
        $data = DosenWaliMahasiswa::query()
            ->with(['mahasiswa', 'dosenWali'])
            ->get()
            ->sortBy(fn (DosenWaliMahasiswa $item) => $item->mahasiswa?->nama)
            ->values();

        return view('dosen-wali-mahasiswa', [
            'data' => $data,
            'mahasiswaOptions' => Mahasiswa::query()->orderBy('nama')->get(),
            'dosenOptions' => Pegawai::query()->dosen()->orderBy('nama')->get(),
            'prodiOptions' => Mahasiswa::PRODI_OPTIONS,
        ]);
    }

    public function simpan(CreateDosenWaliMahasiswaRequest $request)
    {
        $validated = $request->validated();

        DosenWaliMahasiswa::create([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'dosen_wali_id' => $validated['dosen_wali_id'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Relasi dosen wali mahasiswa berhasil ditambahkan');
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            DosenWaliMahasiswa::query()
                ->with(['mahasiswa', 'dosenWali'])
                ->findOrFail($id)
        );
    }

    public function update(UpdateDosenWaliMahasiswaRequest $request, $id)
    {
        $validated = $request->validated();
        $relasi = DosenWaliMahasiswa::findOrFail($id);

        $relasi->update([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'dosen_wali_id' => $validated['dosen_wali_id'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Relasi dosen wali mahasiswa berhasil diperbarui');
    }

    public function hapus($id)
    {
        DosenWaliMahasiswa::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Relasi dosen wali mahasiswa berhasil dihapus');
    }
}
