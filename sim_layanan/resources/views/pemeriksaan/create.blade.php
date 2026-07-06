@extends('layouts.app')

@section('title','Form Pemeriksaan')
@section('breadcrumb','Pelayanan / Pemeriksaan / '.$kunjungan->no_kunjungan)

@section('content')

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card">
            <div class="card-body">

                <h6 class="text-muted text-uppercase small fw-bold mb-3">Data Pasien</h6>

                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="40%">No. Kunjungan</td>
                        <td class="text-mono fw-semibold">{{ $kunjungan->no_kunjungan }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pasien</td>
                        <td class="fw-semibold">{{ $kunjungan->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Poli</td>
                        <td>{{ $kunjungan->poli->nama_poli }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dokter</td>
                        <td>{{ $kunjungan->dokter->nama }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keluhan</td>
                        <td>{{ $kunjungan->keluhan ?: '—' }}</td>
                    </tr>
                </table>

            </div>
        </div>

    </div>

    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('pemeriksaan.store',$kunjungan) }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Diagnosa
                            <span class="text-danger">*</span>
                        </label>
                        <textarea
                            name="diagnosa"
                            rows="2"
                            class="form-control @error('diagnosa') is-invalid @enderror"
                            placeholder="Diagnosa dokter">{{ old('diagnosa') }}</textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Pemeriksaan</label>
                        <textarea
                            name="catatan_pemeriksaan"
                            rows="2"
                            class="form-control"
                            placeholder="Catatan tambahan (opsional)">{{ old('catatan_pemeriksaan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Resep</label>
                        <textarea
                            name="resep"
                            rows="2"
                            class="form-control"
                            placeholder="Resep obat (opsional)">{{ old('resep') }}</textarea>
                    </div>

                    <label class="form-label">
                        Layanan / Tindakan
                        <span class="text-danger">*</span>
                    </label>

                    @error('layanan_id')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror

                    <div class="table-responsive mb-3">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th width="40"></th>
                                <th>Nama Layanan</th>
                                <th width="140">Harga</th>
                                <th width="100">Jumlah</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($layanan as $item)
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            class="form-check-input layanan-check"
                                            value="{{ $item->id }}"
                                            data-harga="{{ $item->harga }}"
                                            data-index="{{ $loop->index }}">
                                    </td>
                                    <td>{{ $item->nama_layanan }}</td>
                                    <td class="text-mono">{{ $item->harga_format }}</td>
                                    <td>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm jumlah-input"
                                            value="1"
                                            min="1"
                                            disabled
                                            data-index="{{ $loop->index }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <x-ui.empty-state
                                            title="Belum ada layanan untuk poli ini"
                                            subtitle="Tambahkan data layanan terlebih dahulu di Master Data."
                                        />
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total</td>
                                <td colspan="2" class="text-mono fw-bold" id="total-biaya" style="color:var(--pine);">
                                    Rp 0
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div id="hidden-inputs"></div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            Simpan Pemeriksaan
                        </button>
                        <a href="{{ route('kunjungan.show',$kunjungan) }}" class="btn btn-light">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<script>
document.querySelectorAll('.layanan-check').forEach(function (chk) {

    chk.addEventListener('change', function () {

        const row = this.closest('tr');
        const jumlahInput = row.querySelector('.jumlah-input');

        jumlahInput.disabled = !this.checked;
        jumlahInput.name = this.checked ? 'jumlah[]' : '';
        this.name = this.checked ? 'layanan_id[]' : '';

        hitungTotal();

    });
});

document.querySelectorAll('.jumlah-input').forEach(function (inp) {
    inp.addEventListener('input', hitungTotal);
});

function hitungTotal() {

    let total = 0;

    document.querySelectorAll('.layanan-check:checked').forEach(function (chk) {

        const row = chk.closest('tr');
        const jumlah = parseInt(row.querySelector('.jumlah-input').value) || 0;
        const harga = parseFloat(chk.dataset.harga);

        total += harga * jumlah;

    });

    document.getElementById('total-biaya').innerText =
        'Rp ' + total.toLocaleString('id-ID');

}
</script>

@endsection
