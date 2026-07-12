<?php
// app/Http/Controllers/Patient/VisitHistoryController.php
// FIX: namespace Poly yang salah (App\Models\Master\Poly → App\Models\Patient\Poly\Poly)

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient\Visit;
use App\Models\Patient\Poly\Poly;  // ← FIX: namespace yang benar

class VisitHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Visit::with([
            'patient',
            'doctor',
            'poly',
        ]);

        // Filter Nama Pasien
        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->patient . '%');
            });
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        // Filter Poli
        if ($request->filled('poly_id')) {
            $query->where('poly_id', $request->poly_id);
        }

        $visits = $query
            ->orderByDesc('visit_date')
            ->orderByDesc('visit_time')
            ->paginate(10)
            ->withQueryString();

        $polies = Poly::orderBy('name')->get();

        return view(
            'patient.visit_history.index',
            compact('visits', 'polies')
        );
    }

    public function show($id)
    {
        $visit = Visit::with([
            'patient',
            'doctor',
            'poly',
        ])->findOrFail($id);

        return view('patient.visit_history.show', compact('visit'));
    }
}