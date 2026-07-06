<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <span class="hero-badge mb-3">
                <i class="bi bi-clipboard2-pulse"></i>
                Layanan Kami
            </span>
            <h2 class="section-title mt-3">Daftar Layanan & Tindakan</h2>
            <span class="pulse-rule mx-auto"></span>
            <p class="text-muted mt-2">Berikut layanan yang tersedia di masing-masing poli kami.</p>
        </div>

        @forelse($layanan as $namaPoli => $items)

            <div class="mb-5">

                <h5 class="fw-bold mb-3" style="color:var(--pine);">
                    <i class="bi bi-hospital-fill me-2"></i>
                    {{ $namaPoli }}
                </h5>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Nama Layanan</th>
                                <th>Kategori</th>
                                <th class="text-end">Harga</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->nama_layanan }}</td>
                                    <td><span class="badge bg-primary">{{ $item->kategori }}</span></td>
                                    <td class="text-end text-mono fw-semibold">{{ $item->harga_format }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        @empty

            <p class="text-center text-muted">Belum ada data layanan.</p>

        @endforelse

    </div>
</section>


