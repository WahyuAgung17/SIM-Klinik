{{-- ========================= --}}
{{-- DATA PASIEN --}}
{{-- ========================= --}}

<div class="card card-primary">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-user"></i>

            Data Pasien

        </h3>

    </div>

    <div class="card-body">

        @if(isset($document))

            {{-- EDIT --}}

            <input type="hidden"
                   name="patient_id"
                   value="{{ $document->patient_id }}">

            <div class="form-group">

                <label>Pasien</label>

                <input type="text"
                       class="form-control"
                       value="{{ $document->patient->medical_record_number }} - {{ $document->patient->full_name }}"
                       readonly>

            </div>

        @else

            {{-- CREATE --}}

            <div class="form-group">

                <label>Pilih Pasien</label>

                <select name="patient_id"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Pasien --</option>

                    @foreach($patients as $patient)

                        <option value="{{ $patient->id }}"
                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                            {{ $patient->medical_record_number }}
                            -
                            {{ $patient->full_name }}

                        </option>

                    @endforeach

                </select>

            </div>

        @endif

    </div>

</div>

{{-- ========================= --}}
{{-- DOKUMEN --}}
{{-- ========================= --}}

<div class="card card-success">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-folder-open"></i>

            Informasi Dokumen

        </h3>

    </div>

    <div class="card-body">

        <div class="form-group">

            <label>Jenis Dokumen</label>

            <select name="document_type"
                    class="form-control"
                    required>

                @php

                $types = [

                    'Foto',

                    'KTP',

                    'KK',

                    'BPJS',

                    'Surat Rujukan',

                    'Hasil Laboratorium',

                    'Hasil Radiologi',

                    'Surat Kontrol',

                    'Lainnya'

                ];

                @endphp

                <option value="">-- Pilih Jenis Dokumen --</option>

                @foreach($types as $type)

                <option value="{{ $type }}"

                    {{ old('document_type', $document->document_type ?? '') == $type ? 'selected' : '' }}>

                    {{ $type }}

                </option>

                @endforeach

            </select>

        </div>

        @if(isset($document))

        <div class="form-group">

            <label>File Saat Ini</label>

            <input type="text"
                   class="form-control"
                   value="{{ $document->file_name }}"
                   readonly>

        </div>

        @endif

        <div class="form-group">

            <label>

                {{ isset($document) ? 'Upload File Baru (Opsional)' : 'Upload Dokumen' }}

            </label>

            <input type="file"
                   name="file"
                   class="form-control-file"
                   {{ isset($document) ? '' : 'required' }}>

            <small class="text-muted">

                Format yang didukung:
                PDF, JPG, JPEG, PNG

            </small>

        </div>

    </div>

</div>