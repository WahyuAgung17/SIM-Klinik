<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Nama Layanan
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="nama_layanan"
            class="form-control @error('nama_layanan') is-invalid @enderror"
            value="{{ old('nama_layanan', $layanan->nama_layanan ?? '') }}"
            placeholder="Masukkan nama layanan">

        @error('nama_layanan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Kategori
            <span class="text-danger">*</span>
        </label>

        <select
            name="kategori"
            class="form-select @error('kategori') is-invalid @enderror">

            <option value="">-- Pilih Kategori --</option>

            @foreach([
                'Konsultasi',
                'Pemeriksaan',
                'Laboratorium',
                'Tindakan',
                'Administrasi'
            ] as $kategori)

                <option
                    value="{{ $kategori }}"
                    @selected(old('kategori', $layanan->kategori ?? '') == $kategori)>

                    {{ $kategori }}

                </option>

            @endforeach

        </select>

        @error('kategori')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Poli
            <span class="text-danger">*</span>
        </label>

        <select
            name="poli_id"
            class="form-select @error('poli_id') is-invalid @enderror">

            <option value="">-- Pilih Poli --</option>

            @foreach($poli as $item)

                <option
                    value="{{ $item->id }}"
                    @selected(old('poli_id', $layanan->poli_id ?? '') == $item->id)>

                    {{ $item->nama_poli }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Harga
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            id="harga"
            class="form-control text-mono"
            placeholder="Rp 0"
            value="{{ old('harga', isset($layanan) ? number_format($layanan->harga,0,',','.') : '') }}">

        <input
            type="hidden"
            name="harga"
            id="harga_real"
            value="{{ old('harga', $layanan->harga ?? '') }}">

    </div>

</div>

<div class="mb-4">

    <label class="form-label">
        Status
    </label>

    <select
        name="status"
        class="form-select">

        <option value="aktif"
            @selected(old('status', $layanan->status ?? '') == 'aktif')>

            Aktif

        </option>

        <option value="tidak_aktif"
            @selected(old('status', $layanan->status ?? '') == 'tidak_aktif')>

            Tidak Aktif

        </option>

    </select>

</div>

<script>

const harga=document.getElementById('harga');

const real=document.getElementById('harga_real');

harga.addEventListener('keyup',function(){

let angka=this.value.replace(/\D/g,'');

real.value=angka;

this.value='Rp '+Number(angka).toLocaleString('id-ID');

});

</script>
