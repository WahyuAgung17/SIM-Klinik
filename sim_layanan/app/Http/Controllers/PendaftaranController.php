<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePendaftaranRequest;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Controller PUBLIK untuk pendaftaran berobat mandiri oleh pengunjung website
 * (tanpa login). Terpisah dari KunjunganController yang khusus dipakai
 * petugas/admin di dashboard.
 */
class PendaftaranController extends Controller
{
    public function create(): View
    {
        $poli = Poli::where('status', 'aktif')->orderBy('nama_poli')->get();
        $dokter = Dokter::where('status', 'aktif')->orderBy('nama')->get();

        return view('profil.pendaftaran.create', compact('poli', 'dokter'));
    }

    public function store(StorePendaftaranRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $kunjungan = DB::transaction(function () use ($data) {
            // Cari pasien berdasarkan NIK. Jika belum pernah terdaftar,
            // buat data pasien baru (self-registration).
            $pasien = Pasien::firstOrCreate(
                ['nik' => $data['nik']],
                [
                    'no_rm' => 'RM-'.now()->format('ymd').'-'.str_pad((string) (Pasien::count() + 1), 4, '0', STR_PAD_LEFT),
                    'nama' => $data['nama'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'alamat' => $data['alamat'],
                    'no_telp' => $data['no_telp'],
                ]
            );

            return Kunjungan::create([
                'no_kunjungan' => Kunjungan::generateNoKunjungan(),
                'pasien_id' => $pasien->id,
                'poli_id' => $data['poli_id'],
                'dokter_id' => $data['dokter_id'],
                'tanggal_kunjungan' => $data['tanggal_kunjungan'],
                'keluhan' => $data['keluhan'] ?? null,
                // Status "terdaftar": menunggu diverifikasi/check-in oleh
                // petugas pendaftaran di klinik sebelum masuk ke antrean
                // pemeriksaan dokter.
                'status_kunjungan' => 'terdaftar',
            ]);
        });

        return redirect()
            ->route('profil.pendaftaran.sukses', $kunjungan)
            ->with('success', 'Pendaftaran berobat berhasil dikirim.');
    }

    public function sukses(Kunjungan $kunjungan): View
    {
        $kunjungan->load(['pasien', 'poli', 'dokter']);

        return view('profil.pendaftaran.sukses', compact('kunjungan'));
    }
}
