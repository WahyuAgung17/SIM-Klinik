<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Http\Requests\StorePoliRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class PoliController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $poli = Poli::when($search, function ($query) use ($search) {
                $query->where('nama_poli', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('poli.index', compact('poli', 'search'));
    }

    public function create(): View
    {
        return view('poli.create');
    }

    public function store(StorePoliRequest $request): RedirectResponse
    {
        $poli = Poli::create($request->validated());

        ActivityLog::create([
            'module' => 'Poli',
            'action' => 'Tambah',
            'description' => 'Menambahkan poli "' . $poli->nama_poli . '"',
        ]);

        return redirect()
            ->route('poli.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli): View
    {
        return view('poli.edit', compact('poli'));
    }

    public function update(StorePoliRequest $request, Poli $poli): RedirectResponse
    {
        $poli->update($request->validated());

        ActivityLog::create([
            'module' => 'Poli',
            'action' => 'Edit',
            'description' => 'Mengubah poli "' . $poli->nama_poli . '"',
        ]);

        return redirect()
            ->route('poli.index')
            ->with('success', 'Poli berhasil diperbarui.');
    }

}
