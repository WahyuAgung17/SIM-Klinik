<?php
// app/Http/Controllers/Patient/VisitController.php
// FIX:
//   - create() dan edit() kini kirim $polies dan $doctors ke view
//   - store() dan update() validasi poly_id dan doctor_id
//   - store() pakai setting visit_prefix dari tabel settings
//   - Ganti clinic_id → poly_id di semua create/update

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Visit;
use App\Models\Patient\Patient;
use App\Models\Patient\Poly\Poly;
use App\Models\Patient\Doctor\Doctor;
use App\Models\Setting;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /* ---------------------------------------------------------------- INDEX */
    public function index(Request $request)
    {
        $title    = 'Registrasi Pasien';
        $perPage  = Setting::where('setting_key', 'per_page')->value('setting_value') ?? 10;

        $visits = Visit::with(['patient', 'poly', 'doctor'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('visit_number', 'like', "%{$search}%")
                      ->orWhereHas('patient', fn($q) => $q
                          ->where('full_name', 'like', "%{$search}%")
                          ->orWhere('medical_record_number', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('patient.visit.index', compact('title', 'visits'));
    }

    /* ---------------------------------------------------------------- CREATE */
    public function create()
    {
        $title   = 'Registrasi Pasien';

        $patients = Patient::where('status', 'Aktif')
            ->orderBy('full_name')->get();

        // FIX: tambah $polies dan $doctors yang dikirim ke view
        $poly  = Poly::where('status', 'Aktif')
            ->orderBy('name')->get();

        $doctors = Doctor::where('status', 'Aktif')
            ->orderBy('full_name')->get();

        return view('patient.visit.create', compact(
            'title', 'patients', 'poly', 'doctors'
        ));
    }

    /* ---------------------------------------------------------------- STORE */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'poly_id'      => 'required|exists:poly,id',   // FIX: validasi poly
            'doctor_id'    => 'nullable|exists:doctor,id',   // FIX: validasi dokter
            'visit_date'   => 'required|date',
            'visit_time'   => 'required',
            'payment_type' => 'required|in:Umum,BPJS,Asuransi',
            'complaint'    => 'nullable|string',
        ]);

        // Baca prefix dari settings (default 'VST')
        $prefix  = Setting::where('setting_key', 'visit_prefix')->value('setting_value') ?? 'VST';
        $today   = now()->format('Ymd');

        $lastQueue   = Visit::whereDate('visit_date', $request->visit_date)->max('queue_number');
        $queue       = $lastQueue ? $lastQueue + 1 : 1;
        $visitNumber = $prefix . $today . str_pad($queue, 4, '0', STR_PAD_LEFT);

        Visit::create([
            'visit_number' => $visitNumber,
            'queue_number' => $queue,
            'patient_id'   => $request->patient_id,
            'poly_id'      => $request->poly_id,      // FIX: simpan poly_id
            'doctor_id'    => $request->doctor_id,
            'visit_date'   => $request->visit_date,
            'visit_time'   => $request->visit_time,
            'payment_type' => $request->payment_type,
            'complaint'    => $request->complaint,
            'status'       => 'Terdaftar',
        ]);

        return redirect()
            ->route('patient.visits.index')
            ->with('success', 'Registrasi pasien berhasil ditambahkan.');
    }

    /* ---------------------------------------------------------------- SHOW */
    public function show(Visit $visit)
    {
        $title = 'Detail Registrasi';
        $visit->load(['patient', 'poly', 'doctor']);
        return view('patient.visit.show', compact('title', 'visit'));
    }

    /* ---------------------------------------------------------------- EDIT */
    public function edit(Visit $visit)
    {
        $title   = 'Edit Registrasi';

        $patients = Patient::where('status', 'Aktif')->orderBy('full_name')->get();

        // FIX: tambah $polies dan $doctors
        $poly  = Poly::where('status', 'Aktif')->orderBy('name')->get();
        $doctors = Doctor::where('status', 'Aktif')->orderBy('full_name')->get();

        return view('patient.visit.edit', compact(
            'title', 'visit', 'patients', 'poly', 'doctors'
        ));
    }

    /* ---------------------------------------------------------------- UPDATE */
    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'poly_id'      => 'required|exists:poly,id',  // FIX
            'doctor_id'    => 'nullable|exists:doctor,id',  // FIX
            'visit_date'   => 'required|date',
            'visit_time'   => 'required',
            'payment_type' => 'required|in:Umum,BPJS,Asuransi',
            'complaint'    => 'nullable|string',
            'status'       => 'required|in:Terdaftar,Menunggu Pemeriksaan,Sedang Diperiksa,Menunggu Pembayaran,Selesai,Dibatalkan',
        ]);

        $visit->update([
            'patient_id'   => $request->patient_id,
            'poly_id'      => $request->poly_id,    // FIX
            'doctor_id'    => $request->doctor_id,
            'visit_date'   => $request->visit_date,
            'visit_time'   => $request->visit_time,
            'payment_type' => $request->payment_type,
            'complaint'    => $request->complaint,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('patient.visits.index')
            ->with('success', 'Registrasi pasien berhasil diperbarui.');
    }

    /* ---------------------------------------------------------------- DESTROY */
    public function destroy(Visit $visit)
    {
        return redirect()
            ->route('patient.visits.index')
            ->with('error', 'Data registrasi tidak dapat dihapus.');
    }

    /* ---------------------------------------------------------------- API: get doctors by poly (AJAX) */
    public function getDoctorsByPoly(Request $request)
    {
        $doctors = Doctor::where('poly_id', $request->poly_id)
            ->where('status', 'Aktif')
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'specialist']);

        return response()->json($doctors);
    }
}
