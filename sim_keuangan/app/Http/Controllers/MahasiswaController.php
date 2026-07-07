<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\DosenWaliMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Throwable;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $simpegAvailable = true;
        $totalDosen = 0;

        try {
            $totalDosen = Pegawai::query()->dosen()->count();
        } catch (Throwable) {
            $simpegAvailable = false;
        }

        return view("dashboard", [
            'stats' => [
                'totalMahasiswa' => $this->safeValue(fn () => Mahasiswa::query()->count(), 0),
                'mahasiswaAktif' => $this->safeValue(fn () => Mahasiswa::query()->where('status_keaktifan', true)->count(), 0),
                'totalDosen' => $totalDosen,
                'totalMataKuliah' => $this->safeValue(fn () => MataKuliah::query()->count(), 0),
                'mataKuliahAktif' => $this->safeValue(fn () => MataKuliah::query()->where('status_aktif', true)->count(), 0),
                'totalDosenWali' => $this->safeValue(fn () => DosenWaliMahasiswa::query()->count(), 0),
                'mahasiswaTanpaWali' => $this->safeValue(
                    fn () => Mahasiswa::query()->whereDoesntHave('dosenWaliMahasiswa')->count(),
                    0
                ),
                'mataKuliahDenganPengampu' => $this->safeValue(
                    fn () => MataKuliah::query()->whereNotNull('dosen_pengampu_id')->count(),
                    0
                ),
            ],
            'recentMahasiswa' => $this->safeValue(
                fn () => Mahasiswa::query()->latest()->take(5)->get(),
                collect()
            ),
            'recentMataKuliah' => $this->safeValue(
                fn () => MataKuliah::query()->with('dosenPengampu')->latest()->take(5)->get(),
                collect()
            ),
            'recentDosenWali' => $this->safeValue(
                fn () => DosenWaliMahasiswa::query()->with(['mahasiswa', 'dosenWali'])->latest()->take(5)->get(),
                collect()
            ),
            'simpegAvailable' => $simpegAvailable,
        ]);
    }

    public function tampil()
    {
        $data = Mahasiswa::all();
        return view("mahasiswa", ["data" => $data]);
    }

    public function simpan(CreateMahasiswaRequest $request)
    {
        $validateData = $request->validated();
        Mahasiswa::create([
            "nim" => $validateData['nim'],
            "nama" => $validateData['nama'],
            "status_keaktifan" => $request->boolean('status_keaktifan'),
            "id_prodi" => $validateData['prodi'],
        ]);

        return redirect()
            ->back()
            ->with("success", "Data mahasiswa berhasil ditambahkan");
    }

    public function show($id)
    {
        return response()->json(Mahasiswa::findOrFail($id));
    }

    public function update(UpdateMahasiswaRequest $request, $id)
    {
        $validateData = $request->validated();
        $mhs = Mahasiswa::findOrFail($id);

        $mhs->update([
            'nim' => $validateData['nim'],
            'nama' => $validateData['nama'],
            'id_prodi' => $validateData['prodi'],
            'status_keaktifan' => $request->boolean('status_keaktifan'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function hapus($id)
    {
        $data = Mahasiswa::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    private function safeValue(callable $resolver, mixed $default): mixed
    {
        try {
            $value = $resolver();

            if ($value instanceof Collection) {
                return $value;
            }

            return $value;
        } catch (Throwable) {
            return $default;
        }
    }
}
