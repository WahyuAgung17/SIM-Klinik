<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Poli;
use App\Http\Requests\StoreLayananRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class LayananController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $layanan = Layanan::with('poli')

            ->when($search, function ($query) use ($search) {

                $query->where('nama_layanan', 'like', "%{$search}%")

                    ->orWhere('kategori', 'like', "%{$search}%");

            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view('layanan.index', compact('layanan', 'search'));
    }

    public function create(): View
    {
        $poli = Poli::where('status', 'aktif')->get();

        return view('layanan.create', compact('poli'));
    }

    public function store(StoreLayananRequest $request): RedirectResponse
{
    $layanan = Layanan::create($request->validated());

    ActivityLog::create([
        'module' => 'Layanan',
        'action' => 'Tambah',
        'description' => 'Menambahkan layanan "' . $layanan->nama_layanan . '"',
    ]);

    return redirect()
        ->route('layanan.index')
        ->with('success', 'Layanan berhasil ditambahkan.');
}

    public function edit(Layanan $layanan): View
    {
        $poli = Poli::where('status', 'aktif')->get();

        return view('layanan.edit', compact('layanan', 'poli'));
    }

    public function update(StoreLayananRequest $request, Layanan $layanan): RedirectResponse
{
    $layanan->update($request->validated());

    ActivityLog::create([
        'module' => 'Layanan',
        'action' => 'Edit',
        'description' => 'Mengubah layanan "' . $layanan->nama_layanan . '"',
    ]);

    return redirect()
        ->route('layanan.index')
        ->with('success', 'Layanan berhasil diperbarui.');
}

}
