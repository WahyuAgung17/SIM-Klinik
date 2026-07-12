<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pemeriksaan;
use App\Models\Layanan;
use App\Http\Requests\StorePemeriksaanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class PemeriksaanController extends Controller
{
    /**
     * Antrian pasien yang menunggu diperiksa dokter.
     */
    public function index(): View
    {
        $kunjungan = Kunjungan::with(['pasien', 'poli', 'dokter'])
            ->where('status_kunjungan', 'menunggu_pemeriksaan')
            ->oldest('tanggal_kunjungan')
            ->paginate(10);

        return view('pemeriksaan.index', compact('kunjungan'));
    }

    /**
     * Form pemeriksaan untuk 1 kunjungan tertentu.
     */
    public function create(Kunjungan $kunjungan): View
    {
        $kunjungan->load(['pasien', 'poli', 'dokter']);

        $layanan = Layanan::where('poli_id', $kunjungan->poli_id)
            ->where('status', 'aktif')
            ->get();

        return view('pemeriksaan.create', compact('kunjungan', 'layanan'));
    }

    /**
     * Simpan hasil pemeriksaan + detail layanan/tindakan yang diberikan.
     */
    public function store(StorePemeriksaanRequest $request, Kunjungan $kunjungan): RedirectResponse
    {
        $data = $request->validated();

        $pemeriksaan = Pemeriksaan::create([
            'kunjungan_id' => $kunjungan->id,
            'dokter_id' => $kunjungan->dokter_id,
            'diagnosa' => $data['diagnosa'],
            'catatan_pemeriksaan' => $data['catatan_pemeriksaan'] ?? null,
            'resep' => $data['resep'] ?? null,
        ]);

        foreach ($data['layanan_id'] as $index => $layananId) {
            $layanan = Layanan::findOrFail($layananId);
            $jumlah = $data['jumlah'][$index] ?? 1;

            $pemeriksaan->detailLayanan()->create([
                'layanan_id' => $layanan->id,
                'harga' => $layanan->harga,
                'jumlah' => $jumlah,
                'subtotal' => $layanan->harga * $jumlah,
            ]);
        }

        // Pemeriksaan selesai -> lanjut ke tahap pembayaran (modul Anggota 4)
        $kunjungan->update(['status_kunjungan' => 'menunggu_pembayaran']);

        ActivityLog::create([
            'module' => 'Pemeriksaan',
            'action' => 'Selesai',
            'description' => 'Pemeriksaan pasien "' . $kunjungan->pasien->nama . '" telah selesai',
        ]);

        return redirect()
            ->route('kunjungan.show', $kunjungan)
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
