<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanMasukRequest;
use App\Models\PesanMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PesanMasukController extends Controller
{
    /**
     * Simpan pesan dari form Kontak di company profile (publik, tanpa login).
     */
    public function store(StorePesanMasukRequest $request): RedirectResponse
    {
        PesanMasuk::create($request->validated() + [
            'status' => 'belum_dibaca',
        ]);

        return redirect(route('profil.index').'#kontak')
            ->with('success', 'Pesan Anda berhasil terkirim. Kami akan segera menghubungi Anda kembali.');
    }

    /**
     * Daftar pesan masuk untuk Admin.
     */
    public function index(): View
    {
        $search = request('search');

        $pesan = PesanMasuk::when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('subjek', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pesan-masuk.index', compact('pesan', 'search'));
    }

    /**
     * Lihat detail pesan, otomatis ditandai "sudah dibaca".
     */
    public function show(PesanMasuk $pesanMasuk): View
    {
        if ($pesanMasuk->status === 'belum_dibaca') {
            $pesanMasuk->update(['status' => 'sudah_dibaca']);
        }

        return view('pesan-masuk.show', ['pesan' => $pesanMasuk]);
    }

    /**
     * Hapus pesan yang sudah tidak diperlukan.
     */
    public function destroy(PesanMasuk $pesanMasuk): RedirectResponse
    {
        $pesanMasuk->delete();

        return redirect()->route('pesan-masuk.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
