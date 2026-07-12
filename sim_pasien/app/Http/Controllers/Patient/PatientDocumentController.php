<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientDocumentController extends Controller
{
    /**
     * Daftar Dokumen
     */
    public function index(Request $request)
    {
        $query = PatientDocument::with('patient');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where('document_type', 'like', "%{$search}%")
                ->orWhereHas('patient', function ($q) use ($search) {

                    $q->where('medical_record_number', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
        }

        $documents = $query
            ->latest()
            ->paginate(10);

        return view(
            'patient.document.index',
            compact('documents')
        );
    }

    /**
     * Form Upload
     */
    public function create()
    {
        $patients = Patient::where('status', 'Aktif')
            ->orderBy('full_name')
            ->get();

        return view(
            'patient.document.create',
            compact('patients')
        );
    }

    /**
     * Simpan Dokumen
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'document_type'  => 'required',
            'file'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $patient = Patient::findOrFail($request->patient_id);

        $file = $request->file('file');

        $folder = 'patient_documents/' . $patient->medical_record_number;

        $path = $file->store($folder, 'public');

        PatientDocument::create([
            'patient_id'     => $request->patient_id,
            'document_type'  => $request->document_type,
            'file_name'      => $file->getClientOriginalName(),
            'file_path'      => $path,
            'uploaded_by'    => 1, // ganti auth()->id() jika sudah ada login
        ]);

        return redirect()
            ->route('patient.documents.index')
            ->with(
                'success',
                'Dokumen berhasil diupload.'
            );
    }

    /**
     * Detail Dokumen
     */
    public function show($id)
    {
        $document = PatientDocument::with('patient')
            ->findOrFail($id);

        return view(
            'patient.document.show',
            compact('document')
        );
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $document = PatientDocument::with('patient')
            ->findOrFail($id);

        return view(
            'patient.document.edit',
            compact('document')
        );
    }

    /**
     * Update Dokumen
     */
    public function update(Request $request, $id)
    {
        $document = PatientDocument::findOrFail($id);

        $request->validate([
            'document_type' => 'required',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('file')) {

            if (
                $document->file_path &&
                Storage::disk('public')->exists($document->file_path)
            ) {
                Storage::disk('public')->delete($document->file_path);
            }

            $patient = Patient::findOrFail($document->patient_id);

            $file = $request->file('file');

            $folder = 'patient_documents/' . $patient->medical_record_number;

            $path = $file->store($folder, 'public');

            $document->file_name = $file->getClientOriginalName();
            $document->file_path = $path;
        }

        $document->document_type = $request->document_type;

        $document->save();

        return redirect()
            ->route('patient.documents.index')
            ->with(
                'success',
                'Dokumen berhasil diperbarui.'
            );
    }

    /**
     * Download Dokumen
     */
    public function download($id)
    {
        $document = PatientDocument::findOrFail($id);

        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Preview Dokumen
     */
    public function preview($id)
    {
        $document = PatientDocument::findOrFail($id);

        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}