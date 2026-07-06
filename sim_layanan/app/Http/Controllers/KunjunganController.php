<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Poli;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Http\Requests\StoreKunjunganRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KunjunganController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $kunjungan = Kunjungan::with(['pasien', 'poli', 'dokter'])
            ->when($search, function ($query) use ($search) {
                $query->where('no_kunjungan', 'like', "%{$search}%")
                    ->orWhereHas('pasien', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->latest('tanggal_kunjungan')
            ->paginate(10)
            ->withQueryString();

        return view('kunjungan.index', compact('kunjungan', 'search'));
    }

    public function create(): View
    {
        $pasien = Pasien::orderBy('nama')->get();
        $poli = Poli::where('status', 'aktif')->get();
        $dokter = Dokter::where('status', 'aktif')->get();

        return view('kunjungan.create', compact('pasien', 'poli', 'dokter'));
    }

    public function store(StoreKunjunganRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Generate nomor kunjungan otomatis (format: KJ-YYYYMMDD-XXX)
        $data['no_kunjungan'] = Kunjungan::generateNoKunjungan();
        $data['tanggal_kunjungan'] = now();
        $data['status_kunjungan'] = 'menunggu_pemeriksaan';

        $kunjungan = Kunjungan::create($data);

        return redirect()
            ->route('kunjungan.show', $kunjungan)
            ->with('success', "Pendaftaran berhasil. No. Kunjungan: {$kunjungan->no_kunjungan}");
    }

    public function show(Kunjungan $kunjungan): View
    {
        $kunjungan->load(['pasien', 'poli', 'dokter', 'pemeriksaan.detailLayanan.layanan']);

        return view('kunjungan.show', compact('kunjungan'));
    }

    /**
     * Check-in pasien yang mendaftar mandiri lewat form publik (company
     * profile). Memindahkan status dari "terdaftar" -> "menunggu_pemeriksaan"
     * supaya kunjungan tersebut muncul di antrian pemeriksaan dokter.
     */
    public function checkin(Kunjungan $kunjungan): RedirectResponse
    {
        if ($kunjungan->status_kunjungan !== 'terdaftar') {
            return redirect()
                ->route('kunjungan.show', $kunjungan)
                ->with('error', 'Kunjungan ini sudah pernah di-check-in sebelumnya.');
        }

        $kunjungan->update(['status_kunjungan' => 'menunggu_pemeriksaan']);

        return redirect()
            ->route('kunjungan.show', $kunjungan)
            ->with('success', 'Check-in berhasil. Pasien masuk ke antrian pemeriksaan.');
    }
}
