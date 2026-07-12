<?php
// app/Http/Controllers/Patient/PatientController.php
// VERSI LENGKAP — semua method ada (index, create, store, show, edit, update)
// + integrasi setting per_page dan rm_prefix/rm_mode

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /* ---------------------------------------------------------------- INDEX */
    public function index(Request $request)
    {
        // Baca per_page dari settings (fallback 10)
        $perPage = (int) (Setting::where('setting_key', 'per_page')->value('setting_value') ?? 10);

        $query = Patient::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('medical_record_number', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('family_card_number', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $patients = $query->latest()->paginate($perPage)->withQueryString();

        return view('patient.patients.index', compact('patients'));
    }

    /* ---------------------------------------------------------------- CREATE */
    public function create()
    {
        // Baca mode RM dari settings
        $rmMode   = Setting::where('setting_key', 'rm_mode')->value('setting_value') ?? 'auto';
        $rmPrefix = Setting::where('setting_key', 'rm_prefix')->value('setting_value') ?? 'RM';

        // Preview No RM berikutnya jika mode auto
        $nextRm = null;
        if ($rmMode === 'auto') {
            $lastPatient = Patient::latest('id')->first();
            $lastNum     = $lastPatient
                ? (int) preg_replace('/\D/', '', substr($lastPatient->medical_record_number, -6))
                : 0;
            $nextRm = $rmPrefix . date('Y') . str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT);
        }

        return view('patient.patients.create', compact('rmMode', 'nextRm', 'rmPrefix'));
    }

    /* ---------------------------------------------------------------- STORE */
    public function store(Request $request)
    {
        $rmMode   = Setting::where('setting_key', 'rm_mode')->value('setting_value') ?? 'auto';
        $rmPrefix = Setting::where('setting_key', 'rm_prefix')->value('setting_value') ?? 'RM';

        $validated = $request->validate([
            'nik'                => 'required|string|max:16|unique:patients,nik',
            'family_card_number' => 'nullable|string|max:20',
            'full_name'          => 'required|string|max:255',
            'nickname'           => 'nullable|string|max:100',
            'gender'             => 'required',
            'birth_place'        => 'nullable|string|max:100',
            'birth_date'         => 'nullable|date',
            'blood_type'         => 'nullable|string|max:5',
            'religion'           => 'nullable|string|max:50',
            'marital_status'     => 'nullable|string|max:50',
            'occupation'         => 'nullable|string|max:100',
            'phone'              => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:100',
            'address'            => 'nullable|string',
            'rt'                 => 'nullable|string|max:5',
            'rw'                 => 'nullable|string|max:5',
            'village'            => 'nullable|string|max:100',
            'district'           => 'nullable|string|max:100',
            'city'               => 'nullable|string|max:100',
            'province'           => 'nullable|string|max:100',
            'postal_code'        => 'nullable|string|max:10',
            'insurance_type'     => 'nullable|string|max:50',
            'bpjs_number'        => 'nullable|string|max:50',
            'insurance_number'   => 'nullable|string|max:50',
            'blood_pressure'     => 'nullable|string|max:20',
            'allergy'            => 'nullable|string|max:255',
            'medical_notes'      => 'nullable|string',
            'photo'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'             => 'required',

            // Validasi No RM manual hanya jika mode manual
            'medical_record_number' => $rmMode === 'manual'
                ? 'required|string|max:20|unique:patients,medical_record_number'
                : 'nullable',
        ]);

        DB::beginTransaction();
        try {
            // Generate No RM otomatis jika mode auto
            if ($rmMode === 'auto') {
                $lastPatient = Patient::latest('id')->lockForUpdate()->first();
                $lastNum     = $lastPatient
                    ? (int) preg_replace('/\D/', '', substr($lastPatient->medical_record_number, -6))
                    : 0;
                $validated['medical_record_number'] = $rmPrefix . date('Y') . str_pad($lastNum + 1, 6, '0', STR_PAD_LEFT);
            }

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('patients', 'public');
            }

            Patient::create($validated);
            DB::commit();

            return redirect()
                ->route('patient.patients.index')
                ->with('success', 'Data pasien berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* ---------------------------------------------------------------- SHOW */
    public function show(Patient $patient)
    {
        return view('patient.patients.show', compact('patient'));
    }

    /* ---------------------------------------------------------------- EDIT */
    public function edit(Patient $patient)
    {
        return view('patient.patients.edit', compact('patient'));
    }

    /* ---------------------------------------------------------------- UPDATE */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nik'                => 'required|string|max:16|unique:patients,nik,' . $patient->id,
            'family_card_number' => 'nullable|string|max:20',
            'full_name'          => 'required|string|max:255',
            'nickname'           => 'nullable|string|max:100',
            'gender'             => 'required|string|max:20',
            'birth_place'        => 'nullable|string|max:100',
            'birth_date'         => 'nullable|date',
            'blood_type'         => 'nullable|string|max:5',
            'religion'           => 'nullable|string|max:50',
            'marital_status'     => 'nullable|string|max:50',
            'occupation'         => 'nullable|string|max:100',
            'phone'              => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:100',
            'address'            => 'nullable|string',
            'rt'                 => 'nullable|string|max:5',
            'rw'                 => 'nullable|string|max:5',
            'village'            => 'nullable|string|max:100',
            'district'           => 'nullable|string|max:100',
            'city'               => 'nullable|string|max:100',
            'province'           => 'nullable|string|max:100',
            'postal_code'        => 'nullable|string|max:10',
            'insurance_type'     => 'nullable|string|max:50',
            'bpjs_number'        => 'nullable|string|max:50',
            'insurance_number'   => 'nullable|string|max:50',
            'blood_pressure'     => 'nullable|string|max:20',
            'allergy'            => 'nullable|string|max:255',
            'medical_notes'      => 'nullable|string',
            'photo'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'             => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                // Hapus foto lama
                if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                    Storage::disk('public')->delete($patient->photo);
                }
                $validated['photo'] = $request->file('photo')->store('patients', 'public');
            }

            $patient->update($validated);
            DB::commit();

            return redirect()
                ->route('patient.patients.index')
                ->with('success', 'Data pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* ---------------------------------------------------------------- DESTROY */
    public function destroy(Patient $patient)
    {
        DB::beginTransaction();
        try {
            if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                Storage::disk('public')->delete($patient->photo);
            }
            $patient->delete();
            DB::commit();

            return redirect()
                ->route('patient.patients.index')
                ->with('success', 'Data pasien berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}