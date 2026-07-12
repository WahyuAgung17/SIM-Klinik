{{-- resources/views/patient/visit/form.blade.php --}}
{{-- FIX: tambah dropdown Poli dan Dokter --}}

{{-- ============================================================ --}}
{{-- DATA PASIEN                                                   --}}
{{-- ============================================================ --}}
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-injured"></i> Data Pasien</h3>
    </div>
    <div class="card-body">

        @if(isset($visit))
            {{-- ===== EDIT: tampilkan readonly ===== --}}
            <input type="hidden" name="patient_id" value="{{ $visit->patient_id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien</label>
                        <input type="text" class="form-control"
                            value="{{ $visit->patient->medical_record_number }} — {{ $visit->patient->full_name }}"
                            readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>No RM</label>
                        <input type="text" class="form-control"
                            value="{{ $visit->patient->medical_record_number }}" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control"
                            value="{{ $visit->patient->nik }}" readonly>
                    </div>
                </div>
            </div>

        @else
            {{-- ===== CREATE: select2 pasien ===== --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasien <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id"
                            class="form-control select2" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    data-rm="{{ $patient->medical_record_number }}"
                                    data-nik="{{ $patient->nik }}"
                                    data-gender="{{ $patient->gender }}"
                                    data-phone="{{ $patient->phone }}"
                                    data-address="{{ $patient->address }}">
                                    {{ $patient->medical_record_number }} — {{ $patient->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>No RM</label>
                        <input type="text" id="rm_display" class="form-control" readonly
                            placeholder="Otomatis">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" id="nik_display" class="form-control" readonly
                            placeholder="Otomatis">
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- ============================================================ --}}
{{-- FIX: POLI DAN DOKTER                                         --}}
{{-- ============================================================ --}}
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-hospital-alt"></i> Poli & Dokter</h3>
    </div>
    <div class="card-body">
        <div class="row">

            {{-- POLI --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Poli Tujuan <span class="text-danger">*</span></label>
                    <select name="poly_id" id="poly_id" class="form-control select2" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach($poly as $poly)
                            <option value="{{ $poly->id }}"
                                {{ old('poly_id', $visit->poly_id ?? '') == $poly->id ? 'selected' : '' }}>
                                {{ $poly->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('poly_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- DOKTER — diisi via AJAX saat poli dipilih --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Dokter</label>
                    <select name="doctor_id" id="doctor_id" class="form-control select2">
                        <option value="">-- Pilih Dokter (opsional) --</option>
                        {{-- jika EDIT: tampilkan dokter yang sudah terpilih --}}
                        @if(isset($visit) && $visit->doctor)
                            <option value="{{ $visit->doctor->id }}" selected>
                                {{ $visit->doctor->full_name }}
                                @if($visit->doctor->specialist)
                                    — {{ $visit->doctor->specialist }}
                                @endif
                            </option>
                        @endif
                    </select>
                    @error('doctor_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Pilih poli terlebih dahulu untuk memuat daftar dokter.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- INFORMASI REGISTRASI                                         --}}
{{-- ============================================================ --}}
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-notes-medical"></i> Informasi Registrasi</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" name="visit_date" class="form-control"
                        value="{{ old('visit_date', isset($visit) ? $visit->visit_date->format('Y-m-d') : date('Y-m-d')) }}"
                        required>
                    @error('visit_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jam Kunjungan <span class="text-danger">*</span></label>
                    <input type="time" name="visit_time" class="form-control"
                        value="{{ old('visit_time', isset($visit) ? substr($visit->visit_time, 0, 5) : date('H:i')) }}"
                        required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="payment_type" class="form-control">
                        @foreach(['Umum', 'BPJS', 'Asuransi'] as $type)
                            <option value="{{ $type }}"
                                {{ old('payment_type', $visit->payment_type ?? 'Umum') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Keluhan Awal</label>
            <textarea name="complaint" rows="4" class="form-control"
                placeholder="Tuliskan keluhan pasien...">{{ old('complaint', $visit->complaint ?? '') }}</textarea>
        </div>

        @if(isset($visit))
            <div class="form-group">
                <label>Status Kunjungan</label>
                <select name="status" class="form-control">
                    @foreach(['Terdaftar','Menunggu Pemeriksaan','Sedang Diperiksa','Menunggu Pembayaran','Selesai','Dibatalkan'] as $st)
                        <option value="{{ $st }}"
                            {{ $visit->status == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

    </div>
</div>

{{-- ============================================================ --}}
{{-- JAVASCRIPT                                                    --}}
{{-- ============================================================ --}}
@push('js')
<script>
$(function () {
    // ----- select2 -----
    $('.select2').select2({ width: '100%' });

    @if(!isset($visit))
    // ----- auto-fill pasien saat CREATE -----
    $('#patient_id').on('change', function () {
        let opt = $(this).find(':selected');
        $('#rm_display').val(opt.data('rm'));
        $('#nik_display').val(opt.data('nik'));
    }).trigger('change');
    @endif

    // ----- AJAX: load dokter berdasarkan poli yang dipilih -----
    let selectedDoctor = '{{ old("doctor_id", $visit->doctor_id ?? "") }}';

    $('#poly_id').on('change', function () {
        let polyId = $(this).val();
        let $doctorSelect = $('#doctor_id');

        $doctorSelect.empty().append('<option value="">-- Pilih Dokter (opsional) --</option>');

        if (!polyId) return;

        $.get('{{ route("patient.visits.doctors-by-poly") }}', { poly_id: polyId }, function (doctors) {
            doctors.forEach(function (d) {
                let label = d.full_name + (d.specialist ? ' — ' + d.specialist : '');
                let selected = (d.id == selectedDoctor) ? 'selected' : '';
                $doctorSelect.append(`<option value="${d.id}" ${selected}>${label}</option>`);
            });
            $doctorSelect.trigger('change.select2');
        });
    });

    // Trigger saat edit agar dokter dimuat ulang
    @if(isset($visit) && $visit->poly_id)
    $('#poly_id').trigger('change');
    @endif
});
</script>
@endpush
