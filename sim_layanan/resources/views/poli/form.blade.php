<div class="mb-3">

    <label class="form-label">
        Nama Poli
    </label>

    <input
        type="text"
        name="nama_poli"
        class="form-control @error('nama_poli') is-invalid @enderror"
        value="{{ old('nama_poli', $poli->nama_poli ?? '') }}"
        placeholder="Contoh: Poli Umum">

    @error('nama_poli')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>

<div class="mb-3">

    <label class="form-label">
        Deskripsi
    </label>

    <textarea
        name="deskripsi"
        rows="4"
        class="form-control"
        placeholder="Deskripsi singkat poli (opsional)">{{ old('deskripsi', $poli->deskripsi ?? '') }}</textarea>

</div>

<div class="mb-4">

    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-select">

        <option value="aktif"
            @selected(old('status', $poli->status ?? '') == 'aktif')>
            Aktif
        </option>

        <option value="tidak_aktif"
            @selected(old('status', $poli->status ?? '') == 'tidak_aktif')>
            Tidak Aktif
        </option>

    </select>

</div>

<div class="d-flex gap-2">

    <button class="btn btn-primary">
        <i class="bi bi-save"></i>
        Simpan
    </button>

    <a
        href="{{ route('poli.index') }}"
        class="btn btn-light">
        Batal
    </a>

</div>
