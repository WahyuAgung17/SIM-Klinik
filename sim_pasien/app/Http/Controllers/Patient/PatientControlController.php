<?php
// app/Http/Controllers/Patient/PatientControlController.php
// FIX: control_time, doctor_id, status enum baru, updateStatus method

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientControl;
use App\Models\Patient\Visit;
use App\Models\Patient\Doctor\Doctor;
use App\Models\Setting;

class PatientControlController extends Controller
{
    /* ---------------------------------------------------------------- INDEX */
    public function index(Request $request)
    {
        $perPage = Setting::where('setting_key', 'per_page')->value('setting_value') ?? 10;

        $query = PatientControl::with(['patient', 'visit', 'doctor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', fn($q) => $q
                ->where('medical_record_number', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('control_date')) {
            $query->whereDate('control_date', $request->control_date);
        }

        $controls = $query->latest('control_date')->paginate($perPage);

        return view('patient.control.index', compact('controls'));
    }

    /* ---------------------------------------------------------------- CREATE */
    public function create()
    {
        $patients = Patient::where('status', 'Aktif')->orderBy('full_name')->get();
        $doctors  = Doctor::where('status', 'Aktif')->orderBy('full_name')->get();  // FIX
        $visits   = Visit::orderByDesc('visit_date')->get();

        return view('patient.control.create', compact('patients', 'doctors', 'visits'));
    }

    /* ---------------------------------------------------------------- STORE */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'visit_id'     => 'nullable|exists:visits,id',
            'doctor_id'    => 'nullable|exists:doctor,id',    // FIX
            'control_date' => 'required|date',
            'control_time' => 'nullable',                     // FIX: jam kontrol
            'notes'        => 'nullable|string',
            'status'       => 'required|in:Menunggu,Sudah Datang,Terlewat',  // FIX
        ]);

        PatientControl::create([
            'patient_id'   => $request->patient_id,
            'visit_id'     => $request->visit_id,
            'doctor_id'    => $request->doctor_id,    // FIX
            'control_date' => $request->control_date,
            'control_time' => $request->control_time, // FIX
            'notes'        => $request->notes,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('patient.controls.index')
            ->with('success', 'Jadwal kontrol berhasil ditambahkan.');
    }

    /* ---------------------------------------------------------------- SHOW */
    public function show($id)
    {
        $control = PatientControl::with(['patient', 'visit', 'doctor'])->findOrFail($id);
        return view('patient.control.show', compact('control'));
    }

    /* ---------------------------------------------------------------- EDIT */
    public function edit($id)
    {
        $control  = PatientControl::findOrFail($id);
        $patients = Patient::where('status', 'Aktif')->orderBy('full_name')->get();
        $doctors  = Doctor::where('status', 'Aktif')->orderBy('full_name')->get(); // FIX
        $visits   = Visit::orderByDesc('visit_date')->get();

        return view('patient.control.edit', compact('control', 'patients', 'doctors', 'visits'));
    }

    /* ---------------------------------------------------------------- UPDATE */
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'doctor_id'    => 'nullable|exists:doctor,id',
            'control_date' => 'required|date',
            'control_time' => 'nullable',
            'notes'        => 'nullable|string',
            'status'       => 'required|in:Menunggu,Sudah Datang,Terlewat',  // FIX
        ]);

        $control = PatientControl::findOrFail($id);
        $control->update([
            'patient_id'   => $request->patient_id,
            'doctor_id'    => $request->doctor_id,
            'control_date' => $request->control_date,
            'control_time' => $request->control_time, // FIX
            'notes'        => $request->notes,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('patient.controls.index')
            ->with('success', 'Jadwal kontrol berhasil diperbarui.');
    }

    /* ---------------------------------------------------------------- UPDATE STATUS (PATCH) */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Sudah Datang,Terlewat',
        ]);

        $control = PatientControl::findOrFail($id);
        $control->update(['status' => $request->status]);

        return back()->with('success', 'Status kontrol berhasil diperbarui.');
    }
}
