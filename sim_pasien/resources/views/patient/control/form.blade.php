{{-- resources/views/patient/control/form.blade.php --}}
{{-- FIX: tambah dokter, jam kontrol, dan status yang benar --}}

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-check"></i> Jadwal Kontrol</h3>
    </div>
    <div class="card-body">

        {{-- PASIEN --}}
        <div class="form-group">
            <label>Pasien <span class="text-danger">*</span></label>
            <select name="patient_id" class="form-control select2" required>
                <option value="">-- Pilih Pasien --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ old('patient_id', $control->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->medical_record_number }} — {{ $patient->full_name }}
                    </option>
                @endforeach
            </select>
            @error('patient_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- FIX: DOKTER --}}
        <div class="form-group">
            <label>Dokter</label>
            <select name="doctor_id" class="form-control select2">
                <option value="">-- Pilih Dokter (opsional) --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}"
                        {{ old('doctor_id', $control->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->full_name }}
                        @if($doctor->specialist) — {{ $doctor->specialist }} @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            {{-- TANGGAL KONTROL --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Kontrol <span class="text-danger">*</span></label>
                    <input type="date" name="control_date" class="form-control"
                        value="{{ old('control_date', isset($control) ? $control->control_date?->format('Y-m-d') : '') }}"
                        required>
                    @error('control_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- FIX: JAM KONTROL --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jam Kontrol</label>
                    <input type="time" name="control_time" class="form-control"
                        value="{{ old('control_time', $control->control_time ?? '') }}">
                    <small class="text-muted">Opsional — isi jika ada jam spesifik.</small>
                </div>
            </div>
        </div>

        {{-- FIX: STATUS (enum baru: Menunggu / Sudah Datang / Terlewat) --}}
        <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                @php
                    $statuses = [
                        'Menunggu'    => ['badge' => 'badge-warning',  'icon' => 'fas fa-clock'],
                        'Sudah Datang'=> ['badge' => 'badge-success',  'icon' => 'fas fa-check-circle'],
                        'Terlewat'    => ['badge' => 'badge-danger',   'icon' => 'fas fa-times-circle'],
                    ];
                    $currentStatus = old('status', $control->status ?? 'Menunggu');
                @endphp
                @foreach($statuses as $val => $meta)
                    <option value="{{ $val }}" {{ $currentStatus == $val ? 'selected' : '' }}>
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- CATATAN --}}
        <div class="form-group">
            <label>Catatan Kontrol</label>
            <textarea name="notes" rows="4" class="form-control"
                placeholder="Catatan atau instruksi untuk kontrol...">{{ old('notes', $control->notes ?? '') }}</textarea>
        </div>

    </div>
</div>

@push('js')
<script>
$(function () {
    $('.select2').select2({ width: '100%' });
});
</script>
@endpush
